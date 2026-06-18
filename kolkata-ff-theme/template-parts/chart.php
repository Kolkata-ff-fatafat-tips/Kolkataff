<?php if (!defined('ABSPATH')) exit; $chart = kff_patti_chart(); ?>
<section class="kff-container kff-section">
    <div class="kff-section__head">
        <p class="kff-eyebrow">Reference Chart</p>
        <h1>Kolkata FF Patti Chart</h1>
        <p>Lookup any three-digit Patti and browse combinations by root single number.</p>
    </div>
    <div class="kff-calculator">
        <label>Type Patti <input maxlength="3" inputmode="numeric" pattern="[0-9]*" data-patti-input placeholder="128"></label>
        <button class="kff-btn" type="button" data-patti-calc>Generate Patti</button>
        <div class="kff-calculator__result"><span>Single Number</span><strong data-patti-result>-</strong></div>
    </div>
    <div class="kff-tabs" role="tablist">
        <?php foreach (array('1','2','3','4','5','6','7','8','9','0') as $digit) : ?>
            <button type="button" data-chart-tab="<?php echo esc_attr($digit); ?>" class="<?php echo $digit === '1' ? 'is-active' : ''; ?>"><?php echo esc_html($digit); ?></button>
        <?php endforeach; ?>
    </div>
    <?php foreach ($chart as $digit => $groups) : ?>
        <div class="kff-chart-panel <?php echo $digit === '1' ? 'is-active' : ''; ?>" data-chart-panel="<?php echo esc_attr($digit); ?>">
            <?php foreach ($groups as $type => $items) : ?>
                <article class="kff-chart-group">
                    <h2><?php echo esc_html($type); ?> Patti <span><?php echo esc_html(count($items)); ?></span></h2>
                    <div class="kff-patti-list">
                        <?php foreach ($items as $patti) : ?><span><?php echo esc_html($patti); ?></span><?php endforeach; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</section>
