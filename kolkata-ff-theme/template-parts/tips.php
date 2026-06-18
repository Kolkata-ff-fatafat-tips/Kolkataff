<?php if (!defined('ABSPATH')) exit; $tips = kff_get_option('tips', array()); ?>
<section class="kff-container kff-section">
    <div class="kff-section__head">
        <p class="kff-eyebrow">Free Guessing Numbers</p>
        <h1>Kolkata FF Tips Today</h1>
        <p>Publish daily single-digit and Patti predictions from the dashboard.</p>
    </div>
    <div class="kff-tip-grid">
        <?php foreach ($tips as $tip) : ?>
            <article class="kff-tip-card">
                <span><?php echo esc_html($tip['bazi']); ?> Bazi</span>
                <strong><?php echo esc_html($tip['numbers']); ?></strong>
                <p><?php echo esc_html($tip['patti']); ?></p>
            </article>
        <?php endforeach; ?>
    </div>
    <p class="kff-note">Tips are predictions only and are not guarantees. Use the information responsibly.</p>
</section>
