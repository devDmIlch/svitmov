<?php
/**
 * Template for the 'Test Your Lang Level section'.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

?>
<section class="section-test-level">
	<div class="content-wrap gray-box">
		<div class="text">
			<h2 class="section-title">
				<?php esc_html_e( 'Перевір рівень своєї англійської безкоштовно', 'svitmov' ); ?>
			</h2>
			<p class="section-desc light-text">
				<?php esc_html_e( 'Ти можеш безкоштовно пройти тест на рівень твоєї англійської після чого ми допомжемо тобі підібрати курс спеціально для тебе', 'svitmov' ); ?>
			</p>
			<div class="buttons">
				<a class="action-button" href="<?php echo esc_url( '/test-page/' ); ?>">
					<?php esc_html_e( 'Перевірити рівень', 'svitmov' ); ?>
				</a>
				<span class="action-button-2 inactive">
					<?php esc_html_e( '~25 хвилин', 'svitmov' ); ?>
				</span>
			</div>
		</div>
		<div class="graphics">
			<?php \Svitmov\Includes\Helpers::the_svg_file( 'level_test_fg' ); ?>
		</div>
	</div>
	<div class="section-background">
		<?php \Svitmov\Includes\Helpers::the_svg_file( 'level_test_bg' ); ?>
	</div>
</section>
