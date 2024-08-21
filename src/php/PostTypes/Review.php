<?php
/**
 * Review post type class file
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\PostTypes;

use Svitmov\Includes\Helpers;

/**
 * Class for the 'review' post type.
 */
class Review extends BasePostType {

	// Private Fields.

	/**
	 * Meta key for a post related to the review.
	 *
	 * @var string $related_meta_key
	 */
	private static string $related_meta_key = 'review-related';

	/**
	 * REST api endpoint namespace.
	 *
	 * @var string $api_namespace
	 */
	private string $api_namespace;


	// Protected Properties.

	/**
	 * Returns key for a post related to the review.
	 *
	 * @return string Meta key.
	 */
	protected static function get_related_meta_key(): string {
		return self::$related_meta_key;
	}


	// Public Properties.

	/**
	 * Returns slug name of the post type
	 *
	 * @return string Slug of post type.
	 */
	public static function get_post_type_slug(): string {
		return 'review';
	}


	// Initializing Methods.

	/**
	 * Initializing method for the class.
	 */
	public function init(): void {
		// Set slug for the post type.
		$this->set_slug( self::get_post_type_slug() );
		// Set names for the post type.
		$this->set_singular_name( __( 'Відгук', 'svitmov' ) );
		$this->set_plural_name( __( 'Відгуки', 'svitmov' ) );
		// Set menu properties.
		$this->menu_position = 33;
		$this->menu_icon     = 'dashicons-format-chat';
		// Disable block editor.
		$this->show_in_rest = false;

		// Set api namespace.
		$this->api_namespace = 'svitmov/review';

		// Run default initialization process for the post type.
		parent::init();
		// Initialize hooks for this post type.
		$this->hooks();
	}

	/**
	 * Hooks initializing method for the class.
	 */
	protected function hooks(): void {
//		// Cache reviews ids on their status updates, so that meta_query doesn't tank performance.
//		add_action( 'transition_post_status', [ $this, 'cache_reviews_on_status_update' ], 10, 3 );
//		// Cache reviews ids on their meta updates, so that meta_query doesn't tank performance.
//		add_action( 'updated_post_meta', [ $this, 'cache_reviews_on_meta_update' ], 10, 4 );

		// Register endpoints.
		add_action( 'rest_api_init', [ $this, 'register_rest_routes' ] );
	}


	// Public Methods.

	/**
	 * Attempts to submit user review.
	 *
	 * @param \WP_REST_Request $request Request arguments.
	 *
	 * @return array Request response.
	 */
	public function submit_user_review( \WP_REST_Request $request ): array {
		// Get parameters from request.
		$params = $request->get_params();
		// Check ID of the post from which review was submitted.
		$post_id = (int) sanitize_text_field( $params['post_id'] ?? 0 );
		// Check if submitted from course page.
		if ( get_post_type( $post_id ) !== Course::get_post_type_slug() ) {
			$post_id = null;
		}
		// Get reviewer name from parameters.
		$reviewer_name = sanitize_text_field( $params['name'] ?? '' );
		// Create post name.
		$post_name = sprintf( __( 'Відгук від %1$s за %2$s', 'svitmov' ), $reviewer_name, (new \DateTime('now'))->format('d.m.Y') );
		// Insert new post.
		$review_id = wp_insert_post(
			[
				'post_type'    => self::get_post_type_slug(),
				'post_title'   => $post_name,
				'post_status'  => 'pending',
				'post_content' => sanitize_text_field( $params['review'] ),
				'meta_input'   => [
					'reviewer-name'  => $reviewer_name,
					'reviewer-email' => sanitize_email( $params['email'] ),
					'review-related' => $post_id,
				],
			]
		);
		// Check if the post was successfully added.
		if ( 0 === $review_id || is_wp_error( $review_id ) ) {
			return [
				'status' => 500,
				'error'  => 'Post could not be created',
			];
		}

		return [
			'status' => 200,
		];
	}

	/**
	 * Registers rest routes related to review post-type.
	 */
	public function register_rest_routes(): void {
		register_rest_route(
			$this->api_namespace,
			'submit',
			[
				[
					'methods'             => [ 'POST' ],
					'callback'            => [ $this, 'submit_user_review' ],
					'permission_callback' => fn ( \WP_REST_Request $request ) => Helpers::is_callback_permitted( $request ),
					'args'                => [
						'name'    => [
							'type'     => 'string',
							'required' => true,
						],
						'email'   => [
							'type'     => 'string',
							'required' => true,
						],
						'review'  => [
							'type'     => 'string',
							'required' => true,
						],
						'post_id' => [
							'type'     => 'int',
							'required' => false,
						]
					]
				],
			]
		);
	}

	/**
	 * Caches reviews on their status update
	 *
	 * @param string   $new_status new status of the published post.
	 * @param string   $old_status old status of the updated post.
	 * @param \WP_Post $post_obj   object of the updated or created post.
	 */
	public function cache_reviews_on_status_update( string $new_status, string $old_status, \WP_Post $post_obj ): void {
		// Return if the post type doesn't match.
		if ( self::get_post_type_slug() !== $post_obj->post_type ) {
			return;
		}
		// If the new status of the post switched to or from 'publish' add it to the array of the posts related to the post.
		if ( 'publish' === $new_status || 'publish' === $old_status ) {
			// Get the post the review is related to.
			$related_post = get_post_meta( $post_obj->ID, self::$related_meta_key, true );
			// Get all reviews where related post id matches the currently selected id.
			$review_ids = self::get_post_related_reviews_from_meta( $related_post );
			// Update the transient cache with the new values.
			set_transient( self::get_post_review_transient_name( $related_post ), $review_ids );
		}
	}

	/**
	 * Caches reviews on their 'review-related' meta value update
	 *
	 * @param int    $meta_id    meta id.
	 * @param int    $post_id    post id which meta value is related to.
	 * @param string $meta_key   updated meta value key.
	 * @param mixed  $meta_value updated meta value.
	 */
	public function cache_reviews_on_meta_update( int $meta_id, int $post_id, string $meta_key, mixed $meta_value ): void {
		// Return if the post type doesn't match.
		if ( self::get_post_type_slug() !== get_post_type( $post_id ) ) {
			return;
		}
		// Return if the meta key is not the one we need.
		if ( $meta_key !== self::$related_meta_key ) {
			return;
		}
		// Get old meta value from the DB.
		$old_meta_value = get_post_meta( $post_id, self::$related_meta_key, true );
		// Check whether the meta values are indeed updated.
		if ( $old_meta_value === $meta_value ) {
			return;
		}
		// Get outdated related review for the post's previous relationship.
		$old_related_posts = self::get_post_related_reviews_from_meta( $old_meta_value );
		// Remove ID or updated review from the list of the post related reviews.
		$old_related_posts = array_splice( $old_related_posts, array_search( $post_id, $old_related_posts, true ), 1 );
		// Update cache for previous 'relationship'.
		set_transient( self::get_post_review_transient_name( $old_meta_value ), $old_related_posts );
		// Get outdated related review for the post's previous relationship, push review id into it and update the cache for the new related post.
		set_transient( self::get_post_review_transient_name( $meta_value ), ( self::get_post_related_reviews_from_meta( $meta_value )[] = $post_id ) );
	}

	/**
	 * Retrieves reviews for specific post type. Utilizes caching for improved speed.
	 *
	 * @param int $post_id ID of the post. 0 - default, all reviews.
	 *
	 * @returns \WP_Query|bool array of posts or false if supplied invalid ID.
	 */
	public static function get_post_reviews( int $post_id = 0 ): \WP_Query|bool {
		// Check whether the ID of the post is valid.
		if ( 0 > $post_id ) {
			return false;
		}
		// Get cached review ids for passed post id.
		$cached_review_ids = get_transient( self::get_post_review_transient_name( $post_id ) );
		// Create new query in case the cache is faulty.
//		if ( ! $cached_review_ids ) {
//			// If for some reason cached data is absent fetch it from DB.
//			$cached_review_ids = self::get_post_related_reviews_from_meta( $post_id );
//			// Update the cache so this doesn't happen again on the next page visit.
//			set_transient( self::get_post_review_transient_name( $post_id ), $cached_review_ids );
//		}
		// Return WP_Query based on the review IDs.
		return new \WP_Query(
			[
				'posts_per_page' => -1,
				'post_type'      => self::get_post_type_slug(),
				'posts__in'      => $cached_review_ids,
			]
		);
	}


	// Protected Methods.

	/**
	 * Returns a string with the cache name where the reviews for particular post are stored.
	 *
	 * @param int $post_id ID of the post or 0 for all reviews.
	 *
	 * @return string|false cache name or false if the post id is faulty.
	 */
	protected static function get_post_review_transient_name( int $post_id ): string|false {
		// Return false if the $post_id is negative (0 is allowed as it returns all reviews).
		if ( $post_id < 0 ) {
			return false;
		}
		// Return compiled cache name.
		return 'post_reviews_id_' . $post_id;
	}

	/**
	 * Returns an array of post type labels.
	 *
	 * @return array An array of labels.
	 */
	protected function get_post_type_labels(): array {
		return [
			'name'                     => $this->get_plural_name(),
			'singular_name'            => $this->get_singular_name(),
			'add_new'                  => __( 'Додати Відгук', 'svitmov' ),
			'add_new_item'             => __( 'Додати Новий Відгук', 'svitmov' ),
			'edit_item'                => __( 'Редагувати Відгук', 'svitmov' ),
			'new_item'                 => __( 'Новий Відгук', 'svitmov' ),
			'view_item'                => __( 'Переглянути Відгук', 'svitmov' ),
			'view_items'               => __( 'Переглянути Відгуки', 'svitmov' ),
			'search_items'             => __( 'Шукати Відгук', 'svitmov' ),
			'not_found'                => __( 'Не Знайдено Відгуки', 'svitmov' ),
			'not_found_in_trash'       => __( 'Не Знайдено Відгуки в Смітнику', 'svitmov' ),
			'all_items'                => __( 'Усі Відгуки', 'svitmov' ),
			'archives'                 => __( 'Архів Відгуків', 'svitmov' ),
			'attributes'               => __( 'Атрибути Відгуку', 'svitmov' ),
			'insert_into_item'         => __( 'Додати до Відгуку', 'svitmov' ),
			'insert_into_this_item'    => __( 'Додати до Цього Відгуку', 'svitmov' ),
			'featured_image'           => __( 'Фото Автора Відгуку', 'svitmov' ),
			'set_featured_image'       => __( 'Встановити Фото Автора Відгуку', 'svitmov' ),
			'remove_featured_image'    => __( 'Прибрати Фото Автора Відгуку', 'svitmov' ),
			'menu_name'                => __( 'Відгуки', 'svitmov' ),
			'filter_items_list'        => __( 'Фільтрувати Відгуки', 'svitmov' ),
			'filter_by_date'           => __( 'Фільтрувати Відгуки за Датою', 'svitmov' ),
			'items_list_navigation'    => __( 'Навігація по Списку Відгуків', 'svitmov' ),
			'items_list'               => __( 'Список Відгуків', 'svitmov' ),
			'item_published'           => __( 'Відгук Опубліковано', 'svitmov' ),
			'item_published_privately' => __( 'Відгук Опубліковано Приватним Записом', 'svitmov' ),
			'item_reverted_to_draft'   => __( 'Відгук Повернено до Чернеток', 'svitmov' ),
			'item_trashed'             => __( 'Відгук Переміщено до Смітника', 'svitmov' ),
			'item_updated'             => __( 'Відгук Оновлено', 'svitmov' ),
			'item_link'                => __( 'Посилання на Відгук', 'svitmov' ),
			'item_link_description'    => __( 'Опис Посилання на Відгук', 'svitmov' ),
		];
	}


	// Private Methods.

	/**
	 * Returns IDs of reviews related to the supplied post type.
	 *
	 * @param int $post_id ID of the post (default 0 - all posts).
	 *
	 * @return int[]|false array of review IDs or 'false' is the supplied post id is invalid.
	 */
	private static function get_post_related_reviews_from_meta( int $post_id = 0 ): array|false {
		// Check whether the ID of the post is valid.
		if ( 0 < $post_id ) {
			return false;
		}
		// Get all review IDs for a particular post.
		return get_posts(
			[
				'post_type'   => self::get_post_type_slug(),
				'post_status' => 'publish',
				'numberposts' => -1,
				'fields'      => 'ids',
				'meta_query'  => [
					[
						'meta_key'   => self::get_related_meta_key(),
						'meta_value' => $post_id,
						'compare'    => '=',
					],
				],
			]
		);
	}
}
