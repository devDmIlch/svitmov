<?php
/**
 * Side-by-side section template file
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

// Prepare wrapper classes.
$wrap_class = implode( ' ', [ 'section-side-by-side', ...$args['wrap_class'] ?? [] ] );

// Prepare content classes.
$class = implode( ' ', [ 'section-inside', ...$args['classes'] ?? [] ] );

?>
<section class="<?php echo esc_attr( $wrap_class ); ?>">
	<?php if ( ! empty( $args['title'] ) ) : ?>
		<?php if ( $args['page-title'] ?? false ) : ?>
			<h1 class="section-title">
				<?php echo esc_html( $args['title'] ); ?>
			</h1>
		<?php else : ?>
			<h2 class="section-title">
				<?php echo esc_html( $args['title'] ); ?>
			</h2>
		<?php endif; ?>
	<?php endif; ?>
	<div class="<?php echo esc_attr( $class ); ?>">
		<div class="text">
			<?php if ( ! empty( $args['name'] ) ) : ?>
				<<?php echo esc_attr( $args['name-tag'] ?? 'h2' ); ?> class="section-name">
					<?php echo esc_html( $args['name'] ); ?>
				</<?php echo esc_attr( $args['name-tag'] ?? 'h2' ); ?>>
			<?php endif; ?>
			<p>
				<?php echo esc_html( $args['text'] ); ?>
			</p>
		</div>
		<div class="graphics">
			<img class="section-image" src="<?php echo esc_url( $args['graphics'] ); ?>" alt="<?php esc_attr_e( 'Ілюстративне зображення секції', 'svitmov' ); ?>">
		</div>
	</div>
</section>
