<!doctype html>
<html <?php language_attributes(); ?> class="motion-safe:scroll-smooth">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="apple-mobile-web-app-title" content="<?php echo esc_attr(get_bloginfo('name')); ?>" />

    <link rel="icon" type="image/png" href="<?php echo esc_url(get_theme_file_uri('assets/images/favico/favicon-96x96.png')); ?>" sizes="96x96" />
    <link rel="shortcut icon" href="<?php echo esc_url(get_theme_file_uri('assets/images/favico/favicon.ico')); ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url(get_theme_file_uri('assets/images/favico/apple-touch-icon.png')); ?>" />
    <link rel="manifest" href="<?php echo esc_url(get_theme_file_uri('assets/images/favico/site.webmanifest')); ?>" />

    <?php wp_head(); ?>
</head>

<body <?php body_class('min-h-screen bg-ink font-sans text-[17px] leading-[1.6] text-fg antialiased'); ?>>

    <?php wp_body_open(); ?>

    <a class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:rounded-full focus:bg-accent focus:px-5 focus:py-3 focus:font-semibold focus:text-ink" href="#main">
        <?php esc_html_e('Skip to content', 'rickmanu'); ?>
    </a>

    <header class="fixed inset-x-0 top-(--wp-admin--admin-bar--height,0px) z-30 h-(--header-height) border-b border-line bg-ink/82 backdrop-blur-[14px]">
        <nav class="page-shell flex h-full items-center justify-between gap-4" aria-label="<?php esc_attr_e('Main', 'rickmanu'); ?>">
            <a href="<?php echo esc_url(rickmanu_home_url()); ?>" class="flex min-h-11 items-center gap-2.5 font-mono text-base font-medium tracking-[-0.01em] transition-colors hover:text-accent">
                <img src="<?php echo esc_url(get_theme_file_uri('assets/images/logo.png')); ?>" class="size-12 md:size-8" width="520" height="520" alt="" decoding="async" />
                <span class="max-[480px]:sr-only">rickmanu.dev</span>
            </a>

            <?php
            wp_nav_menu([
                'theme_location'  => 'main-menu',
                'depth'           => 1,
                'container'       => 'div',
                'container_class' => 'hidden text-[15px] min-[821px]:block',
                'menu_id'         => 'main-navigation',
                'menu_class'      => 'flex items-center gap-1',
                'fallback_cb'     => 'rickmanu_main_menu_fallback',
            ]);
            ?>

            <div class="flex flex-none items-center gap-2.5">
                <?php rickmanu_language_switch(); ?>

                <a href="<?php echo esc_url(rickmanu_get_contact_mailto()); ?>" class="hidden md:inline-flex min-h-11 flex-none items-center gap-2 rounded-full bg-fg px-4.5 text-sm font-semibold text-ink transition-colors hover:bg-accent">
                    <span class="size-1.75 rounded-full bg-online" aria-hidden="true"></span>
                    <?php esc_html_e("Let's talk", 'rickmanu'); ?>
                </a>
            </div>
        </nav>
    </header>

    <?php // Full-screen transition played by assets/src/js/language-switch.js. ?>
    <div class="language-wipe fixed inset-0 z-100 hidden flex-col items-center justify-center gap-4.5 bg-accent text-ink pointer-events-none" aria-hidden="true" data-language-wipe>
        <code class="font-mono text-[15px] tracking-[.02em]" data-language-wipe-code></code>
        <span class="font-display text-[clamp(72px,16vw,220px)] leading-[.9] font-extrabold tracking-[-.05em]" data-language-wipe-word></span>
    </div>

    <?php get_template_part('template-parts/mobile-dock'); ?>

    <?php // Opened here and closed in footer.php; see assets/src/js/smooth-scroll.js. ?>
    <div id="smooth-wrapper">
    <div id="smooth-content" class="pt-(--header-height)">
