<?php
/**
 * Booking email for users
 *
 * @package svitmov/theme
 * @since 0.0.2
 */

// Check whether an empty array was supplied.
if ( ! isset( $args ) ) {
	return;
}

?>
<h1 class="">
	<?php esc_html_e( 'Вашу заявку відправлено', 'svitmov' ); ?>
</h1>
<p>
	<?php esc_html_e( 'Скоро з вами зв\'яжуться, очікуйте дзвінка адміністратора', 'svitmov' ); ?>
</p>
