<?php
/**
 * Theme menus controller class file.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\Menus;

/**
 * Menus controller class
 */
class MenuController {

	// Initialization Methods.

	/**
	 * Initialization method for the class.
	 */
	public function init(): void {
		$this->register_menus();
	}


	// Private Methods.

	/**
	 * Register theme menus.
	 */
	private function register_menus(): void {
		register_nav_menus(
			[
				'main-menu'        => __( 'Головне Меню', 'svitmov' ),
				'main-menu-mobile' => __( 'Головне Меню (Мобільне)', 'svitmov' ),
				'footer-menu-1'    => __( 'Меню у Футері (2-га колонка)', 'svitmov' ),
				'footer-menu-2'    => __( 'Меню у Футері (3-тя колонка)', 'svitmov' ),
				'footer-menu-3'    => __( 'Меню у Футері (4-та колонка)', 'svitmov' ),
			]
		);
	}
}
