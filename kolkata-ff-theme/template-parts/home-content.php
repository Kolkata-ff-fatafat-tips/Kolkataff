<?php if (!defined('ABSPATH')) exit; ?>
<section class="kff-container kff-content-panel">
    <?php echo wp_kses_post(wpautop(kff_get_option('home_content'))); ?>
    <div class="kff-quick-links">
        <a href="<?php echo esc_url(home_url('/kolkata-ff-result-today/')); ?>">Today Result</a>
        <a href="<?php echo esc_url(home_url('/old-result/')); ?>">Old Results</a>
        <a href="<?php echo esc_url(home_url('/kolkata-ff-chart/')); ?>">FF Chart</a>
        <a href="<?php echo esc_url(home_url('/kolkata-ff-tips/')); ?>">Free Tips</a>
        <a href="<?php echo esc_url(home_url('/hot-numbers/')); ?>">Hot Numbers</a>
    </div>
</section>
<?php get_template_part('template-parts/tips'); ?>
<?php get_template_part('template-parts/hot-numbers'); ?>
