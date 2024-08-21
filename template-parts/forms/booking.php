<?php
/**
 * Booking form template file
 *
 * @package svitmov/theme
 * @since 0.0.2
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

$form_fields = [
	'first-name' => [
		'type' => 'text',
		'name' => __( 'Ім\'я', 'svitmov' ),
	],
	'last-name' => [
		'type' => 'text',
		'name' => __( 'Прізвище', 'svitmov' ),
	],
	'phone' => [
		'type' => 'tel',
		'name' => __( 'Номер телефону', 'svitmov' ),
	],
	'email' => [
		'type' => 'email',
		'name' => __( 'Email', 'svitmov' ),
	]
];

if ( in_array( $args['subtype'], [ 'selectable', 'child' ], true ) ) {
	$form_fields['birth-date'] = [
		'type' => 'date',
		'name' => __( 'Дата народження', 'svitmov' ),
	];
	$form_fields['guardian-name'] = [
		'type' => 'text',
		'name' => __( 'Ім\'я одного з батьків', 'svitmov' ),
	];
}

?>
<div class="svitmov-form book-form">
	<label class="test-question" for="test-question"><input tabindex="100" type="text" name="test-question" class="test-question"/></label>
	<?php if ( $args['subtype'] === 'selectable' ) : ?>
		<div class="subtype-switch">
			<span class="type-switch active" type="kid"><?php esc_html_e( 'Для дитини', 'svitmov-theme' ); ?></span>
			<span class="type-switch" type="adult"><?php esc_html_e( 'Для дорослих', 'svitmov-theme' ); ?></span>
		</div>
	<?php endif; ?>
	<?php foreach ( $form_fields as $field_slug => $field_data ) : ?>
		<div class="field-wrap">
			<label for="<?php echo esc_attr( $field_slug ); ?>" hidden>
				<?php echo esc_html( $field_data['name'] ); ?>
			</label>
			<span class="field-error"></span>
			<input id="<?php echo esc_attr( $field_slug ); ?>" name="<?php echo esc_attr( $field_slug ); ?>" required
				type="<?php echo esc_attr( $field_data['type'] ); ?>" placeholder="<?php echo esc_html( $field_data['name'] ); ?>">
		</div>
	<?php endforeach; ?>
	<?php if ( isset( $args['course'] ) ) : ?>
		<input type="hidden" id="course" name="course" value="<?php echo esc_attr( $args['course'] ); ?>">
	<?php else : ?>
		<div class="field-wrap">
			<label for="language" hidden>
				<?php esc_attr_e( 'Виберіть мову навчання', 'svitmov' ); ?>
			</label>
			<span class="field-error"></span>
			<input type="hidden" name="language" id="language" required>
			<div type="text" class="pseudo-select" rel="language" tabindex="0">
				<?php esc_attr_e( 'Виберіть мову навчання', 'svitmov' ); ?>
			</div>
			<div class="pseudo-select-dropdown" rel="language">
				<?php foreach ( $args['languages'] ?? [] as $lang_slug => $lang_name ) : ?>
					<div class="option" tabindex="0" value="<?php echo esc_attr( $lang_slug ); ?>">
						<?php echo esc_html( $lang_name ); ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="field-wrap">
			<label for="is-online" hidden>
				<?php esc_attr_e( 'Виберіть формат', 'svitmov' ); ?>
			</label>
			<span class="field-error"></span>
			<input type="hidden" name="is-online" id="is-online" required>
			<div type="text" class="pseudo-select" rel="is-online" tabindex="0">
				<?php esc_attr_e( 'Виберіть формат', 'svitmov' ); ?>
			</div>
			<div class="pseudo-select-dropdown" rel="is-online">
				<div class="option" tabindex="0" value="offline">
					<?php esc_html_e( 'В нашому центрі', 'svitmov' ); ?>
				</div>
				<div class="option" tabindex="0" value="online">
					<?php esc_html_e( 'Онлайн', 'svitmov' ); ?>
				</div>
				<div class="option" tabindex="0" value="mixed">
					<?php esc_html_e( 'Змішана', 'svitmov' ); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<span class="submit-error hidden">
		<?php esc_html_e( 'Помилка при відправці форми', 'svitmov' ); ?>
	</span>
	<button class="submit-review submit-form button-yellow-mid">
		<?php esc_html_e( 'Записатися', 'svitmov' ); ?>
	</button>
</div>
