<?php
if (!defined('ABSPATH')) {
    exit;
}

function kff_admin_menu() {
    add_menu_page('Kolkata FF Theme', 'Kolkata FF', 'manage_options', 'kff-dashboard', 'kff_admin_page', 'dashicons-chart-area', 3);
}
add_action('admin_menu', 'kff_admin_menu');

function kff_admin_assets($hook) {
    if ($hook !== 'toplevel_page_kff-dashboard') {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_style('kff-admin', KFF_THEME_URI . '/assets/css/admin.css', array(), KFF_THEME_VERSION);
    wp_enqueue_script('kff-admin', KFF_THEME_URI . '/assets/js/admin.js', array(), KFF_THEME_VERSION, true);
}
add_action('admin_enqueue_scripts', 'kff_admin_assets');

function kff_sanitize_rows($rows, $allowed_keys) {
    $clean = array();
    if (!is_array($rows)) {
        return $clean;
    }
    foreach ($rows as $row) {
        $item = array();
        foreach ($allowed_keys as $key) {
            $item[$key] = isset($row[$key]) ? sanitize_text_field(wp_unslash($row[$key])) : '';
        }
        $clean[] = $item;
    }
    return $clean;
}

function kff_handle_settings_save() {
    if (!current_user_can('manage_options') || !isset($_POST['kff_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['kff_nonce'])), 'kff_save_options')) {
        wp_die(esc_html__('You are not allowed to save these settings.', 'kolkata-ff-theme'));
    }

    $old_keys = array('date');
    for ($i = 1; $i <= 8; $i++) {
        $old_keys[] = 'b' . $i . '_patti';
        $old_keys[] = 'b' . $i . '_single';
    }

    $options = array(
        'site_name' => sanitize_text_field(wp_unslash($_POST['site_name'] ?? '')),
        'tagline' => sanitize_text_field(wp_unslash($_POST['tagline'] ?? '')),
        'accent_color' => sanitize_hex_color(wp_unslash($_POST['accent_color'] ?? '')) ?: '#f5b301',
        'brand_color' => sanitize_hex_color(wp_unslash($_POST['brand_color'] ?? '')) ?: '#101820',
        'meta_description' => sanitize_text_field(wp_unslash($_POST['meta_description'] ?? '')),
        'share_text' => sanitize_text_field(wp_unslash($_POST['share_text'] ?? '')),
        'contact_email' => sanitize_email(wp_unslash($_POST['contact_email'] ?? '')),
        'contact_phone' => sanitize_text_field(wp_unslash($_POST['contact_phone'] ?? '')),
        'contact_address' => sanitize_text_field(wp_unslash($_POST['contact_address'] ?? '')),
        'whatsapp_number' => sanitize_text_field(wp_unslash($_POST['whatsapp_number'] ?? '')),
        'telegram_url' => esc_url_raw(wp_unslash($_POST['telegram_url'] ?? '')),
        'facebook_url' => esc_url_raw(wp_unslash($_POST['facebook_url'] ?? '')),
        'youtube_url' => esc_url_raw(wp_unslash($_POST['youtube_url'] ?? '')),
        'enable_dark_default' => isset($_POST['enable_dark_default']) ? '1' : '0',
        'disclaimer_footer' => sanitize_text_field(wp_unslash($_POST['disclaimer_footer'] ?? '')),
        'results' => kff_sanitize_rows($_POST['results'] ?? array(), array('bazi', 'time', 'patti', 'single', 'status')),
        'tips' => kff_sanitize_rows($_POST['tips'] ?? array(), array('bazi', 'numbers', 'patti')),
        'old_results' => kff_sanitize_rows($_POST['old_results'] ?? array(), $old_keys),
        'hot_numbers' => kff_sanitize_rows($_POST['hot_numbers'] ?? array(), array('number', 'count', 'type')),
        'home_content' => wp_kses_post(wp_unslash($_POST['home_content'] ?? '')),
        'about_content' => wp_kses_post(wp_unslash($_POST['about_content'] ?? '')),
        'privacy_content' => wp_kses_post(wp_unslash($_POST['privacy_content'] ?? '')),
        'terms_content' => wp_kses_post(wp_unslash($_POST['terms_content'] ?? '')),
        'disclaimer_content' => wp_kses_post(wp_unslash($_POST['disclaimer_content'] ?? '')),
    );

    update_option('kff_theme_options', $options);
    wp_safe_redirect(add_query_arg('kff_saved', '1', admin_url('admin.php?page=kff-dashboard')));
    exit;
}
add_action('admin_post_kff_save_options', 'kff_handle_settings_save');

function kff_admin_page() {
    $options = kff_get_options();
    ?>
    <div class="wrap kff-admin">
        <h1>Kolkata FF Theme Dashboard</h1>
        <?php if (isset($_GET['kff_saved'])) : ?>
            <div class="notice notice-success is-dismissible"><p>Theme data saved.</p></div>
        <?php endif; ?>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="kff_save_options">
            <?php wp_nonce_field('kff_save_options', 'kff_nonce'); ?>
            <nav class="kff-admin-tabs" aria-label="Dashboard sections">
                <button type="button" data-tab="brand" class="is-active">Brand</button>
                <button type="button" data-tab="results">Live Results</button>
                <button type="button" data-tab="tips">Tips</button>
                <button type="button" data-tab="archive">Old Results</button>
                <button type="button" data-tab="hot">Hot Numbers</button>
                <button type="button" data-tab="content">Pages & SEO</button>
                <button type="button" data-tab="contact">Contact</button>
            </nav>

            <section class="kff-admin-panel is-active" data-panel="brand">
                <h2>Brand Controls</h2>
                <?php kff_admin_text('site_name', 'Site Name', $options['site_name']); ?>
                <?php kff_admin_text('tagline', 'Tagline', $options['tagline']); ?>
                <?php kff_admin_color('brand_color', 'Brand Color', $options['brand_color']); ?>
                <?php kff_admin_color('accent_color', 'Accent Color', $options['accent_color']); ?>
                <label class="kff-admin-check"><input type="checkbox" name="enable_dark_default" value="1" <?php checked($options['enable_dark_default'], '1'); ?>> Enable dark mode by default</label>
            </section>

            <section class="kff-admin-panel" data-panel="results">
                <h2>Live Result Board</h2>
                <p>Edit all 8 baazi rows. Use dashes while a result is waiting.</p>
                <?php kff_admin_results_table($options['results']); ?>
            </section>

            <section class="kff-admin-panel" data-panel="tips">
                <h2>Tips & Guessing Numbers</h2>
                <?php kff_admin_tips_table($options['tips']); ?>
            </section>

            <section class="kff-admin-panel" data-panel="archive">
                <h2>Old Result Archive</h2>
                <p>Add daily records for the public old-result filter and history chart.</p>
                <?php kff_admin_old_results_table($options['old_results']); ?>
            </section>

            <section class="kff-admin-panel" data-panel="hot">
                <h2>Hot & Cold Numbers</h2>
                <?php kff_admin_hot_table($options['hot_numbers']); ?>
            </section>

            <section class="kff-admin-panel" data-panel="content">
                <h2>Editable Page Content & SEO</h2>
                <?php kff_admin_textarea('meta_description', 'Global Meta Description', $options['meta_description'], 3); ?>
                <?php kff_admin_text('share_text', 'Share Text', $options['share_text']); ?>
                <?php kff_admin_textarea('home_content', 'Homepage SEO Content', $options['home_content'], 10); ?>
                <?php kff_admin_textarea('about_content', 'About Page Content', $options['about_content'], 8); ?>
                <?php kff_admin_textarea('privacy_content', 'Privacy Policy Content', $options['privacy_content'], 8); ?>
                <?php kff_admin_textarea('terms_content', 'Terms Content', $options['terms_content'], 8); ?>
                <?php kff_admin_textarea('disclaimer_content', 'Disclaimer Content', $options['disclaimer_content'], 8); ?>
            </section>

            <section class="kff-admin-panel" data-panel="contact">
                <h2>Contact & Footer</h2>
                <?php kff_admin_text('contact_email', 'Email', $options['contact_email']); ?>
                <?php kff_admin_text('contact_phone', 'Phone', $options['contact_phone']); ?>
                <?php kff_admin_text('contact_address', 'Address', $options['contact_address']); ?>
                <?php kff_admin_text('whatsapp_number', 'WhatsApp Number', $options['whatsapp_number']); ?>
                <?php kff_admin_text('telegram_url', 'Telegram URL', $options['telegram_url']); ?>
                <?php kff_admin_text('facebook_url', 'Facebook URL', $options['facebook_url']); ?>
                <?php kff_admin_text('youtube_url', 'YouTube URL', $options['youtube_url']); ?>
                <?php kff_admin_textarea('disclaimer_footer', 'Footer Disclaimer', $options['disclaimer_footer'] ?? '', 3); ?>
            </section>

            <?php submit_button('Save Kolkata FF Theme Data'); ?>
        </form>
    </div>
    <?php
}

function kff_admin_text($name, $label, $value) {
    echo '<label class="kff-admin-field"><span>' . esc_html($label) . '</span><input type="text" name="' . esc_attr($name) . '" value="' . esc_attr($value) . '"></label>';
}

function kff_admin_color($name, $label, $value) {
    echo '<label class="kff-admin-field"><span>' . esc_html($label) . '</span><input type="color" name="' . esc_attr($name) . '" value="' . esc_attr($value) . '"></label>';
}

function kff_admin_textarea($name, $label, $value, $rows = 6) {
    echo '<label class="kff-admin-field"><span>' . esc_html($label) . '</span><textarea name="' . esc_attr($name) . '" rows="' . esc_attr($rows) . '">' . esc_textarea($value) . '</textarea></label>';
}

function kff_admin_results_table($rows) {
    echo '<table class="widefat striped kff-repeat-table"><thead><tr><th>Baazi</th><th>Time</th><th>Patti</th><th>Single</th><th>Status</th></tr></thead><tbody>';
    foreach ($rows as $i => $row) {
        echo '<tr>';
        foreach (array('bazi', 'time', 'patti', 'single', 'status') as $key) {
            echo '<td><input name="results[' . esc_attr($i) . '][' . esc_attr($key) . ']" value="' . esc_attr($row[$key] ?? '') . '"></td>';
        }
        echo '</tr>';
    }
    echo '</tbody></table>';
}

function kff_admin_tips_table($rows) {
    echo '<table class="widefat striped kff-repeat-table"><thead><tr><th>Baazi</th><th>Single Numbers</th><th>Patti Tips</th></tr></thead><tbody>';
    foreach ($rows as $i => $row) {
        echo '<tr><td><input name="tips[' . esc_attr($i) . '][bazi]" value="' . esc_attr($row['bazi'] ?? '') . '"></td><td><input name="tips[' . esc_attr($i) . '][numbers]" value="' . esc_attr($row['numbers'] ?? '') . '"></td><td><input name="tips[' . esc_attr($i) . '][patti]" value="' . esc_attr($row['patti'] ?? '') . '"></td></tr>';
    }
    echo '</tbody></table>';
}

function kff_admin_old_results_table($rows) {
    echo '<div class="kff-table-scroll"><table class="widefat striped kff-repeat-table"><thead><tr><th>Date</th>';
    for ($i = 1; $i <= 8; $i++) {
        echo '<th>B' . esc_html($i) . ' Patti</th><th>B' . esc_html($i) . ' Single</th>';
    }
    echo '</tr></thead><tbody>';
    foreach ($rows as $r => $row) {
        echo '<tr><td><input type="date" name="old_results[' . esc_attr($r) . '][date]" value="' . esc_attr($row['date'] ?? '') . '"></td>';
        for ($i = 1; $i <= 8; $i++) {
            echo '<td><input name="old_results[' . esc_attr($r) . '][b' . esc_attr($i) . '_patti]" value="' . esc_attr($row['b' . $i . '_patti'] ?? '') . '"></td>';
            echo '<td><input name="old_results[' . esc_attr($r) . '][b' . esc_attr($i) . '_single]" value="' . esc_attr($row['b' . $i . '_single'] ?? '') . '"></td>';
        }
        echo '</tr>';
    }
    for ($extra = count($rows); $extra < count($rows) + 5; $extra++) {
        echo '<tr><td><input type="date" name="old_results[' . esc_attr($extra) . '][date]"></td>';
        for ($i = 1; $i <= 8; $i++) {
            echo '<td><input name="old_results[' . esc_attr($extra) . '][b' . esc_attr($i) . '_patti]"></td>';
            echo '<td><input name="old_results[' . esc_attr($extra) . '][b' . esc_attr($i) . '_single]"></td>';
        }
        echo '</tr>';
    }
    echo '</tbody></table></div>';
}

function kff_admin_hot_table($rows) {
    echo '<table class="widefat striped kff-repeat-table"><thead><tr><th>Number</th><th>Count</th><th>Type</th></tr></thead><tbody>';
    for ($i = 0; $i < 10; $i++) {
        $row = $rows[$i] ?? array('number' => '', 'count' => '', 'type' => '');
        echo '<tr><td><input name="hot_numbers[' . esc_attr($i) . '][number]" value="' . esc_attr($row['number']) . '"></td><td><input name="hot_numbers[' . esc_attr($i) . '][count]" value="' . esc_attr($row['count']) . '"></td><td><input name="hot_numbers[' . esc_attr($i) . '][type]" value="' . esc_attr($row['type']) . '"></td></tr>';
    }
    echo '</tbody></table>';
}

function kff_fallback_menu() {
    echo '<ul class="kff-menu">';
    $links = array('Home' => '/', 'About' => '/about-us/', 'Old Result' => '/old-result/', 'Hot Numbers' => '/hot-numbers/', 'FF Chart' => '/kolkata-ff-chart/', 'Tips' => '/kolkata-ff-tips/', 'Contact' => '/contact/');
    foreach ($links as $label => $url) {
        echo '<li><a href="' . esc_url(home_url($url)) . '">' . esc_html($label) . '</a></li>';
    }
    echo '</ul>';
}

function kff_fallback_footer_menu() {
    kff_fallback_menu();
}
