<?php
/**
 * News post type class file
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\PostTypes;

/**
 * Class for the 'news' post type.
 */
class News extends BasePostType {

	// Public Properties.

	/**
	 * Returns slug name of the post type
	 *
	 * @return string Slug of post type.
	 */
	public static function get_post_type_slug(): string {
		return 'news';
	}


	// Initializing Methods.

	/**
	 * Initializing method for the class.
	 */
	public function init(): void {
		// Set slug for the post type.
		$this->set_slug( self::get_post_type_slug() );
		// Set names for the post type.
		$this->set_singular_name( __( 'Новина', 'svitmov' ) );
		$this->set_plural_name( __( 'Новини', 'svitmov' ) );
		// News cannot be hierarchical.
		$this->is_hierarchical = false;
		// Set menu properties.
		$this->menu_position = 32;
		$this->menu_icon     = 'dashicons-pressthis';
		// Add tags to the list of supported taxonomies.
		$this->taxonomies = [ 'news-tag', 'news-category' ];
		$this->supports   = [ 'title', 'editor', 'excerpt', 'revisions', 'thumbnail', 'custom-fields' ];
		// Set rewrite rules.
		$this->rewrite = [
			'slug' => 'blog',
		];
		// Enable block editor.
		$this->show_in_rest = true;

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
			'add_new'                  => __( 'Додати Новину', 'svitmov' ),
			'add_new_item'             => __( 'Додати Нову Новину', 'svitmov' ),
			'edit_item'                => __( 'Редагувати Новину', 'svitmov' ),
			'new_item'                 => __( 'Нова Новина', 'svitmov' ),
			'view_item'                => __( 'Переглянути Новину', 'svitmov' ),
			'view_items'               => __( 'Переглянути Новини', 'svitmov' ),
			'search_items'             => __( 'Шукати Новини', 'svitmov' ),
			'not_found'                => __( 'Не Знайдено Новин', 'svitmov' ),
			'not_found_in_trash'       => __( 'Не Знайдено Новин в Смітнику', 'svitmov' ),
			'all_items'                => __( 'Усі Новини', 'svitmov' ),
			'archives'                 => __( 'Архів Новин', 'svitmov' ),
			'attributes'               => __( 'Атрибути Новини', 'svitmov' ),
			'insert_into_item'         => __( 'Додати до Новини', 'svitmov' ),
			'insert_into_this_item'    => __( 'Додати до Цієї Новини', 'svitmov' ),
			'featured_image'           => __( 'Картинка до Новини', 'svitmov' ),
			'set_featured_image'       => __( 'Встановити Картинку до Новини', 'svitmov' ),
			'remove_featured_image'    => __( 'Прибрати Картинку до Новини', 'svitmov' ),
			'menu_name'                => __( 'Новини', 'svitmov' ),
			'filter_items_list'        => __( 'Фільтрувати Новини', 'svitmov' ),
			'filter_by_date'           => __( 'Фільтрувати Новини за Датою', 'svitmov' ),
			'items_list_navigation'    => __( 'Навігація по Списку Новин', 'svitmov' ),
			'items_list'               => __( 'Список Новин', 'svitmov' ),
			'item_published'           => __( 'Новину Опубліковано', 'svitmov' ),
			'item_published_privately' => __( 'Новину Опубліковано Приватним Записом', 'svitmov' ),
			'item_reverted_to_draft'   => __( 'Новину Повернено до Чернеток', 'svitmov' ),
			'item_trashed'             => __( 'Новину Переміщено до Смітника', 'svitmov' ),
			'item_updated'             => __( 'Новину Оновлено', 'svitmov' ),
			'item_link'                => __( 'Посилання на Новину', 'svitmov' ),
			'item_link_description'    => __( 'Опис Посилання на Новину', 'svitmov' ),
		];
	}


	// Public Methods.

	/**
	 * Get archive data for the page.
	 *
	 * @return array Array of data required to display the content of the page
	 */
	public static function get_news_list(): array {
		// Fetch all 'teacher' posts.
		$posts = get_posts(
			[
				'post_type' => 'news',
				'number'    => 6,
			]
		);
		// Map posts to include required data.
		array_walk(
			$posts,
			static function ( &$value ) {
				$value = [
					'title'     => $value->post_title,
					'excerpt'   => get_the_excerpt( $value->ID ),
					'thumbnail' => get_the_post_thumbnail_url( $value->ID, 'post-thumbnail' ),
					'tags'      => wp_get_post_terms( $value->ID, 'post_tag', [ 'fields' => 'names' ] ),
					'url'       => get_the_permalink( $value ),
				];
			}
		);

		return $posts;
	}
}
