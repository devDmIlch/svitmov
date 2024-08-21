<?php
/**
 * Helpers class template file.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

namespace Svitmov\Includes;

/**
 * Special class with helper static methods.
 */
class Helpers {

	// Public Methods.

	/**
	 * Saves outputted data into string.
	 *
	 * @param callable $callback output function.
	 *
	 * @return string stringified output.
	 */
	public static function echo_to_string( callable $callback ): string {
		ob_start();
		$callback();
		return ob_get_clean();
	}

	/**
	 * Displays content of the svg file.
	 *
	 * @param string $file SVG file name.
	 */
	public static function the_svg_file( string $file ): void {
		// Check whether the file contains extension.
		if ( ! str_contains( $file, '.svg' ) ) {
			$file .= '.svg';
		}
		// Compile file path for future use.
		$file_path = SVITMOV_THEME_PATH . '/assets/images/svg/' . $file;
		// Attempt to get avg from the cache.
		$file_exists = wp_cache_get( 'svg_' . $file, 'svg' );
		// If the cache is empty try to get svg from the file.
		if ( false === $file_exists ) {
			// Check whether the file exists. This is a performance-expensive function call, but it should be fine as long as we cache this.
			$file_exists = file_exists( $file_path );
			// Set cached data for future use.
			wp_cache_set( 'svg_' . $file, 'svg', $file_exists );
		}
		// Require file if it exits.
		if ( $file_exists ) {
			require $file_path;
		}
	}

	/**
	 * Returns svg file data in a string.
	 *
	 * @param string $file SVG file name.
	 *
	 * @return string svg file contents in a string.
	 */
	public static function get_svg_file( string $file ): string {
		return self::echo_to_string( static fn() => self::the_svg_file( $file ) );
	}

	/**
	 * Retrieves meta values of multiple posts.
	 *
	 * @param string $meta_key Meta key of values to retrieve.
	 * @param array  $post_ids ID's of the posts to retrieve meta values from. Default: [] (all)
	 *
	 * @return array array of meta values.
	 */
	public static function get_meta_bulk( string $meta_key, array $post_ids = [] ): array {
		global $wpdb;

		// Try getting values from cache.
		$cache_val = wp_cache_get( 'meta_bulk_' . $meta_key );
		if ( ! empty( $cache_val ) ) {
			return $cache_val;
		}

		// Prepare query placeholder.
		$statement = 'SELECT post_id, meta_value FROM %i WHERE meta_key = %s';
		// Add IN statement if the posts were specified.
		if ( ! empty( $post_ids ) ) {
			$statement .= ' AND post_id IN (' . implode( ',', array_fill( 0, count( $post_ids ), '%d' ) ). ')';
		}

		// Request query data.
		$result = $wpdb->get_results( $wpdb->prepare( $statement, $wpdb->prefix . 'postmeta', $meta_key, ...$post_ids ), OBJECT_K );

		// Map query values.
		array_walk( $result, static fn ( &$value ) => $value = $value->meta_value );
		// Filter out empty values.
		$result = array_filter( $result, static fn ( &$value ) => ! empty( $value ) );

		// Save values to cache.
		wp_cache_set( 'meta_bulk_' . $meta_key, $cache_val );

		// Return the resulting array.
		return $result;
	}

	/**
	 * Checks form request submission.
	 *
	 * @param \WP_REST_Request $request Request parameters.
	 *
	 * @return bool Whether the request is from valid source.
	 */
	public static function is_callback_permitted( \WP_REST_Request $request ): bool {
		// Check nonce value.
		if ( ! wp_verify_nonce( $request->get_header( 'x_wp_nonce' ), 'wp_rest' ) ) {
			return false;
		}
		// Request captcha verification.
		$result = wp_remote_post(
			'https://www.google.com/recaptcha/api/siteverify',
			[
				'body' => [
					'secret'   => get_option( 'svitmov-captcha-secret' ),
					'response' => $request->get_param( 'captcha_token' ),
				]
			]
		);

		// Check if the response is okay.
		if ( is_wp_error( $result ) ) {
			return false;
		}
		// Prepare variable for the score.
		$score = [];
		try {
			$score = json_decode( $result['body'], true, 512, JSON_THROW_ON_ERROR );
		} catch ( \JsonException $exception ) {
			return false;
		}
		// Check if the score is ok.
		if ( $score['success'] && $score['score'] > 0.6 ) {
			// Return true if everything is okay.
			return true;
		}
		// Return false if the score is too low.
		return false;
	}
}
