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
        }

        public function theme_styles()
        {
            wp_enqueue_style(
                'rickmanu-style',
                get_template_directory_uri() . '/assets/dist/css/style.css',
                [],
                wp_get_theme()->get('Version')
            );
        }

        public function theme_scripts()
        {
            wp_enqueue_script(
                'rickmanu-scripts',
                get_template_directory_uri() . '/assets/dist/js/main.js',
                [],
                wp_get_theme()->get('Version'),
                true
            );
        }
    }

    (new Enqueue_Scripts())->run();
endif;
