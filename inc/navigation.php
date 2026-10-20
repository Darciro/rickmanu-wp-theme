<?php

/**
 * Navigation helpers: main menu link styling, a fallback when no menu is
 * assigned and the section links of the mobile dock.
 *
 * Links pointing at a front page section (#about, #projects...) are highlighted
 * while that section is in view; see assets/src/js/active-section.js.
 *
 * @package rickmanu
 */

if (! defined('ABSPATH')) {
    exit;
}

const RICKMANU_NAV_LINK_CLASS = 'inline-flex min-h-11 items-center rounded-full px-3.5 text-fg-muted transition-colors hover:text-accent data-active:bg-line data-active:text-fg';

/**
 * Add the theme link classes to items of the main menu.
 *
 * @param array<string, string> $atts Link attributes.
 * @param WP_Post               $item Menu item.
 * @param stdClass              $args wp_nav_menu() arguments.
 * @return array<string, string>
 */
function rickmanu_nav_menu_link_attributes(array $atts, $item, $args): array
{
    if (isset($args->theme_location) && 'main-menu' === $args->theme_location) {
        $atts['class'] = trim(($atts['class'] ?? '') . ' ' . RICKMANU_NAV_LINK_CLASS);
    }

    return $atts;
}
add_filter('nav_menu_link_attributes', 'rickmanu_nav_menu_link_attributes', 10, 3);

/**
 * Render the front page section anchors when no menu is assigned to "main-menu".
 *
 * @param array<string, mixed> $args wp_nav_menu() arguments.
 */
function rickmanu_main_menu_fallback(array $args): void
{
    $items = [
        'about'      => __('About', 'rickmanu'),
        'experience' => __('Experience', 'rickmanu'),
        'skills'     => __('Skills', 'rickmanu'),
        'services'   => __('Services', 'rickmanu'),
        'projects'   => __('Projects', 'rickmanu'),
    ];

    $container_class = $args['container_class'] ?? '';

    if ($container_class) {
        printf('<div class="%s">', esc_attr($container_class));
    }

    printf('<ul id="%1$s" class="%2$s">', esc_attr($args['menu_id'] ?? ''), esc_attr($args['menu_class'] ?? ''));

    foreach ($items as $anchor => $label) {
        printf(
            '<li><a class="%1$s" href="%2$s">%3$s</a></li>',
            esc_attr(RICKMANU_NAV_LINK_CLASS),
            esc_url(rickmanu_home_url('#' . $anchor)),
            esc_html($label)
        );
    }

    echo '</ul>';

    if ($container_class) {
        echo '</div>';
    }
}

/**
 * Front page sections linked from the mobile dock, with their icon markup.
 *
 * @return array<string, array{label: string, icon: string}> Keyed by section anchor.
 */
function rickmanu_get_dock_items(): array
{
    return [
        'about'      => [
            'label' => __('About', 'rickmanu'),
            'icon'  => '<circle cx="12" cy="8" r="4"></circle><path d="M4 21a8 8 0 0 1 16 0"></path>',
        ],
        'experience' => [
            'label' => __('Work', 'rickmanu'),
            'icon'  => '<rect x="3" y="7" width="18" height="13" rx="2"></rect><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>',
        ],
        'skills'     => [
            'label' => __('Skills', 'rickmanu'),
            'icon'  => '<path d="M8 6l-6 6 6 6"></path><path d="M16 6l6 6-6 6"></path>',
        ],
        'projects'   => [
            'label' => __('Projects', 'rickmanu'),
            'icon'  => '<rect x="3" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="3" width="7" height="7" rx="1.5"></rect><rect x="3" y="14" width="7" height="7" rx="1.5"></rect><rect x="14" y="14" width="7" height="7" rx="1.5"></rect>',
        ],
        'contact'    => [
            'label' => __('Contact', 'rickmanu'),
            'icon'  => '<rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="M3 7l9 6 9-6"></path>',
        ],
    ];
}
