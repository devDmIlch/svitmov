<?php
/**
 * Author taxonomy class file
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\Taxonomies;

/**
 * Class for the 'author' post type.
 */
class Author extends BaseTaxonomy {

	// Initializing Methods.

	/**
	 * Initialization method for the class
	 */
	public function init(): void {
		// Set taxonomy's slug.
		$this->set_slug( 'author' );
		// Set taxonomy's names.
		$this->set_singular_name( __( 'Автор', 'svitmov' ) );
		$this->set_plural_name( __( 'Автори', 'svitmov' ) );
		// Set taxonomy's associated post types.
		$this->set_post_types( [ 'text-book' ] );

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
			'search_items'          => __( 'Шукати Авторів', 'svitmov' ),
			'parent_item_colon'     => __( 'Колонка Батьківського Автора', 'svitmov' ),
			'parent_item'           => __( 'Батьківський Автор', 'svitmov' ),
			'edit_item'             => __( 'Редагувати Автора', 'svitmov' ),
			'view_item'             => __( 'Переглянути Архів Автора', 'svitmov' ),
			'update_item'           => __( 'Оновити Автора', 'svitmov' ),
			'add_new_item'          => __( 'Додати Нового Автора', 'svitmov' ),
			'new_item_name'         => __( 'Нова Назва Автора', 'svitmov' ),
			'not_found'             => __( 'Не Знайдено Авторів', 'svitmov' ),
			'no_terms'              => __( 'Немає Авторів', 'svitmov' ),
			'filter_by_item'        => __( 'Фільтрувати по Авторам', 'svitmov' ),
			'items_list_navigation' => __( 'Навігація по Списку Авторів', 'svitmov' ),
			'items_list'            => __( 'Список Авторів', 'svitmov' ),
			'most_used'             => __( 'Найпоширеніші', 'svitmov' ),
			'back_to_items'         => __( 'Назад до Авторів', 'svitmov' ),
			'item_link'             => __( 'Посилання на Архів Авторів', 'svitmov' ),
			'item_link_description' => __( 'Опис Посилання на Архів Авторів', 'svitmov' ),
		];
	}
}
