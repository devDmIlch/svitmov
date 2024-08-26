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
			<a class="register-button button-yellow-mid pop-up-trigger" rel="booking-pop-up">
				<?php esc_html_e( 'Записатися на курс' ); ?>
			</a>
			<?php
			$form_args = [
				'subtype' => 'selectable',
				'course'  => get_the_ID(),
			];
			// If the course id is not empty retrieve subtype from meta.
			if ( ! empty( $form_args['course'] ) ) {
				$form_args['subtype'] = get_post_meta( $form_args['course'], 'course-audience', true );
			}

			get_template_part(
				'template-parts/pop-ups/generic-pop-up',
				args: [
					'form'      => 'booking',
					'form-name' => 'booking-form',
					'rel'       => 'booking-pop-up',
					'title'     => __( 'Записатися на курс', 'svitmov' ),
					'data'      => $form_args,
					'success'   => __( 'Заявка відправлена!', 'svitmov' ),
				]
			); ?>
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
