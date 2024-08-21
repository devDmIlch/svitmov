<?php
/**
 * Template for the 'Location section'.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

$location_info = get_options( [ 'svitmov-location', 'svitmov-phone', 'svitmov-embedded' ] );
?>
<section class="section-location">
	<div class="map-element">
		<?php
		if ( ! empty( $location_info['svitmov-embedded'] ) ) {
			// phpcs:ignore
			echo $location_info['svitmov-embedded'];
		}
		?>
	</div>
	<div class="description">
		<h2 class="section-title">
			<?php esc_html_e( 'Ти зможеш знайти нас тут', 'svitmov' ); ?>
		</h2>
		<h5 class="">
			<?php esc_html_e( 'Головний офіс', 'svitmov' ); ?>
		</h5>
		<p class="heavy-text address">
			<?php echo esc_html( $location_info[ 'svitmov-location' ] ); ?>
		</p>
		<h5>
			<?php esc_html_e( 'Номер телефону', 'svitmov' ); ?>
		</h5>
		<p class="heavy-text phones">
			<?php echo wp_kses( implode( '<br>', $location_info['svitmov-phone'] ), [ 'br' => [] ] ); ?>
		</p>
	</div>
</section>
