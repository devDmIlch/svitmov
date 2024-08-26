<?php
/**
 * Review Submission Pop-up template.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

?>
<div class="<?php echo esc_attr( $args['form-name'] ?? 'review-form' ); ?> pop-up-form pop-up-target" rel="<?php echo esc_attr( $args['rel'] ?? 'review-pop-up' ); ?>">
	<div class="form-content">
		<?php if ( ! empty( $args['title'] ) ) : ?>
			<h3 class="form-title"><?php echo esc_html( $args['title'] ); ?></h3>
		<?php endif; ?>
		<?php get_template_part( 'template-parts/forms/' . $args['form'], args: $args['data'] ?? [] ); ?>
	</div>
	<div class="success-message hidden">
		<span class="text"><?php echo esc_html( $args['success'] ?? __( 'Форма відправлена!', 'svitmov' ) ); ?></span>
	</div>
	<a class="pop-up-close">
		<?php esc_html_e( 'Закрити', 'svitmov' ); ?>
	</a>
</div>
