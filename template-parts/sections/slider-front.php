<?php
/**
 * Intro section template for Course pages.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

?>
<section class="section-intro-2 alt">
	<div class="splide front-slider svitmov-slider">
		<div class="splide__track">
			<div class="splide__list">
				<?php foreach ( $args['slider'] as $slider_item ) : ?>
					<div class="section-inside splide__slide">
						<div class="content-wrap">
							<div class="post-data">
								<h1 class="post-title">
									<?php echo esc_html( $slider_item['title'] ); ?>
								</h1>
								<p class="post-description light-text">
									<?php echo esc_html( $slider_item['description'] ); ?>
								</p>
								<a class="button-yellow-mid link-block" href="<?php echo esc_url( $slider_item['button-url'] ); ?>">
									<?php echo esc_html( $slider_item['button-text'] ); ?>
								</a>
							</div>
						</div>
						<div class="section-graphics">
							<?php
							if ( empty( $slider_item['image'] ) ) {
								\Svitmov\Includes\Helpers::the_svg_file( 'graphic_3' );
							} else {
								?>
								<img src="<?php echo esc_url( $slider_item['image']['sizes']['large'] ); ?>" alt="<?php esc_attr_e( 'Ілюстративне зображення до слайду', 'svitmov' ); ?>">
								<?php
							}
							?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
