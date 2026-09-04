<?php
/**
 * Accessibility helpers.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add useful accessibility attributes to navigation links.
 *
 * @param string $output Menu HTML.
 * @param object $args Menu arguments.
 * @return string
 */
function gyad_accessible_menu_output( $output, $args ) {
	if ( empty( $output ) ) {
		return $output;
	}

	$output = preg_replace_callback(
		'/<a([^>]+)>/i',
		function ( $matches ) {
			$attrs = $matches[1];
			if ( false !== stripos( $attrs, 'aria-label=' ) ) {
				return $matches[0];
			}
			return '<a' . $attrs . '>';
		},
		$output
	);

	return $output;
}
add_filter( 'wp_nav_menu', 'gyad_accessible_menu_output', 10, 2 );

/**
 * Add a useful body class when JavaScript is available.
 *
 * @param array $classes Body classes.
 * @return array
 */
function gyad_accessibility_body_class( $classes ) {
	$classes[] = 'gyad-accessibility-ready';
	return $classes;
}
add_filter( 'body_class', 'gyad_accessibility_body_class' );

/**
 * Remove the title attribute from post thumbnails when alt text is present.
 *
 * @param array $attr Image attributes.
 * @return array
 */
function gyad_accessibility_image_attributes( $attr ) {
	if ( ! empty( $attr['alt'] ) && isset( $attr['title'] ) ) {
		unset( $attr['title'] );
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'gyad_accessibility_image_attributes', 20 );
