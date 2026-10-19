<?php

/**
 * Rick Manu functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package rickmanu
 */

if (!defined('RICKMANU_VERSION')) {
    // Replace the version number of the theme on each release.
    define('RICKMANU_VERSION', '2.0.0');
}

if (! defined('RICKMANU_SLUG')) {
    define('RICKMANU_SLUG', 'rickmanu');
}

require_once get_template_directory() . '/inc/language.php';
require_once get_template_directory() . '/inc/class-theme-setup.php';
require_once get_template_directory() . '/inc/class-enqueue-scripts.php';
require_once get_template_directory() . '/inc/class-gallery-lightbox.php';
require_once get_template_directory() . '/inc/navigation.php';
require_once get_template_directory() . '/inc/meta-fields.php';
require_once get_template_directory() . '/inc/experience.php';
require_once get_template_directory() . '/inc/projects.php';
require_once get_template_directory() . '/inc/linkedin-import.php';
require_once get_template_directory() . '/inc/content.php';
