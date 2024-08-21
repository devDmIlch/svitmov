<?php
/**
 * Registration/Booking section template with form
 *
 * @package svitmov/theme
 * @since 0.0.2
 **/

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

?>
<section id="section-booking" class="section-booking">
	<h2 class="section-title">
		<?php esc_html_e( 'Запис на курси', 'svitmov' ); ?>
	</h2>
	<div class="section-inside">
		<div class="form-wrap booking-form">
			<div class="form-content">
				<?php get_template_part( 'template-parts/forms/booking', args: $args ); ?>
			</div>
			<div class="success-message hidden">
				<?php esc_html_e( 'Заявка відправлена!', 'svitmov' ); ?>
			</div>
		</div>
		<div class="graphics-wrap">
			<?php \Svitmov\Includes\Helpers::the_svg_file( 'graphic_4' ); ?>
		</div>
	</div>
</section>
