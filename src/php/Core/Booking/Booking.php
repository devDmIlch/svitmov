<?php
/**
 * Booking requests handler class file
 *
 * @package svitmov/theme
 * @since 0.0.2
 */

namespace Svitmov\Core\Booking;

use Svitmov\Includes\Helpers;
use Svitmov\PostTypes\Course;
use Svitmov\Theme\Emails;

/**
 * Booking requests handler
 */
class Booking {

	// Private Fields.

	/**
	 * REST API namespace
	 *
	 * @var string $api_namespace
	 */
	private string $api_namespace;


	// Initialization Methods.

	/**
	 * Initialization method for class.
	 */
	public function init(): void {
		$this->api_namespace = 'svitmov/booking';

		// Initialize hooks.
		$this->hooks();
	}

	/**
	 * Hooks initialization method for class.
	 */
	protected function hooks(): void {
		// Register endpoints.
		add_action( 'rest_api_init', [ $this, 'register_rest_routes' ] );
	}


	// Private Methods.


	// Public Methods.

	/**
	 * Creates booking form based on request.
	 *
	 * @param \WP_REST_Request $request Request data.
	 *
	 * @return array Request response.
	 */
	public function get_form_content( \WP_REST_Request $request ): array {
		// Get id of the course from request parameters.
		$course_id = sanitize_text_field( $request->get_param( 'course' ) ?? '' );
		// Check whether ID is valid.
		if ( ! empty( $course_id ) && get_post_type( $course_id ) !== Course::get_post_type_slug() ) {
			return [
				'status' => 500,
				'error'  => 'Invalid ID (not a course)',
			];
		}
		// Prepare arguments array.
		$args = [
			'subtype' => 'selectable',
		];
		// If the course id is not empty retrieve subtype from meta.
		if ( ! empty( $course_id ) ) {
			$args['subtype'] = get_post_meta( $course_id, 'course-audience', true );
			// Set course id argument.
			$args['course'] = $course_id;
		}
		// Render template into a string.
		$form = Helpers::echo_to_string(
			static function () use ( $args ) {
				get_template_part(
					'template-parts/pop-ups/generic-pop-up',
					args: [
						'title'   => __( 'Записатися на курс', 'svitmov' ),
						'form'    => 'booking',
						'data'    => $args,
						'success' => __( 'Заявка відправлена!', 'svitmov' ),
					]
				);
			}
		);
		// Return form as request response.
		return [
			'status' => 200,
			'form'   => $form,
		];
	}

	/**
	 * Handles POST booking form submission request.
	 *
	 * @param \WP_REST_Request $request Request data.
	 *
	 * @return array Request response.
	 */
	public function handle_booking_request( \WP_REST_Request $request ): array {
		// Get parameters from request.
		$params = $request->get_params();

		// Check if the parameters are supplied properly.
		if ( ! ( isset( $params['course'] ) || isset( $params['language'], $params['is-online'] ) ) ) {
			return [
				'status' => 400,
				'error'  => 'Missing required fields (either \'course\' or \'language\' and \'is-online\' should be supplied )',
			];
		}

		// Get arguments from request.
		$args['first-name'] = sanitize_text_field( $params['first-name'] );
		$args['last-name']  = sanitize_text_field( $params['last-name'] );
		$args['phone']      = sanitize_text_field( $params['phone'] );
		$args['email']      = sanitize_email( $params['email'] );

		// Check if the request is course-specific.
		if ( isset( $params['course'] ) ) {
			// Get the course id from parameters.
			$course_id = (int) sanitize_text_field( $params['course'] );

			// Check whether this course ID is valid.
			if ( Course::get_post_type_slug() !== get_post_type( $course_id ) ) {
				return [
					'status' => 500,
					'error'  => 'Invalid Course ID (no fiddling with the forms!)',
				];
			}

			// Add course to the parameters.
			$args['course'] = get_the_title( $course_id );
		}

		// Check if the request is for non-specific course.
		if ( isset( $params['language'], $params['is-online'] ) ) {
			// Get language name.
			$lang = (int) sanitize_text_field( $params['language'] );
			// Check whether 'language' parameter is a valid language.
			if ( ! term_exists( $lang, 'language' ) ) {
				return [
					'status' => 500,
					'error'  => 'Invalid Language (no fiddling with the forms!)',
				];
			}
			// Add language name to the parameters.
			$args['language'] = get_term( $lang, 'language' )->name;

			// Get 'course-type' parameters.
			$args['is-online'] = match ( sanitize_text_field( $params['is-online'] ) ) {
				'online'  => __( 'Онлайн', 'svitmov' ),
				'offline' => __( 'В центрі', 'svitmov' ),
				'mixed'   => __( 'Змішана', 'svitmov' ),
				default   => null,
			};
			// Check whether 'is-online' parameter is valid.
			if ( ! isset( $args['is-online'] ) ) {
				return [
					'status' => 500,
					'error'  => 'Invalid Course Type (no fiddling with the forms!)',
				];
			}
		}

		// Check if the request contains child-course specific information.
		if ( isset( $params['birth-date'], $params['guardian-name'] ) ) {
			// Get birthdate.
			$args['birth-date'] = sanitize_text_field( $params['birth-date'] );
			// Get guardian name.
			$args['guardian-name'] = sanitize_text_field( $params['guardian-name'] );
		}

		// Email the user who submitted form.
		Emails::get_instance()->send_email( $args['email'], 'book-user', [] );
		// Email admin about new booking request.
		Emails::get_instance()->send_email( get_bloginfo( 'admin_email' ), 'book-admin', $args );

		return [
			'status' => 200,
		];
	}

	/**
	 * Registers endpoints related to booking functionality.
	 */
	public function register_rest_routes(): void {
		register_rest_route(
			$this->api_namespace,
			'create-form',
			[
				[
					'methods'             => [ 'POST' ],
					'callback'            => [ $this, 'get_form_content' ],
					'permission_callback' => static fn ( \WP_REST_Request $request ) => wp_verify_nonce( $request->get_header( 'x_wp_nonce' ), 'wp_rest' ),
					'args'                => [
						'course' => [
							'type'     => 'string',
							'required' => false,
						]
					]
				],
			]
		);

		register_rest_route(
			$this->api_namespace,
			'submit',
			[
				[
					'methods'             => [ 'POST' ],
					'callback'            => [ $this, 'handle_booking_request' ],
					'permission_callback' => fn ( \WP_REST_Request $request ) => Helpers::is_callback_permitted( $request ),
					'args'                => [
						// Required arguments.
						'first-name'    => [
							'type'     => 'string',
							'required' => true,
						],
						'last-name'     => [
							'type'     => 'string',
							'required' => true,
						],
						'email'         => [
							'type'     => 'string',
							'required' => true,
						],
						'phone'         => [
							'type'     => 'string',
							'required' => true,
						],
						// Optional (specific course).
						'course'        => [
							'type'     => 'string',
							'required' => false,
						],
						// Optional (not-specific course).
						'language'      => [
							'type'     => 'string',
							'required' => false,
						],
						'is-online'     => [
							'type'     => 'string',
							'required' => false,
						],
						// Optional (for child courses).
						'birth-date'    => [
							'type'     => 'string',
							'required' => false,
						],
						'guardian-name' => [
							'type'     => 'string',
							'required' => false,
						],
					]
				],
			]
		);
	}
}
