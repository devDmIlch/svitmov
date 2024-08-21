<?php
/**
 * Archive template for course posts.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

?>
<section class="section-archive simplified">
	<h1 class="page-title">
		<?php echo esc_html( $args['name'] ); ?>
	</h1>
	<div class="top-links">
		<?php foreach( \Svitmov\Taxonomies\NewsCategory::get_term_list() as $link ) : ?>
			<a class="single-link <?php echo esc_attr( $link['selected'] ? 'current' : '' ); ?>" href="<?php echo esc_url( $link['url'] ); ?>">
				<?php echo esc_html( $link['name'] ); ?>
			</a>
		<?php endforeach; ?>
	</div>
	<div class="subsection">
		<div class="archive-main">
			<div class="latest-post">
				<?php $args['load_latest_post'](); ?>
			</div>
			<div class="archive-content loading">
			</div>
			<div class="archive-pagination">
			</div>
		</div>
		<div class="featured-sidebar">
			<?php $args['load_featured_posts'](); ?>
		</div>
	</div>
</section>
