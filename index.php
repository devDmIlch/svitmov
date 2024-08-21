<?php
/**
 * Template file for Svitmov Theme
 *
 * @package svitmove/theme
 * @since 0.0.1
 */

get_template_part( 'template-parts/header' );

// Load archive template.
if ( is_tax() || is_archive() || is_search() ) {
	\Svitmov\Core\Archive\Archive::load_archive_template();
}

// Load single page template.
if ( is_page() ) {
	\Svitmov\Theme\Pages::get_page_template();
}

if ( is_single() ) {
	\Svitmov\ThemeController::get_single_post_content();
}

if ( is_404() ) {
	get_template_part( 'template-parts/static/404' );
}

get_template_part( 'template-parts/footer' );
