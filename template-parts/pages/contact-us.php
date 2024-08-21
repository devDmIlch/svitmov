<?php
/**
 * Contact Us page template
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

$day_list = [
	'monday'    => __( 'Пн:', 'svitmov' ),
	'tuesday'   => __( 'Вт:', 'svitmov' ),
	'wednesday' => __( 'Ср:', 'svitmov' ),
	'thursday'  => __( 'Чт:', 'svitmov' ),
	'friday'    => __( 'Пт:', 'svitmov' ),
	'saturday'  => __( 'Сб:', 'svitmov' ),
	'sunday'    => __( 'Нд:', 'svitmov' ),
];

?>
<section class="section-contact-details">
	<main class="contact-details">
		<h1>
			<?php echo esc_html( $args['title'] ); ?>
		</h1>
		<?php if ( is_array( $args['svitmov-phone'] ) && ! empty( $args['svitmov-phone'][0] ) ) : ?>
			<h2 class="detail-piece-name">
				<?php esc_html_e( 'Телефони', 'svitmov' ); ?>
			</h2>
			<p class="list">
				<?php echo wp_kses( implode( '<br>', $args['svitmov-phone'] ), [ 'br' => [] ] ); ?>
			</p>
		<?php endif; ?>
		<?php if ( is_array( $args['svitmov-emails'] ) && ! empty( $args['svitmov-emails'][0] ) ) : ?>
			<h2 class="detail-piece-name">
				<?php esc_html_e( 'Електронна пошта', 'svitmov' ); ?>
			</h2>
			<p class="list">
				<?php echo wp_kses( implode( '<br>', $args['svitmov-emails'] ), [ 'br' => [] ] ); ?>
			</p>
		<?php endif; ?>
		<?php if ( ! empty( $args['svitmov-location'] ) ) : ?>
			<h2 class="detail-piece-name">
				<?php esc_html_e( 'Адреса', 'svitmov' ); ?>
			</h2>
			<p>
				<?php echo esc_html( $args['svitmov-location'] ); ?>
			</p>
		<?php endif; ?>
	</main>
	<?php if ( $args['schedule-enabled'] ?? false ) : ?>
		<aside class="schedule">
			<h2 class="schedule-title">
				<?php esc_html_e( 'Графік', 'svitmov' ); ?>
			</h2>
			<div class="working-hour-list">
				<?php foreach ( $day_list as $day_slug => $day_abr ) : ?>
					<?php if ( ! empty( $args[ $day_slug ] ) ) : ?>
						<p class="schedule-day">
							<span class="day-name">
								<?php echo esc_html( $day_abr ); ?>
							</span>
							<b class="working-hours">
								<?php echo esc_html( $args[ $day_slug ] ); ?>
							</b>
						</p>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</aside>
	<?php endif; ?>
</section>
<?php if ( ! empty( $args['svitmov-embedded'] ) ) : ?>
	<section class="section-map">
		<?php echo $args['svitmov-embedded']; // phpcs:ignore ?>
	</section>
<?php endif; ?>
