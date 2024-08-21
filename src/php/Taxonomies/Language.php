<?php
/**
 * Language taxonomy class file
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\Taxonomies;

/**
 * Class for the 'language' post type.
 */
class Language extends BaseTaxonomy {

	// Initializing Methods.

	/**
	 * Initialization method for the class
	 */
	public function init(): void {
		// Set taxonomy's slug.
		$this->set_slug( 'language' );
		// Set taxonomy's names.
		$this->set_singular_name( __( 'Мова Викладання', 'svitmov' ) );
		$this->set_plural_name( __( 'Мови Викладання', 'svitmov' ) );
		// Set taxonomy's associated post types.
		$this->set_post_types( [ 'course', 'teacher' ] );

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
			'search_items'          => __( 'Шукати Мову Викладання', 'svitmov' ),
			'parent_item_colon'     => __( 'Колонка Батьківської Мови Викладання', 'svitmov' ),
			'parent_item'           => __( 'Батьківська Мова Викладання', 'svitmov' ),
			'edit_item'             => __( 'Редагувати Мову Викладання', 'svitmov' ),
			'view_item'             => __( 'Переглянути Мову Викладання', 'svitmov' ),
			'update_item'           => __( 'Оновити Мову Викладання', 'svitmov' ),
			'add_new_item'          => __( 'Додати Нову Мову Викладання', 'svitmov' ),
			'new_item_name'         => __( 'Нова Назва Мови Викладання', 'svitmov' ),
			'not_found'             => __( 'Не Знайдено Мов Викладання', 'svitmov' ),
			'no_terms'              => __( 'Немає Мов Викладання', 'svitmov' ),
			'filter_by_item'        => __( 'Фільтрувати по Мові Викладання', 'svitmov' ),
			'items_list_navigation' => __( 'Навігація по Списку Мов Викладання', 'svitmov' ),
			'items_list'            => __( 'Список Мов Викладання', 'svitmov' ),
			'most_used'             => __( 'Найпоширеніші', 'svitmov' ),
			'back_to_items'         => __( 'Назад до Мов Викладання', 'svitmov' ),
			'item_link'             => __( 'Посилання на Архів Мов Викладання', 'svitmov' ),
			'item_link_description' => __( 'Опис Посилання на Архів Мов Викладання', 'svitmov' ),
		];
	}


	// Public Methods.

	/**
	 * Returns greeting according to the selected language category.
	 *
	 * @param int|bool $post_id ID of the post (default: false, uses global $post value)
	 *
	 * @return string
	 */
	public static function get_lang_greeting( int|bool $post_id = false ): string {
		// Get post id if none was provided.
		if ( ! isset( $post_id ) ) {
			$post_id = get_the_ID();
		}

		// Return simple 'Hello' if the post was not found.
		if ( ! $post_id ) {
			return 'Hello';
		}

		// Search the languages for the post.
		$languages = get_the_terms( $post_id, 'language' );

		// Return simple 'Hello' if the post was not found or languages are missing.
		if ( empty( $languages ) ) {
			return 'Hello';
		}

		// Get the greeting text.
		$greeting = get_term_field( 'greeting-text', $languages[0]->term_id );
		if ( empty( $greeting ) ) {
			$greeting = 'Hello';
		}

		return $greeting;
	}
}
