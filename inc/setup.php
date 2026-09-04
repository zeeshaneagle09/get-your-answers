<?php
/**
 * Theme setup.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Theme setup.
 *
 * @return void
 */
function gyad_theme_setup() {

	load_theme_textdomain(
		'get-your-answers-daily',
		GYAD_DIR . '/languages'
	);


	/*
	|--------------------------------------------------------------------------
	| Document title
	|--------------------------------------------------------------------------
	*/

	add_theme_support(
		'title-tag'
	);


	/*
	|--------------------------------------------------------------------------
	| Featured images
	|--------------------------------------------------------------------------
	*/

	add_theme_support(
		'post-thumbnails'
	);


	/*
	|--------------------------------------------------------------------------
	| Custom logo
	|--------------------------------------------------------------------------
	*/

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 280,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);


	/*
	|--------------------------------------------------------------------------
	| HTML5
	|--------------------------------------------------------------------------
	*/

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
		)
	);


	/*
	|--------------------------------------------------------------------------
	| Responsive embeds
	|--------------------------------------------------------------------------
	*/

	add_theme_support(
		'responsive-embeds'
	);


	/*
	|--------------------------------------------------------------------------
	| Editor styles
	|--------------------------------------------------------------------------
	*/

	add_theme_support(
		'editor-styles'
	);

	add_editor_style(
		'assets/css/editor.css'
	);


	/*
	|--------------------------------------------------------------------------
	| Gutenberg wide / full support
	|--------------------------------------------------------------------------
	*/

	add_theme_support(
		'align-wide'
	);


	/*
	|--------------------------------------------------------------------------
	| Feed links
	|--------------------------------------------------------------------------
	*/

	add_theme_support(
		'automatic-feed-links'
	);


	/*
	|--------------------------------------------------------------------------
	| Navigation menus
	|--------------------------------------------------------------------------
	*/

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'get-your-answers-daily' ),
			'footer'  => __( 'Footer Menu', 'get-your-answers-daily' ),
		)
	);


	/*
	|--------------------------------------------------------------------------
	| Custom image sizes
	|--------------------------------------------------------------------------
	*/

	add_image_size(
		'gyad-card',
		640,
		360,
		true
	);

	add_image_size(
		'gyad-card-small',
		480,
		270,
		true
	);

	add_image_size(
		'gyad-archive',
		900,
		506,
		true
	);

	add_image_size(
		'gyad-single',
		1400,
		788,
		true
	);
}

add_action(
	'after_setup_theme',
	'gyad_theme_setup'
);


/**
 * Set content width.
 *
 * @return void
 */
function gyad_content_width() {

	$GLOBALS['content_width'] = 760;
}

add_action(
	'after_setup_theme',
	'gyad_content_width',
	0
);


/**
 * Add editor stylesheet only when available.
 *
 * @return void
 */
function gyad_editor_styles_fallback() {

	if (
		is_admin() &&
		current_user_can( 'edit_posts' )
	) {
		return;
	}
}