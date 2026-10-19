<!doctype html>
<html <?php language_attributes(); ?> class="motion-safe:scroll-smooth">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="apple-mobile-web-app-title" content="<?php echo esc_attr(get_bloginfo('name')); ?>" />

    <link rel="icon" type="image/png" href="<?php echo esc_url(get_theme_file_uri('assets/images/favico/favicon-96x96.png')); ?>" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?php echo esc_url(get_theme_file_uri('assets/images/favico/favicon.svg')); ?>" />
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

    <?php // Opened here and closed in footer.php; see assets/src/js/smooth-scroll.js. ?>
    <div id="smooth-wrapper">
    <div id="smooth-content">

    <header class="relative border-b border-line">
        <nav class="page-shell flex flex-wrap items-center justify-between gap-4 py-5" aria-label="<?php esc_attr_e('Main', 'rickmanu'); ?>">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="flex min-h-11 items-center gap-2.5 font-mono text-base font-medium tracking-[-0.01em] transition-colors hover:text-accent">
                <span class="inline-flex size-8 items-center justify-center rounded-lg bg-accent text-sm font-bold text-ink" aria-hidden="true">RM</span>
                <span>rick.manu</span>
            </a>

            <div class="flex flex-wrap items-center gap-x-7 gap-y-2 text-[15px]">
                <?php
                wp_nav_menu([
                    'theme_location' => 'main-menu',
                    'depth'          => 1,
                    'container'      => '',
                    'menu_id'        => 'main-navigation',
                    'menu_class'     => 'flex flex-wrap items-center gap-x-7 gap-y-2',
                    'fallback_cb'    => 'rickmanu_main_menu_fallback',
                ]);
                ?>
                <a href="mailto:rickmanu@gmail.com" class="rounded-full border border-edge px-4.5 py-2.5 font-medium transition-colors hover:border-accent hover:text-accent">
                    <?php esc_html_e("Let's talk", 'rickmanu'); ?>
                </a>
            </div>
        </nav>
    </header>
