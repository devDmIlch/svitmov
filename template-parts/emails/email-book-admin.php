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
	<?php esc_html_e( 'Нова заявка на курс', 'svitmov' ); ?>
</h1>
<?php foreach ( [ 'first-name', 'last-name', 'birth-date', 'guardian-name', 'email', 'phone', 'question', 'language', 'is-online', 'course' ] as $field ) : ?>
	<?php if ( ! empty( $args[ $field ] ) ) : ?>
		<p>
			<b>
				<?php
				switch ( $field ) {
					case 'first-name':
						esc_html_e( 'Ім\'я:', 'svitmov' );
						break;
					case 'last-name':
						esc_html_e( 'Прізвище:', 'svitmov' );
						break;
					case 'email':
						esc_html_e( 'Пошта:', 'svitmov' );
						break;
					case 'phone':
						esc_html_e( 'Телефон:', 'svitmov' );
						break;
					case 'guardian-name':
						esc_html_e( 'Ім\'я Опікуна:', 'svitmov' );
						break;
					case 'birth-date':
						esc_html_e( 'Дата Народження:', 'svitmov' );
						break;
					case 'language':
						esc_html_e( 'Мова Навчання:', 'svitmov' );
						break;
					case 'is-online':
						esc_html_e( 'Форма Навчання:', 'svitmov' );
						break;
					case 'course':
						esc_html_e( 'Курс:', 'svitmov' );
						break;
				}
				?>
			</b>
			<?php echo esc_html( $args[ $field ] ); ?>
		</p>
	<?php endif; ?>
<?php endforeach; ?>
