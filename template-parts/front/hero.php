<?php

/**
 * Front page hero: name, positioning, value proposition, core competencies,
 * calls to action and portrait.
 *
 * @package rickmanu
 */

$rickmanu_position = rickmanu_get_current_position();

$rickmanu_core = [
    'PHP / Laravel',
    'React / TypeScript',
    __('APIs & integrations', 'rickmanu'),
    __('Tech leadership', 'rickmanu'),
];
?>
<section id="top" class="page-shell grid grid-cols-1 items-center gap-14 pt-24 pb-20 md:grid-cols-[minmax(0,3fr)_minmax(0,2fr)] lg:grid-cols-[minmax(0,1fr)_380px] md:gap-10 lg:gap-14">
    <div id="intro" class="flex min-w-0 flex-col gap-7">
        <p class="flex flex-wrap items-center gap-2.5 font-mono text-sm text-fg-subtle">
            <span class="inline-block size-2 rounded-full bg-accent" aria-hidden="true"></span>
            <span class="text-accent" aria-hidden="true">&lt;<span id="role">developer</span>/&gt;</span>
            <span class="sr-only"><?php esc_html_e('Developer', 'rickmanu'); ?></span>
            <span><?php esc_html_e('· senior software engineer · BR / EU', 'rickmanu'); ?></span>
        </p>

        <div class="flex flex-col gap-3.5">
            <h1 class="font-display text-[clamp(52px,8vw,104px)] leading-[0.95] font-extrabold tracking-[-0.04em]">Ricardo Carvalho</h1>
            <p class="font-display text-[clamp(22px,2.6vw,32px)] leading-[1.2] font-semibold tracking-[-0.015em] text-accent">
                <?php esc_html_e('Senior Software Engineer · Full Stack · Architecture · Tech Leadership', 'rickmanu'); ?>
            </p>
        </div>

        <p class="max-w-160 text-[19px] text-fg-muted">
            <?php esc_html_e('I build digital products, modernize systems and help teams turn business needs into sustainable software — with more than a decade of experience in development, architecture and technical leadership across Brazil and Europe.', 'rickmanu'); ?>
        </p>

        <div class="flex flex-wrap items-center gap-2">
            <p id="hero-core" class="mr-1.5 font-mono text-[13px] text-fg-subtle"><?php esc_html_e('core →', 'rickmanu'); ?></p>
            <ul class="flex flex-wrap gap-2" aria-labelledby="hero-core">
                <?php foreach ($rickmanu_core as $rickmanu_item) : ?>
                    <li class="rounded-full border border-line-strong bg-surface px-3 py-1.5 text-sm"><?php echo esc_html($rickmanu_item); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="mt-2 flex flex-wrap gap-3">
            <a href="#projects" class="inline-flex min-h-13 items-center gap-2.5 rounded-full bg-accent px-6.5 font-semibold text-ink transition-colors hover:bg-fg">
                <?php esc_html_e('See my projects', 'rickmanu'); ?>
                <svg class="size-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                    <path d="M5 12h14"></path>
                    <path d="M13 6l6 6-6 6"></path>
                </svg>
            </a>
            <a href="#contact" class="inline-flex min-h-13 items-center rounded-full border border-edge px-6.5 font-medium transition-colors hover:border-accent hover:text-accent">
                <?php esc_html_e('Get in touch', 'rickmanu'); ?>
            </a>
        </div>
    </div>

    <div class="flex min-w-0 flex-col gap-4">
        <div class="aspect-4/5 overflow-hidden rounded-[28px] border border-line bg-surface">
            <img
                class="size-full object-cover grayscale transition-[filter] duration-500 hover:grayscale-0 motion-reduce:transition-none"
                src="<?php echo esc_url(get_theme_file_uri('assets/images/rick-manu.jpg')); ?>"
                width="860"
                height="860"
                alt="<?php esc_attr_e('Portrait of Ricardo Carvalho', 'rickmanu'); ?>"
                fetchpriority="high" />
        </div>

        <?php if ($rickmanu_position) : ?>
            <div class="flex items-center gap-3.5 rounded-[18px] border border-line bg-surface px-5 py-4.5">
                <span class="size-2.5 flex-none rounded-full bg-accent ring-5 ring-accent/15" aria-hidden="true"></span>
                <p class="flex min-w-0 flex-col gap-0.5">
                    <span class="font-mono text-xs text-fg-subtle"><?php esc_html_e('Currently', 'rickmanu'); ?></span>
                    <span class="font-semibold">
                        <?php
                        /* translators: 1: job title, 2: company name. */
                        echo esc_html(sprintf(__('%1$s @ %2$s', 'rickmanu'), $rickmanu_position['role'], $rickmanu_position['company']));
                        ?>
                    </span>
                </p>
            </div>
        <?php endif; ?>
    </div>
</section>
