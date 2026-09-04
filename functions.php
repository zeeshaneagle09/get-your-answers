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

require_once GYAD_DIR . '/inc/setup.php';
require_once GYAD_DIR . '/inc/theme-core.php';
require_once GYAD_DIR . '/inc/enqueue.php';
require_once GYAD_DIR . '/inc/template-functions.php';
require_once GYAD_DIR . '/inc/helpers.php';
require_once GYAD_DIR . '/inc/post-types.php';
require_once GYAD_DIR . '/inc/taxonomies.php';
require_once GYAD_DIR . '/inc/meta-fields.php';
require_once GYAD_DIR . '/inc/homepage.php';
require_once GYAD_DIR . '/inc/queries.php';
require_once GYAD_DIR . '/inc/search.php';

if ( file_exists( GYAD_DIR . '/inc/single.php' ) ) {
	require_once GYAD_DIR . '/inc/single.php';
}
if ( file_exists( GYAD_DIR . '/inc/single-premium.php' ) ) {
	require_once GYAD_DIR . '/inc/single-premium.php';
}
if ( file_exists( GYAD_DIR . '/inc/single-navigation.php' ) ) {
	require_once GYAD_DIR . '/inc/single-navigation.php';
}
if ( file_exists( GYAD_DIR . '/inc/performance.php' ) ) {
	require_once GYAD_DIR . '/inc/performance.php';
}
if ( file_exists( GYAD_DIR . '/inc/recommendations.php' ) ) {
	require_once GYAD_DIR . '/inc/recommendations.php';
}
if ( file_exists( GYAD_DIR . '/inc/accessibility.php' ) ) {
	require_once GYAD_DIR . '/inc/accessibility.php';
}

require_once GYAD_DIR . '/inc/theme-options.php';

if ( file_exists( GYAD_DIR . '/inc/navigation.php' ) ) {
	require_once GYAD_DIR . '/inc/navigation.php';
}
if ( file_exists( GYAD_DIR . '/inc/widgets.php' ) ) {
	require_once GYAD_DIR . '/inc/widgets.php';
}
if ( file_exists( GYAD_DIR . '/inc/seo.php' ) ) {
	require_once GYAD_DIR . '/inc/seo.php';
}
if ( file_exists( GYAD_DIR . '/inc/seo-premium.php' ) ) {
	require_once GYAD_DIR . '/inc/seo-premium.php';
}
