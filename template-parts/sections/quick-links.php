<?php
/**
 * Quick Links section template
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

?>
<section class="section-quick-links">
	<h2>
		<?php esc_html_e( 'Оберіть собі курс', 'svitmov' ); ?>
	</h2>
	<a class="sidelink" href="<?php echo esc_url( $args['course-link'] ); ?>">
		<?php esc_html_e( 'Всі Курси', 'svitmov' ); ?>
	</a>
	<div class="link-list">
		<?php foreach ( $args['links'] as $link_data ) : ?>
			<a class="quick-link" href="<?php echo esc_url( $link_data['url'] ); ?>" style='background-image: url("<?php echo esc_url( wp_get_attachment_image_url( $link_data['image'], 'medium' ) ); ?>");'>
				<span class="foreground"><?php echo esc_html( $link_data['name'] ); ?></span>
			</a>
		<?php endforeach; ?>
	</div>
</section>

