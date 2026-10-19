<?php

/**
 * Front page project grid.
 *
 * @package rickmanu
 */

$rickmanu_projects = rickmanu_get_projects();
$rickmanu_count    = count($rickmanu_projects);
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
                _n('%d project · web, games & platforms', '%d projects · web, games & platforms', $rickmanu_count, 'rickmanu'),
                $rickmanu_count
            )
        ) . '</span>',
    ]);
    ?>

    <ul class="grid grid-cols-[repeat(auto-fill,minmax(min(270px,100%),1fr))] gap-5">
        <?php foreach ($rickmanu_projects as $rickmanu_index => $rickmanu_project) : ?>
            <li>
                <a href="<?php echo esc_url($rickmanu_project['url']); ?>" target="_blank" rel="noopener noreferrer" class="group flex flex-col gap-3.5">
                    <div class="relative aspect-[4/3] overflow-hidden rounded-[18px] border border-line bg-surface transition-colors group-hover:border-accent">
                        <img
                            class="size-full object-cover grayscale transition duration-500 group-hover:scale-[1.03] group-hover:grayscale-0 motion-reduce:transition-none motion-reduce:group-hover:scale-100"
                            src="<?php echo esc_url(get_theme_file_uri('assets/images/projects/' . $rickmanu_project['image'])); ?>"
                            alt=""
                            loading="lazy"
                            decoding="async" />
                        <span class="absolute top-3.5 right-4 rounded-md bg-ink/80 px-2 py-0.5 font-mono text-xs text-fg-subtle" aria-hidden="true">
                            <?php echo esc_html(str_pad((string) ($rickmanu_index + 1), 2, '0', STR_PAD_LEFT)); ?>
                        </span>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <span class="font-display text-xl font-semibold transition-colors group-hover:text-accent">
                            <?php echo esc_html($rickmanu_project['title']); ?>
                            <span class="sr-only"><?php esc_html_e('(opens in a new tab)', 'rickmanu'); ?></span>
                        </span>
                        <span class="font-mono text-xs text-fg-subtle"><?php echo esc_html($rickmanu_project['type']); ?></span>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
