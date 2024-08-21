<?php
/**
 * Email controller class file.
 *
 * @package svitmov/theme
 * @since 0.0.2
 */

namespace Svitmov\Theme;

use Svitmov\Includes\Helpers;

/**
 * Email controller class
 */
final class Emails {

	// Private fields.

	/**
	 * Singleton instance field.
	 *
	 * @var Emails $instance.
	 */
	private static Emails $instance;


	// Public Properties.

	/**
	 * Returns singleton instance of the Emails class.
	 */
	public static function get_instance(): Emails {
		// Check whether singleton is initialized.
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	// Initialization Methods.

	/**
	 * Privatize construction method to ensure it's not called outside the class.
	 */
	private function __construct() {}


	// Public Methods.

	/**
	 * Sends an email based on parameters supplied to the method.
	 *
	 * @param string $recipient Email of the recipient.
	 * @param string $type      Internal type of email (book-user|book-admin).
	 * @param array  $data      Data to populate content of the email.
	 *
	 * @return bool Whether the email was sent successfully.
	 */
	public function send_email( string $recipient, string $type, array $data ): bool {
		// Prepare headers for the email.
		$email_headers = [ 'Content-Type: text/html; charset=UTF-8' ];
		// Get proper subject for the email.
		$subject = match ( $type ) {
			'book-user'  => __( 'Заявка на курс у SvitMov', 'svitmov' ),
			'book-admin' => __( 'Нова заявка на курс', 'svitmov' ),
			'contact'    => __( 'Нове запитання з форми', 'svitmov' ),
		};
		// Push email type into data array.
		$data['type'] = $type;
		// Attempt to send an email.
		return wp_mail(
			[ $recipient ],
			$subject,
			Helpers::echo_to_string( static function () use ( $type, $data ) { get_template_part( 'template-parts/emails/email', 'template', args: $data ); } ),
			$email_headers,
		);
	}
}
