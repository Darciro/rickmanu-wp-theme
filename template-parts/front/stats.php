<?php

/**
 * Front page key numbers strip.
 *
 * @package rickmanu
 */

$rickmanu_stats = [
    [
        'value' => '2011',
        'label' => __('Building software since', 'rickmanu'),
    ],
    [
        'value' => (string) count(rickmanu_get_experience()),
        'label' => __('Companies, from public sector to global agencies', 'rickmanu'),
    ],
    [
        'value' => 'PSM II',
        'label' => __('Professional Scrum Master I & II', 'rickmanu'),
    ],
    [
        'value' => 'BR · EU',
        'label' => __('Teams across Brazil, Europe & Central Asia', 'rickmanu'),
    ],
];
?>
<section class="border-y border-line" aria-label="<?php esc_attr_e('Highlights', 'rickmanu'); ?>">
    <dl class="page-shell grid grid-cols-[repeat(auto-fit,minmax(220px,1fr))]">
        <?php foreach ($rickmanu_stats as $rickmanu_stat) : ?>
            <div class="flex flex-col-reverse justify-end gap-1 py-8 pr-6">
                <dt class="text-[15px] text-fg-subtle"><?php echo esc_html($rickmanu_stat['label']); ?></dt>
                <dd class="font-display text-5xl leading-none font-extrabold tracking-[-0.03em]"><?php echo esc_html($rickmanu_stat['value']); ?></dd>
            </div>
        <?php endforeach; ?>
    </dl>
</section>
