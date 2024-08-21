<?php
/**
 * Title section for archive
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

?>
<section class="section-title-archive">
	<h1 class="page-title">
		<?php echo wp_kses( $args['title'], [ 'b' => [] ] ); ?>
	</h1>
	<?php if ( $args['fail'] ?? false ) : ?>
		<p class="fail-message">
			<?php esc_html_e( 'Нічого не знайдено', 'svitmov' ); ?>
		</p>
		<p class="fail-suggestion">
			<?php esc_html_e( 'Можливо вас зацікавить наступне:', 'svitmov' ); ?>
		</p>
	<?php endif; ?>
</section>
