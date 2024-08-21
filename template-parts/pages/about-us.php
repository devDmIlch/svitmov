<?php
/**
 * "About Us" page template file.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

foreach ( $args['area-1'] ?? [] as $section ) {
	get_template_part( 'template-parts/sections/side-by-side', args: $section );
}

get_template_part( 'template-parts/sections/advantages' );

?>
<div class="gray-bg">
	<?php
	foreach ( $args['area-2'] ?? [] as $section ) {
		get_template_part( 'template-parts/sections/side-by-side', args: $section );
	}
	?>
</div>
<?php

foreach ( $args['area-3'] ?? [] as $section ) {
	get_template_part( 'template-parts/sections/side-by-side', args: $section );
}

get_template_part( 'template-parts/sections/reviews' );

