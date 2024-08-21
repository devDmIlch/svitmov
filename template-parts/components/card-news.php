<?php
/**
 * Template for single 'News card'.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

$classes = implode( ' ', [ 'news-card', ...( $args['classes'] ?? [] ) ] );

?>
<div class="<?php echo esc_attr( $classes ); ?>">
	<div class="thumbnail-wrap">
		<a href="<?php echo esc_url( $args['url'] ); ?>">
			<?php if ( ! empty( $args['thumbnail'] ) ) : ?>
				<img class="thumbnail" src="<?php echo esc_url( $args['thumbnail'] ); ?>" alt="<?php esc_attr_e( 'Головне зображення новини', 'svitmov' ); ?>">
			<?php endif; ?>
		</a>
	</div>
	<div class="info-block">
		<?php if ( ! empty( $args['tags'] ) ) : ?>
			<div class="tags">
				<?php foreach ( $args['tags'] as $tag ) : ?>
					<span class="tag">
						<?php echo esc_html( '#' . $tag ); ?>
					</span>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<h3 class="name">
			<a href="<?php echo esc_url( $args['url'] ); ?>">
				<?php echo esc_html( $args['title'] ); ?>
			</a>
		</h3>
		<p class="desc">
			<?php echo esc_html( $args['excerpt'] ); ?>
		</p>
	</div>
</div>
