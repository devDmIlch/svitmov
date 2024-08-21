<?php
/**
 * Header template file for the theme.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<?php wp_head(); ?>
</head>
<body>
	<header class="site-header">
		<div class="header-content">
			<?php if ( has_nav_menu( 'main-menu' ) ) : ?>
				<div class="main-menu-mobile">
					<div class="menu-controls">
						<div class="close-menu">
						</div>
						<div class="site-search">
							<div class="search-toggle">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M10.3635 3C8.90709 3 7.48342 3.43187 6.27248 4.24099C5.06154 5.05011 4.11773 6.20015 3.5604 7.54567C3.00307 8.89119 2.85724 10.3718 3.14137 11.8002C3.4255 13.2286 4.12681 14.5406 5.15663 15.5704C6.18645 16.6003 7.49851 17.3016 8.92691 17.5857C10.3553 17.8698 11.8359 17.724 13.1814 17.1667C14.5269 16.6093 15.677 15.6655 16.4861 14.4546C17.2952 13.2437 17.7271 11.82 17.7271 10.3636C17.7269 8.41069 16.9511 6.5378 15.5702 5.15688C14.1893 3.77597 12.3164 3.00012 10.3635 3Z" stroke="#333333" stroke-width="2" stroke-miterlimit="10"/>
									<path d="M15.8573 15.8574L21 21.0001" stroke="#333333" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
								</svg>
							</div>
							<input type="text" class="search-input"/>
							<div class="search-submit">
								<svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1.46875 1.41113L6.53125 6.47363L1.46875 11.5361" stroke="#666666" stroke-width="2" stroke-miterlimit="10" stroke-linecap="square"/>
								</svg>
							</div>
						</div>
					</div>
					<?php
					wp_nav_menu(
						[
							'menu'    => 'main-menu',
							'menu_id' => 'svitmov-main-menu',
						]
					);
					?>
				</div>
				<div class="main-menu-trigger">
				</div>
			<?php endif; ?>
			<div class="site-identity">
				<?php the_custom_logo(); ?>
			</div>
			<div class="main-menu-desktop">
				<?php
				if ( has_nav_menu( 'main-menu' ) ) {
					wp_nav_menu(
						[
							'menu'       => 'main-menu',
							'menu_id'    => 'svitmov-main-menu',
							'container'  => false,
							'items_wrap' => '<div id="%1$s" class="%2$s">%3$s</div>',
							'walker'     => new \Svitmov\Menus\SvitmovMainMenuWalker(),
						]
					);
				}
				?>
			</div>
			<div class="header-controls">
				<div class="site-search">
					<div class="search-toggle">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M10.3635 3C8.90709 3 7.48342 3.43187 6.27248 4.24099C5.06154 5.05011 4.11773 6.20015 3.5604 7.54567C3.00307 8.89119 2.85724 10.3718 3.14137 11.8002C3.4255 13.2286 4.12681 14.5406 5.15663 15.5704C6.18645 16.6003 7.49851 17.3016 8.92691 17.5857C10.3553 17.8698 11.8359 17.724 13.1814 17.1667C14.5269 16.6093 15.677 15.6655 16.4861 14.4546C17.2952 13.2437 17.7271 11.82 17.7271 10.3636C17.7269 8.41069 16.9511 6.5378 15.5702 5.15688C14.1893 3.77597 12.3164 3.00012 10.3635 3Z" stroke="#333333" stroke-width="2" stroke-miterlimit="10"/>
							<path d="M15.8573 15.8574L21 21.0001" stroke="#333333" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"/>
						</svg>
					</div>
					<input type="text" class="search-input"/>
					<div class="search-submit">
						<svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1.46875 1.41113L6.53125 6.47363L1.46875 11.5361" stroke="#666666" stroke-width="2" stroke-miterlimit="10" stroke-linecap="square"/>
						</svg>
					</div>
				</div>
				<div class="contacts">
					<?php echo esc_html( get_option( 'svitmov-phone' ?? [ '' ] )[0] ); ?>
				</div>
			</div>
		</div>
	</header>
	<?php $breadcrumbs = \Svitmov\Theme\Breadcrumbs::get_breadcrumbs(); ?>
	<?php if ( ! empty( $breadcrumbs ) ) : ?>
		<div class="breadcrumbs">
			<?php foreach ( $breadcrumbs as $breadcrumb_item ) : ?>
				<a class="breadcrumb-item" href="<?php echo esc_url( $breadcrumb_item['url'] ?? '#' ); ?>">
					<?php echo esc_html( $breadcrumb_item['name'] ); ?>
				</a>
				<span class="direction-arrow">
					<?php \Svitmov\Includes\Helpers::the_svg_file( 'arrow' ); ?>
				</span>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
