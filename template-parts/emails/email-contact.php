<?php
/**
 * Booking email for admin
 *
 * @package svitmov/theme
 * @since 0.0.2
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

?>
<h1 class="">
	<?php esc_html_e( 'Нове запитання з форми', 'svitmov' ); ?>
</h1>
<?php foreach ( [ 'name', 'email', 'phone', 'question' ] as $field ) : ?>
	<?php if ( ! empty( $args[ $field ] ) ) : ?>
		<p>
			<b>
				<?php
				switch ( $field ) {
					case 'name':
						esc_html_e( 'Ім\'я:', 'svitmov' );
						break;
					case 'email':
						esc_html_e( 'Пошта:', 'svitmov' );
						break;
					case 'phone':
						esc_html_e( 'Телефон:', 'svitmov' );
						break;
					case 'question':
						esc_html_e( 'Запитання:', 'svitmov' );
						break;
				}
				?>
			</b>
			<?php echo esc_html( $args[ $field ] ); ?>
		</p>
	<?php endif; ?>
<?php endforeach; ?>
