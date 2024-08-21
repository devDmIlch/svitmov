<?php
/**
 * Generic email wrapper template
 *
 * @package svitmov/theme
 * @since 0.0.2
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php echo esc_html( $args['title'] ?? get_bloginfo() ); ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> <?php // phpcs:ignore ?>
	<style>
		body {
			max-width: 600px;
			margin: auto;
			padding: 48px 20px;
		}

		.email-content {
			margin: 24px 0 12px;
			padding: 24px;
			background-color: #F4F5F7;
			border-radius: 30px;
		}

		.svitmov-logo {
			margin-left: 15px;
		}

		.svitmov-logo img {
			max-width: 200px;
		}

		h1 {
			font-size: 24px;
			font-weight: 600;
			font-family: 'Montserrat', serif;
		}

		p {
			font-size: 14px;
			font-weight: 500;
			font-family: 'Montserrat', serif;
		}

		a {
			text-decoration: none;
		}

		.copyright {
			margin-left: 30px;
			font-size: 12px;
			font-family: 'Montserrat', serif;
		}
	</style>
</head>
<body>
	<div class="svitmov-logo">
		<?php the_custom_logo(); ?>
	</div>
	<div class="email-content">
		<?php get_template_part( 'template-parts/emails/email', $args['type'] ?? null, $args ?? [] ); ?>
	</div>
	<div class="copyright">
		<a href="<?php echo esc_url( get_site_url() ); ?>">Svitmov</a>
		2024
	</div>
</body>
</html>
