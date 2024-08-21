<?php
/**
 * Custom walker for theme's main menu.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\Menus;

use Svitmov\Includes\Helpers;

/**
 * Custom walker class for main menu of the theme
 *
 * @extends \Walker_Nav_Menu Default WP walker class
 */
class SvitmovMainMenuWalker extends \Walker_Nav_Menu {

	// Private Fields.

	/**
	 * Stores an id that is utilised to establish relations between parent and child menu items.
	 *
	 * @var int $menu_item_id
	 */
	private static int $menu_item_id = 0;

	// Private Methods.

	/**
	 * Returns unique id for menu item.
	 *
	 * @return int unique id.
	 */
	private static function get_menu_item_id(): int {
		return ++self::$menu_item_id;
	}

	// Public Methods.

	/**
	 * Starts the list before the elements are added.
	 *
	 * @param string    $output Used to append additional content (passed by reference).
	 * @param int       $depth  Depth of menu item. Used for padding.
	 * @param \stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ): void {
		// Prepare initial classes of the
		$classes = [ 'sub-menu', 'menu-level-' . $depth ];

		switch ( $depth ) {
			case 1:
				$classes []= 'menu-dropdown-target';
				break;
			case 2:
				$classes []= 'side-menu-area';
				break;
		}

		// Build menu attributes.
		$attributes = $this->build_atts( [ 'class' => implode( ' ', $classes ) ] );
		// Add code to the output.
		$output .= "<div$attributes>";
	}

	/**
	 * Ends the list after the elements were added.
	 *
	 * @param string    $output Used to append additional content (passed by reference).
	 * @param int       $depth  Depth of menu item. Used for padding.
	 * @param \stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ): void {
		// Return simple close tag.
		$output .= '</div>';
	}

	/**
	 * Starts the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string    $output            Used to append additional content (passed by reference).
	 * @param \WP_Post  $data_object       Menu item data object.
	 * @param int       $depth             Depth of menu item. Used for padding.
	 * @param \stdClass $args              An object of wp_nav_menu() arguments.
	 * @param int       $current_object_id Optional. ID of the current menu item. Default 0.
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ): void {
		// Get unique menu id.
		$menu_item_id = self::get_menu_item_id();
		// Check whether the element has children.
		$has_children = in_array( 'menu-item-has-children', $data_object->classes ?? [], true );
		// Check whether the link is a dud.
		$is_dud = '#' === $data_object->url;
		// Get link title.
		$title = apply_filters( 'the_title', $data_object->title, $data_object->ID );
		// Prepare attributes for the menu item itself.
		$attributes = [
			'title'        => ! empty( $data_object->attr_title ) ? $data_object->attr_title : '',
			'aria-current' => $data_object->current ? 'page' : '',
			'class'        => 'menu-item'
		];
		// Check if the link is supposed to be empty.
		if ( ! $is_dud ) {
			$attributes['href'] = $data_object->url;
		}
		// Add relation attribute for dropdown.
		if ( $has_children ) {
			$attributes['rel'] = 'menu-item-' . $menu_item_id;
		}
		// Add trigger for the dropdown.
		if ( 0 === $depth && $has_children ) {
			// Add class to initialize dropdown.
			$attributes['class'] .= ' dropdown-trigger';
		}
		// Add class to initialize hover activated element.
		if ( $depth === 1 ) {
			$attributes['class'] .= ' hover-activator';
		}

		// Prepare proper tag for
		$tag = $is_dud ? 'span' : 'a';
		// Add a link to the menu.
		if ( $depth === 1 && $has_children ) {
			// Get arrow svg.
			$arrow_svg = Helpers::get_svg_file( 'arrow' );

			$output .= "<$tag{$this->build_atts($attributes)}>$title $arrow_svg</$tag>";
		} else {
			$output .= "<$tag{$this->build_atts($attributes)}>$title</$tag>";
		}

		// Skip adding the dropdown if the menu item lacks children.
		if ( ! $has_children ) {
			return;
		}

		// Prepare classes for submenu.
		$wrap_class = [ 'sub-menu-wrap', 'wrap-level-' . $depth ];
		// Add dropdown classes to 0-level wrap.
		if ( 0 === $depth ) {
			// Add class to initialize dropdown.
			$wrap_class []= 'main-menu-dropdown dropdown-target';
		} else {
			// Add class to initialize hover activation.
			$wrap_class []= 'hover-activated';
		}
		// Add menu wrapper.
		$output .= '<div class="' . implode( ' ', $wrap_class ) . '" rel="' . 'menu-item-' . $menu_item_id . '">';
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @param string    $output      Used to append additional content (passed by reference).
	 * @param \WP_Post  $data_object Menu item data object. Not used.
	 * @param int       $depth       Depth of page. Not Used.
	 * @param \stdClass $args        An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
		// Opening tag is added if the menu item has children.
		if ( in_array( 'menu-item-has-children', $data_object->classes ?? [], true ) ) {
			// Add simple closing tag.
			$output .= '</div>';
		}
	}
}
