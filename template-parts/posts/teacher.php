<?php
/**
 * Single Teacher page template.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

?>
<section class="section-teacher">
	<div class="photo-wrap">
		<img src="<?php the_post_thumbnail_url( 'full' ); ?>" alt="<?php esc_html_e( 'Фотографія Викладача', 'svitmov' ); ?>" />
	</div>
	<div class="description">
		<span class="greeting">
			— <?php echo esc_html( \Svitmov\Taxonomies\Language::get_lang_greeting() ); ?>
		</span>
		<div class="title-wrap">
			<h1 class="teacher-name"><?php the_title(); ?></h1>
		</div>
		<div class="teacher-bio">
			<?php the_content(); ?>
		</div>
	</div>
	<?php if ( ! empty( $args['certs'] ) ) : ?>
		<div class="splide certificates-slider svitmov-slider">
			<div class="splide__track">
				<div class="splide__list">
					<?php foreach ( $args['certs'] as $cert_img ) : ?>
						<div class="splide__slide certificate-wrap">
							<img src="<?php echo esc_url( $cert_img['sizes']['large'] ); ?>" class="certificate" alt="<?php esc_attr_e( 'Зображення сертифікату', 'svitmov' ); ?>"/>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
</section>
