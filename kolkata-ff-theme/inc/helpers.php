<?php
if (!defined('ABSPATH')) {
    exit;
}

function kff_default_options() {
    return array(
        'site_name' => 'Kolkata FF',
        'tagline' => 'Live results, tips, Patti chart and old result archive.',
        'accent_color' => '#f5b301',
        'brand_color' => '#101820',
        'meta_description' => 'Check Kolkata FF result today, old results, free tips, hot numbers and Patti chart on a fast mobile optimized website.',
        'share_text' => 'Kolkata FF result update',
        'contact_email' => 'support@example.com',
        'contact_phone' => '+91-000-000-0000',
        'contact_address' => 'Kolkata, West Bengal, India',
        'whatsapp_number' => '',
        'telegram_url' => '',
        'facebook_url' => '',
        'youtube_url' => '',
        'enable_dark_default' => '0',
        'results' => kff_default_results(),
        'tips' => kff_default_tips(),
        'old_results' => kff_default_old_results(),
        'hot_numbers' => kff_default_hot_numbers(),
        'home_content' => kff_default_home_content(),
        'about_content' => kff_default_about_content(),
        'privacy_content' => kff_default_privacy_content(),
        'terms_content' => kff_default_terms_content(),
        'disclaimer_content' => kff_default_disclaimer_content(),
    );
}

function kff_get_options() {
    $saved = get_option('kff_theme_options', array());
    return wp_parse_args(is_array($saved) ? $saved : array(), kff_default_options());
}

function kff_get_option($key, $fallback = '') {
    $options = kff_get_options();
    return isset($options[$key]) ? $options[$key] : $fallback;
}

function kff_default_results() {
    $rows = array();
    $times = array('10:03 AM', '11:33 AM', '1:03 PM', '2:33 PM', '4:03 PM', '5:33 PM', '7:03 PM', '8:33 PM');
    for ($i = 1; $i <= 8; $i++) {
        $rows[] = array('bazi' => (string) $i, 'time' => $times[$i - 1], 'patti' => '---', 'single' => '-', 'status' => 'Waiting');
    }
    return $rows;
}

function kff_default_tips() {
    $tips = array();
    for ($i = 1; $i <= 8; $i++) {
        $tips[] = array('bazi' => (string) $i, 'numbers' => $i === 1 ? '0 2 4 6 8' : 'Waiting...', 'patti' => $i === 1 ? '128, 137, 560' : 'Waiting...');
    }
    return $tips;
}

function kff_default_old_results() {
    $items = array();
    for ($d = 1; $d <= 7; $d++) {
        $date = date_i18n('Y-m-d', strtotime('-' . $d . ' days'));
        $row = array('date' => $date);
        for ($i = 1; $i <= 8; $i++) {
            $row['b' . $i . '_patti'] = str_pad((string) (($d * 111 + $i * 17) % 1000), 3, '0', STR_PAD_LEFT);
            $row['b' . $i . '_single'] = (string) (($d + $i) % 10);
        }
        $items[] = $row;
    }
    return $items;
}

function kff_default_hot_numbers() {
    return array(
        array('number' => '7', 'count' => '18', 'type' => 'Hot'),
        array('number' => '3', 'count' => '16', 'type' => 'Hot'),
        array('number' => '0', 'count' => '14', 'type' => 'Warm'),
        array('number' => '5', 'count' => '4', 'type' => 'Cold'),
        array('number' => '9', 'count' => '3', 'type' => 'Cold'),
    );
}

function kff_default_home_content() {
    return '<h2>Kolkata FF Result Today - All Baazi Live Update</h2><p>Use this page as your daily result hub. Update all baazi numbers, Patti values, tips, hot numbers, contact details and SEO text from the Kolkata FF admin dashboard.</p><h2>Fast Mobile Result Experience</h2><p>The theme is built for quick loading on mobile, readable result tables, share-ready result cards, dark mode and a scratch reveal interaction.</p><h2>Responsible Information Notice</h2><p>This website is for informational and entertainment purposes only. It does not operate, promote or facilitate gambling. Please follow all laws applicable in your region.</p>';
}

function kff_default_about_content() {
    return '<h1>About Us</h1><p>We publish Kolkata FF related information, results, historical charts and number references in a clean mobile-first format.</p><h2>Our Focus</h2><p>Speed, clarity, easy editing and responsible publishing are the core goals of this website.</p>';
}

function kff_default_privacy_content() {
    return '<h1>Privacy Policy</h1><p>This website may collect basic analytics and contact form information to improve service quality. We do not sell visitor information.</p>';
}

function kff_default_terms_content() {
    return '<h1>Terms of Service</h1><p>By using this website you agree that the information is provided for general informational purposes only and may be updated without notice.</p>';
}

function kff_default_disclaimer_content() {
    return '<h1>Disclaimer</h1><p>This website is independent and informational. It does not promote, encourage or facilitate gambling. Visitors are responsible for complying with local laws.</p>';
}

function kff_today_label() {
    return date_i18n('l, j F Y');
}

function kff_render_content_section($type) {
    $map = array(
        'about' => 'about_content',
        'privacy' => 'privacy_content',
        'terms' => 'terms_content',
        'disclaimer' => 'disclaimer_content',
    );
    $key = isset($map[$type]) ? $map[$type] : 'about_content';
    return '<div class="kff-container kff-content-panel">' . wp_kses_post(wpautop(kff_get_option($key))) . '</div>';
}

function kff_patti_chart() {
    $chart = array();
    for ($root = 0; $root <= 9; $root++) {
        $chart[(string) $root] = array('SP' => array(), 'DP' => array(), 'TP' => array());
    }
    for ($n = 0; $n <= 999; $n++) {
        $patti = str_pad((string) $n, 3, '0', STR_PAD_LEFT);
        $digits = str_split($patti);
        $root = (string) (array_sum(array_map('intval', $digits)) % 10);
        $unique = count(array_unique($digits));
        $type = $unique === 1 ? 'TP' : ($unique === 2 ? 'DP' : 'SP');
        $chart[$root][$type][] = $patti;
    }
    return $chart;
}

function kff_inline_theme_vars() {
    $accent = sanitize_hex_color(kff_get_option('accent_color', '#f5b301')) ?: '#f5b301';
    $brand = sanitize_hex_color(kff_get_option('brand_color', '#101820')) ?: '#101820';
    echo '<style>:root{--kff-accent:' . esc_html($accent) . ';--kff-brand:' . esc_html($brand) . ';}</style>';
}
add_action('wp_head', 'kff_inline_theme_vars', 20);
