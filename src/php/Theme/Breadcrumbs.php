<?php
/**
 * Breadcrumbs class file
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\Theme;

use Svitmov\PostTypes\Course;
use Svitmov\PostTypes\News;
use Svitmov\Taxonomies\LangLevel;

/**
 * Breadcrumbs class file.
 */
class Breadcrumbs {

	// Public Methods.

	/**
	 * Returns an array of breadcrumbs items for current page.
	 */
	public static function get_breadcrumbs(): array {
		// Prepare an array for breadcrumbs.
		$breadcrumbs = [];
		// If user is on home/front page return empty.
		if ( is_home() || is_front_page() ) {
			return $breadcrumbs;
		}
		// If on any other page start with home page.
		$breadcrumbs = [
			[
				'url'  => get_site_url(),
				'name' => __( 'Головна', 'svitmov' ),
			],
		];
		// if taxonomy archive, do 'front' -> 'archive -> 'tax' sequence.
		if ( is_tax() ) {
			// Get currently queried term object.
			$term_obj = get_queried_object();
			// Manually assign path for each of the taxonomies.
			switch ( $term_obj->taxonomy ) {
				case 'lang-level':
				case 'lang-test':
				case 'language':
					$breadcrumbs []= [
						'url'  => get_post_type_archive_link( Course::get_post_type_slug() ),
						'name' => get_post_type_object( Course::get_post_type_slug() )->label,
					];

					// Add element with current term.
					$breadcrumbs []= [
						'url'  => null,
						'name' => get_taxonomy( $term_obj->taxonomy )->label . ': ' . $term_obj->name,
					];
					break;
				case 'news-category':
				case 'news-tag':
					$breadcrumbs []= [
						'url'  => get_post_type_archive_link( News::get_post_type_slug() ),
						'name' => get_post_type_object( News::get_post_type_slug() )->label,
					];

					// Add element with current term.
					$breadcrumbs []= [
						'url'  => null,
						'name' => $term_obj->name,
					];
					break;
			}

			return $breadcrumbs;
		}
		// If user is on archive page, consider it a direct child of the home page.
		if ( is_archive() ) {
			$breadcrumbs []= [
				'url'  => null,
				'name' => get_queried_object()->label,
			];

			return $breadcrumbs;
		}
		// If the user is on search page, do 'front' -> 'courses' -> 'search' sequence.
		if ( is_search() ) {
			// Add link to the 'course' archive page.
			$breadcrumbs []= [
				'url'  => get_post_type_archive_link( Course::get_post_type_slug() ),
				'name' => get_post_type_object( Course::get_post_type_slug() )->label,
			];
			// Add element with currently searched item.
			$breadcrumbs []= [
				'url'  => null,
				/* translators: %s is replaced with search query */
				'name' => sprintf( __( 'Пошук: %s', 'svitmov' ), get_search_query() ),
			];

			return $breadcrumbs;
		}
		// If user is on single page, consider it direct child of the home page.
		if ( is_page() ) {
			$breadcrumbs []= [
				'url'  => null,
				'name' => get_the_title(),
			];

			return $breadcrumbs;
		}
		// If user is on single page, do 'front' -> 'archive' -> 'single' sequence.
		if ( is_single() ) {
			// Get object of currently queried post.
			$post_obj = get_queried_object();
			// First add link to the archive.
			$breadcrumbs []= [
				'url'  => get_post_type_archive_link( $post_obj->post_type ),
				'name' => get_post_type_object( $post_obj->post_type )->label,
			];
			// Add element with current post.
			$breadcrumbs []= [
				'url'  => null,
				'name' => $post_obj->post_title,
			];

			return $breadcrumbs;
		}

		// Return default empty array if none of the conditions match.
		return [];
	}
}
