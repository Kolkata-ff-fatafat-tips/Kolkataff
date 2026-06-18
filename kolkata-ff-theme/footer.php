<?php if (!defined('ABSPATH')) exit; ?>
</main>
<footer class="kff-footer">
    <div class="kff-container kff-footer__grid">
        <div>
            <a class="kff-footer__brand" href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html(kff_get_option('site_name', get_bloginfo('name'))); ?></a>
            <p><?php echo esc_html(kff_get_option('tagline')); ?></p>
            <div class="kff-social">
                <?php if (kff_get_option('facebook_url')) : ?><a href="<?php echo esc_url(kff_get_option('facebook_url')); ?>">Facebook</a><?php endif; ?>
                <?php if (kff_get_option('telegram_url')) : ?><a href="<?php echo esc_url(kff_get_option('telegram_url')); ?>">Telegram</a><?php endif; ?>
                <?php if (kff_get_option('whatsapp_number')) : ?><a href="https://wa.me/<?php echo esc_attr(preg_replace('/\D+/', '', kff_get_option('whatsapp_number'))); ?>">WhatsApp</a><?php endif; ?>
                <?php if (kff_get_option('youtube_url')) : ?><a href="<?php echo esc_url(kff_get_option('youtube_url')); ?>">YouTube</a><?php endif; ?>
            </div>
        </div>
        <div>
            <h2>Quick Links</h2>
            <?php wp_nav_menu(array('theme_location' => 'footer', 'container' => false, 'fallback_cb' => 'kff_fallback_footer_menu', 'menu_class' => 'kff-footer-menu')); ?>
        </div>
        <div>
            <h2>Contact Us</h2>
            <p><?php echo esc_html(kff_get_option('contact_email')); ?><br><?php echo esc_html(kff_get_option('contact_phone')); ?><br><?php echo esc_html(kff_get_option('contact_address')); ?></p>
        </div>
    </div>
    <div class="kff-container kff-footer__bottom">
        <p><?php echo esc_html(kff_get_option('disclaimer_footer', 'This website is for informational purposes only. We do not promote or encourage gambling.')); ?></p>
        <p>&copy; <?php echo esc_html(date_i18n('Y')); ?> <?php echo esc_html(kff_get_option('site_name', get_bloginfo('name'))); ?>. All Rights Reserved.</p>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
