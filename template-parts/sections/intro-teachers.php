<?php
/**
 * Intro section template for Course pages.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

?>
<section class="section-intro-2">
	<div class="content-wrap">
		<div class="post-data">
			<h1 class="post-title">
				<?php esc_html_e( 'Викладачі', 'svitmov' ); ?>
			</h1>
			<p class="post-description light-text">
				<?php esc_html_e( 'Усі наші викладачі регулярно (кожні 6 місяців) підтверджують свої знання за допомогою мовних тестів TOEFL, IELTS, C1 Advanced, C2 Proficiency та отримують високі бали.', 'svitmov' ); ?>
			</p>
		</div>
	</div>
	<div class="section-graphics">
		<?php \Svitmov\Includes\Helpers::the_svg_file( 'graphic_2' ); ?>
	</div>
</section>
