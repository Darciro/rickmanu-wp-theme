<?php

if (!class_exists('Theme_Setup')) :
    class Theme_Setup
    {
        public function run()
        {
            add_action('after_setup_theme', array($this, 'theme_setup'));
            add_action('after_setup_theme', array($this, 'theme_navigation'));
        }

        public function theme_setup()
        {
            load_theme_textdomain('rickmanu', get_template_directory() . '/languages');
            // add_theme_support('automatic-feed-links');
            // add_theme_support('title-tag');
            add_theme_support('post-thumbnails');
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
