<?php if (!defined('ABSPATH')) exit; $rows = kff_get_option('old_results', array()); ?>
<section class="kff-container kff-section">
    <div class="kff-section__head">
        <p class="kff-eyebrow">History</p>
        <h1>Kolkata FF Old Result</h1>
        <p>Search date-wise previous result records for all 8 baazi rounds.</p>
    </div>
    <div class="kff-filter">
        <label>From <input type="date" data-old-from></label>
        <label>To <input type="date" data-old-to></label>
        <button class="kff-btn" type="button" data-old-filter>Search</button>
        <button class="kff-btn kff-btn--ghost" type="button" data-old-reset>Reset</button>
    </div>
    <div class="kff-table-wrap">
        <table class="kff-old-table">
            <thead>
                <tr><th>Date</th><?php for ($i = 1; $i <= 8; $i++) : ?><th>B<?php echo esc_html($i); ?></th><?php endfor; ?></tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row) : if (empty($row['date'])) continue; ?>
                    <tr data-date="<?php echo esc_attr($row['date']); ?>">
                        <td><?php echo esc_html(date_i18n('d M Y', strtotime($row['date']))); ?></td>
                        <?php for ($i = 1; $i <= 8; $i++) : ?>
                            <td><strong><?php echo esc_html($row['b' . $i . '_patti'] ?? '-'); ?></strong><span><?php echo esc_html($row['b' . $i . '_single'] ?? '-'); ?></span></td>
                        <?php endfor; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
