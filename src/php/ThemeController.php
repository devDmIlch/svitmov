<?php
/**
 * Controller class for Svitmov theme
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov;

// Admin.
use Svitmov\Admin\Admin;
// Core.
use Svitmov\Core\Archive\Archive;
use Svitmov\Core\Booking\Booking;
// Post Types.
use Svitmov\PostTypes\News;
use Svitmov\PostTypes\Review;
use Svitmov\PostTypes\Teacher;
use Svitmov\PostTypes\Course;
// Taxonomies.
use Svitmov\Taxonomies\Author;
use Svitmov\Taxonomies\LangLevel;
use Svitmov\Taxonomies\LangTest;
use Svitmov\Taxonomies\Language;
use Svitmov\Taxonomies\NewsCategory;
use Svitmov\Taxonomies\NewsTag;
// Menus.
use Svitmov\Menus\MenuController;
// Other.
use Svitmov\Theme\Enqueued;
use Svitmov\Theme\Widgets;
use Svitmov\Theme\Pages;

/**
 * Svitmov controller class
 */
class ThemeController {

	// Construction Methods.

	/**
	 * Initializing function for the class
	 */
	public function init(): void {
		// Initialize theme features support.
		$this->init_theme_features();
		// Initialize post types.
		$this->init_post_types();
		// Initialize taxonomies.
		$this->init_taxonomies();

		// Initialize page controller.
		$page_controller = new Pages();
		$page_controller->init();

		// Initialize archive class.
		$archive = new Archive();
		$archive->init();

		// Initialize enqueueing class.
		$enqueued = new Enqueued();
		$enqueued->init();

		// Initialize widgets class.
		$widgets = new Widgets();
		$widgets->init();

		// Initialize menus.
		$menus = new MenuController();
		$menus->init();

		// Initialize booking functionality.
		$booking = new Booking();
		$booking->init();

		// Initialize contact functionality.
		$contact = new Core\Contact\Contact();
		$contact->init();

		// Initialize Admin Controller.
		$admin_controller = new Admin();
		$admin_controller->init();

		// Initialize all hooks.
		$this->hooks();
	}

	/**
	 * Hooks initializing function for the class
	 */
	private function hooks(): void {
		// Add actions to customize wp-admin.
		add_action( 'admin_menu', [ $this, 'adjust_wp_admin_menu' ], 99 );
		// Add Google Fonts to website.
		add_action( 'wp_head', [ $this, 'insert_google_fonts' ], 10 );

		// Set post parameters.
		add_filter( 'excerpt_more', fn () => '', 99 );
		add_filter( 'excerpt_length', fn () => 20, 99 );

		// Restrict theme switch if the plugin is not active.
		add_action( 'after_switch_theme', [ $this, 'check_theme_dependencies' ], 10, 2 );
	}


	// Private Methods.

	/**
	 * Initializes theme support features.
	 */
	private function init_theme_features(): void {
		add_theme_support( 'menus' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'widgets' );
		add_theme_support(
			'custom-logo',
			[
				'height'               => 100,
				'width'                => 400,
				'flex-height'          => true,
				'flex-width'           => true,
				'header-text'          => [ 'site-title', 'site-description' ],
				'unlink-homepage-logo' => true,
			]
		);
	}

	/**
	 * Initializes all post types included in the theme.
	 */
	private function init_post_types(): void {
		// Initialize courses.
		$course_obj = new Course();
		$course_obj->init();
		// Initialize teachers.
		$teacher_obj = new Teacher();
		$teacher_obj->init();
		// Initialize reviews.
		$review_obj = new Review();
		$review_obj->init();
		// Initialize news.
		$news_obj = new News();
		$news_obj->init();
	}

	/**
	 * Initializes all taxonomies included in the theme.
	 */
	private function init_taxonomies(): void {
		// Initialize languages.
		$languages_obj = new Language();
		$languages_obj->init();
		// Initialize language levels.
		$lang_level_obj = new LangLevel();
		$lang_level_obj->init();
		// Initialize language tests.
		$lang_test_obj = new LangTest();
		$lang_test_obj->init();

		// Initialize news categories.
		$news_categories = new NewsCategory();
		$news_categories->init();
		// Initialize news tags.
		$news_tags = new NewsTag();
		$news_tags->init();

		// Initialize text book authors.
		$author = new Author();
		$author->init();
	}

	/**
	 * Adds separator to wp-admin menu at position.
	 *
	 * @param int $pos position in the menu.
	 */
	private function add_admin_menu_separator( int $pos ): void {
		global $menu;
		$index = 0;
		foreach ( $menu as $offset => $section ) {
			if ( str_starts_with( $section[2], 'separator' ) ) {
				$index++;
			}
			if ( $offset >= $pos ) {
				$menu[ $pos ] = [ '', 'read', "separator{$index}", '', 'wp-menu-separator' ]; // phpcs:ignore
				break;
			}
		}
		ksort( $menu );
	}


	// Public Methods.

	/**
	 * Checks missing dependencies for plugins and aborts theme switch.
	 *
	 * @param string    $old_theme     Name of the old theme.
	 * @param \WP_Theme $old_theme_obj Object of the old theme.
	 */
	public function check_theme_dependencies( string $old_theme, \WP_Theme $old_theme_obj ): void {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			function is_plugin_active( string $plugin ): bool {
				return in_array( $plugin, (array) get_option( 'active_plugins', [] ), true );
			}
		}
		// Check whether ACF plugin is installed.
		$acf_installed = is_plugin_active( 'advanced-custom-fields/acf.php' ) || is_plugin_active( 'advanced-custom-fields-pro/acf.php' );
		// If 'Advanced Custom Field' plugin is not installed, revert to original theme.
		if ( $acf_installed ) {
			return;
		}

		// Add text to indicate missing dependencies.
		add_filter(
			'gettext',
			static function ( $translated, $original, $domain ) {
				// Strings to translate.
				$strings = [
					'New theme activated.' => 'Missing Dependencies: Advanced Custom Fields',
				];

				if ( isset( $strings[ $original ] ) ) {
					// Translate but without running all the filters again.
					$translations = get_translations_for_domain( $domain );

					if ( isset( $translations ) ) {
						$translated = $translations->translate( $strings[ $original ] );
					}
				}

				return $translated;
			},
			10,
			3
		);
		// Add styles to the message.
		add_action( 'admin_head', static function () { echo wp_kses( '<style>#message2{border-left-color:#dc3232;}</style>', [ 'style' => [] ] ); } );
		// Switch to previous theme.
		switch_theme( $old_theme_obj->stylesheet );
	}

	/**
	 * Adjusts menu options in the wp-admin.
	 */
	public function adjust_wp_admin_menu(): void {
		// Remove default comments page from wp-admin.
		remove_menu_page( 'edit-comments.php' );
		// Add separator before the custom post types.
		$this->add_admin_menu_separator( 24 );
		$this->add_admin_menu_separator( 29 );
	}

	/**
	 * Inserts Google fonts into the project.
	 */
	public function insert_google_fonts(): void {
		// phpcs:disable
		?>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
		<?php
		// phpcs:enable
	}

	/**
	 * Handles loading single posts templates.
	 */
	public static function get_single_post_content(): void {
		// Get post type.
		$__post_type = get_post_type();
		// Prepare arguments for template.
		switch ( $__post_type ) {
			case News::get_post_type_slug():
				$args = [
					'title' => get_the_title(),
					'tags'  => array_map( static fn ( $value ) => $value->name, wp_get_post_terms( get_the_ID(), 'news-tag' ) ),
				];
				break;
			case Course::get_post_type_slug():
				// Prepare array for arguments.
				$args = [];
				// Get course reviews.
				$args['reviews'] = array_map(
					static function ( $post_obj ) {
						// Get post meta.
						$post_meta = get_post_meta( $post_obj->ID, single: true );
						// Return required data.
						return [
							'reviewer-name'   => isset( $post_meta['reviewer-name'] ) ? $post_meta['reviewer-name'][0] : '',
							'reviewer-avatar' => isset( $post_meta['reviewer-avatar'] ) ? $post_meta['reviewer-avatar'][0] : '',
							'review-text'     => $post_obj->post_content,
						];
					},
					get_posts(
						[
							'number'     => 10,
							'post_type'  => Review::get_post_type_slug(),
							'meta_query' => [
								'relation' => 'AND',
								[
									'meta_key'   => 'review-related',
									'meta_value' => get_the_ID(),
									'compare'    => '=',
								]
							],
						]
					)
				);
				// Get prices.
				$args['prices'] = array_filter( get_fields(), static fn ( $key ) => in_array( $key, [ 'lesson-price', 'monthly-price', 'full-price' ], true ), ARRAY_FILTER_USE_KEY );

				break;
			case Teacher::get_post_type_slug():
				$args = [];
				// Get certificates.
				$args['certs'] = get_field( 'certificates' ) ?? [];

				break;
		}
		// Load template for post type.
		get_template_part( 'template-parts/posts/' . $__post_type, args: $args ?? [] );
	}
}
