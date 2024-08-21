<?php
/**
 * Teacher post type class file.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\PostTypes;

/**
 * Class for the 'teacher' post type.
 */
class Teacher extends BasePostType {


	// Public Properties.

	/**
	 * Returns slug name of the post type
	 *
	 * @return string Slug of post type.
	 */
	public static function get_post_type_slug(): string {
		return 'teacher';
	}


	// Initializing Methods.

	/**
	 * Initializing method for the class.
	 */
	public function init(): void {
		// Set slug for the post type.
		$this->set_slug( self::get_post_type_slug() );
		// Set names for the post type.
		$this->set_singular_name( __( 'Викладач', 'svitmov' ) );
		$this->set_plural_name( __( 'Викладачі', 'svitmov' ) );
		// Teachers cannot be hierarchical.
		$this->is_hierarchical = false;
		// Set menu properties.
		$this->menu_position = 31;
		$this->menu_icon     = 'dashicons-businessperson';
		// Set supported features.
		$this->supports = [ 'title', 'editor', 'excerpt', 'revisions', 'thumbnail', 'custom-fields' ];

		// Run default initialization process for the post type.
		parent::init();
	}


	// Protected Methods.

	/**
	 * Returns an array of post type labels.
	 *
	 * @return array An array of labels.
	 */
	protected function get_post_type_labels(): array {
		return [
			'name'                     => $this->get_plural_name(),
			'singular_name'            => $this->get_singular_name(),
			'add_new'                  => __( 'Додати Викладача', 'svitmov' ),
			'add_new_item'             => __( 'Додати Нового Викладача', 'svitmov' ),
			'edit_item'                => __( 'Редагувати Викладача', 'svitmov' ),
			'new_item'                 => __( 'Новий Викладач', 'svitmov' ),
			'view_item'                => __( 'Переглянути Викладача', 'svitmov' ),
			'view_items'               => __( 'Переглянути Викладачів', 'svitmov' ),
			'search_items'             => __( 'Шукати Викладача', 'svitmov' ),
			'not_found'                => __( 'Не Знайдено Викладачів', 'svitmov' ),
			'not_found_in_trash'       => __( 'Не Знайдено Викладачів у Смітнику', 'svitmov' ),
			'all_items'                => __( 'Усі Викладачі', 'svitmov' ),
			'archives'                 => __( 'Архів Викладачів', 'svitmov' ),
			'attributes'               => __( 'Атрибути Викладача', 'svitmov' ),
			'insert_into_item'         => __( 'Додати до Викладача', 'svitmov' ),
			'insert_into_this_item'    => __( 'Додати до Цього Викладача', 'svitmov' ),
			'featured_image'           => __( 'Фото Викладача', 'svitmov' ),
			'set_featured_image'       => __( 'Встановити Фото Викладача', 'svitmov' ),
			'remove_featured_image'    => __( 'Прибрати Фото Викладача', 'svitmov' ),
			'menu_name'                => __( 'Викладачі', 'svitmov' ),
			'filter_items_list'        => __( 'Фільтрувати Викладачів', 'svitmov' ),
			'filter_by_date'           => __( 'Фільтрувати Викладачів за Датою', 'svitmov' ),
			'items_list_navigation'    => __( 'Навігація по Списку Викладачів', 'svitmov' ),
			'items_list'               => __( 'Список Викладачів', 'svitmov' ),
			'item_published'           => __( 'Викладача Опубліковано', 'svitmov' ),
			'item_published_privately' => __( 'Викладача Опубліковано Приватним Записом', 'svitmov' ),
			'item_reverted_to_draft'   => __( 'Запис Викладача Повернено до Чернеток', 'svitmov' ),
			'item_trashed'             => __( 'Запис Викладача Переміщено до Смітника', 'svitmov' ),
			'item_updated'             => __( 'Запис Викладача Оновлено', 'svitmov' ),
			'item_link'                => __( 'Посилання на Викладача', 'svitmov' ),
			'item_link_description'    => __( 'Опис Посилання на Викладача', 'svitmov' ),
		];
	}


	// Public Methods.

	/**
	 * Get archive data for the page.
	 *
	 * @return array Array of data required to display the content of the page
	 */
	public static function get_teacher_list(): array {
		// Fetch all 'teacher' posts.
		$posts = get_posts(
			[
				'post_type'   => 'teacher',
				'numberposts' => -1,
				'order'       => 'DESC',
				'orderby'     => 'meta_value',
				'meta_key'    => 'priority',
				'meta_type'   => 'NUMERIC',
			]
		);
		// Map posts to include required data.
		array_walk(
			$posts,
			static function ( &$value ) {
				$value = [
					'name'  => $value->post_title,
					'bio'   => $value->post_excerpt,
					'photo' => get_the_post_thumbnail_url( $value->ID, 'post-thumbnail' ),
					'lang'  => wp_get_post_terms( $value->ID, 'language', [ 'fields' => 'names' ] ),
					'url'   => get_the_permalink( $value ),
				];
			}
		);

		return $posts;
	}
}
