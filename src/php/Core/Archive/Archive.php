<?php
/**
 * Archive class file
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\Core\Archive;

use Svitmov\Includes\Helpers;
use Svitmov\PostTypes\Course;
use Svitmov\PostTypes\News;
use Svitmov\PostTypes\Teacher;

class Archive {

	// Private Fields.

	/**
	 * Endpoint namespace.
	 *
	 * @var string $api_namespace
	 */
	private string $api_namespace;


	// Initialization Methods.

	/**
	 * Initializes Archive class.
	 */
	public function init(): void {
		// Set namespace.
		$this->api_namespace = 'svitmov/archive';

		$this->hooks();
	}

	/**
	 * Initializes hooks for Archive class.
	 */
	protected function hooks(): void {
		// Register endpoints.
		add_action( 'rest_api_init', [ $this, 'register_rest_routes' ] );
		// Enqueue archive settings.
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_archive_settings' ], 20 );
	}


	// Private Methods.

	/**
	 * Loads course cards based on global variables.
	 *
	 * @param array $classes Classes added to the card.
	 */
	private static function load_course_card( array $classes = [ 'single-el', 'unloaded' ] ): void {
		// Get post id.
		$post_id = get_the_ID();
		// Get post meta values.
		$post_meta = get_post_meta( $post_id, single: true );
		// Prepare values for template.
		$args = [
			'course_id'       => $post_id,
			'classes'         => $classes,
			'title'           => get_the_title(),
			'course_type'     => $post_meta['is_online'][0],
			'lang_levels'     => wp_get_post_terms( $post_id, 'lang-level' ),
			'num_lessons'     => isset( $post_meta['num-lessons'] ) ? $post_meta['num-lessons'][0] : 0,
			'num_lessons_per' => isset( $post_meta['num-lessons-per'] ) ? $post_meta['num-lessons-per'][0] : 0,
			'month_duration'  => isset( $post_meta['num-month'] ) ? $post_meta['num-month'][0] : 0,
			'price'           => [
				'lesson' => isset( $post_meta['lesson-price'] ) ? $post_meta['lesson-price'][0] : 0,
				'month'  => isset( $post_meta['monthly-price'] ) ? $post_meta['monthly-price'][0] : 0,
				'full'   => isset( $post_meta['full-price'] ) ? $post_meta['full-price'][0] : 0,
			],
			'is_active'       => isset( $post_meta['is-active'] ) ? $post_meta['is-active'][0] : 0,
			'permalink'       => get_the_permalink( $post_id ),
		];
		// Load the template with the post.
		get_template_part( 'template-parts/components/card', 'course', $args );
	}

	/**
	 * Loads news cards based on global variables.
	 *
	 * @param array $classes Classes added to the card.
	 */
	private static function load_news_card( array $classes = [ 'archive-el', 'single-el', 'unloaded' ] ): void {
		// Get post id.
		$post_id = get_the_ID();
		// Prepare values for template.
		$args = [
			'classes'   => $classes,
			'title'     => get_the_title(),
			'excerpt'   => get_the_excerpt( $post_id ),
			'thumbnail' => get_the_post_thumbnail_url( $post_id, 'post-thumbnail' ),
			'tags'      => wp_get_post_terms( $post_id, 'news-tag', [ 'fields' => 'names' ] ),
			'url'       => get_the_permalink( $post_id ),
		];
		// Load the template with the post.
		get_template_part( 'template-parts/components/card', 'news', $args );
	}


	// Public Methods.

	/**
	 * Loads archive posts based on REST request parameters.
	 *
	 * @param \WP_REST_Request $request REST request details.
	 *
	 * @return array Request response data.
	 */
	public function load_archive_posts( \WP_REST_Request $request ): array {
		// Get request parameters.
		$params = $request->get_params();

		// Set up query arguments.
		$query_args = [
			'post_type'      => sanitize_text_field( $params['post_type'] ),
			'posts_per_page' => (int) sanitize_text_field( $params['number'] ),
			'paged'          => (int) sanitize_text_field( $params['page'] ),
		];

		// Add offset parameter to query data.
		if ( isset( $params['exclude'] ) ) {
			$query_args['post__not_in'] = rest_sanitize_array( $params['exclude'] );
		}

		// Add alphabetical search for the 'course' posts.
		if ( $query_args['post_type'] === Course::get_post_type_slug() ) {
			$query_args['orderby'] = 'title';
			$query_args['order']   = 'ASC';
		}

		// Add search parameters to query data.
		if ( isset( $params['search'] ) ) {
			$query_args['s'] = sanitize_text_field( $params['search'] );
		}

		// Attempt search to see whether search yield any results.
		if ( empty( get_posts( array_merge( [ 'fields' => 'ids' ], $query_args ) ) ) ) {
			unset( $query_args['s'] );
		}

		// Get filters data.
		$filters = rest_sanitize_array( $params['filters'] ?? [] );

		// Get selected filters data.
		$selected = rest_sanitize_object( $params['selected'] ?? [] );

		// Add values of the selected filters to the query arguments.
		if ( ! empty( $selected ) ) {
			foreach ( $selected as $name => $value ) {
				// Skip if the value equals to 'all'.
				if ( 'all' === $value ) {
					continue;
				}

				switch ( $name ) {
					case 'is_online':
					case 'is_individual':
						// Initialize meta query if it wasn't already.
						if ( empty( $query_args['meta_query'] ) ) {
							$query_args['meta_query'] = [
								'relation' => 'AND',
							];
						}
						// Add value to the meta query.
						$query_args['meta_query'][] = [
							'key'   => $name,
							'value' => $value,
						];
						break;
					case 'news-category':
					case 'lang-level':
					case 'lang-test':
					case 'language':
						// Initialize tax query if it wasn't already.
						if ( empty( $query_args['tax_query'] ) ) {
							$query_args['tax_query'] = [
								'relation' => 'AND',
							];
						}
						// Add value to the tax query.
						$query_args['tax_query'][] = [
							'taxonomy' => $name,
							'field'    => 'term_id',
							'terms'    => $value,

						];
						break;
					case 'price':
						// Initialize meta query if it wasn't already.
						if ( empty( $query_args['meta_query'] ) ) {
							$query_args['meta_query'] = [
								'relation' => 'AND',
							];
						}
						// Add values to the meta query.
						$query_args['meta_query'][] = [
							'relation' => 'OR',
							[
								'key'     => 'full-price',
								'value'   => [ $value['min'], $value['max'] ],
								'compare' => 'BETWEEN',
								'type'    => 'NUMERIC',
							],
						];

						break;
				}
			}
		}

		// Create variable for total post count.
		$count = 0;

		// Get content for the page.
		$html = Helpers::echo_to_string(
			function () use ( $query_args, &$count ) {
				// Create query for the posts.
				$query = new \WP_Query( $query_args );

				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						// Initialize the post.
						$query->the_post();

						// Load proper item card.
						switch ( get_post_type() ) {
							case 'course':
								self::load_course_card();
								break;
							case 'news':
								self::load_news_card();
								break;
						}
					}
				}

				// Save total number of posts found.
				$count = $query->found_posts;

				// Reset queried data.
				wp_reset_postdata();
			}
		);

		// Set up return value.
		$result = [
			'status'  => 200,
			'total'   => $count,
			'content' => $html,
		];

		// Create filter html.
		$result['filters'] = Helpers::echo_to_string(
			static function () use ( $filters, $selected ) {
				foreach ( $filters as $filter_name ) {
					switch ( $filter_name ) {
						case 'is_online':
							$args = [
								'ref'     => $filter_name,
								'name'    => __( 'Форма Навчання', 'svitmov' ),
								'options' => [
									'in-person' => __( 'Офлайн', 'svitmov' ),
									'online'    => __( 'Онлайн', 'svitmov' ),
									'mixed'     => __( 'Змішана', 'svitmov' ),
								],
								'selected' => $selected[ $filter_name ] ?? 'all',
							];
							// Load template with filters.
							get_template_part( 'template-parts/components/filter', 'radio', $args );

							break;
						case 'is_individual':
							$args = [
								'ref'     => $filter_name,
								'name'    => __( 'Тип Занять', 'svitmov' ),
								'options' => [
									'individual' => __( 'Індивідуальні', 'svitmov' ),
									'group'      => __( 'Групові', 'svitmov' ),
								],
								'selected' => $selected[ $filter_name ] ?? 'all',
							];
							// Load template with filters.
							get_template_part( 'template-parts/components/filter', 'radio', $args );

							break;
						case 'lang-level':
						case 'lang-test':
						case 'language':
							// Prepare arguments for the template.
							$args = [
								'ref'     => $filter_name,
								'name'    => get_taxonomy( $filter_name )->label,
								'options' => get_terms(
									[
										'taxonomy' => $filter_name,
										'fields'   => 'id=>name',
									]
								),
								'selected' => $selected[ $filter_name ] ?? 'all',
							];
							// Load template with filters.
							get_template_part( 'template-parts/components/filter', 'radio', $args );

							break;
						case 'price':
							// Get possible values.
							$range_values = Helpers::get_meta_bulk( 'full-price' );
							// Sort values.
							sort( $range_values );
							//
							$args = [
								'ref'  => $filter_name,
								'name' => __( 'Ціна', 'svitmov' ),
								'min'  => $range_values[0],
								'max'  => array_pop( $range_values ),
								'note' => __( '*Ціна за модуль', 'svitmov' ),
							];
							// Check if the prices are selected.
							if ( isset( $selected['price'] ) ) {
								// Check whether the minimal value exceeds absolute minimal value.
								if ( $selected['price']['min'] > $args['min'] ) {
									// Set selected minimal value.
									$args['min-selected'] = $selected['price']['min'];
									// Set percentage minimal value.
									$args['min-percent'] = ( $selected['price']['min'] - $args['min'] ) / ( $args['max'] - $args['min'] ) * 100;
								}
								// Check whether the maximum value exceeds absolute maximum value.
								if ( $selected['price']['max'] < $args['max'] ) {
									// Set selected maximum value.
									$args['max-selected'] = $selected['price']['max'];
									// Set percentage minimal value.
									$args['max-percent'] = ( 1 - ( $selected['price']['max'] - $args['min'] ) / ( $args['max'] - $args['min'] ) ) * 100;
								}
							}
							// Load template with range filter.
							get_template_part( 'template-parts/components/filter', 'range', $args );

							break;
					}
				}
			}
		);

		// Create pagination html.
		if ( rest_sanitize_boolean( $params['pagination'] ?? false ) ) {
			$result['pagination'] = Helpers::echo_to_string(
				static function () use ( $query_args, $count ) {
					// Prepare template arguments.
					$args = [
						'current' => $query_args['paged'],
						'pages'   => (int) ceil( $count / $query_args['posts_per_page'] ),
					];
					// Load template with pagination.
					get_template_part( 'template-parts/components/pagination', args: $args );
				}
			);
		}

		// Add proper name of the post type for 'total' text.
		switch ( $query_args['post_type'] ) {
			case 'course':
				if ( ( $count % 100 < 10 || $count % 100 > 20 ) ) {
					if ( $count % 10 === 1 ) {
						$result['total_suffix'] = __( 'Курс', 'svitmov' );
						break;
					}

					if ( $count % 10 > 1 && $count % 10 < 5 ) {
						$result['total_suffix'] = __( 'Курси', 'svitmov' );
						break;
					}
				}

				$result['total_suffix'] = __( 'Курсів', 'svitmov' );
				break;
		}

		// Return the result.
		return $result;
	}

	/**
	 * Registers endpoint routes.
	 */
	public function register_rest_routes(): void {
		register_rest_route(
			$this->api_namespace,
			'get-posts',
			[
				[
					'methods'             => [ 'POST' ],
					'callback'            => [ $this, 'load_archive_posts' ],
					'permission_callback' => static fn ( \WP_REST_Request $request ) => wp_verify_nonce( $request->get_header( 'x_wp_nonce' ), 'wp_rest' ),
					'args'                => [
						// Base parameters.
						'post_type' => [
							'type'     => 'string',
							'required' => true,
						],
						'number'    => [
							'type'     => 'int',
							'required' => true,
						],
						'page'      => [
							'type'     => 'int',
							'required' => true,
						],
						'exclude'   => [
							'type'     => 'array',
							'required' => false,
						],
						// Filter parameters.
						'filters'   => [
							'type'     => 'array',
							'required' => false,
						],
						'selected'  => [
							'type'     => 'object',
							'required' => false,
						],
						'search'    => [
							'type'     => 'string',
							'required' => false,
						],
						// Page parameters.
						'pagination' => [
							'type'     => 'bool',
							'required' => false,
						]
					],
				],
			]
		);
	}

	/**
	 * Enqueues archive settings as localization file to pass them into JS file.
	 */
	public function enqueue_archive_settings(): void {
		if ( ! is_archive() && ! is_tax() && ! is_search() ) {
			return;
		}

		// Get queried object to add additional archive parameters.
		$queried_obj = get_queried_object();
		// Prepare localization script.
		$localization_script = [
			'type' => get_post_type(),
		];

		// Add term related parameters.
		if ( $queried_obj instanceof \WP_Term ) {
			// Add parameters.
			$localization_script['selected'] = [
				$queried_obj->taxonomy => $queried_obj->term_id,
			];

			// Hard set post type for particular taxonomies.
			switch ( $queried_obj->taxonomy ) {
				case 'language':
				case 'lang-level':
					$localization_script['type'] = Course::get_post_type_slug();
					break;
			}
		}

		// Add search related parameters.
		if ( is_search() ) {
			// Set parameters for search archive.
			$localization_script = [
				'type'   => Course::get_post_type_slug(),
				'search' => get_search_query(),
			];
		}

		// Set paged display for 'news' post type and exclude last post.
		if ( $localization_script['type'] === News::get_post_type_slug() ) {
			// Display archive in paged format.
			$localization_script['paged'] = true;
			// Exclude separately displayed latest post.
			$localization_script['exclude'] = [ get_the_ID() ];
		}

		wp_localize_script(
			'svitmov_script',
			'archiveSettings',
			$localization_script
		);
	}

	/**
	 * Handles loading of templates for the archive-related pages (archives, taxonomy pages, searches etc.)
	 */
	public static function load_archive_template(): void {
		// Get page queried object.
		$queried_obj = get_queried_object();
		// Default to 'course' post type.
		$post_type = Course::get_post_type_slug();

		// Load default template for post archive.
		if ( $queried_obj instanceof \WP_Post_Type ) {
			$post_type = $queried_obj->name;
		}

		// Handle loading post-type-like archive page templates for term archives.
		if ( $queried_obj instanceof \WP_Term ) {
			// Set proper post type for queried taxonomy.
			switch ( $queried_obj->taxonomy ) {
				case 'language':
				case 'lang-level':
					$post_type = 'course';
					break;
				case 'news-category':
					$post_type = 'news';
					break;
			}
		}

		switch ( $post_type ) {
			case News::get_post_type_slug():
			case 'post':
				// Prepare arguments for the template.
				$args = [
					'name' => __( 'Наш Блог', 'svitmov' ),
				];
				// Get the most recent news article.
				$args['load_latest_post'] = static function () {
					self::load_news_card( [ 'animated' ] );
				};
				// Get 3 latest featured posts.
				$args['load_featured_posts'] = static function () use ( $post_type ) {
					$query = new \WP_Query(
						[
							'post_type'      => $post_type,
							'posts_per_page' => 3,
							'meta_query'     => [
								[
									'key'   => 'featured',
									'value' => '1',
								]
							],
						]
					);

					while ( $query->have_posts() ) {
						// Load post object.
						$query->the_post();
						// Load cards for the featured items.
						self::load_news_card( [ 'animated', 'dark' ] );
					}

					wp_reset_postdata();
				};

				get_template_part( 'template-parts/archive/' . News::get_post_type_slug(), args: $args );
				break;
			case Teacher::get_post_type_slug():
				// Prepare arguments for the template.
				$args = [
					/* translators: %s here stands for post type name (as in 'Всі Курси') */
					'name' => __( sprintf( 'Всі %s', get_post_type_object( $post_type )->label ), 'svitmov' ),
				];

				get_template_part( 'template-parts/archive/' . $post_type, args: $args );
				break;
			default:
				// Prepare an array to populate with arguments.
				$args = [];
				// Check if the search has any values.
				if ( is_search() ) {
					// Add custom title for archive.
					$args = [
						/* translators: %s - is search query */
						'title' => sprintf( __( 'Результат за пошуком: <b>"%s"</b>', 'svitmov' ), get_search_query()),
					];
					// Check if any posts matches the search.
					$posts = get_posts(
						[
							'post_type' => $post_type,
							's'         => get_search_query(),
						]
					);
					// If no posts were found
					if ( count( $posts ) < 1 ) {
						$args['fail'] = true;
					}
				}

				get_template_part( 'template-parts/archive/' . $post_type, args: $args );
				break;
		}
	}
}
