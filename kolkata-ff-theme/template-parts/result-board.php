<?php if (!defined('ABSPATH')) exit; $results = kff_get_option('results', array()); ?>
<section class="kff-hero">
    <div class="kff-container kff-hero__grid">
        <div class="kff-scratch" data-scratch>
            <p class="kff-eyebrow">Scratch to reveal result</p>
            <h1><?php echo esc_html(kff_get_option('site_name', 'Kolkata FF')); ?></h1>
            <?php $first = $results[0] ?? array('bazi' => '1', 'patti' => '---', 'single' => '-'); ?>
            <div class="kff-scratch__card">
                <span>Bazi <?php echo esc_html($first['bazi']); ?></span>
                <strong><?php echo esc_html($first['patti']); ?></strong>
                <b><?php echo esc_html($first['single']); ?></b>
                <button type="button" data-reveal>Open Result</button>
            </div>
        </div>
        <div class="kff-live-card" id="kff-share-card">
            <p class="kff-date"><?php echo esc_html(kff_today_label()); ?></p>
            <h2>Live Result</h2>
            <p class="kff-live-card__site"><?php echo esc_html(parse_url(home_url(), PHP_URL_HOST)); ?></p>
            <div class="kff-result-grid" role="table" aria-label="Live Kolkata FF result">
                <div class="kff-result-grid__head" role="row">
                    <?php foreach ($results as $row) : ?><span role="columnheader"><?php echo esc_html($row['bazi']); ?></span><?php endforeach; ?>
                </div>
                <div class="kff-result-grid__patti" role="row">
                    <?php foreach ($results as $row) : ?><span role="cell"><?php echo esc_html($row['patti']); ?></span><?php endforeach; ?>
                </div>
                <div class="kff-result-grid__single" role="row">
                    <?php foreach ($results as $row) : ?><span role="cell"><?php echo esc_html($row['single']); ?></span><?php endforeach; ?>
                </div>
            </div>
            <div class="kff-action-row">
                <button class="kff-btn" type="button" data-refresh>Load Result</button>
                <button class="kff-btn kff-btn--ghost" type="button" data-share>Share</button>
                <a class="kff-btn kff-btn--ghost" href="<?php echo esc_url(home_url('/old-result/')); ?>">Old Result</a>
            </div>
        </div>
    </div>
</section>
