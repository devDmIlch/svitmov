<?php
/**
 * Archive Course page template.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// Set arguments variable.
if ( ! isset( $args ) || ! is_array( $args ) ) {
	$args = [];
}
// Update arguments variable with archive name.
if ( empty( $args['name'] ) ) {
	$args['name'] = __( 'Всі курси', 'estore-theme' );
}

if ( ! empty( $args['title'] ) ) {
	get_template_part( 'template-parts/sections/title', 'archive', $args );
}
get_template_part( 'template-parts/sections/archive', 'course', $args );
get_template_part( 'template-parts/sections/contact' );
