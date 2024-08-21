<?php
/**
 * "Tests" page template file.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

?>
<section class="section-tests">
	<?php foreach ( $args['test_list'] ?? [] as $test_data ) : ?>
		<div class="single-test" style="background-color: <?php echo esc_attr( $test_data['color'] ); ?>">
			<?php if ( ! empty( $test_data['thumbnail'] ) ) : ?>
				<div class="thumbnail">
					<?php if ( is_array( $test_data['thumbnail'] ) ) : ?>
						<img src="<?php echo esc_url( $test_data['thumbnail']['sizes']['large'] ); ?>" alt="<?php esc_attr_e( 'Ілюстративне зображення до тесту', 'svitmov' ); ?>" />
					<?php else : ?>
						<img src="<?php echo esc_url( wp_get_attachment_image_url( $test_data['thumbnail'], 'large' ) ); ?>" alt="<?php esc_attr_e( 'Ілюстративне зображення до тесту', 'svitmov' ); ?>" />
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<h2>
				<?php echo esc_html( $test_data['name'] ); ?>
			</h2>
			<p>
				 <?php echo esc_html( $test_data['desc'] ?? '' ); ?>
			</p>
			<a class="test-link action-button" href="<?php echo esc_url( $test_data['url'] ); ?>" target="_blank">
				<?php esc_html_e( 'Пройти тест', 'svitmov' ); ?>
			</a>
		</div>
	<?php endforeach; ?>
</section>
