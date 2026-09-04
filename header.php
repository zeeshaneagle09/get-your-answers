<?php
/**
 * Theme header.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<!doctype html>

<html <?php language_attributes(); ?>>

<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<meta
		name="viewport"
		content="width=device-width, initial-scale=1"
	>

	<meta
		name="theme-color"
		content="#071B3A"
	>

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<a
	class="skip-link"
	href="#content-start"
>
	<?php esc_html_e( 'Skip to content', 'get-your-answers-daily' ); ?>
</a>


<div id="page" class="site">

	<header class="site-header">

		<?php
		get_template_part(
			'template-parts/header/topbar'
		);

		get_template_part(
			'template-parts/header/branding'
		);

		get_template_part(
			'template-parts/navigation/main-nav'
		);
		?>

	</header>


	<main
		id="primary"
		class="site-main"
		tabindex="-1"
	>