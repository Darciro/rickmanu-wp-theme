<?php

/**
 * Front page "How I can help" section: the problems I can solve for
 * companies and teams, with a call to action for project inquiries.
 *
 * @package rickmanu
 */

$rickmanu_services = rickmanu_get_services();
?>
<section id="services" class="page-shell flex flex-col gap-10 pt-30 pb-10" aria-labelledby="services-title">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div class="flex max-w-180 flex-col gap-3">
            <span class="font-mono text-sm text-accent"><?php esc_html_e('04 / ./help --list', 'rickmanu'); ?></span>
            <h2 id="services-title" class="font-display text-[clamp(40px,6vw,52px)] leading-none font-extrabold tracking-[-0.03em]">
                <?php esc_html_e('How I can help', 'rickmanu'); ?>
            </h2>
            <p class="text-fg-muted">
                <?php esc_html_e('For companies and teams that need to build, evolve or connect software — and for teams that need an experienced technical hand.', 'rickmanu'); ?>
            </p>
        </div>

        <a href="<?php echo esc_url(rickmanu_get_contact_mailto('project')); ?>" class="inline-flex min-h-13 items-center gap-2.5 rounded-full bg-accent px-6 font-semibold text-ink transition-colors hover:bg-fg">
            <?php esc_html_e('Talk about a project', 'rickmanu'); ?>
            <svg class="size-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                <path d="M5 12h14"></path>
                <path d="M13 6l6 6-6 6"></path>
            </svg>
        </a>
    </div>

    <ul class="grid grid-cols-[repeat(auto-fit,minmax(min(260px,100%),1fr))] gap-4">
        <?php foreach ($rickmanu_services as $rickmanu_index => $rickmanu_service) : ?>
            <li class="flex flex-col gap-3.5 rounded-[22px] border border-line bg-surface p-7">
                <div class="flex items-center justify-between">
                    <span class="flex size-12 items-center justify-center rounded-[14px] border border-line-strong bg-ink text-accent" aria-hidden="true">
                        <svg class="size-5.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                            <?php echo $rickmanu_service['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static SVG markup from rickmanu_get_services(). ?>
                        </svg>
                    </span>
                    <span class="font-mono text-xs text-fg-subtle" aria-hidden="true"><?php echo esc_html(str_pad((string) ($rickmanu_index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                </div>
                <h3 class="font-display text-[23px] font-semibold tracking-[-0.01em]"><?php echo esc_html($rickmanu_service['title']); ?></h3>
                <p class="text-base text-fg-muted"><?php echo esc_html($rickmanu_service['text']); ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
