<?php
/**
 * Archive filter radio button template.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires parameters.
if ( empty( $args ) ) {
	return;
}

?>
<div class="single-filter" filter="<?php echo esc_attr( $args['ref'] ); ?>" type="radio">
	<h3 class="filter-title"><?php echo esc_html( $args['name'] ); ?></h3>
	<div class="options-list">
		<div class="single-option <?php echo esc_attr( $args['selected'] === 'all' ? 'selected' : '' ); ?>" value="all">
			<?php esc_attr_e( 'Всі', 'svitmov' ); ?>
		</div>
		<?php foreach ( $args['options'] as $option_value => $option_name ) : ?>
			<div class="single-option <?php echo esc_attr( $args['selected'] === (string) $option_value ? 'selected' : '' ); ?>" value="<?php echo esc_attr( $option_value ); ?>">
				<?php echo esc_html( $option_name ); ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>
