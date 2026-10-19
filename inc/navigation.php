<?php

/**
 * Main menu helpers: link styling and a fallback when no menu is assigned.
 *
 * @package rickmanu
 */

if (! defined('ABSPATH')) {
    exit;
}

const RICKMANU_NAV_LINK_CLASS = 'inline-block py-2.5 transition-colors hover:text-accent';

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
        'projects'   => __('Projects', 'rickmanu'),
    ];

    printf('<ul class="%s">', esc_attr($args['menu_class'] ?? ''));

    foreach ($items as $anchor => $label) {
        printf(
            '<li><a class="%1$s" href="%2$s">%3$s</a></li>',
            esc_attr(RICKMANU_NAV_LINK_CLASS),
            esc_url(home_url('/#' . $anchor)),
            esc_html($label)
        );
    }

    echo '</ul>';
}
