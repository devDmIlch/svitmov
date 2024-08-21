<?php
/**
 * Admin Controller class file
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\Admin;

/**
 * Admin Controller class.
 */
class Admin {

	// Private Fields.

	/**
	 * Settings domain name
	 *
	 * @var string $settings_group
	 */
	private string $settings_group;

	/**
	 * Social domain name.
	 *
	 * @var string $social_group
	 */
	private string $social_group;

	/**
	 * Integration domain name.
	 *
	 * @var string $integration_group
	 */
	private string $integration_group;

	/**
	 * List of custom theme options
	 *
	 * @var array $theme_options
	 */
	private array $theme_options;

	/**
	 * List of custom social options.
	 *
	 * @var array $social_options.
	 */
	private array $social_options;

	/**
	 * List of custom integration options.
	 *
	 * @var array $integration_options.
	 */
	private array $integration_options;


	// Initializing methods.

	/**
	 * Initialization method for the class.
	 */
	public function init(): void {
		// Set settings group name
		$this->settings_group = 'svitmov';
		// Set theme options.
		$this->theme_options = [ 'svitmov-phone', 'svitmov-emails', 'svitmov-location', 'svitmov-embedded' ];

		// Set social group name
		$this->social_group = 'svitmov-social';
		// Set social options.
		$this->social_options = [ 'svitmov-social-ig', 'svitmov-social-yt', 'svitmov-social-fb', 'svitmov-social-vb', 'svitmov-social-tg' ];

		// Set integrations group name
		$this->integration_group = 'svitmov-int';
		// Set integrations options.
		$this->integration_options = [ 'svitmov-captcha', 'svitmov-captcha-secret' ];

		$this->hooks();
	}

	/**
	 * Hooks initialization method for the class.
	 */
	protected function hooks(): void {
		// Register settings.
		add_action( 'admin_init', [ $this, 'register_theme_settings' ] );
		// Register option pages.
		add_action( 'admin_menu', [ $this, 'register_option_pages' ], 5 );

		// Parse and sanitize options before submitting.
		add_action( 'pre_update_option', [ $this, 'parse_submitted_theme_options' ], 10, 2 );
	}


	// Public Methods.

	/**
	 * Registers option pages for admin.
	 */
	public function register_option_pages(): void {
		add_menu_page(
			__( 'Налаштування теми "Svitmov"', 'svitmov' ),
			__( 'Svitmov', 'svitmov' ),
			'edit_pages',
			'svitmov-settings',
			[ $this, 'load_theme_menu_template' ],
			'dashicons-art',
			25,
		);
	}

	/**
	 * Loads theme menu template.
	 */
	public function load_theme_menu_template(): void {
		// Get theme options.
		$args = [];
		// Add contact information.
		$args['contact'] = [
			'group'  => $this->settings_group,
			'fields' => get_options( $this->theme_options ),
		];
		// Add social information.
		$args['social'] = [
			'group'  => $this->settings_group,
			'fields' => get_options( $this->social_options ),
		];
		// Add integration information.
		$args['integration'] = [
			'group'  => $this->integration_group,
			'fields' => get_options( $this->integration_options ),
		];
		// Load the template.
		get_template_part( 'template-parts/admin/theme', 'settings', $args );
	}

	/**
	 * Registers theme settings.
	 */
	public function register_theme_settings(): void {
		// Register theme settings.
		foreach ( $this->theme_options as $option_name ) {
			register_setting( $this->settings_group, $option_name );
		}
		// Register social links settings.
		foreach ( $this->social_options as $option_name ) {
			register_setting( $this->social_group, $option_name );
		}
		// Register integrations settings.
		foreach ( $this->integration_options as $option_name ) {
			register_setting( $this->integration_group, $option_name );
		}
	}

	/**
	 * Parses submitted theme options
	 *
	 * @param mixed  $value  The new, unserialized option value.
	 * @param string $option Name of the option.
	 */
	public function parse_submitted_theme_options( mixed $value, string $option ): mixed {
		// Bail if the option is not related to theme.
		if ( ! in_array( $option, $this->theme_options, true ) ) {
			return $value;
		}

		if ( in_array( $option, [ 'svitmov-phone', 'svitmov-emails' ] ) ) {
			$value = preg_split( '/(\n|, |,)/', $value );
		}

		return $value;
	}
}
