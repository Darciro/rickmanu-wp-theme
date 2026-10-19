<?php

/**
 * Section heading: mono eyebrow, display title and optional right-aligned meta.
 *
 * Expected $args:
 * - eyebrow (string) Short terminal-style label above the title.
 * - title   (string) Section title.
 * - id      (string) Optional id for the <h2>, used by aria-labelledby.
 * - meta    (string) Optional pre-escaped HTML shown on the right side.
 *
 * @package rickmanu
 */

$args = wp_parse_args($args ?? [], [
    'eyebrow' => '',
    'title'   => '',
    'id'      => '',
    'meta'    => '',
]);
?>
<div class="flex flex-wrap items-end justify-between gap-4">
    <div class="flex flex-col gap-3">
        <span class="font-mono text-sm text-accent"><?php echo esc_html($args['eyebrow']); ?></span>
        <h2 <?php echo $args['id'] ? 'id="' . esc_attr($args['id']) . '"' : ''; ?> class="font-display text-[clamp(40px,6vw,52px)] leading-none font-extrabold tracking-[-0.03em]">
            <?php echo esc_html($args['title']); ?>
        </h2>
    </div>
    <?php
    if ($args['meta']) {
        echo $args['meta']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Callers pass escaped markup.
    }
    ?>
</div>
