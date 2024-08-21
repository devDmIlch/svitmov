<?php
/**
 * Intro section template for Course pages.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

?>
<section class="section-intro">
	<div class="content-wrap">
		<div class="post-data">
			<h1 class="post-title">
				<?php the_title(); ?>
			</h1>
			<p class="post-description light-text">
				<?php the_field( 'short-desc' ); ?>
			</p>
			<a class="register-button button-yellow-mid">
				<?php esc_html_e( 'Записатися на курс' ); ?>
			</a>
		</div>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="post-thumbnail">
				<div class="thumbnail-background">
					<?php \Svitmov\Includes\Helpers::the_svg_file( 'graphic_1' ); ?>
				</div>
				<?php the_post_thumbnail(); ?>
			</div>
		<?php endif; ?>
	</div>
</section>
