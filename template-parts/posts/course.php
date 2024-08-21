<?php
/**
 * Single Course page template.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

get_template_part( 'template-parts/sections/intro', 'course' );
get_template_part( 'template-parts/sections/price', 'course', [ 'prices' => $args['prices'] ] );
get_template_part( 'template-parts/sections/content', 'course' );
get_template_part( 'template-parts/sections/related', 'course' );
get_template_part( 'template-parts/sections/enroll' );
get_template_part( 'template-parts/sections/reviews', args: [ 'reviews' => $args['reviews'] ] );
get_template_part( 'template-parts/sections/advantages' );
get_template_part( 'template-parts/sections/location' );
get_template_part( 'template-parts/sections/level-test' );
