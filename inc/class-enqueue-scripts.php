<?php

if (! class_exists('Enqueue_Scripts')) :
    class Enqueue_Scripts
    {

        public $env;

        public function __construct()
        {
            $this->env = wp_get_environment_type();
        }

        public function run()
        {
            add_action('wp_enqueue_scripts', array($this, 'theme_styles'));
            add_action('wp_enqueue_scripts', array($this, 'theme_scripts'));
            add_filter('wp_resource_hints', array($this, 'font_resource_hints'), 10, 2);
        }

        public function theme_styles()
        {
            wp_enqueue_style(
                'rickmanu-fonts',
                'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,600;12..96,800&family=DM+Sans:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap',
                [],
                null
            );

            wp_enqueue_style(
                'rickmanu-style',
                get_theme_file_uri('assets/dist/css/style.css'),
                ['rickmanu-fonts'],
                wp_get_theme()->get('Version')
            );
        }

        public function theme_scripts()
        {
            wp_enqueue_script(
                'rickmanu-scripts',
                get_theme_file_uri('assets/dist/js/main.js'),
                [],
                wp_get_theme()->get('Version'),
                [
                    'strategy'  => 'defer',
                    'in_footer' => true,
                ]
            );
        }

        /**
         * Preconnect to the Google Fonts hosts used by the theme fonts.
         *
         * @param array  $urls          URLs to print for resource hints.
         * @param string $relation_type The relation type the URLs are printed for.
         * @return array
         */
        public function font_resource_hints($urls, $relation_type)
        {
            if ('preconnect' === $relation_type && wp_style_is('rickmanu-fonts', 'queue')) {
                $urls[] = 'https://fonts.googleapis.com';
                $urls[] = [
                    'href' => 'https://fonts.gstatic.com',
                    'crossorigin',
                ];
            }

            return $urls;
        }
    }

    (new Enqueue_Scripts())->run();
endif;
