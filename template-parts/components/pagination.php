<?php
/**
 * Archive pagination template.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

?>
<div class="pagination">
	<div class="page-prev">
		<svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M6.53125 11.5361L1.46875 6.47363L6.53125 1.41113" stroke="#666666" stroke-width="2" stroke-miterlimit="10" stroke-linecap="square"/>
		</svg>
	</div>
	<?php for ( $i = 1; $i <= $args['pages']; ++$i ) : ?>
		<div class="pag-item page-jump <?php echo esc_attr( $i === $args['current'] ? 'current' : '' ); ?>" value="<?php echo esc_attr( $i ); ?>">
			<?php echo esc_html( $i ); ?>
		</div>
	<?php endfor; ?>
	<div class="page-next">
		<svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M1.46875 1.41113L6.53125 6.47363L1.46875 11.5361" stroke="#666666" stroke-width="2" stroke-miterlimit="10" stroke-linecap="square"/>
		</svg>
	</div>
</div>
