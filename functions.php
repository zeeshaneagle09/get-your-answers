<?php
/**
 * Get Your Answers Daily
 *
 * Main theme bootstrap.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

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

foreach ( array( 'single.php', 'single-premium.php', 'single-navigation.php', 'article-author-source.php', 'article-status.php', 'article-type-intelligence.php', 'performance.php', 'recommendations.php', 'accessibility.php', 'related-intelligence.php' ) as $gyad_inc_file ) {
	if ( file_exists( GYAD_DIR . '/inc/' . $gyad_inc_file ) ) require_once GYAD_DIR . '/inc/' . $gyad_inc_file;
}

require_once GYAD_DIR . '/inc/theme-options.php';

foreach ( array( 'navigation.php', 'widgets.php', 'seo.php', 'seo-premium.php' ) as $gyad_optional_file ) {
	if ( file_exists( GYAD_DIR . '/inc/' . $gyad_optional_file ) ) require_once GYAD_DIR . '/inc/' . $gyad_optional_file;
}
