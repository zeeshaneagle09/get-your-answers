<?php
/**
 * Lightweight performance helpers.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Remove unnecessary front-end WordPress assets.
 *
 * @return void
 */
function gyad_remove_unneeded_frontend_assets() {
	if ( is_admin() ) {
		return;
	}

	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'classic-theme-styles' );
	wp_dequeue_style( 'global-styles' );
}
add_action( 'wp_enqueue_scripts', 'gyad_remove_unneeded_frontend_assets', 100 );

/**
 * Add native lazy loading to non-critical images while leaving the first
 * content image under theme control.
 *
 * @param array  $attr       Image attributes.
 * @param WP_Post $attachment Attachment object.
 * @return array
 */
function gyad_optimize_image_attributes( $attr, $attachment ) {
	if ( ! is_admin() && empty( $attr['loading'] ) ) {
		$attr['loading'] = 'lazy';
	}

	if ( empty( $attr['decoding'] ) ) {
		$attr['decoding'] = 'async';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'gyad_optimize_image_attributes', 10, 2 );

/**
 * Add fetchpriority to the main singular featured image when WordPress has
 * not already assigned one.
 *
 * @param string $html Image HTML.
 * @param int    $post_id Post ID.
 * @param int    $post_thumbnail_id Thumbnail attachment ID.
 * @param string $size Image size.
 * @return string
 */
function gyad_optimize_post_thumbnail_html( $html, $post_id, $post_thumbnail_id, $size ) {
	if ( ! is_singular() || ! in_the_loop() || ! is_main_query() || ! $html ) {
		return $html;
	}

	if ( false !== strpos( $html, 'fetchpriority=' ) ) {
		return $html;
	}

	return preg_replace(
		'/<img\b/i',
		'<img fetchpriority="high"',
		$html,
		1
	);
}
add_filter( 'post_thumbnail_html', 'gyad_optimize_post_thumbnail_html', 10, 4 );

/**
 * Add a short resource hint set without adding third-party connections.
 *
 * @param array  $urls          Resource hints.
 * @param string $relation_type Relation type.
 * @return array
 */
function gyad_resource_hints( $urls, $relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		return $urls;
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'gyad_resource_hints', 10, 2 );

/**
 * Prevent WordPress from emitting emoji assets when not required by the theme.
 *
 * @return void
 */
function gyad_disable_emoji_assets() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'gyad_disable_emoji_assets' );
