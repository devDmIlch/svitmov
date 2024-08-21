<?php
/**
 * News slider template
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

?>
<section class="section-news-slider">
	<?php if ( $args['show_title'] ?? true ) : ?>
		<h2 class="section-title">
			<?php esc_html_e( 'Наш блог', 'svitmov' ); ?>
		</h2>
	<?php endif; ?>
	<div class="splide news-slider svitmov-slider">
		<div class="splide__track">
			<div class="splide__list">
				<?php
				foreach ( \Svitmov\PostTypes\News::get_news_list() as $args ) {
					// Push classes into array of arguments for cards to work properly with slider.
					$args['classes'] = [ 'splide__slide' ];
					// Load template.
					get_template_part( 'template-parts/components/card', 'news', $args );
				}
				?>
			</div>
		</div>
	</div>
</section>
