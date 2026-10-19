<?php

/**
 * Front page project grid with a details dialog.
 *
 * Each card links to the live project, so the grid still works without
 * JavaScript. assets/src/js/project-dialog.js upgrades the cards to open
 * the dialog below, filled from the JSON data block.
 *
 * @package rickmanu
 */

$rickmanu_projects = rickmanu_get_projects();
$rickmanu_count    = count($rickmanu_projects);

$rickmanu_dialog_data = array_map(
    static fn(array $project): array => [
        'title'       => $project['title'],
        'type'        => $project['type'],
        'year'        => $project['year'],
        'description' => $project['description'],
        'stack'       => $project['stack'],
        'url'         => esc_url_raw($project['url']),
        'github'      => esc_url_raw($project['github']),
        'image'       => esc_url_raw($project['image']),
    ],
    $rickmanu_projects
);

$rickmanu_arrow_icon = '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M7 17L17 7"></path><path d="M8 7h9v9"></path></svg>';
?>
<section id="projects" class="page-shell flex flex-col gap-12 pt-30 pb-10" aria-labelledby="projects-title">
    <?php
    get_template_part('template-parts/section-heading', null, [
        'eyebrow' => __('04 / ls ./projects', 'rickmanu'),
        'title'   => __('Selected projects', 'rickmanu'),
        'id'      => 'projects-title',
        'meta'    => '<span class="text-[15px] text-fg-subtle">' . esc_html(
            sprintf(
                /* translators: %d: number of projects. */
                _n('%d project · click one for details', '%d projects · click one for details', $rickmanu_count, 'rickmanu'),
                $rickmanu_count
            )
        ) . '</span>',
    ]);
    ?>

    <ul class="grid grid-cols-[repeat(auto-fill,minmax(min(270px,100%),1fr))] gap-5">
        <?php foreach ($rickmanu_projects as $rickmanu_index => $rickmanu_project) : ?>
            <li>
                <a
                    href="<?php echo esc_url($rickmanu_project['url']); ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="group flex flex-col gap-3.5 focus-visible:outline-none"
                    data-project="<?php echo esc_attr((string) $rickmanu_index); ?>">
                    <div class="relative aspect-4/3 overflow-hidden rounded-[18px] border border-line bg-surface transition duration-300 ease-[cubic-bezier(.2,.8,.2,1)] group-hover:-translate-y-1 group-hover:border-accent group-focus-visible:-translate-y-1 group-focus-visible:border-accent group-focus-visible:outline-2 group-focus-visible:outline-offset-3 group-focus-visible:outline-accent motion-reduce:transition-none motion-reduce:group-hover:translate-y-0">
                        <?php if ($rickmanu_project['image']) : ?>
                            <img
                                class="size-full object-cover grayscale transition duration-500 group-hover:scale-[1.03] group-hover:grayscale-0 group-focus-visible:grayscale-0 motion-reduce:transition-none motion-reduce:group-hover:scale-100"
                                src="<?php echo esc_url($rickmanu_project['image']); ?>"
                                alt=""
                                loading="lazy"
                                decoding="async" />
                        <?php endif; ?>
                        <span class="absolute top-3.5 left-4 rounded-md bg-ink/80 px-2 py-0.5 font-mono text-xs text-fg-subtle" aria-hidden="true">
                            <?php echo esc_html(str_pad((string) ($rickmanu_index + 1), 2, '0', STR_PAD_LEFT)); ?>
                        </span>
                        <span class="absolute top-2.5 right-2.5 flex size-9 scale-70 items-center justify-center rounded-full bg-accent text-ink opacity-0 transition duration-200 group-hover:scale-100 group-hover:opacity-100 group-focus-visible:scale-100 group-focus-visible:opacity-100 max-[820px]:scale-100 max-[820px]:opacity-100" aria-hidden="true">
                            <?php echo $rickmanu_arrow_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static SVG markup defined above. ?>
                        </span>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <span class="font-display text-xl font-semibold transition-colors group-hover:text-accent">
                            <?php echo esc_html($rickmanu_project['title']); ?>
                            <span class="sr-only" data-project-new-tab><?php esc_html_e('(opens in a new tab)', 'rickmanu'); ?></span>
                        </span>
                        <span class="flex-none font-mono text-xs text-fg-subtle"><?php echo esc_html($rickmanu_project['type']); ?></span>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <script type="application/json" id="project-dialog-data">
        <?php echo wp_json_encode($rickmanu_dialog_data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
    </script>

    <dialog
        id="project-dialog"
        class="project-dialog m-auto open:flex max-h-[calc(100dvh-32px)] w-[calc(100%-32px)] max-w-220 flex-col overflow-hidden rounded-[28px] border border-line-strong bg-surface p-0 text-fg shadow-[0_40px_120px_rgba(0,0,0,.6)] backdrop:bg-[rgba(5,6,8,.78)] backdrop:backdrop-blur-[6px] max-[820px]:mb-0 max-[820px]:max-h-[92dvh] max-[820px]:w-full max-[820px]:max-w-none max-[820px]:rounded-b-none"
        aria-labelledby="project-dialog-title">
        <div class="min-h-0 flex-1 overflow-y-auto overscroll-contain" data-project-scroll>
            <div class="relative aspect-16/8 border-b border-line bg-ink">
                <img class="size-full object-cover object-top" src="" alt="" decoding="async" data-project-field="image" />
                <form method="dialog">
                    <button type="submit" class="absolute top-3.5 right-3.5 flex size-11 cursor-pointer items-center justify-center rounded-full border border-line-strong bg-surface/90 text-fg transition-colors hover:border-accent" aria-label="<?php esc_attr_e('Close project details', 'rickmanu'); ?>">
                        <svg class="size-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true" focusable="false">
                            <path d="M6 6l12 12"></path>
                            <path d="M18 6L6 18"></path>
                        </svg>
                    </button>
                </form>
            </div>

            <div class="flex flex-col gap-5.5 p-[clamp(24px,4vw,40px)]">
                <p class="flex flex-wrap gap-x-4 gap-y-2 font-mono text-[13px]">
                    <span class="text-accent" data-project-field="position"></span>
                    <span class="text-fg-subtle" data-project-field="meta"></span>
                </p>
                <h3 id="project-dialog-title" class="font-display text-[clamp(32px,5vw,48px)] leading-[1.02] font-extrabold tracking-[-0.03em]" data-project-field="title"></h3>
                <p class="max-w-170 text-fg-muted" data-project-field="description"></p>

                <div class="flex flex-col gap-2.5" data-project-field="stack-wrap">
                    <span class="font-mono text-xs text-fg-subtle" id="project-dialog-stack"><?php esc_html_e('Stack', 'rickmanu'); ?></span>
                    <ul class="flex flex-wrap gap-2" aria-labelledby="project-dialog-stack" data-project-field="stack"></ul>
                </div>

                <div class="flex flex-wrap gap-3 pt-1">
                    <a href="#" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-13 items-center gap-2.5 rounded-full bg-accent px-6 font-semibold text-ink transition-colors hover:bg-fg" data-project-field="url">
                        <?php esc_html_e('View live project', 'rickmanu'); ?>
                        <?php echo $rickmanu_arrow_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static SVG markup defined above. ?>
                        <span class="sr-only"><?php esc_html_e('(opens in a new tab)', 'rickmanu'); ?></span>
                    </a>
                    <a href="#" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-13 items-center gap-2.5 rounded-full border border-edge px-6 font-medium transition-colors hover:border-accent hover:text-accent" data-project-field="github">
                        <svg class="size-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                            <path d="M9 19c-4.3 1.4-4.3-2.5-6-3m12 5v-3.5c0-1 .1-1.4-.5-2 2.8-.3 5.5-1.4 5.5-6a4.6 4.6 0 0 0-1.3-3.2 4.2 4.2 0 0 0-.1-3.2s-1.1-.3-3.5 1.3a12.3 12.3 0 0 0-6.2 0C6.5 2.8 5.4 3.1 5.4 3.1a4.2 4.2 0 0 0-.1 3.2A4.6 4.6 0 0 0 4 9.5c0 4.6 2.7 5.7 5.5 6-.6.6-.6 1.2-.5 2V21"></path>
                        </svg>
                        <?php esc_html_e('Source on GitHub', 'rickmanu'); ?>
                        <span class="sr-only"><?php esc_html_e('(opens in a new tab)', 'rickmanu'); ?></span>
                    </a>
                </div>

                <div class="flex justify-between gap-3 border-t border-line pt-5">
                    <button type="button" class="inline-flex min-h-11 min-w-0 cursor-pointer items-center gap-2 rounded-xl border border-line-strong px-3.5 text-sm text-fg-soft transition-colors hover:border-accent" data-project-step="-1">
                        <svg class="size-4 flex-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                            <path d="M19 12H5"></path>
                            <path d="M11 6l-6 6 6 6"></path>
                        </svg>
                        <span class="sr-only"><?php esc_html_e('Previous project:', 'rickmanu'); ?></span>
                        <span class="truncate hidden" data-project-field="prev"></span>
                    </button>
                    <button type="button" class="inline-flex min-h-11 min-w-0 cursor-pointer items-center gap-2 rounded-xl border border-line-strong px-3.5 text-sm text-fg-soft transition-colors hover:border-accent" data-project-step="1">
                        <span class="sr-only"><?php esc_html_e('Next project:', 'rickmanu'); ?></span>
                        <span class="truncate hidden" data-project-field="next"></span>
                        <svg class="size-4 flex-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                            <path d="M5 12h14"></path>
                            <path d="M13 6l6 6-6 6"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </dialog>
</section>
