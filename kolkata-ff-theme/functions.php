<?php
if (!defined('ABSPATH')) {
    exit;
}

define('KFF_THEME_VERSION', '1.0.0');
define('KFF_THEME_DIR', get_template_directory());
define('KFF_THEME_URI', get_template_directory_uri());

require_once KFF_THEME_DIR . '/inc/helpers.php';
require_once KFF_THEME_DIR . '/inc/admin.php';

function kff_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array('height' => 72, 'width' => 260, 'flex-height' => true, 'flex-width' => true));
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
    add_theme_support('align-wide');
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'kolkata-ff-theme'),
        'footer' => __('Footer Menu', 'kolkata-ff-theme'),
    ));
}
add_action('after_setup_theme', 'kff_theme_setup');

function kff_enqueue_assets() {
    wp_enqueue_style('kff-theme', KFF_THEME_URI . '/assets/css/theme.css', array(), KFF_THEME_VERSION);
    wp_enqueue_script('kff-theme', KFF_THEME_URI . '/assets/js/theme.js', array(), KFF_THEME_VERSION, true);
    wp_localize_script('kff-theme', 'KFF_THEME', array(
        'siteName' => kff_get_option('site_name', get_bloginfo('name')),
        'oldResultUrl' => home_url('/old-result/'),
        'shareText' => kff_get_option('share_text', 'Kolkata FF result update'),
    ));
}
add_action('wp_enqueue_scripts', 'kff_enqueue_assets');

function kff_body_classes($classes) {
    $classes[] = 'kff-site';
    if (kff_get_option('enable_dark_default', '0') === '1') {
        $classes[] = 'kff-dark-default';
    }
    return $classes;
}
add_filter('body_class', 'kff_body_classes');

function kff_register_result_post_type() {
    register_post_type('kff_result', array(
        'labels' => array(
            'name' => __('Result Archive', 'kolkata-ff-theme'),
            'singular_name' => __('Result Day', 'kolkata-ff-theme'),
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => 'kff-dashboard',
        'supports' => array('title', 'editor', 'custom-fields'),
        'menu_icon' => 'dashicons-chart-line',
    ));
}
add_action('init', 'kff_register_result_post_type');

function kff_theme_activation_pages() {
    $pages = array(
        'home' => array('Home', '[kff_home]'),
        'about-us' => array('About Us', '[kff_page_section type="about"]'),
        'old-result' => array('Old Result', '[kff_old_results]'),
        'hot-numbers' => array('Hot Numbers', '[kff_hot_numbers]'),
        'kolkata-ff-chart' => array('FF Chart', '[kff_chart]'),
        'kolkata-ff-tips' => array('Tips', '[kff_tips]'),
        'contact' => array('Contact', '[kff_contact]'),
        'kolkata-ff-result-today' => array('Kolkata FF Result Today', '[kff_home]'),
        'kolkata-fatafat-result' => array('Kolkata Fatafat Result', '[kff_home]'),
        'kolkata-ff-previous-result' => array('Kolkata FF Previous Result', '[kff_old_results]'),
        'privacy-policy' => array('Privacy Policy', '[kff_page_section type="privacy"]'),
        'terms-of-service' => array('Terms of Service', '[kff_page_section type="terms"]'),
        'disclaimer' => array('Disclaimer', '[kff_page_section type="disclaimer"]'),
    );

    foreach ($pages as $slug => $page) {
        if (!get_page_by_path($slug)) {
            wp_insert_post(array(
                'post_title' => $page[0],
                'post_name' => $slug,
                'post_content' => $page[1],
                'post_status' => 'publish',
                'post_type' => 'page',
            ));
        }
    }

    $home = get_page_by_path('home');
    if ($home) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home->ID);
    }
}
add_action('after_switch_theme', 'kff_theme_activation_pages');

function kff_shortcode_home() {
    ob_start();
    get_template_part('template-parts/result-board');
    get_template_part('template-parts/home-content');
    return ob_get_clean();
}
add_shortcode('kff_home', 'kff_shortcode_home');

function kff_shortcode_old_results() {
    ob_start();
    get_template_part('template-parts/old-results');
    return ob_get_clean();
}
add_shortcode('kff_old_results', 'kff_shortcode_old_results');

function kff_shortcode_hot_numbers() {
    ob_start();
    get_template_part('template-parts/hot-numbers');
    return ob_get_clean();
}
add_shortcode('kff_hot_numbers', 'kff_shortcode_hot_numbers');

function kff_shortcode_chart() {
    ob_start();
    get_template_part('template-parts/chart');
    return ob_get_clean();
}
add_shortcode('kff_chart', 'kff_shortcode_chart');

function kff_shortcode_tips() {
    ob_start();
    get_template_part('template-parts/tips');
    return ob_get_clean();
}
add_shortcode('kff_tips', 'kff_shortcode_tips');

function kff_shortcode_contact() {
    ob_start();
    get_template_part('template-parts/contact');
    return ob_get_clean();
}
add_shortcode('kff_contact', 'kff_shortcode_contact');

function kff_shortcode_page_section($atts) {
    $atts = shortcode_atts(array('type' => 'about'), $atts);
    return kff_render_content_section($atts['type']);
}
add_shortcode('kff_page_section', 'kff_shortcode_page_section');

function kff_meta_description() {
    if (is_admin()) {
        return;
    }
    $description = kff_get_option('meta_description', 'Fast Kolkata FF live result, old result chart, free tips, hot numbers and Patti chart.');
    echo "\n" . '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr(wp_get_document_title()) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:type" content="website">' . "\n";
    echo '<meta property="og:url" content="' . esc_url(home_url(add_query_arg(array(), $GLOBALS['wp']->request ?? ''))) . '">' . "\n";
}
add_action('wp_head', 'kff_meta_description', 2);
