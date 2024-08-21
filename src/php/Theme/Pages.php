<?php
/**
 * Page Controller class template file.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\Theme;

use Svitmov\PostTypes\Course;

/**
 * Page controller class
 */
class Pages {

	// Initialization Methods.

	/**
	 * Initializing Method for the class
	*/
	public function init(): void {
		$this->hooks();
	}

	/**
	 * Hook initialization method for the class
	 */
	protected function hooks(): void {
		// Add custom theme page templates.
		add_filter( 'theme_page_templates', [ $this, 'add_theme_templates' ] );
		// Create pages on theme switch.
		add_action( 'after_switch_theme', [ $this, 'add_theme_pages' ] );
	}


	// Private Methods.

	/**
	 * Returns a list of theme's custom pages.
	 *
	 * @return array An array of pages [ $template-name => $template-title ].
	 */
	private function get_custom_page_list(): array {
		return [
			'front-page' => __( 'Головна Сторінка', 'svitmov' ),
			'test-page'  => __( 'Сторінка "Онлайн Тести"', 'svitmov' ),
			'about-us'   => __( 'Сторінка "Про Нас"', 'svitmov' ),
			'contact-us' => __( 'Сторінка "Контакти"', 'svitmov' ),
		];
	}


	// Public Methods.

	/**
	 * Adds custom page templates.
	 *
	 * @param array $page_templates List of existing page templates.
	 *
	 * @return array Modified list of page templates.
	 */
	public function add_theme_templates( array $page_templates ): array {
		return array_merge( $this->get_custom_page_list(), $page_templates );
	}

	/**
	 * Searches and creates missing pages for theme.
	 */
	public function add_theme_pages(): void {
		foreach ( $this->get_custom_page_list() as $template_name => $page_name ) {
			// Attempt to get page with template.
			$pages = get_posts(
				[
					'meta_key'   => '_wp_page_template',
					'meta_value' => $template_name,
				]
			);
			// Continue if page with template already exists.
			if ( count( $pages ) > 0 ) {
				continue;
			}
			// If page doesn't exist create one for this specific template.
			wp_insert_post(
				[
					'post_title'  => $page_name,
					'post_name'   => $template_name,
					'post_type'   => 'page',
					'post_status' => 'draft',
					'meta_input'  => [
						'_wp_page_template' => $template_name,
					],
				]
			);
		}
	}

	/**
	 * Loads page template with arguments.
	 */
	public static function get_page_template(): void {
		// Get name of the template.
		$template_name = get_page_template_slug();
		// Prepare array for arguments.
		$args = [];

		// Find arguments for each of the templates.
		switch ( $template_name ) {
			case 'test-page':
				// Get ACF fields for this page and filter out disabled fields.
				$args['test_list'] = array_filter( get_fields(), static fn ( $value ) => $value['enable'] );

				break;
			case 'contact-us':
				// Get ACF and options fields.
				$args = array_merge(
					get_options( [ 'svitmov-phone', 'svitmov-emails', 'svitmov-location', 'svitmov-embedded' ] ),
					get_field( 'schedule' ) ?? [],
				);
				// Push title into array of arguments.
				$args['title'] = get_the_title();

				break;
			case 'front-page':
				// Get fields for front page.
				$fields = get_fields();
				// Get front slider items.
				$args['slider'] = $fields['front-slider'] ?? [];
				// Get gallery items.
				$args['gallery'] = $fields['gallery'] ?? [];
				// Get quick links.
				$args['quick-links'] = [
					'course-link' => get_post_type_archive_link( Course::get_post_type_slug() ),
					'links'       => $fields['quick-links'] ?? [],
				];
				// Prepare parameters for 'booking' form.
				$args['form'] = [
					'subtype'   => 'selectable',
					'languages' => get_terms(
						[
							'taxonomy' => 'language',
							'fields'   => 'id=>name',
						]
					)
				];

				break;
			case 'about-us':
				// Get fields.
				$args = get_fields();
				// Modify arguments for each of the areas.
				array_walk(
					$args,
					static function ( &$value, $key ) {
						// Create flag to alternate text/graphics order.
						$index = 0;
						// Adjust arguments for each of the sections.
						switch ( $key ) {
							case 'area-1':
								$value = array_map(
									static function ( $section ) use ( &$index ) {
										// Add shared arguments.
										$args = [
											'title'    => $section['name'],
											'text'     => $section['text'],
											'graphics' => $section['image']['sizes']['large'],
										];
										// Add flag to the first item to render page title instead of section title.
										$args['page_title'] = 0 === $index;
										// Alternate order of the text and picture for uneven-numbered sections.
										if ( $index % 2 === 1 ) {
											$args['classes'] = [ 'reverse' ];
										}
										// Increase index of the element.
										++$index;
										// Return array of arguments.
										return $args;
									},
									$value
								);
								break;
							case 'area-2':
								$value = array_map(
									static function ( $section ) use ( &$index ) {
										// Add shared arguments.
										$args = [
											'name'       => $section['name'],
											'name_tag'   => 'h3',
											'text'       => $section['text'],
											'graphics'   => $section['image']['sizes']['large'],
											'wrap_class' => [ 'alt' ]
										];
										// Add title for the first element.
										if ( 0 === $index ) {
											$args['title'] = __( 'Гарантії', 'svitmov' );
										}
										// Alternate order of the text and picture for uneven-numbered sections.
										if ( $index % 2 === 1 ) {
											$args['classes'] = [ 'reverse' ];
										}
										// Increase index of the element.
										++$index;
										// Return array of arguments.
										return $args;
									},
									$value
								);
								break;
							case 'area-3':
								$value = array_map(
									static function ( $section ) use ( &$index ) {
										// Add shared arguments.
										$args = [
											'name'     => $section['name'],
											'text'     => $section['text'],
											'graphics' => $section['image']['sizes']['large'],
										];
										// Alternate order of the text and picture for uneven-numbered sections.
										if ( $index % 2 === 1 ) {
											$args['classes'] = [ 'reverse' ];
										}
										// Increase index of the element.
										++$index;
										// Return array of arguments.
										return $args;
									},
									$value
								);
								break;
						}
					}
				);
		}

		// Load template from templates folder.
		get_template_part( 'template-parts/pages/' . $template_name, args: $args );
	}
}
