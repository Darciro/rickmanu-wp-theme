<?php

/**
 * Contact call to action, shown above the footer on every page.
 *
 * @package rickmanu
 */

$rickmanu_contact_links = [
    [
        'label' => 'GitHub',
        'url'   => 'https://github.com/darciro/',
        'icon'  => '<path d="M9 19c-4.3 1.4-4.3-2.5-6-3m12 5v-3.5c0-1 .1-1.4-.5-2 2.8-.3 5.5-1.4 5.5-6a4.6 4.6 0 0 0-1.3-3.2 4.2 4.2 0 0 0-.1-3.2s-1.1-.3-3.5 1.3a12.3 12.3 0 0 0-6.2 0C6.5 2.8 5.4 3.1 5.4 3.1a4.2 4.2 0 0 0-.1 3.2A4.6 4.6 0 0 0 4 9.5c0 4.6 2.7 5.7 5.5 6-.6.6-.6 1.2-.5 2V21"></path>',
    ],
    [
        'label' => 'LinkedIn',
        'url'   => 'https://www.linkedin.com/in/darciro/',
        'icon'  => '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle>',
    ],
];
?>
<section id="contact" class="page-shell pt-30 pb-24" aria-labelledby="contact-title">
    <div class="flex flex-col gap-8 rounded-[32px] border border-line bg-surface p-[clamp(32px,6vw,80px)]">
        <span class="font-mono text-sm text-accent"><?php esc_html_e('05 / ./contact.sh', 'rickmanu'); ?></span>
        <h2 id="contact-title" class="max-w-[900px] font-display text-[clamp(40px,6vw,80px)] leading-none font-extrabold tracking-[-0.035em]">
            <?php esc_html_e("Have a project in mind? Let's build it.", 'rickmanu'); ?>
        </h2>
        <a href="mailto:rickmanu@gmail.com" class="font-display text-[clamp(24px,3.4vw,40px)] font-semibold wrap-anywhere text-accent underline decoration-2 underline-offset-8 transition-colors hover:text-fg">
            rickmanu@gmail.com
        </a>
        <div class="flex flex-wrap gap-3">
            <?php foreach ($rickmanu_contact_links as $rickmanu_link) : ?>
                <a href="<?php echo esc_url($rickmanu_link['url']); ?>" class="inline-flex min-h-13 items-center gap-2.5 rounded-full border border-edge px-6 font-medium transition-colors hover:border-accent hover:text-accent">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                        <?php echo $rickmanu_link['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static SVG markup defined above. ?>
                    </svg>
                    <?php echo esc_html($rickmanu_link['label']); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
