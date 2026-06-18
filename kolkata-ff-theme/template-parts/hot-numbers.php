<?php if (!defined('ABSPATH')) exit; $numbers = kff_get_option('hot_numbers', array()); ?>
<section class="kff-container kff-section">
    <div class="kff-section__head">
        <p class="kff-eyebrow">Pattern Snapshot</p>
        <h1>Kolkata FF Hot Numbers</h1>
        <p>Highlight frequent and less frequent digits using your latest result data.</p>
    </div>
    <div class="kff-hot-grid">
        <?php foreach ($numbers as $item) : if (empty($item['number'])) continue; ?>
            <article class="kff-hot-card kff-hot-card--<?php echo esc_attr(strtolower($item['type'])); ?>">
                <span><?php echo esc_html($item['type']); ?></span>
                <strong><?php echo esc_html($item['number']); ?></strong>
                <p><?php echo esc_html($item['count']); ?> hits</p>
            </article>
        <?php endforeach; ?>
    </div>
</section>
