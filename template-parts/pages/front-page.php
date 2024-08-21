<?php
/**
 * Front page template file
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

get_template_part( 'template-parts/sections/slider', 'front', [ 'slider' => $args['slider'] ] );
get_template_part( 'template-parts/sections/quick-links', args: $args['quick-links'] );
get_template_part( 'template-parts/sections/enroll' );
get_template_part( 'template-parts/sections/online' ); // TODO
get_template_part( 'template-parts/sections/advantages' );
get_template_part( 'template-parts/sections/slider', 'teachers' );
get_template_part( 'template-parts/sections/slider', 'gallery', [ 'gallery' => $args['gallery'] ] );
get_template_part( 'template-parts/sections/reviews' );
get_template_part( 'template-parts/sections/location' );
get_template_part( 'template-parts/sections/level-test' );
get_template_part( 'template-parts/sections/booking', args: $args['form'] );
get_template_part( 'template-parts/sections/slider', 'news' );

