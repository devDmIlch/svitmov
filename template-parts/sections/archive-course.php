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
<section class="section-archive">
	<aside class="archive-filters">
	</aside>
	<div class="archive-main">
		<div class="archive-head">
			<?php if ( empty( $args['title'] ) ) : ?>
				<h1 class="page-name">
					<?php echo esc_html( $args['name'] ); ?>
				</h1>
			<?php else : ?>
				<h2 class="page-name">
					<?php echo esc_html( $args['name'] ); ?>
				</h2>
			<?php endif; ?>
			<span class="total-entries">
			</span>
		</div>
		<div class="archive-content loading">
		</div>
		<div class="archive-load-more hidden">
			<span class="load-more">
				<?php esc_html_e( 'Показати Більше', 'estore-theme' ); ?>
				<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M4 6.25L8.5 10.75L13 6.25" stroke="#333333" stroke-miterlimit="10" stroke-linecap="square"/>
				</svg>
			</span>
		</div>
	</div>
</section>
