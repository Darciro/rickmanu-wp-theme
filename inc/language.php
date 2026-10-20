<?php

/**
 * Language switch and language-aware links, backed by the Polylang plugin.
 *
 * Polylang detects the language (from the URL) and sets the locale, so the
 * theme translations in languages/ load on their own. Without Polylang the
 * switch is not rendered and links point at the plain home URL.
 *
 * @package rickmanu
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Home URL of the current language, with an optional path or #anchor appended.
 *
 * @param string $path Path relative to the language home, e.g. "#about".
 */
function rickmanu_home_url(string $path = ''): string
{
    $home = function_exists('pll_home_url') ? pll_home_url() : home_url('/');

    return trailingslashit($home) . ltrim($path, '/');
}

/**
 * Word flashed by the switch transition, in the target language.
 *
 * @param string $locale Target locale, e.g. "pt_BR".
 */
function rickmanu_get_language_greeting(string $locale): string
{
    // Shown in the target language, so not translatable.
    return str_starts_with($locale, 'pt') ? 'Olá.' : 'Hello.';
}

/**
 * Render the language switch shown in the header, one link per Polylang language.
 *
 * Plain links, so it works without JavaScript; assets/src/js/language-switch.js
 * adds the transition animation.
 */
function rickmanu_language_switch(): void
{
    if (! function_exists('pll_the_languages')) {
        return;
    }

    $languages = pll_the_languages([
        'raw'                    => 1,
        'hide_if_empty'          => 0,
        'hide_if_no_translation' => 0,
    ]);

    if (! is_array($languages) || count($languages) < 2) {
        return;
    }

    $languages = array_values($languages);
    $current   = (int) array_search(true, array_column($languages, 'current_lang'), true);
    ?>
    <div class="relative grid auto-cols-fr grid-flow-col rounded-full border border-line-strong bg-surface p-1" role="group" aria-label="<?php echo esc_attr('Language / Idioma'); ?>" data-language-switch>
        <span class="absolute inset-y-1 left-1 rounded-full bg-accent shadow-[0_0_18px_rgba(200,240,90,.35)] transition-transform duration-500 ease-[cubic-bezier(.7,0,.2,1)] motion-reduce:transition-none" style="<?php echo esc_attr(sprintf('width: calc((100%% - 8px) / %d); transform: translateX(%d%%);', count($languages), $current * 100)); ?>" aria-hidden="true" data-language-thumb></span>
        <?php foreach ($languages as $index => $language) : ?>
            <a
                href="<?php echo esc_url($language['url']); ?>"
                class="relative z-1 inline-flex min-h-9 min-w-11 items-center justify-center rounded-full px-3 font-mono text-[13px] font-semibold tracking-[.04em] text-fg-muted uppercase transition-colors duration-350 hover:text-fg aria-current:text-ink aria-current:hover:text-ink"
                hreflang="<?php echo esc_attr(str_replace('_', '-', $language['locale'])); ?>"
                lang="<?php echo esc_attr(str_replace('_', '-', $language['locale'])); ?>"
                aria-label="<?php echo esc_attr($language['name']); ?>"
                data-language-index="<?php echo esc_attr((string) $index); ?>"
                data-greeting="<?php echo esc_attr(rickmanu_get_language_greeting($language['locale'])); ?>"
                <?php echo $language['current_lang'] ? 'aria-current="true"' : ''; ?>><?php echo esc_html($language['slug']); ?></a>
        <?php endforeach; ?>
    </div>
    <?php
}

/**
 * Make the portfolio post types translatable, so each language shows its own
 * experience and project posts instead of the same untranslated text.
 *
 * Posts without a language are left out of the front end by Polylang: assign
 * one in the admin (Languages > Settings offers a bulk action) after enabling.
 *
 * @param string[] $post_types  Post types handled by Polylang, keyed by name.
 * @param bool     $is_settings  Whether the list is built for the settings screen.
 * @return string[]
 */
function rickmanu_translatable_post_types(array $post_types, bool $is_settings): array
{
    foreach ([RICKMANU_EXPERIENCE_POST_TYPE, RICKMANU_PROJECT_POST_TYPE] as $post_type) {
        // Hidden from the settings screen so it cannot be unchecked; the theme relies on it.
        if ($is_settings) {
            unset($post_types[$post_type]);
        } else {
            $post_types[$post_type] = $post_type;
        }
    }

    return $post_types;
}
add_filter('pll_get_post_types', 'rickmanu_translatable_post_types', 10, 2);
