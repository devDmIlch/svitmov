<?php
/**
 * Base class for taxonomy initialization.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\Taxonomies;

/**
 * Base abstract class for taxonomies.
 */
abstract class BaseTaxonomy {

	// Private Fields.

	/**
	 * Taxonomy's slug.
	 *
	 * @var string $slug
	 */
	private string $slug;

	/**
	 * Taxonomy's singular name.
	 *
	 * @var string $slug
	 */
	private string $singular_name;

	/**
	 * Taxonomy's plural name.
	 *
	 * @var string $slug
	 */
	private string $plural_name;

	/**
	 * Taxonomy's associated post types.
	 *
	 * @var string|array $post_types
	 */
	private string|array $post_types;


	// Protected Properties.

	/**
	 * Setter method for $slug field.
	 *
	 * @param string $slug New value.
	 */
	final protected function set_slug( string $slug ): void {
		$this->slug = $slug;
	}

	/**
	 * Setter method for singular_name field.
	 *
	 * @param string $singular_name New value.
	 */
	final protected function set_singular_name( string $singular_name ): void {
		$this->singular_name = $singular_name;
	}

	/**
	 * Setter method for $plural_name field.
	 *
	 * @param string $plural_name New value.
	 */
	final protected function set_plural_name( string $plural_name ): void {
		$this->plural_name = $plural_name;
	}

	/**
	 * Setter method for $post_types field.
	 *
	 * @param string|array $post_types New value.
	 */
	final protected function set_post_types( string|array $post_types ): void {
		$this->post_types = $post_types;
	}


	// Public Properties.

	/**
	 * Getter method for $slug field.
	 *
	 * @return string Value of the $slug field.
	 */
	final public function get_slug(): string {
		return $this->slug;
	}

	/**
	 * Getter method for $singular_name field.
	 *
	 * @return string Value of the $singular_name field.
	 */
	final public function get_singular_name(): string {
		return $this->singular_name;
	}

	/**
	 * Getter method for $plural_name field.
	 *
	 * @return string Value of the $plural_name field.
	 */
	final public function get_plural_name(): string {
		return $this->plural_name;
	}

	/**
	 * Getter method for $post_types field.
	 *
	 * @return string|array Value of the $post_types field.
	 */
	final public function get_post_types(): string|array {
		return $this->post_types;
	}


	// Initialization Methods.

	/**
	 * Initialization method for the class
	 */
	public function init(): void {
		// Register Taxonomy.
		register_taxonomy( $this->slug, $this->post_types, $this->get_taxonomy_properties() );
	}


	// Protected Methods.

	/**
	 * Returns an array of properties for the taxonomy registration function.
	 *
	 * @return array An array of properties.
	 */
	protected function get_taxonomy_properties(): array {
		return [
			'labels'              => $this->get_taxonomy_labels(),
			'description'         => $this->description ?? '',
			'public'              => $this->is_public ?? true,
			'publicly_queryable'  => $this->is_publicly_queryable ?? true,
			'show_ui'             => $this->is_ui_shown ?? true,
			'show_in_menu'        => $this->is_shown_in_menu ?? true,
			'hierarchical'        => $this->is_hierarchical ?? true,
			'has_archive'         => $this->is_archive_exist ?? true,
			'exclude_from_search' => $this->is_excluded_from_search ?? false,
			'menu_position'       => $this->menu_position ?? null,
			'menu_icon'           => $this->menu_icon ?? null,
			'support'             => $this->supports ?? null,
			'taxonomies'          => $this->taxonomies ?? [],
			'rewrite'             => $this->rewrite ?? null,
			'show_in_rest'        => true,
		];
	}

	/**
	 * Returns an array of taxonomy labels.
	 *
	 * @return array An array of labels.
	 */
	protected function get_taxonomy_labels(): array {
		return [
			'name'                  => $this->plural_name,
			'singular_name'         => $this->singular_name,
			'menu_name'             => $this->plural_name,
			/* translators: %1$s is replaced with plural post type name (E.g. "Book Authors" in "View All Book Authors") */
			'popular_items'         => sprintf( __( 'Популярні %1$s', 'svitmov' ), $this->plural_name ),
			/* translators: %1$s is replaced with plural post type name (E.g. "Book Authors" in "View All Book Authors") */
			'search_items'          => sprintf( __( 'Шукати %1$s', 'svitmov' ), $this->plural_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book Author" in "Add New Book Author") */
			'parent_item_colon'     => sprintf( __( 'Колонка Батьківського %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book Author" in "Add New Book Author") */
			'parent_item'           => sprintf( __( 'Батьківська %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book Author" in "Add New Book Author") */
			'edit_item'             => sprintf( __( 'Редагувати %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book Author" in "Add New Book Author") */
			'view_item'             => sprintf( __( 'Переглянути %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book Author" in "Add New Book Author") */
			'update_item'           => sprintf( __( 'Оновити %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book Author" in "Add New Book Author") */
			'add_new_item'          => sprintf( __( 'Додати Новий %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book Author" in "Add New Book Author") */
			'new_item_name'         => sprintf( __( 'Нова Назва %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with plural post type name (E.g. "Book Authors" in "View All Book Authors") */
			'not_found'             => sprintf( __( 'Не Знайдено %1$s', 'svitmov' ), $this->plural_name ),
			/* translators: %1$s is replaced with plural post type name (E.g. "Book Authors" in "View All Book Authors") */
			'no_terms'              => sprintf( __( 'Немає %1$s', 'svitmov' ), $this->plural_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book Author" in "Add New Book Author") */
			'filter_by_item'        => sprintf( __( 'Фільтрувати по %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with plural post type name (E.g. "Book Authors" in "View All Book Authors") */
			'items_list_navigation' => sprintf( __( 'Навігація по Списку %1$s', 'svitmov' ), $this->plural_name ),
			/* translators: %1$s is replaced with plural post type name (E.g. "Book Authors" in "View All Book Authors") */
			'items_list'            => sprintf( __( 'Список %1$s', 'svitmov' ), $this->plural_name ),
			/* translators: %1$s is replaced with plural post type name (E.g. "Book Authors" in "View All Book Authors") */
			'most_used'             => sprintf( __( 'Найбільш Використовані %1$s', 'svitmov' ), $this->plural_name ),
			/* translators: %1$s is replaced with plural post type name (E.g. "Book Authors" in "View All Book Authors") */
			'back_to_items'         => sprintf( __( 'Назад до %1$s', 'svitmov' ), $this->plural_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book Author" in "Add New Book Author") */
			'item_link'             => sprintf( __( 'Посилання на %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book Author" in "Add New Book Author") */
			'item_link_description' => sprintf( __( 'Опис Посилання на %1$s', 'svitmov' ), $this->singular_name ),
		];
	}
}
