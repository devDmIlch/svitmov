<?php
/**
 * Theme settings admin page.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

$social_names = [
	'svitmov-social-ig' => 'Instagram',
	'svitmov-social-yt' => 'Youtube',
	'svitmov-social-fb' => 'Facebook',
	'svitmov-social-vb' => 'Viber',
	'svitmov-social-tg' => 'Telegram',
];

$integration_names = [
	'svitmov-captcha'        => 'reCaptcha Key',
	'svitmov-captcha-secret' => 'reCaptcha Secret',
];

?>
<h1 class="wp-heading-inline">
	<?php esc_html_e( 'Налаштування теми "Svitmov"', 'svitmov' ); ?>
</h1>
<form method="post" action="options.php" style="display: flex; flex-direction: column; gap: 8px; max-width: 600px">
	<h2><?php esc_html_e( 'Контактна інформація', 'svitmov' ); ?></h2>
	<?php settings_fields( $args['contact']['group'] ); ?>
	<label for="svitmov-location">
		<?php esc_html_e( 'Адреса', 'svitmov' ); ?>
	</label>
	<input type="text" name="svitmov-location" id="svitmov-location" style="margin-bottom: 24px" value="<?php echo esc_html( $args['contact']['fields']['svitmov-location'] ?? [] ); ?>">
	<label for="svitmov-phone">
		<?php esc_html_e( 'Телефони', 'svitmov' ); ?>
	</label>
	<textarea name="svitmov-phone" id="svitmov-phone" style="margin-bottom: 24px" rows="5"><?php echo esc_html( implode( "\n", ! $args['contact']['fields']['svitmov-phone'] ? [] : $args['contact']['fields']['svitmov-phone'] ) ); ?></textarea>
	<label for="svitmov-emails">
		<?php esc_html_e( 'Електронна Пошта', 'svitmov' ); ?>
	</label>
	<textarea name="svitmov-emails" id="svitmov-emails" style="margin-bottom: 24px" rows="5"><?php echo esc_html( implode( "\n", ! $args['contact']['fields']['svitmov-emails'] ? [] : $args['contact']['fields']['svitmov-phone'] ) ); ?></textarea>
	<label for="svitmov-embedded">
		<?php esc_html_e( 'Вставити Карту', 'svitmov' ); ?>
	</label>
	<textarea name="svitmov-embedded" id="svitmov-embedded" rows="10"><?php echo esc_html( $args['contact']['fields']['svitmov-embedded'] ?? [] ); ?></textarea>
	<?php submit_button( __( 'Зберегти Налаштування', 'svitmov' ) ); ?>
</form>
<form method="post" action="options.php" style="display: flex; flex-direction: column; gap: 8px; max-width: 600px">
	<h2><?php esc_html_e( 'Соцмережі', 'svitmov' ); ?></h2>
	<?php settings_fields( $args['social']['group'] . '-social' ); ?>
	<?php foreach ( $args['social']['fields'] as $name => $value ) : ?>
		<label for="<?php echo esc_attr( $name ); ?>">
			<?php echo esc_html( $social_names[ $name ] ); ?>
		</label>
		<input type="text" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $name ); ?>" style="margin-bottom: 24px" value="<?php echo esc_html( $value ); ?>" placeholder="<?php esc_attr_e( 'Почніть з https://', 'svitmov' ); ?>">
	<?php endforeach; ?>
	<?php submit_button( __( 'Зберегти Налаштування', 'svitmov' ) ); ?>
</form>
<form method="post" action="options.php" style="display: flex; flex-direction: column; gap: 8px; max-width: 600px">
	<h2><?php esc_html_e( 'Інтеграції з сервісами', 'svitmov' ); ?></h2>
	<?php settings_fields( $args['integration']['group'] ); ?>
	<?php foreach ( $args['integration']['fields'] as $name => $value ) : ?>
		<label for="<?php echo esc_attr( $name ); ?>">
			<?php echo esc_html( $integration_names[ $name ] ); ?>
		</label>
		<input type="text" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $name ); ?>" style="margin-bottom: 24px" value="<?php echo esc_html( $value ?? '' ); ?>">
	<?php endforeach; ?>
	<?php submit_button( __( 'Зберегти Налаштування', 'svitmov' ) ); ?>
</form>
