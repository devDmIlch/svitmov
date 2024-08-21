<?php
/**
 * Language Test taxonomy class file
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\Taxonomies;

/**
 * Class for the 'lang-level' taxonomy.
 */
class LangTest extends BaseTaxonomy {

	// Initializing Methods.

	/**
	 * Initialization method for the class
	 */
	public function init(): void {
		// Set taxonomy's slug.
		$this->set_slug( 'lang-test' );
		// Set taxonomy's names.
		$this->set_singular_name( __( 'Іспит', 'svitmov' ) );
		$this->set_plural_name( __( 'Іспити', 'svitmov' ) );
		// Set taxonomy's associated post types.
		$this->set_post_types( [ 'course' ] );

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
			'search_items'          => __( 'Шукати Іспити', 'svitmov' ),
			'parent_item_colon'     => __( 'Колонка Батьківського Іспиту', 'svitmov' ),
			'parent_item'           => __( 'Батьківський Іспит', 'svitmov' ),
			'edit_item'             => __( 'Редагувати Іспит', 'svitmov' ),
			'view_item'             => __( 'Переглянути Іспит', 'svitmov' ),
			'update_item'           => __( 'Оновити Іспит', 'svitmov' ),
			'add_new_item'          => __( 'Додати Новий Іспит', 'svitmov' ),
			'new_item_name'         => __( 'Нова Назва Іспиту', 'svitmov' ),
			'not_found'             => __( 'Не Знайдено Іспитів', 'svitmov' ),
			'no_terms'              => __( 'Немає Іспитів', 'svitmov' ),
			'filter_by_item'        => __( 'Фільтрувати по Іспитам', 'svitmov' ),
			'items_list_navigation' => __( 'Навігація по Списку Іспитів', 'svitmov' ),
			'items_list'            => __( 'Список Іспитів', 'svitmov' ),
			'most_used'             => __( 'Найпоширеніші', 'svitmov' ),
			'back_to_items'         => __( 'Назад до Іспитів', 'svitmov' ),
			'item_link'             => __( 'Посилання на Архів Іспитів', 'svitmov' ),
			'item_link_description' => __( 'Опис Посилання на Архів Іспитів', 'svitmov' ),
		];
	}
}
