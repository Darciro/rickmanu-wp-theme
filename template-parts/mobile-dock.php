<?php

/**
 * Bottom navigation dock shown instead of the main menu on small screens.
 *
 * Rendered outside #smooth-wrapper so position: fixed is not affected by the
 * ScrollSmoother transform.
 *
 * @package rickmanu
 */

?>
<nav data-dock class="fixed inset-x-3 bottom-[calc(12px+env(safe-area-inset-bottom))] z-40 hidden justify-between gap-1 rounded-[22px] border border-line-strong bg-surface/86 p-1.5 shadow-[0_16px_40px_rgba(0,0,0,.5)] backdrop-blur-[18px] max-[820px]:flex" aria-label="<?php esc_attr_e('Sections', 'rickmanu'); ?>">
    <?php foreach (rickmanu_get_dock_items() as $rickmanu_anchor => $rickmanu_item) : ?>
        <a href="<?php echo esc_url(rickmanu_home_url('#' . $rickmanu_anchor)); ?>" class="flex min-h-14 min-w-0 flex-1 flex-col items-center justify-center gap-0.75 rounded-2xl text-[11px] font-medium text-fg-muted transition-colors hover:text-accent data-active:bg-accent/12 data-active:text-accent">
            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                <?php echo $rickmanu_item['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static SVG markup from rickmanu_get_dock_items(). ?>
            </svg>
            <?php echo esc_html($rickmanu_item['label']); ?>
        </a>
    <?php endforeach; ?>
</nav>
