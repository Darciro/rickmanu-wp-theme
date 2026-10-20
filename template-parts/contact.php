<?php

/**
 * Contact call to action, shown above the footer on every page.
 *
 * Offers one path for companies with a project and one for recruiters; both
 * use the same address with a different e-mail subject.
 *
 * @package rickmanu
 */

$rickmanu_contact_paths = [
    [
        'eyebrow' => __('// for companies & clients', 'rickmanu'),
        'text'    => __("Need to build an application, modernize existing systems or integrate platforms? Let's talk about the technical challenges and how we could work together.", 'rickmanu'),
        'cta'     => __('Talk about a project', 'rickmanu'),
        'url'     => rickmanu_get_contact_mailto('project'),
    ],
    [
        'eyebrow' => __('// for recruiters & hiring managers', 'rickmanu'),
        'text'    => __("I'm also open to opportunities in software engineering, architecture and technical leadership — Senior Software Engineer, Senior Full Stack or Tech Lead roles.", 'rickmanu'),
        'cta'     => __('Discuss an opportunity', 'rickmanu'),
        'url'     => rickmanu_get_contact_mailto('job'),
    ],
];

$rickmanu_contact_links = [
    [
        'label' => 'LinkedIn',
        'url'   => 'https://www.linkedin.com/in/darciro/',
        'icon'  => '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle>',
    ],
    [
        'label' => 'GitHub',
        'url'   => 'https://github.com/darciro/',
        'icon'  => '<path d="M9 19c-4.3 1.4-4.3-2.5-6-3m12 5v-3.5c0-1 .1-1.4-.5-2 2.8-.3 5.5-1.4 5.5-6a4.6 4.6 0 0 0-1.3-3.2 4.2 4.2 0 0 0-.1-3.2s-1.1-.3-3.5 1.3a12.3 12.3 0 0 0-6.2 0C6.5 2.8 5.4 3.1 5.4 3.1a4.2 4.2 0 0 0-.1 3.2A4.6 4.6 0 0 0 4 9.5c0 4.6 2.7 5.7 5.5 6-.6.6-.6 1.2-.5 2V21"></path>',
    ],
];
?>
<section id="contact" class="page-shell pt-30 pb-24" aria-labelledby="contact-title">
    <div class="flex flex-col gap-8 rounded-4xl border border-line bg-surface p-[clamp(28px,6vw,80px)]">
        <span class="font-mono text-sm text-accent"><?php esc_html_e('06 / ./contact.sh', 'rickmanu'); ?></span>
        <h2 id="contact-title" class="max-w-225 font-display text-[clamp(40px,6vw,80px)] leading-none font-extrabold tracking-[-0.035em]">
            <?php esc_html_e("Let's talk?", 'rickmanu'); ?>
        </h2>

        <ul class="grid grid-cols-[repeat(auto-fit,minmax(min(300px,100%),1fr))] gap-4">
            <?php foreach ($rickmanu_contact_paths as $rickmanu_path) : ?>
                <li>
                    <a href="<?php echo esc_url($rickmanu_path['url']); ?>" class="group flex h-full flex-col gap-3 rounded-[22px] border border-line-strong bg-ink p-7 transition duration-300 hover:-translate-y-0.75 hover:border-accent motion-reduce:transition-none motion-reduce:hover:translate-y-0">
                        <span class="font-mono text-[13px] text-accent"><?php echo esc_html($rickmanu_path['eyebrow']); ?></span>
                        <span class="text-base text-fg-muted"><?php echo esc_html($rickmanu_path['text']); ?></span>
                        <span class="mt-auto inline-flex items-center gap-2.5 font-display text-[22px] font-semibold text-fg">
                            <?php echo esc_html($rickmanu_path['cta']); ?>
                            <span class="text-accent transition-transform group-hover:translate-x-1 motion-reduce:transition-none" aria-hidden="true">→</span>
                        </span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="flex flex-wrap items-center gap-3">
            <a href="<?php echo esc_url(rickmanu_get_contact_mailto()); ?>" class="mr-3 inline-flex min-h-13 items-center px-1 font-display text-[clamp(20px,2.6vw,28px)] font-semibold wrap-anywhere text-accent underline decoration-2 underline-offset-6 transition-colors hover:text-fg">
                <?php echo esc_html(RICKMANU_CONTACT_EMAIL); ?>
            </a>
            <?php foreach ($rickmanu_contact_links as $rickmanu_link) : ?>
                <a href="<?php echo esc_url($rickmanu_link['url']); ?>" rel="me" class="inline-flex min-h-13 items-center gap-2.5 rounded-full border border-edge px-6 font-medium transition-colors hover:border-accent hover:text-accent">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                        <?php echo $rickmanu_link['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static SVG markup defined above. ?>
                    </svg>
                    <?php echo esc_html($rickmanu_link['label']); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
