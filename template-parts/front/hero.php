<?php

/**
 * Front page hero: headline, intro, calls to action and portrait.
 *
 * @package rickmanu
 */

?>
<section id="top" class="page-shell grid grid-cols-1 items-center gap-14 pt-24 pb-20 md:grid-cols-[minmax(0,3fr)_minmax(0,2fr)] lg:grid-cols-[minmax(0,1fr)_380px] md:gap-10 lg:gap-14">
    <div class="flex min-w-0 flex-col gap-7">
        <p class="flex flex-wrap items-center gap-2.5 font-mono text-sm text-fg-subtle">
            <span class="inline-block size-2 rounded-full bg-accent" aria-hidden="true"></span>
            <span class="text-accent" aria-hidden="true">&lt;<span id="role">developer</span>/&gt;</span>
            <span class="sr-only"><?php esc_html_e('Developer', 'rickmanu'); ?></span>
            <span><?php esc_html_e('· fullstack · since 2011', 'rickmanu'); ?></span>
        </p>

        <h1 class="font-display text-[clamp(44px,7vw,92px)] leading-[0.98] font-extrabold tracking-[-0.035em]">
            <?php esc_html_e('Ricardo Carvalho builds web & mobile products,', 'rickmanu'); ?>
            <span class="text-accent"><?php esc_html_e('end to end.', 'rickmanu'); ?></span>
        </h1>

        <p class="max-w-155 text-[19px] text-fg-muted">
            <?php esc_html_e('Fullstack developer with deep roots in PHP, C#, React, React Native and Angular — designing scalable apps, robust back-ends and intuitive front-ends for teams across Brazil and Europe.', 'rickmanu'); ?>
        </p>

        <div class="mt-2 flex flex-wrap gap-3">
            <a href="#projects" class="inline-flex min-h-13 items-center gap-2.5 rounded-full bg-accent px-6.5 font-semibold text-ink transition-colors hover:bg-fg">
                <?php esc_html_e('View projects', 'rickmanu'); ?>
                <svg class="size-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                    <path d="M5 12h14"></path>
                    <path d="M13 6l6 6-6 6"></path>
                </svg>
            </a>
            <a href="mailto:rickmanu@gmail.com" class="inline-flex min-h-13 items-center rounded-full border border-edge px-6.5 font-medium transition-colors hover:border-accent hover:text-accent">
                rickmanu@gmail.com
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

        <div class="flex items-center gap-3.5 rounded-[18px] border border-line bg-surface px-5 py-4.5">
            <span class="size-2.5 flex-none rounded-full bg-accent ring-5 ring-accent/15" aria-hidden="true"></span>
            <div class="flex min-w-0 flex-col gap-0.5">
                <span class="font-mono text-xs text-fg-subtle"><?php esc_html_e('Currently', 'rickmanu'); ?></span>
                <span class="font-semibold"><?php esc_html_e('Smart Integrations Engineer @ Merkle (Dentsu Group)', 'rickmanu'); ?></span>
            </div>
        </div>
    </div>
</section>
