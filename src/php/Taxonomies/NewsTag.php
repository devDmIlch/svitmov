<?php
/**
 * Language Test taxonomy class file
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\Taxonomies;

/**
 * Class for the 'news-tag' post type.
 */
class NewsTag extends BaseTaxonomy {

	// Initializing Methods.

	/**
	 * Initialization method for the class
	 */
	public function init(): void {
		// Set taxonomy's slug.
		$this->set_slug( 'news-tag' );
		// Set taxonomy's names.
		$this->set_singular_name( __( 'Позначка', 'svitmov' ) );
		$this->set_plural_name( __( 'Позначки', 'svitmov' ) );
		// Set taxonomy's associated post types.
		$this->set_post_types( [ 'news' ] );
		// Set hierarchical as false for tags.
		$this->is_hierarchical = false;



		// Run default initialization process for the post type.
		parent::init();
	}


	// Protected Methods.

	/**
	 * Returns an array of taxonomy labels.
	 *
	 * @return array An array of labels.
	 */
	protected function get_taxonomy_labels(): array {
		return [
			'name'                  => $this->get_plural_name(),
			'menu_name'             => $this->get_plural_name(),
			'singular_name'         => $this->get_singular_name(),
			'popular_items'         => __( 'Популярні', 'svitmov' ),
			'search_items'          => __( 'Шукати Позначки', 'svitmov' ),
			'parent_item_colon'     => __( 'Колонка Батьківської Позначки', 'svitmov' ),
			'parent_item'           => __( 'Батьківська Позначка', 'svitmov' ),
			'edit_item'             => __( 'Редагувати Позначку', 'svitmov' ),
			'view_item'             => __( 'Переглянути Позначку', 'svitmov' ),
			'update_item'           => __( 'Оновити Позначку', 'svitmov' ),
			'add_new_item'          => __( 'Додати Нову Позначку', 'svitmov' ),
			'new_item_name'         => __( 'Нова Назва Позначки', 'svitmov' ),
			'not_found'             => __( 'Не Знайдено Позначок', 'svitmov' ),
			'no_terms'              => __( 'Немає Позначок', 'svitmov' ),
			'filter_by_item'        => __( 'Фільтрувати по Позначкам', 'svitmov' ),
			'items_list_navigation' => __( 'Навігація по Списку Позначок', 'svitmov' ),
			'items_list'            => __( 'Список Позначок', 'svitmov' ),
			'most_used'             => __( 'Найпоширеніші', 'svitmov' ),
			'back_to_items'         => __( 'Назад до Позначок', 'svitmov' ),
			'item_link'             => __( 'Посилання на Архів Позначок', 'svitmov' ),
			'item_link_description' => __( 'Опис Посилання на Архів Позначок', 'svitmov' ),
		];
	}
}
