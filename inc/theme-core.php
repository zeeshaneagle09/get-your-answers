<?php
/**
 * Theme core functionality.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Theme name.
 *
 * @return string
 */
function gyad_theme_name() {

	return 'Get Your Answers Daily';
}


/**
 * Theme description.
 *
 * @return string
 */
function gyad_theme_description() {

	return 'A lightweight education information portal theme for admissions, jobs, results, exams, scholarships, courses and education news.';
}


/**
 * Get the current theme slug.
 *
 * @return string
 */
function gyad_theme_slug() {

	return 'get-your-answers-daily';
}


/**
 * Add useful body classes.
 *
 * @param array $classes Existing body classes.
 * @return array
 */
function gyad_core_body_classes( $classes ) {

	$classes[] = 'gyad-theme';

	if ( is_front_page() ) {
		$classes[] = 'is-front-page';
	}

	if ( is_home() ) {
		$classes[] = 'is-blog-page';
	}

	if ( is_archive() ) {
		$classes[] = 'is-archive-page';
	}

	if ( is_search() ) {
		$classes[] = 'is-search-page';
	}

	if ( is_singular() ) {
		$classes[] = 'is-singular-page';
	}

	if ( is_page() ) {
		$classes[] = 'is-standard-page';
	}

	if ( wp_is_mobile() ) {
		$classes[] = 'is-mobile-device';
	}

	return $classes;
}

add_filter(
	'body_class',
	'gyad_core_body_classes'
);


/**
 * Add a custom document language class.
 *
 * @param string $output Body class string.
 * @return string
 */
function gyad_html_class( $output ) {

	return $output;
}


/**
 * Keep WordPress excerpt generation clean.
 *
 * @param string $more More marker.
 * @return string
 */
function gyad_excerpt_more( $more ) {

	return '…';
}

add_filter(
	'excerpt_more',
	'gyad_excerpt_more'
);


/**
 * Set a sensible excerpt length.
 *
 * @param int $length Existing length.
 * @return int
 */
function gyad_excerpt_length( $length ) {

	return 24;
}

add_filter(
	'excerpt_length',
	'gyad_excerpt_length',
	20
);


/**
 * Add a skip-link target to the primary content.
 *
 * @return void
 */
function gyad_skip_link_target() {

	if ( ! is_admin() ) {
		echo '<span id="content-start" class="gyad-skip-target"></span>';
	}
}

add_action(
	'wp_body_open',
	'gyad_skip_link_target',
	1
);


/**
 * Add useful image attributes where WordPress does not already provide them.
 *
 * @param array $attr Image attributes.
 * @param WP_Post $attachment Attachment.
 * @param string|int[] $size Requested size.
 * @return array
 */
function gyad_image_attributes( $attr, $attachment, $size ) {

	if ( empty( $attr['decoding'] ) ) {
		$attr['decoding'] = 'async';
	}

	return $attr;
}

add_filter(
	'wp_get_attachment_image_attributes',
	'gyad_image_attributes',
	10,
	3
);


/**
 * Remove the WordPress emoji assets.
 *
 * These are unnecessary for this theme unless explicitly needed.
 *
 * @return void
 */
function gyad_disable_emoji_assets() {

	remove_action(
		'wp_head',
		'print_emoji_detection_script',
		7
	);

	remove_action(
		'admin_print_scripts',
		'print_emoji_detection_script'
	);

	remove_action(
		'wp_print_styles',
		'print_emoji_styles'
	);

	remove_action(
		'admin_print_styles',
		'print_emoji_styles'
	);

	remove_filter(
		'the_content_feed',
		'wp_staticize_emoji'
	);

	remove_filter(
		'comment_text_rss',
		'wp_staticize_emoji'
	);

	remove_filter(
		'wp_mail',
		'wp_staticize_emoji_for_email'
	);
}

add_action(
	'init',
	'gyad_disable_emoji_assets'
);


/**
 * Remove unnecessary WordPress head information.
 *
 * @return void
 */
function gyad_clean_wp_head() {

	remove_action(
		'wp_head',
		'rsd_link'
	);

	remove_action(
		'wp_head',
		'wlwmanifest_link'
	);

	remove_action(
		'wp_head',
		'wp_generator'
	);

	remove_action(
		'wp_head',
		'rest_output_link_wp_head'
	);

	remove_action(
		'wp_head',
		'wp_shortlink_wp_head'
	);
}

add_action(
	'after_setup_theme',
	'gyad_clean_wp_head'
);


/**
 * Disable WordPress embeds discovery script on the frontend.
 *
 * We still allow normal iframe embeds.
 *
 * @return void
 */
function gyad_disable_embed_discovery() {

	if ( ! is_admin() ) {

		wp_deregister_script(
			'wp-embed'
		);
	}
}

add_action(
	'wp_footer',
	'gyad_disable_embed_discovery',
	1
);


/**
 * Add a theme-specific script class to the root body.
 *
 * @return void
 */
function gyad_core_body_class_fallback() {

	echo '';
}
