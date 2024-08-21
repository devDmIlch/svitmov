<?php
/**
 * Archive filter range template.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires parameters.
if ( empty( $args ) ) {
	return;
}

?>
<div class="single-filter" filter="<?php echo esc_attr( $args['ref'] ); ?>" type="range">
	<h3 class="filter-title"><?php echo esc_html( $args['name'] ); ?></h3>
	<div class="range-values">
		<div class="min-value"><?php echo esc_html( $args['min-selected'] ?? $args['min'] ); ?></div>
		<div class="max-value"><?php echo esc_html( $args['max-selected'] ?? $args['max'] ); ?></div>
	</div>
	<div class="range-bar" min="<?php echo esc_attr( $args['min'] ); ?>" max="<?php echo esc_attr( $args['max'] ); ?>">
		<div class="min-handle handle" style="left: <?php echo esc_attr( ( $args['min-percent'] ?? 0 ) . '%' ); ?>"></div>
		<div class="max-handle handle" style="right: <?php echo esc_attr( ( $args['max-percent'] ?? 0 ) . '%' ); ?>"></div>
	</div>
	<?php if ( isset( $args['note'] ) ) : ?>
		<div class="notation">
			<?php echo esc_html( $args['note'] ); ?>
		</div>
	<?php endif; ?>
	<a class="apply-filter hidden">
		<?php esc_html_e( 'Застосувати', 'estore-theme' ); ?>
	</a>
</div>
