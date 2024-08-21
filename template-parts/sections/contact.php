<?php
/**
 * Contact Us section template with form
 *
 * @package svitmov/theme
 * @since 0.0.2
 **/

?>
<section id="section-booking" class="section-booking">
	<h2 class="section-title">
		<?php esc_html_e( 'Поставити запитання', 'svitmov' ); ?>
	</h2>
	<div class="section-inside">
		<div class="form-wrap contact-form">
			<div class="form-content">
				<?php get_template_part( 'template-parts/forms/contact' ); ?>
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
