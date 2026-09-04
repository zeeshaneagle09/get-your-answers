<?php
/**
 * Get Your Answers Daily
 *
 * Main theme bootstrap.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GYAD_VERSION', '1.0.0' );
define( 'GYAD_DIR', get_template_directory() );
define( 'GYAD_URI', get_template_directory_uri() );

/* Core theme */
require_once GYAD_DIR . '/inc/setup.php';
require_once GYAD_DIR . '/inc/theme-core.php';

/* Frontend assets */
require_once GYAD_DIR . '/inc/enqueue.php';

/* Template / utility helpers */
require_once GYAD_DIR . '/inc/template-functions.php';
require_once GYAD_DIR . '/inc/helpers.php';

/* Content architecture */
require_once GYAD_DIR . '/inc/post-types.php';
require_once GYAD_DIR . '/inc/taxonomies.php';
require_once GYAD_DIR . '/inc/meta-fields.php';
require_once GYAD_DIR . '/inc/homepage.php';

/* Query / search */
require_once GYAD_DIR . '/inc/queries.php';
require_once GYAD_DIR . '/inc/search.php';

/* Single article system */
if ( file_exists( GYAD_DIR . '/inc/single.php' ) ) {
	require_once GYAD_DIR . '/inc/single.php';
}
if ( file_exists( GYAD_DIR . '/inc/single-premium.php' ) ) {
	require_once GYAD_DIR . '/inc/single-premium.php';
}

/* Theme settings */
require_once GYAD_DIR . '/inc/theme-options.php';

/* Optional modules */
if ( file_exists( GYAD_DIR . '/inc/navigation.php' ) ) {
	require_once GYAD_DIR . '/inc/navigation.php';
}
if ( file_exists( GYAD_DIR . '/inc/widgets.php' ) ) {
	require_once GYAD_DIR . '/inc/widgets.php';
}
if ( file_exists( GYAD_DIR . '/inc/seo.php' ) ) {
	require_once GYAD_DIR . '/inc/seo.php';
}