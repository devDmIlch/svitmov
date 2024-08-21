<?php
/**
 * Text Book post type class file
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\PostTypes;

/**
 * Class for the 'text-book' post type.
 */
class TextBook extends BasePostType {


	// Public Properties.

	/**
	 * Returns slug name of the post type
	 *
	 * @return string Slug of post type.
	 */
	public static function get_post_type_slug(): string {
		return 'text-book';
	}


	// Initializing Methods.

	/**
	 * Initializing method for the class.
	 */
	public function init(): void {
		// Set slug for the post type.
		$this->set_slug( self::get_post_type_slug() );
		// Set names for the post type.
		$this->set_singular_name( __( 'Підручник', 'svitmov' ) );
		$this->set_plural_name( __( 'Підручники', 'svitmov' ) );
		// Set menu properties.
		$this->menu_position = 35;
		$this->menu_icon     = 'dashicons-book-alt';

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
			'add_new'                  => __( 'Додати Підручник', 'svitmov' ),
			'add_new_item'             => __( 'Додати Новий Підручник', 'svitmov' ),
			'edit_item'                => __( 'Редагувати Підручник', 'svitmov' ),
			'new_item'                 => __( 'Новий Підручник', 'svitmov' ),
			'view_item'                => __( 'Переглянути Підручник', 'svitmov' ),
			'view_items'               => __( 'Переглянути Підручник', 'svitmov' ),
			'search_items'             => __( 'Шукати Підручники', 'svitmov' ),
			'not_found'                => __( 'Не Знайдено Підручникик', 'svitmov' ),
			'not_found_in_trash'       => __( 'Не Знайдено Підручники в Смітнику', 'svitmov' ),
			'all_items'                => __( 'Усі Підручники', 'svitmov' ),
			'archives'                 => __( 'Архів Підручників', 'svitmov' ),
			'attributes'               => __( 'Атрибути Підручника', 'svitmov' ),
			'insert_into_item'         => __( 'Додати до Підручника', 'svitmov' ),
			'insert_into_this_item'    => __( 'Додати до Цього Підручника', 'svitmov' ),
			'featured_image'           => __( 'Зображення Підручниика', 'svitmov' ),
			'set_featured_image'       => __( 'Встановити Зображення Підручника', 'svitmov' ),
			'remove_featured_image'    => __( 'Прибрати Зображення Підручника', 'svitmov' ),
			'menu_name'                => __( 'Підручники', 'svitmov' ),
			'filter_items_list'        => __( 'Фільтрувати Підручники', 'svitmov' ),
			'filter_by_date'           => __( 'Фільтрувати Підручники за Датою', 'svitmov' ),
			'items_list_navigation'    => __( 'Навігація по Списку Підручників', 'svitmov' ),
			'items_list'               => __( 'Список Підручників', 'svitmov' ),
			'item_published'           => __( 'Підручник Опубліковано', 'svitmov' ),
			'item_published_privately' => __( 'Підручник Опубліковано Приватним Записом', 'svitmov' ),
			'item_reverted_to_draft'   => __( 'Підручник Повернено до Чернеток', 'svitmov' ),
			'item_trashed'             => __( 'Підручник Переміщено до Смітника', 'svitmov' ),
			'item_updated'             => __( 'Підручник Оновлено', 'svitmov' ),
			'item_link'                => __( 'Посилання на Підручник', 'svitmov' ),
			'item_link_description'    => __( 'Опис Посилання на Підручник', 'svitmov' ),
		];
	}
}
