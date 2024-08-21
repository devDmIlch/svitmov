<?php
/**
 * Footer template file for the theme.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

?>
<footer>
	<div class="newsletter">
		<div class="newsletter-content">
			<label class="text" for="newsletter-email">
				<?php esc_html_e( 'Підпишися на наші соціальні мережі', 'svitmov' ); ?>
			</label>
			<?php foreach ( get_options( [ 'svitmov-social-ig', 'svitmov-social-yt', 'svitmov-social-fb' ] ) as $name => $link ) : ?>
				<?php if ( ! empty( $link ) ) : ?>
					<a class="social-link <?php echo esc_attr( $name ); ?>" href="<?php echo esc_url( $link ); ?>" target="_blank">
					</a>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="footer-main">
		<div class="footer-main-content">
			<div class="site-identity">
				<?php the_custom_logo(); ?>
			</div>
			<div class="widgets">
				<div class="widget-column">
					<?php $contact_data = get_options( [ 'svitmov-location', 'svitmov-emails', 'svitmov-phone' ] ); ?>
					<h4>
						<?php esc_html_e( 'Контакти', 'svitmov' ); ?>
					</h4>
					<?php foreach ( $contact_data as $data_piece ) : ?>
						<p>
							<?php
							if ( is_array( $data_piece ) ) {
								echo wp_kses( implode( '<br>', $data_piece ), [ 'br' => [] ] );
							} else {
								echo wp_kses( $data_piece . '<br>', [ 'br' => [] ] );
							}
							?>
						</p>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="copyright">
				<span class="date">
					2024 ©svitmov.ck. All Rights Reserved.
				</span>
				<a class="message-dev" href="mailto:dm.ilch.mail@gmail.com">
					Роробка <b>Dmytro Ilchenko</b>
				</a>
			</div>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>

