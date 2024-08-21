<?php
/**
 * Teachers slider template
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

?>
<section class="section-teacher-slider">
	<?php if ( $args['show_title'] ?? true ) : ?>
		<h2 class="section-title">
			<?php esc_html_e( 'Викладачі', 'svitmov' ); ?>
		</h2>
	<?php endif; ?>
	<div class="splide teacher-slider svitmov-slider">
		<div class="splide__track">
			<ul class="splide__list">
				<?php foreach ( \Svitmov\PostTypes\Teacher::get_teacher_list() as $teacher ) : ?>
					<li class="splide__slide teacher-card">
						<div class="thumbnail-wrap">
							<a href="<?php echo esc_url( $teacher['url'] ); ?>">
								<?php if ( ! empty( $teacher['photo'] ) ) : ?>
									<img class="thumbnail" src="<?php echo esc_url( $teacher['photo'] ); ?>" alt="<?php esc_attr_e( 'Фотографія викладача', 'svitmov' ); ?>">
								<?php endif; ?>
							</a>
						</div>
						<div class="info-block">
							<h3 class="name">
								<a href="<?php echo esc_url( $teacher['url'] ); ?>">
									<?php echo esc_html( $teacher['name'] ); ?>
								</a>
							</h3>
							<p class="bio">
								<?php echo esc_html( $teacher['bio'] ); ?>
							</p>
							<div class="lang-list">
								<?php foreach ( $teacher['lang'] as $lang ) : ?>
									<span class="lang">
										<?php echo esc_html( $lang ); ?>
									</span>
								<?php endforeach; ?>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>
