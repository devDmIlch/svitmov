<?php
/**
 * Language Level taxonomy class file
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\Taxonomies;

/**
 * Class for the 'lang-level' post type.
 */
class LangLevel extends BaseTaxonomy {

	// Initializing Methods.

	/**
	 * Initialization method for the class
	 */
	public function init(): void {
		// Set taxonomy's slug.
		$this->set_slug( 'lang-level' );
		// Set taxonomy's names.
		$this->set_singular_name( __( 'Рівень Мови', 'svitmov' ) );
		$this->set_plural_name( __( 'Рівні Мови', 'svitmov' ) );
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
			'search_items'          => __( 'Шукати Рівні Мов', 'svitmov' ),
			'parent_item_colon'     => __( 'Колонка Батьківського Рівня Мови', 'svitmov' ),
			'parent_item'           => __( 'Батьківський Рівень Мови', 'svitmov' ),
			'edit_item'             => __( 'Редагувати Рівень Мови', 'svitmov' ),
			'view_item'             => __( 'Переглянути Рівень Мови', 'svitmov' ),
			'update_item'           => __( 'Оновити Рівень Мови', 'svitmov' ),
			'add_new_item'          => __( 'Додати Новий Рівень Мови', 'svitmov' ),
			'new_item_name'         => __( 'Нова Назва Рівня Мови', 'svitmov' ),
			'not_found'             => __( 'Не Знайдено Рівні Мов', 'svitmov' ),
			'no_terms'              => __( 'Немає Рівнів Мов', 'svitmov' ),
			'filter_by_item'        => __( 'Фільтрувати по Рівню Мов', 'svitmov' ),
			'items_list_navigation' => __( 'Навігація по Списку Рівнів Мов', 'svitmov' ),
			'items_list'            => __( 'Список Рівнів Мов', 'svitmov' ),
			'most_used'             => __( 'Найпоширеніші', 'svitmov' ),
			'back_to_items'         => __( 'Назад до Рівнів Мов', 'svitmov' ),
			'item_link'             => __( 'Посилання на Архів Рівнів Мов', 'svitmov' ),
			'item_link_description' => __( 'Опис Посилання на Архів Рівнів Мов', 'svitmov' ),
		];
	}
}
