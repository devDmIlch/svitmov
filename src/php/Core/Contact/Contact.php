<?php
/**
 * Contact requests handler class file
 *
 * @package svitmov/theme
 * @since 0.0.3
 */

namespace Svitmov\Core\Contact;

use Svitmov\Includes\Helpers;
use Svitmov\Theme\Emails;

/**
 * Booking requests handler
 */
class Contact {

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
		$this->api_namespace = 'svitmov/contact';

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
	 * Handles POST booking form submission request.
	 *
	 * @param \WP_REST_Request $request Request data.
	 *
	 * @return array Request response.
	 */
	public function handle_contact_request( \WP_REST_Request $request ): array {
		// Get parameters from request.
		$params = $request->get_params();

		// Prepare array for the arguments.
		$args = [];
		// Populate arguments with data from request.
		foreach ( [ 'name', 'email', 'phone', 'question' ] as $field ) {
			switch ( $field ) {
				case 'email':
					$value = sanitize_email( $params[ $field ] );
					break;
				default:
					$value = sanitize_text_field( $params[ $field ] );
					break;
			}
			// Add value to the arguments array.
			$args[ $field ] = $value;
		}

		// Email admin about new contact form submission.
		Emails::get_instance()->send_email( get_bloginfo( 'admin_email' ), 'contact', $args );

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
			'submit',
			[
				[
					'methods'             => [ 'POST' ],
					'callback'            => [ $this, 'handle_contact_request' ],
					'permission_callback' => fn ( \WP_REST_Request $request ) => Helpers::is_callback_permitted( $request ),
					'args'                => [
						// Required arguments.
						'name'     => [
							'type'     => 'string',
							'required' => true,
						],
						'email'    => [
							'type'     => 'string',
							'required' => true,
						],
						'phone'    => [
							'type'     => 'string',
							'required' => true,
						],
						'question' => [
							'type'     => 'string',
							'required' => true,
						],
					]
				],
			]
		);
	}
}
