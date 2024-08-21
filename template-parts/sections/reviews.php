<?php
/**
 * Template for the 'Reviews section'.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

?>
<section class="section-reviews">
	<h2 class="section-title">
		<?php esc_html_e( 'Відгуки про навчання', 'svitmov' ); ?>
	</h2>
	<span tabindex="0" class="sidelink leave-review pop-up-trigger" rel="review-pop-up">
		<?php esc_html_e( 'Залишити відгук', 'svitmov' ); ?>
	</span>
	<?php
	get_template_part(
		'template-parts/pop-ups/generic-pop-up',
		args: [
			'form'    => 'review',
			'title'   => __( 'Надіслати відгук', 'svitmov' ),
			'success' => __( 'Дякуємо за відгук!', 'svitmov' ),
		]
	); ?>
	<div class="content-wrap">
		<?php if ( ! empty( $args['reviews'] ) ) : ?>
			<div class="splide reviews-slider">
				<div class="splide__track">
					<ul class="splide__list">
						<?php
						foreach ( $args['reviews'] as $review_data ) {
							$review_template_args = array_merge(
								$review_data,
								[
									'tag'     => 'li',
									'classes' => 'splide__slide',
								]
							);
							// Find template part with review.
							get_template_part( 'template-parts/elements/review', args: $review_template_args);
						}
						?>
					</ul>
				</div>
			</div>
		<?php else : ?>
			<div class="no-reviews">
				<p class="no-reviews-message">
					<?php esc_html_e( 'На даний момент відгуки відсутні. Залиште свій відгук натиснувши кнопку "Залишити відгук".', 'svitmov' ); ?>
				</p>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php
wp_reset_postdata();

