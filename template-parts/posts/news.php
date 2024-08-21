<?php
/**
 * Single News post template
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

get_template_part( 'template-parts/sections/intro', 'news', $args );
get_template_part( 'template-parts/sections/content', 'news', $args );
