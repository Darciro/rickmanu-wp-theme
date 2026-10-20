<?php

if (!class_exists('Theme_Setup')) :
    class Theme_Setup
    {
        public function run()
        {
            add_action('after_setup_theme', array($this, 'theme_setup'));
            add_action('after_setup_theme', array($this, 'theme_navigation'));
            add_filter('document_title_separator', array($this, 'title_separator'));
            add_filter('document_title_parts', array($this, 'front_page_title'));
        }

        public function theme_setup()
        {
            load_theme_textdomain('rickmanu', get_template_directory() . '/languages');
            // add_theme_support('automatic-feed-links');
            add_theme_support('title-tag');
            add_theme_support('post-thumbnails');
        }

        /**
         * Separator between the parts of the document title.
         */
        public function title_separator(): string
        {
            return '|';
        }

        /**
         * Front page title that states the professional positioning, e.g.
         * "Ricardo Carvalho | Senior Software Engineer, Full Stack & Tech Lead".
         *
         * @param array<string, string> $parts Document title parts.
         * @return array<string, string>
         */
        public function front_page_title(array $parts): array
        {
            if (! is_front_page()) {
                return $parts;
            }

            $parts['title']   = 'Ricardo Carvalho';
            $parts['tagline'] = __('Senior Software Engineer, Full Stack & Tech Lead', 'rickmanu');

            return $parts;
        }

        public function theme_navigation()
        {
            register_nav_menus(
                array(
                    'main-menu' => esc_html__('Main menu', 'rickmanu'),
                )
            );
        }
    }

    (new Theme_Setup())->run();
endif;
