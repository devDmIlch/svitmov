<?php
/**
 * Archive News page template.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

get_template_part( 'template-parts/sections/archive', 'news', $args );
