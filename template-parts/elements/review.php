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

// Get preferred tag for the element wrapper.
$wrap_tag = $args['tag'] ?? 'div';
?>
<<?php echo esc_attr( $wrap_tag ); ?> class="<?php echo esc_attr( 'review-item ' . $args['classes'] ?? '' ); ?>">
	<div class="review-head">
		<?php if ( ! empty( $args['reviewer-avatar'] ) ) : ?>
			<div class="review-avatar">
				<img class="avatar" src="<?php echo esc_url( wp_get_attachment_image_url( $args['reviewer-avatar'] ) ); ?>" alt="<?php esc_html_e( 'Фото автора відгуку', 'svitmov' ); ?>">
			</div>
		<?php endif; ?>
		<div class="review-meta">
			<h4 class="reviewer-name"><?php echo esc_html( $args['reviewer-name'] ); ?></h4>
		</div>
	</div>
	<div class="review-body">
		<?php echo esc_html( $args['review-text'] ); ?>
	</div>
</<?php echo esc_attr( $wrap_tag ); ?>>
