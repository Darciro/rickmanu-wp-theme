<?php

/**
 * Front page "About me" section.
 *
 * @package rickmanu
 */

$rickmanu_about_cards = [
    [
        'title' => __('Education', 'rickmanu'),
        'text'  => __('Degree in Information Technology Management (UNIP) and postgraduate degree in Software Engineering (IESB) — systems analysis, project management and software quality.', 'rickmanu'),
        'icon'  => '<path d="M22 10L12 5 2 10l10 5 10-5z"></path><path d="M6 12v5c3 2 9 2 12 0v-5"></path>',
    ],
    [
        'title' => __('Certifications', 'rickmanu'),
        'text'  => __('Professional Scrum Master I and II by Scrum.org — agile practices, team facilitation, backlog management and continuous improvement.', 'rickmanu'),
        'icon'  => '<circle cx="12" cy="9" r="6"></circle><path d="M8.5 14L7 22l5-3 5 3-1.5-8"></path>',
    ],
];
?>
<section id="about" class="page-shell flex flex-wrap gap-12 pt-30 pb-10" aria-labelledby="about-title">
    <div class="flex flex-[1_1_280px] flex-col gap-3">
        <span class="font-mono text-sm text-accent"><?php esc_html_e('01 / $ whoami', 'rickmanu'); ?></span>
        <h2 id="about-title" class="font-display text-[clamp(40px,6vw,52px)] leading-none font-extrabold tracking-[-0.03em]">
            <?php esc_html_e('About me', 'rickmanu'); ?>
        </h2>
    </div>

    <div class="flex min-w-0 flex-[999_1_560px] flex-col gap-8">
        <p class="text-2xl leading-normal tracking-[-0.005em] text-fg-soft">
            <?php esc_html_e("I'm a software developer who began my career in 2011 as an engineer and have since specialized as a fullstack developer with strong expertise in PHP, C#, React, React Native, and Angular.", 'rickmanu'); ?>
        </p>
        <p class="text-fg-muted">
            <?php esc_html_e('I have designed and implemented scalable web and mobile applications, built robust back-end architectures, and crafted intuitive front-end experiences. My work spans projects such as internal CRM systems (including commercial modules and invoicing), commercial and logistics solutions for the food industry, and web platforms for the property and training sectors.', 'rickmanu'); ?>
        </p>

        <div class="grid grid-cols-[repeat(auto-fit,minmax(min(260px,100%),1fr))] gap-4">
            <?php foreach ($rickmanu_about_cards as $rickmanu_card) : ?>
                <div class="flex flex-col gap-3 rounded-[20px] border border-line bg-surface p-7">
                    <svg class="size-7 text-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                        <?php echo $rickmanu_card['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static SVG markup defined above. ?>
                    </svg>
                    <h3 class="font-display text-[22px] font-semibold"><?php echo esc_html($rickmanu_card['title']); ?></h3>
                    <p class="text-base text-fg-muted"><?php echo esc_html($rickmanu_card['text']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
