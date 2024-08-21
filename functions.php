<?php
/**
 * Svitmov theme functions.php file
 *
 * @package svitmov/theme
 */

// Avoid calling this file directly.
use Svitmov\ThemeController;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme version.
 * When modifying js/css files, increase the lowest number here and in style.css.
 */
const SVITMOV_THEME_VERSION = '1.0.0';

// Theme path.
const SVITMOV_THEME_PATH = __DIR__;

// Theme php path.
const SVITMOV_THEME_PHP_PATH = SVITMOV_THEME_PATH . '/src/php';

// Core path.
const SVITMOV_CORE_PATH = SVITMOV_THEME_PHP_PATH . '/Core';

// Set up all dependencies.
require_once SVITMOV_THEME_PATH . '/vendor/autoload.php';

// Initialize theme controller.
$theme = new ThemeController();
$theme->init();
