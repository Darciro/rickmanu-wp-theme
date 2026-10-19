<?php

/**
 * Front page skills explorer.
 *
 * Renders every skill server-side (grouped and A–Z views) so the section works
 * without JavaScript. assets/src/js/skills-explorer.js reveals the toolbar and
 * drives search, category filter and view mode through data-* / aria-* state,
 * which the Tailwind variants below style.
 *
 * @package rickmanu
 */

$rickmanu_categories = rickmanu_get_skill_categories();
$rickmanu_total      = array_sum(array_map(static fn(array $category): int => count($category['skills']), $rickmanu_categories));

$rickmanu_wall = [];
foreach ($rickmanu_categories as $rickmanu_category) {
    foreach ($rickmanu_category['skills'] as $rickmanu_skill) {
        $rickmanu_wall[] = [
            'name'     => $rickmanu_skill,
            'category' => $rickmanu_category['id'],
            'color'    => $rickmanu_category['color'],
        ];
    }
}
usort($rickmanu_wall, static fn(array $a, array $b): int => strcasecmp($a['name'], $b['name']));

$rickmanu_chip_class = 'inline-flex items-center gap-2 rounded-full border border-line-strong bg-ink px-3.5 py-[7px] leading-[1.4] text-fg-soft transition-[opacity,border-color,box-shadow,transform] duration-250 motion-reduce:transition-none data-[match=no]:border-line data-[match=no]:opacity-25 data-[match=lit]:-translate-y-px data-[match=lit]:border-(--cat) data-[match=lit]:text-fg data-[match=lit]:shadow-[0_0_0_3px_color-mix(in_srgb,var(--cat)_20%,transparent)]';
$rickmanu_accent     = '#C8F05A';
$rickmanu_suggest    = ['react', 'laravel', 'sql', 'docker', 'wordpress'];

$rickmanu_counter = sprintf(
    /* translators: 1: number of matching technologies, 2: number of technologies listed. */
    esc_html__('%1$s / %2$s technologies', 'rickmanu'),
    '<span data-skills-count class="font-display text-[40px] font-extrabold tracking-[-0.03em] text-fg">' . esc_html($rickmanu_total) . '</span>',
    '<span data-skills-total>' . esc_html($rickmanu_total) . '</span>'
);
?>
<section id="skills" class="page-shell flex flex-col gap-10 pt-30 pb-10" aria-labelledby="skills-title" data-skills-explorer>
    <?php
    get_template_part('template-parts/section-heading', null, [
        'eyebrow' => __('03 / cat stack.json | grep', 'rickmanu'),
        'title'   => __('Skills & stack', 'rickmanu'),
        'id'      => 'skills-title',
        'meta'    => '<p class="font-mono text-sm text-fg-subtle" aria-live="polite">' . $rickmanu_counter . '</p>',
    ]);
    ?>

    <div data-skills-toolbar hidden class="flex flex-col gap-4.5 rounded-3xl border border-line bg-surface p-5">
        <div class="flex flex-wrap items-stretch gap-3">
            <label for="skills-query" class="flex min-h-14 min-w-0 flex-[999_1_380px] items-center gap-3 rounded-2xl border border-line-strong bg-ink px-4.5 font-mono text-[15px] transition-colors focus-within:border-accent has-[input:not(:placeholder-shown)]:border-accent">
                <span class="flex-none text-accent" aria-hidden="true">$ grep -i</span>
                <span class="sr-only"><?php esc_html_e('Search skills', 'rickmanu'); ?></span>
                <input
                    id="skills-query"
                    data-skills-query
                    type="search"
                    placeholder="<?php esc_attr_e('react, laravel, docker…', 'rickmanu'); ?>"
                    autocomplete="off"
                    class="peer h-13 min-w-0 flex-1 bg-transparent text-fg outline-none placeholder:text-fg-subtle [&::-webkit-search-cancel-button]:hidden" />
                <button type="button" data-skills-clear aria-label="<?php esc_attr_e('Clear search', 'rickmanu'); ?>" class="inline-flex size-9 flex-none cursor-pointer items-center justify-center rounded-[10px] border border-line-strong bg-surface text-fg-subtle transition-colors peer-placeholder-shown:hidden hover:text-fg">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true" focusable="false">
                        <path d="M6 6l12 12"></path>
                        <path d="M18 6L6 18"></path>
                    </svg>
                </button>
            </label>

            <div role="group" aria-label="<?php esc_attr_e('View mode', 'rickmanu'); ?>" class="flex flex-[1_1_220px] gap-1 rounded-2xl border border-line bg-ink p-1">
                <?php
                $rickmanu_modes = [
                    'grouped' => __('By category', 'rickmanu'),
                    'wall'    => __('A–Z wall', 'rickmanu'),
                ];
                foreach ($rickmanu_modes as $rickmanu_mode => $rickmanu_mode_label) :
                ?>
                    <button type="button" data-skills-mode="<?php echo esc_attr($rickmanu_mode); ?>" aria-pressed="<?php echo 'grouped' === $rickmanu_mode ? 'true' : 'false'; ?>" class="min-h-11 flex-1 cursor-pointer rounded-xl px-3.5 text-sm font-semibold text-fg-subtle transition-colors hover:text-fg aria-pressed:bg-fg aria-pressed:text-ink">
                        <?php echo esc_html($rickmanu_mode_label); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <div role="group" aria-label="<?php esc_attr_e('Filter by category', 'rickmanu'); ?>" class="flex flex-wrap items-center gap-2">
            <?php
            $rickmanu_pills = array_merge(
                [['id' => 'all', 'label' => __('All', 'rickmanu'), 'color' => $rickmanu_accent, 'count' => $rickmanu_total]],
                array_map(
                    static fn(array $category): array => [
                        'id'    => $category['id'],
                        'label' => $category['label'],
                        'color' => $category['color'],
                        'count' => count($category['skills']),
                    ],
                    $rickmanu_categories
                )
            );
            foreach ($rickmanu_pills as $rickmanu_pill) :
            ?>
                <button
                    type="button"
                    data-skills-category="<?php echo esc_attr($rickmanu_pill['id']); ?>"
                    aria-pressed="<?php echo 'all' === $rickmanu_pill['id'] ? 'true' : 'false'; ?>"
                    style="--cat: <?php echo esc_attr($rickmanu_pill['color']); ?>"
                    class="group inline-flex min-h-10 cursor-pointer items-center gap-2 rounded-full border border-line-strong px-3.5 text-sm font-medium text-fg-soft transition-colors hover:border-(--cat) aria-pressed:border-(--cat) aria-pressed:bg-(--cat) aria-pressed:text-ink">
                    <?php echo esc_html($rickmanu_pill['label']); ?>
                    <span data-skills-category-count class="rounded-full bg-line px-1.75 py-px font-mono text-xs text-fg-subtle group-aria-pressed:bg-ink/15 group-aria-pressed:text-ink">
                        <?php echo esc_html($rickmanu_pill['count']); ?>
                    </span>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="flex flex-wrap items-center gap-2 font-mono text-[13px] text-fg-subtle">
            <span><?php esc_html_e('try →', 'rickmanu'); ?></span>
            <?php foreach ($rickmanu_suggest as $rickmanu_term) : ?>
                <button type="button" data-skills-suggest="<?php echo esc_attr($rickmanu_term); ?>" class="min-h-8 cursor-pointer rounded-lg border border-dashed border-edge px-2.5 text-fg-soft transition-colors hover:border-accent hover:text-accent">
                    <?php echo esc_html($rickmanu_term); ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>

    <div data-skills-empty hidden class="flex flex-col items-start gap-2.5 rounded-[20px] border border-dashed border-edge px-7 py-10">
        <?php /* translators: %s: search term typed by the visitor. */ ?>
        <span data-skills-empty-query data-template="<?php echo esc_attr__('grep: no match for "%s"', 'rickmanu'); ?>" class="font-mono text-sm text-fg-subtle"></span>
        <span class="font-display text-[28px] font-semibold"><?php esc_html_e('Not on the list yet — but I pick things up fast.', 'rickmanu'); ?></span>
        <a href="mailto:rickmanu@gmail.com" class="font-medium text-accent hover:underline"><?php esc_html_e('Ask me about it →', 'rickmanu'); ?></a>
    </div>

    <div data-skills-view="grouped" class="grid grid-cols-[repeat(auto-fit,minmax(min(340px,100%),1fr))] gap-4">
        <?php
        foreach ($rickmanu_categories as $rickmanu_category) :
            $rickmanu_size = count($rickmanu_category['skills']);
            $rickmanu_pct  = (int) round($rickmanu_size / $rickmanu_total * 100);
        ?>
            <div
                data-skills-card
                data-category="<?php echo esc_attr($rickmanu_category['id']); ?>"
                style="--cat: <?php echo esc_attr($rickmanu_category['color']); ?>"
                class="flex flex-col gap-4 rounded-[20px] border border-line bg-surface p-6 transition-opacity duration-250 data-[state=dim]:opacity-40 data-[state=match]:border-[color-mix(in_srgb,var(--cat)_40%,transparent)]">
                <div class="flex items-center justify-between gap-3">
                    <h3 class="flex items-center gap-2.5 font-mono text-[13px] text-fg-soft">
                        <span class="size-2.5 rounded-[3px] bg-(--cat)" aria-hidden="true"></span>
                        <?php echo esc_html($rickmanu_category['label']); ?>
                    </h3>
                    <span data-skills-card-meta class="font-mono text-xs text-fg-subtle">
                        <?php
                        /* translators: 1: number of skills in the category, 2: share of the whole stack in percent. */
                        echo esc_html(sprintf(__('%1$d · %2$d%% of stack', 'rickmanu'), $rickmanu_size, $rickmanu_pct));
                        ?>
                    </span>
                </div>
                <div class="h-1 overflow-hidden rounded bg-line" aria-hidden="true">
                    <div data-skills-bar class="h-full rounded bg-(--cat) transition-[width] duration-400 motion-reduce:transition-none" style="width: <?php echo esc_attr(min(100, $rickmanu_pct * 2.5)); ?>%"></div>
                </div>
                <ul data-skills-list class="flex flex-wrap gap-2">
                    <?php foreach ($rickmanu_category['skills'] as $rickmanu_skill) : ?>
                        <li data-skill="<?php echo esc_attr($rickmanu_skill); ?>" class="<?php echo esc_attr($rickmanu_chip_class); ?> text-[15px]">
                            <span data-skill-label><?php echo esc_html($rickmanu_skill); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>

    <ul data-skills-view="wall" hidden class="flex flex-wrap items-center gap-2.5 rounded-3xl border border-line bg-surface p-7">
        <?php foreach ($rickmanu_wall as $rickmanu_item) : ?>
            <li
                data-skill="<?php echo esc_attr($rickmanu_item['name']); ?>"
                data-category="<?php echo esc_attr($rickmanu_item['category']); ?>"
                style="--cat: <?php echo esc_attr($rickmanu_item['color']); ?>"
                class="<?php echo esc_attr($rickmanu_chip_class); ?> text-base">
                <span class="size-[7px] flex-none rounded-full bg-(--cat)" aria-hidden="true"></span>
                <span data-skill-label><?php echo esc_html($rickmanu_item['name']); ?></span>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="flex flex-wrap items-center gap-x-3 gap-y-2.5 rounded-[20px] border border-dashed border-edge px-7 py-6">
        <h3 class="mr-2 font-mono text-[13px] text-accent"><?php esc_html_e('soft skills →', 'rickmanu'); ?></h3>
        <ul class="flex flex-wrap items-center gap-x-3 gap-y-2.5">
            <?php foreach (rickmanu_get_soft_skills() as $rickmanu_soft_skill) : ?>
                <li class="text-[15px] text-fg-soft not-last:after:ml-3 not-last:after:text-fg-faint not-last:after:content-['/']">
                    <?php echo esc_html($rickmanu_soft_skill); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
