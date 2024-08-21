<?php
/**
 * Review form template file.
 *
 * @package svitmov/theme
 * @since 0.0.2
 */

?>
<label class="test-question" for="test-question"><input tabindex="100" type="text" name="test-question" class="test-question"/></label>
<div class="field-wrap">
	<label for="name" hidden>
		<?php esc_html_e( 'Ім\'я', 'svitmov' ); ?>
	</label>
	<span class="field-error"></span>
	<input id="name" name="name" class="form-field" type="text" placeholder="<?php esc_attr_e( 'Ім\'я', 'svitmov' ); ?>" required/>
</div>
<div class="field-wrap">
	<label for="email" hidden>
		<?php esc_html_e( 'Email', 'svitmov' ); ?>
	</label>
	<span class="field-error"></span>
	<input id="email" name="email" class="form-field" type="email" placeholder="<?php esc_attr_e( 'Email', 'svitmov' ); ?>" required/>
</div>
<div class="field-wrap">
	<label for="review" hidden>
		<?php esc_html_e( 'Текст відгуку', 'svitmov' ); ?>
	</label>
	<span class="field-error"></span>
	<textarea id="review" name="review" placeholder="<?php esc_attr_e( 'Опишіть ваш досвід в декількох реченнях...', 'svitmov' ); ?>" required></textarea>
</div>
<span class="submit-error hidden">
	<?php esc_html_e( 'Помилка при відправці форми', 'svitmov' ); ?>
</span>
<button class="submit-review submit-form">
	<?php esc_html_e( 'Залишити відгук', 'svitmov' ); ?>
</button>
