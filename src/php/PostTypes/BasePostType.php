<?php
/**
 * Base class for post type initialization.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\PostTypes;

/**
 * Base abstract class for post types.
 */
abstract class BasePostType {

	// Private Fields.

	/**
	 * Post type's slug.
	 *
	 * @var string $slug
	 */
	private string $slug;

	/**
	 * Post type's singular name.
	 *
	 * @var string $slug
	 */
	private string $singular_name;

	/**
	 * Post type's plural name.
	 *
	 * @var string $slug
	 */
	private string $plural_name;


	// Protected Fields.

	/**
	 * Post type's description.
	 *
	 * @var string $description
	 */
	protected string $description;

	/**
	 * Post type's publicity setting.
	 *
	 * @var bool $is_public
	 */
	protected bool $is_public;

	/**
	 * Post type's hierarchy setting.
	 *
	 * @var bool $is_hierarchical;
	 */
	protected bool $is_hierarchical;

	/**
	 * Post type's exclusivity from search setting.
	 *
	 * @var bool $is_excluded_from_search
	 */
	protected bool $is_excluded_from_search;

	/**
	 * Post type's ui elements visibility in the wp-admin.
	 *
	 * @var bool $is_ui_shown
	 */
	protected bool $is_ui_shown;

	/**
	 * Post type's accessibility through option in wp-admin menu.
	 *
	 * @var bool|string $is_shown_in_menu
	 */
	protected bool|string $is_shown_in_menu;

	/**
	 * Post type's queribility setting.
	 *
	 * @var bool $is_publicly_queryable
	 */
	protected bool $is_publicly_queryable;

	/**
	 * Post type's position in wp-admin menu. Redundant if $is_shown_in_menu equals to 'false'.
	 *
	 * @var int $num_menu_position
	 */
	protected int $menu_position;

	/**
	 * Post type's menu icon dashboard name.
	 *
	 * @var string $menu_icon
	 */
	protected string $menu_icon;

	/**
	 * Post type's supported features.
	 *
	 * @var array $supports
	 */
	protected array $supports;

	/**
	 * Post type's assigned taxonomies.
	 *
	 * @var string[] $taxonomies
	 */
	protected array $taxonomies;

	/**
	 * Post type's existence of archive page.
	 *
	 * @var bool|string $is_archive_exist
	 */
	protected bool|string $is_archive_exist;

	/**
	 * Post type's rewrite rules.
	 *
	 * @var array $rewrite
	 */
	protected array $rewrite;

	/**
	 * Whether post type should use Gutenberg block editor.
	 *
	 * @var bool $is_ui_shown
	 */
	protected bool $show_in_rest;


	// Protected Properties.

	/**
	 * Setter method for $slug field.
	 *
	 * @param string $slug New value.
	 */
	protected function set_slug( string $slug ): void {
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


	// Public Properties.

	/**
	 * Getter method for $slug field.
	 *
	 * @return string Value of the $slug field.
	 */
	public function get_slug(): string {
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


	// Initialization Methods.

	/**
	 * Initialization method for the class.
	 */
	public function init(): void {
		register_post_type( $this->get_slug(), $this->get_post_type_properties() );
	}


	// Protected Methods.

	/**
	 * Returns an array of properties for the post type registration function.
	 *
	 * @return array An array of properties.
	 */
	protected function get_post_type_properties(): array {
		return [
			'labels'              => $this->get_post_type_labels(),
			'description'         => $this->description ?? '',
			'public'              => $this->is_public ?? true,
			'publicly_queryable'  => $this->is_publicly_queryable ?? true,
			'show_ui'             => $this->is_ui_shown ?? true,
			'show_in_menu'        => $this->is_shown_in_menu ?? true,
			'show_in_nav_menus'   => $this->is_shown_in_nav_menus ?? true,
			'hierarchical'        => $this->is_hierarchical ?? false,
			'has_archive'         => $this->is_archive_exist ?? true,
			'exclude_from_search' => $this->is_excluded_from_search ?? false,
			'menu_position'       => $this->menu_position ?? null,
			'menu_icon'           => $this->menu_icon ?? null,
			'supports'            => $this->supports ?? null,
			'taxonomies'          => $this->taxonomies ?? [],
			'rewrite'             => $this->rewrite ?? null,
			'show_in_rest'        => $this->show_in_rest ?? false,
		];
	}

	/**
	 * Returns an array of post type labels.
	 *
	 * @return array An array of labels.
	 */
	protected function get_post_type_labels(): array {
		return [
			'name'                     => $this->plural_name,
			'singular_name'            => $this->singular_name,
			'menu_name'                => $this->plural_name,
			/* translators: %1$s is replaced with singular post type name. Genitive  (E.g. "Book" in "Add New Book") */
			'add_new'                  => sprintf( __( 'Додати %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book" in "Add New Book") */
			'add_new_item'             => sprintf( __( 'Додати Новий %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book" in "Add New Book") */
			'edit_item'                => sprintf( __( 'Редагувати %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book" in "Add New Book") */
			'new_item'                 => sprintf( __( 'Новий %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book" in "Add New Book") */
			'view_item'                => sprintf( __( 'Переглянути %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with plural post type name (E.g. "Books" in "View All Books") */
			'view_items'               => sprintf( __( 'Переглянути %1$s', 'svitmov' ), $this->plural_name ),
			/* translators: %1$s is replaced with plural post type name (E.g. "Books" in "View All Books") */
			'search_items'             => sprintf( __( 'Шукати %1$s', 'svitmov' ), $this->plural_name ),
			/* translators: %1$s is replaced with plural post type name (E.g. "Books" in "View All Books") */
			'not_found'                => sprintf( __( 'Не Знайдено %1$s', 'svitmov' ), $this->plural_name ),
			/* translators: %1$s is replaced with plural post type name (E.g. "Books" in "View All Books") */
			'not_found_in_trash'       => sprintf( __( 'Не Знайдено %1$s в Смітнику', 'svitmov' ), $this->plural_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book" in "Add New Book") */
			'parent_item_colon'        => sprintf( __( 'Колонка Батьківського %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with plural post type name (E.g. "Books" in "View All Books") */
			'all_items'                => sprintf( __( 'Всі %1$s', 'svitmov' ), $this->plural_name ),
			/* translators: %1$s is replaced with plural post type name (E.g. "Books" in "View All Books") */
			'archives'                 => sprintf( __( 'Архів %1$s', 'svitmov' ), $this->plural_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book" in "Add New Book") */
			'attributes'               => sprintf( __( 'Атрибути %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book" in "Add New Book") */
			'insert_into_item'         => sprintf( __( 'Вставити в %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book" in "Add New Book") */
			'insert_into_this_item'    => sprintf( __( 'Вставивти в цей %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book" in "Add New Book") */
			'featured_image'           => sprintf( __( 'Титульне Зображення для %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book" in "Add New Book") */
			'set_featured_image'       => sprintf( __( 'Встановити Титульне Зображення для %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book" in "Add New Book") */
			'remove_featured_image'    => sprintf( __( 'Видалити Титульне Зображення для %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Books" in "View All Books") */
			'filter_items_list'        => sprintf( __( 'Фільтрувати Список %1$s', 'svitmov' ), $this->plural_name ),
			/* translators: %1$s is replaced with plural post type name (E.g. "Books" in "View All Books") */
			'filter_by_date'           => sprintf( __( 'Фільтрувати Список %1$s за Датою', 'svitmov' ), $this->plural_name ),
			/* translators: %1$s is replaced with plural post type name (E.g. "Books" in "View All Books") */
			'items_list_navigation'    => sprintf( __( 'Навігація по Списку %1$s', 'svitmov' ), $this->plural_name ),
			/* translators: %1$s is replaced with plural post type name (E.g. "Books" in "View All Books") */
			'items_list'               => sprintf( __( 'Список %1$s', 'svitmov' ), $this->plural_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book" in "Add New Book") */
			'item_published'           => sprintf( __( '%1$s Опубліковано', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book" in "Add New Book") */
			'item_published_privately' => sprintf( __( '%1$s Опублікавано Приватно', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book" in "Add New Book") */
			'item_reverted_to_draft'   => sprintf( __( '%1$s Перенесено до Чернеток', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book" in "Add New Book") */
			'item_trashed'             => sprintf( __( '%1$s Перенесено до Смітника', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book" in "Add New Book") */
			'item_scheduled'           => sprintf( __( '%1$s Заплановано для Публікації', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book" in "Add New Book") */
			'item_updated'             => sprintf( __( '%1$s Оновлено', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book" in "Add New Book") */
			'item_link'                => sprintf( __( 'Посилання на %1$s', 'svitmov' ), $this->singular_name ),
			/* translators: %1$s is replaced with singular post type name (E.g. "Book" in "Add New Book") */
			'item_link_description'    => sprintf( __( 'Опис Посилання на %1$s', 'svitmov' ), $this->singular_name ),
		];
	}
}
