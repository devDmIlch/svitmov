<?php
/**
 * Course post type class file
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\PostTypes;

/**
 * Class for the 'course' post type.
 */
class Course extends BasePostType {

	// Public Properties.

	/**
	 * Returns slug name of the post type
	 *
	 * @return string Slug of post type.
	 */
	public static function get_post_type_slug(): string {
		return 'course';
	}


	// Initializing Methods.

	/**
	 * Initializing method for the class.
	 */
	public function init(): void {
		// Set slug for the post type.
		$this->set_slug( self::get_post_type_slug() );
		// Set names for the post type.
		$this->set_singular_name( __( 'Курс', 'svitmov' ) );
		$this->set_plural_name( __( 'Курси', 'svitmov' ) );
		// Set menu properties.
		$this->menu_position = 30;
		$this->menu_icon     = 'dashicons-media-document';
		// Set supported features.
		$this->supports = [ 'title', 'editor', 'revisions', 'thumbnail' ];

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
			'add_new'                  => __( 'Додати Курс', 'svitmov' ),
			'add_new_item'             => __( 'Додати Новий Курс', 'svitmov' ),
			'edit_item'                => __( 'Редагувати Курс', 'svitmov' ),
			'new_item'                 => __( 'Новий Курс', 'svitmov' ),
			'view_item'                => __( 'Переглянути Курс', 'svitmov' ),
			'view_items'               => __( 'Переглянути Курси', 'svitmov' ),
			'search_items'             => __( 'Шукати Курс', 'svitmov' ),
			'not_found'                => __( 'Не Знайдено Курси', 'svitmov' ),
			'not_found_in_trash'       => __( 'Не Знайдено Курси в Смітнику', 'svitmov' ),
			'all_items'                => __( 'Усі Курси', 'svitmov' ),
			'archives'                 => __( 'Архів Курсів', 'svitmov' ),
			'attributes'               => __( 'Атрибути Курсу', 'svitmov' ),
			'insert_into_item'         => __( 'Додати до Курсу', 'svitmov' ),
			'insert_into_this_item'    => __( 'Додати до Цього Курсу', 'svitmov' ),
			'featured_image'           => __( 'Фото Курсу', 'svitmov' ),
			'set_featured_image'       => __( 'Встановити Фото Курсу', 'svitmov' ),
			'remove_featured_image'    => __( 'Прибрати Фото Курсу', 'svitmov' ),
			'menu_name'                => __( 'Курси', 'svitmov' ),
			'filter_items_list'        => __( 'Фільтрувати Курси', 'svitmov' ),
			'filter_by_date'           => __( 'Фільтрувати Курси за Датою', 'svitmov' ),
			'items_list_navigation'    => __( 'Навігація по Списку Курсів', 'svitmov' ),
			'items_list'               => __( 'Список Курсів', 'svitmov' ),
			'item_published'           => __( 'Курс Опубліковано', 'svitmov' ),
			'item_published_privately' => __( 'Курс Опубліковано Приватним Записом', 'svitmov' ),
			'item_reverted_to_draft'   => __( 'Курс Повернено до Чернеток', 'svitmov' ),
			'item_trashed'             => __( 'Курс Переміщено до Смітника', 'svitmov' ),
			'item_updated'             => __( 'Курс Оновлено', 'svitmov' ),
			'item_link'                => __( 'Посилання на Курс', 'svitmov' ),
			'item_link_description'    => __( 'Опис Посилання на Курс', 'svitmov' ),
		];
	}
}
