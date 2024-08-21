<?php
/**
 * Archive Teacher page template.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

get_template_part( 'template-parts/sections/intro', 'teachers' );
get_template_part( 'template-parts/sections/slider', 'teachers', [ 'show_title' => false ] );
get_template_part( 'template-parts/sections/slider', 'news' );
