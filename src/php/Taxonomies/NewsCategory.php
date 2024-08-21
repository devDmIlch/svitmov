<?php
/**
 * News Category taxonomy class file
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\Taxonomies;

/**
 * Class for the 'news-category' taxonomy.
 */
class NewsCategory extends BaseTaxonomy {

	// Initializing Methods.

	/**
	 * Initialization method for the class
	 */
	public function init(): void {
		// Set taxonomy's slug.
		$this->set_slug( 'news-category' );
		// Set taxonomy's names.
		$this->set_singular_name( __( 'Категорія', 'svitmov' ) );
		$this->set_plural_name( __( 'Категорії', 'svitmov' ) );
		// Set taxonomy's associated post types.
		$this->set_post_types( [ 'news' ] );

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
			'search_items'          => __( 'Шукати Категорії', 'svitmov' ),
			'parent_item_colon'     => __( 'Колонка Батьківської Категорії', 'svitmov' ),
			'parent_item'           => __( 'Батьківська Категорія', 'svitmov' ),
			'edit_item'             => __( 'Редагувати Категорію', 'svitmov' ),
			'view_item'             => __( 'Переглянути Категорію', 'svitmov' ),
			'update_item'           => __( 'Оновити Категорію', 'svitmov' ),
			'add_new_item'          => __( 'Додати Нову Категорію', 'svitmov' ),
			'new_item_name'         => __( 'Нова Назва Категорії', 'svitmov' ),
			'not_found'             => __( 'Не Знайдено Категорій', 'svitmov' ),
			'no_terms'              => __( 'Немає Категорій', 'svitmov' ),
			'filter_by_item'        => __( 'Фільтрувати по Категоріям', 'svitmov' ),
			'items_list_navigation' => __( 'Навігація по Списку Категорій', 'svitmov' ),
			'items_list'            => __( 'Список Категорій', 'svitmov' ),
			'most_used'             => __( 'Найпоширеніші', 'svitmov' ),
			'back_to_items'         => __( 'Назад до Категорій', 'svitmov' ),
			'item_link'             => __( 'Посилання на Архів Категорій', 'svitmov' ),
			'item_link_description' => __( 'Опис Посилання на Архів Категорій', 'svitmov' ),
		];
	}


	// Public Methods.

	/**
	 * Returns an array of taxonomy names and permalinks
	 *
	 * @return array Array of term data.
	 */
	public static function get_term_list(): array {
		// Get the terms for this taxonomy.
		$terms = get_terms( [ 'taxonomy' => 'news-category' ]);
		// Map the terms with required values.
		array_walk(
			$terms,
			static function ( &$value ) {
				// Update mapped value.
				$value = [
					'name'     => $value->name,
					'url'      => get_term_link( $value ),
					'selected' => is_tax( $value->taxonomy, $value->term_id ),
				];
			}
		);
		// Push 'latest' option if the term list is not empty.
		if ( ! empty( $terms ) ) {
			array_unshift(
				$terms,
				[
					'name'     => __( 'Останнє', 'svitmov' ),
					'url'      => get_post_type_archive_link( 'news' ),
					'selected' => is_post_type_archive( 'news' ),
				]
			);
		}

		return $terms;
	}
}
