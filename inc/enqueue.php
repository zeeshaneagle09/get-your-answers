<?php
/**
 * Enqueue theme assets.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Get an asset version based on modification time.
 *
 * @param string $relative_path Relative theme path.
 * @return string
 */
function gyad_asset_version( $relative_path ) {

	$file = GYAD_DIR . '/' . ltrim(
		$relative_path,
		'/'
	);

	if ( file_exists( $file ) ) {
		return (string) filemtime( $file );
	}

	return GYAD_VERSION;
}


/**
 * Enqueue theme assets.
 *
 * @return void
 */
function gyad_enqueue_assets() {

	/*
	|--------------------------------------------------------------------------
	| Core CSS
	|--------------------------------------------------------------------------
	*/

	wp_enqueue_style(
		'gyad-reset',
		GYAD_URI . '/assets/css/reset.css',
		array(),
		gyad_asset_version(
			'assets/css/reset.css'
		)
	);

	wp_enqueue_style(
		'gyad-variables',
		GYAD_URI . '/assets/css/variables.css',
		array( 'gyad-reset' ),
		gyad_asset_version(
			'assets/css/variables.css'
		)
	);

	wp_enqueue_style(
		'gyad-base',
		GYAD_URI . '/assets/css/base.css',
		array( 'gyad-variables' ),
		gyad_asset_version(
			'assets/css/base.css'
		)
	);

	wp_enqueue_style(
		'gyad-typography',
		GYAD_URI . '/assets/css/typography.css',
		array( 'gyad-base' ),
		gyad_asset_version(
			'assets/css/typography.css'
		)
	);

	wp_enqueue_style(
		'gyad-layout',
		GYAD_URI . '/assets/css/layout.css',
		array( 'gyad-typography' ),
		gyad_asset_version(
			'assets/css/layout.css'
		)
	);

	wp_enqueue_style(
		'gyad-components',
		GYAD_URI . '/assets/css/components.css',
		array( 'gyad-layout' ),
		gyad_asset_version(
			'assets/css/components.css'
		)
	);

	wp_enqueue_style(
		'gyad-accessibility',
		GYAD_URI . '/assets/css/accessibility.css',
		array( 'gyad-components' ),
		gyad_asset_version(
			'assets/css/accessibility.css'
		)
	);

	wp_enqueue_style(
		'gyad-header',
		GYAD_URI . '/assets/css/header.css',
		array( 'gyad-accessibility' ),
		gyad_asset_version(
			'assets/css/header.css'
		)
	);

	wp_enqueue_style(
		'gyad-navigation',
		GYAD_URI . '/assets/css/navigation.css',
		array( 'gyad-header' ),
		gyad_asset_version(
			'assets/css/navigation.css'
		)
	);

	wp_enqueue_style(
		'gyad-cards',
		GYAD_URI . '/assets/css/cards.css',
		array( 'gyad-components' ),
		gyad_asset_version(
			'assets/css/cards.css'
		)
	);

	wp_enqueue_style(
		'gyad-sections',
		GYAD_URI . '/assets/css/sections.css',
		array( 'gyad-cards' ),
		gyad_asset_version(
			'assets/css/sections.css'
		)
	);

	wp_enqueue_style(
		'gyad-sidebar',
		GYAD_URI . '/assets/css/sidebar.css',
		array( 'gyad-sections' ),
		gyad_asset_version(
			'assets/css/sidebar.css'
		)
	);

	wp_enqueue_style(
		'gyad-footer',
		GYAD_URI . '/assets/css/footer.css',
		array( 'gyad-sidebar' ),
		gyad_asset_version(
			'assets/css/footer.css'
		)
	);

	wp_enqueue_style(
		'gyad-responsive',
		GYAD_URI . '/assets/css/responsive.css',
		array( 'gyad-footer' ),
		gyad_asset_version(
			'assets/css/responsive.css'
		)
	);

	wp_enqueue_style(
		'gyad-utilities',
		GYAD_URI . '/assets/css/utilities.css',
		array( 'gyad-responsive' ),
		gyad_asset_version(
			'assets/css/utilities.css'
		)
	);

	if ( is_front_page() ) {

	wp_enqueue_style(
		'gyad-homepage',
		GYAD_URI . '/assets/css/homepage.css',
		array( 'gyad-utilities' ),
		gyad_asset_version(
			'assets/css/homepage.css'
		)
	);
}


	/*
	|--------------------------------------------------------------------------
	| Single article CSS
	|--------------------------------------------------------------------------
	*/

	if ( is_singular() ) {

		wp_enqueue_style(
			'gyad-single',
			GYAD_URI . '/assets/css/single.css',
			array( 'gyad-utilities' ),
			gyad_asset_version(
				'assets/css/single.css'
			)
		);
	}


	/*
	|--------------------------------------------------------------------------
	| Global JS
	|--------------------------------------------------------------------------
	*/

	wp_enqueue_script(
		'gyad-navigation',
		GYAD_URI . '/assets/js/navigation.js',
		array(),
		gyad_asset_version(
			'assets/js/navigation.js'
		),
		true
	);

	wp_enqueue_script(
		'gyad-mobile-menu',
		GYAD_URI . '/assets/js/mobile-menu.js',
		array(),
		gyad_asset_version(
			'assets/js/mobile-menu.js'
		),
		true
	);


	/*
	|--------------------------------------------------------------------------
	| Search JS
	|--------------------------------------------------------------------------
	*/

	if (
		is_search() ||
		is_front_page() ||
		is_post_type_archive()
	) {

		wp_enqueue_script(
			'gyad-search',
			GYAD_URI . '/assets/js/search.js',
			array(),
			gyad_asset_version(
				'assets/js/search.js'
			),
			true
		);
	}


	/*
	|--------------------------------------------------------------------------
	| Single JS
	|--------------------------------------------------------------------------
	*/

	if ( is_singular() ) {

		wp_enqueue_script(
			'gyad-single',
			GYAD_URI . '/assets/js/single.js',
			array(),
			gyad_asset_version(
				'assets/js/single.js'
			),
			true
		);
	}


	/*
	|--------------------------------------------------------------------------
	| Main JS
	|--------------------------------------------------------------------------
	*/

	wp_enqueue_script(
		'gyad-main',
		GYAD_URI . '/assets/js/main.js',
		array(),
		gyad_asset_version(
			'assets/js/main.js'
		),
		true
	);
}

add_action(
	'wp_enqueue_scripts',
	'gyad_enqueue_assets'
);


/**
 * Defer theme scripts.
 *
 * @param string $tag Script tag.
 * @param string $handle Script handle.
 * @param string $src Script URL.
 * @return string
 */
function gyad_defer_theme_scripts(
	$tag,
	$handle,
	$src
) {

	$defer_scripts = array(
		'gyad-navigation',
		'gyad-mobile-menu',
		'gyad-search',
		'gyad-single',
		'gyad-main',
	);

	if (
		! in_array(
			$handle,
			$defer_scripts,
			true
		)
	) {
		return $tag;
	}

	return sprintf(
		'<script src="%s" defer></script>',
		esc_url( $src )
	);
}

add_filter(
	'script_loader_tag',
	'gyad_defer_theme_scripts',
	10,
	3
);


/**
 * Resource hints.
 *
 * @param array  $urls Resource URLs.
 * @param string $relation_type Relation type.
 * @return array
 */
function gyad_resource_hints(
	$urls,
	$relation_type
) {

	/*
	 * Deliberately no external preconnects.
	 * The theme currently has no mandatory external
	 * asset provider that needs one.
	 */

	return $urls;
}

add_filter(
	'wp_resource_hints',
	'gyad_resource_hints',
	10,
	2
);