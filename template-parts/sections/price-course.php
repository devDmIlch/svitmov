<?php
/**
 * Course price template file.
 *
 * @package svitmov/theme
 * @since 0.0.3
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

?>
<section class="section-prices">
	<?php
	foreach ( $args['prices'] as $price_type => $price_data ) {
		if ( empty( $price_data ) ) {
			continue;
		}
		?>
		<div class="price-area">
			<p class="price-name">
				<?php
				switch ( $price_type ) {
					case 'lesson-price':
						esc_html_e( 'Ціна за одне заняття', 'svitmov' );
						break;
					case 'monthly-price':
						esc_html_e( 'Ціна за один місяць', 'svitmov' );
						break;
					case 'full-price':
						esc_html_e( 'Ціна за весь курс', 'svitmov' );
						break;
				}
				?>
			</p>
			<p class="price-value">
				<?php echo esc_html( $price_data . ' ₴' ); ?>
			</p>
		</div>
		<?php
	}
	?>
</section>
