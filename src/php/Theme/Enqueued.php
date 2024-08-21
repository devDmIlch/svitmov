<?php
/**
 * Class file with script & style files enqueueing.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\Theme;

/**
 * Enqueued Class
 */
class Enqueued {

	// Private Fields.

	/**
	 * Theme's handle prefix.
	 *
	 * @var string $prefix
	 */
	private string $prefix;

	/**
	 * Path to the build folder of the project.
	 *
	 * @var string $build_path
	 */
	private string $build_path;


	// Construction Methods.

	/**
	 * Initializing function for the class
	 */
	public function init(): void {
		$this->prefix = 'svitmov';
		// Save the path to compiled files in the project.
		$this->build_path = get_stylesheet_directory_uri() . '/assets/build/';

		// Initialize class hooks.
		$this->hooks();
	}

	/**
	 * Hooks initializing function for the class
	 */
	protected function hooks(): void {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_theme_files' ] );
	}


	// Public Methods.

	/**
	 * Enqueues script and style files for the theme.
	 */
	public function enqueue_theme_files(): void {
		// Enqueue nonces for JS.
		wp_enqueue_script( 'wp-api' );
		wp_localize_script(
			'wp-api',
			'wpApiSettings',
			[
				'root'           => esc_url_raw( rest_url() ),
				'nonce'          => wp_create_nonce( 'wp_rest' ),
				'captcha'        => get_option( 'svitmov-captcha' ),
				'captcha_secret' => get_option( 'svitmov-captcha-secret' ),
				'post_id'        => get_the_ID(),
			]
		);

		// Enqueue JavaScript.
		wp_enqueue_script(
			$this->prefix . '_script',
			$this->build_path . 'custom.js',
			[ 'wp-i18n' ],
			SVITMOV_THEME_VERSION,
			true,
		);

		// Enqueue Styles.
		wp_enqueue_style(
			$this->prefix . '_style',
			$this->build_path . 'custom.css',
			[],
			SVITMOV_THEME_VERSION,
			'all',
		);

		// Enqueue Google Recaptcha.
		wp_enqueue_script(
			$this->prefix . '_captcha',
			'https://www.google.com/recaptcha/api.js?render=' . get_option( 'svitmov-captcha' ),
			[],
			SVITMOV_THEME_VERSION,
			[ 'in_footer' => true ],
		);
	}
}
