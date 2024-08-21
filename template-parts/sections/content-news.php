<?php
/**
 * Content section for News posts
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

?>
<section class="section-content">
	<?php the_content(); ?>
	<div class="post-tags">
		<span class="tag-text">
			<?php esc_html_e( 'Теги:', 'svitmov' ); ?>
		</span>
		<?php foreach ( $args['tags'] as $tag ) : ?>
			<span class="single-tag">
				<?php echo esc_html( '#' . $tag ); ?>
			</span>
		<?php endforeach; ?>
	</div>
</section>
