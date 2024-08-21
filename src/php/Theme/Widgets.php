<?php
/**
 * Widgets class file.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\Theme;

/**
 * Class for registering and managing theme's widgets and sidebars.
 */
class Widgets {

	// Initialization Methods.

	/**
	 * Initialization method for the class
	 */
	public function init(): void {
		$this->register_sidebars();
	}


	// Private Methods.

	/**
	 * Registers theme's sidebars.
	 */
	private function register_sidebars(): void {
		// Prepare widget data.
		$widget_data = [
			'svitmov-footer-sidebar-1' => __( 'Колонка футера №2', 'svitmov' ),
			'svitmov-footer-sidebar-2' => __( 'Колонка футера №3', 'svitmov' ),
			'svitmov-footer-sidebar-3' => __( 'Колонка футера №4', 'svitmov' ),
		];
		// Register the sidebars.
		foreach ( $widget_data as $sidebar_id => $sidebar_name ) {
			register_sidebar(
				[
					'name'          => $sidebar_name,
					'id'            => $sidebar_id,
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
				]
			);
		}
	}
}
