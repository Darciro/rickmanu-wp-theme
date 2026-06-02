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
    define('RICKMANU_VERSION', '1.0.0');
}

if (! defined('RICKMANU_SLUG')) {
    define('RICKMANU_SLUG', 'rickmanu');
}

require_once get_template_directory() . '/inc/class-theme-setup.php';
require_once get_template_directory() . '/inc/class-enqueue-scripts.php';
require_once get_template_directory() . '/inc/class-split-nav-walker.php';
require_once get_template_directory() . '/inc/class-gallery-lightbox.php';
