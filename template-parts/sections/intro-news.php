<?php
/**
 * Intro section template for News posts.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

?>
<section class="section-intro-3">
	<h1 class="post-title">
		<?php echo esc_html( $args['title'] ); ?>
	</h1>
	<div class="post-tags">
		<?php foreach ( $args['tags'] as $tag ) : ?>
			<span class="single-tag">
				<?php echo esc_html( '#' . $tag ); ?>
			</span>
		<?php endforeach; ?>
	</div>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
	<?php endif; ?>
</section>
