<?php if (!defined('ABSPATH')) exit; ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="kff-skip" href="#content"><?php esc_html_e('Skip to content', 'kolkata-ff-theme'); ?></a>
<header class="kff-header">
    <div class="kff-container kff-header__inner">
        <a class="kff-brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php bloginfo('name'); ?>">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <span><?php echo esc_html(kff_get_option('site_name', get_bloginfo('name'))); ?></span>
            <?php endif; ?>
        </a>
        <nav class="kff-nav" aria-label="<?php esc_attr_e('Primary navigation', 'kolkata-ff-theme'); ?>">
            <button class="kff-icon-btn kff-menu-toggle" type="button" aria-label="<?php esc_attr_e('Open menu', 'kolkata-ff-theme'); ?>" aria-expanded="false">&#9776;</button>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'fallback_cb' => 'kff_fallback_menu',
                'menu_class' => 'kff-menu',
            ));
            ?>
        </nav>
        <button class="kff-icon-btn kff-dark-toggle" type="button" aria-label="<?php esc_attr_e('Toggle dark mode', 'kolkata-ff-theme'); ?>">&#9680;</button>
    </div>
</header>
<main id="content" class="kff-main">
