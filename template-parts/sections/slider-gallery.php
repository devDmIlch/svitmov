<?php
/**
 * Gallery slider template file.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

if ( empty( $args ) ) {
	return;
}

?>
<section class="section-gallery-slider">
	<h2 class="section-title">
		<?php esc_html_e( 'Галерея', 'svitmov' ); ?>
	</h2>
	<div class="splide gallery-slider svitmov-slider">
		<div class="splide__track">
			<div class="splide__list">
				<?php foreach ( $args['gallery'] as $img ) : ?>
					<div class="gallery-item splide__slide">
						<img class="gallery-trigger" alt="<?php esc_html_e( 'Зображення галереї', 'svitmov' ); ?>" src="<?php echo esc_url( $img['sizes']['thumbnail'] ); ?>" fullsize="<?php echo esc_url( $img['url'] ); ?>">
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

