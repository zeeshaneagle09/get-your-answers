<?php
/**
 * Lightweight recommendation and most-read system.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get the most-read posts for a content type.
 *
 * @param int    $limit Number of posts.
 * @param string $post_type Post type.
 * @param int    $exclude Post ID to exclude.
 * @return WP_Post[]
 */
function gyad_get_most_read( $limit = 5, $post_type = '', $exclude = 0 ) {
	$args = array(
		'post_type'           => $post_type ? $post_type : get_post_types( array( 'public' => true ), 'names' ),
		'post_status'         => 'publish',
		'posts_per_page'      => max( 1, (int) $limit ),
		'orderby'             => 'meta_value_num',
		'order'               => 'DESC',
		'meta_key'            => '_gyad_views',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	if ( $exclude ) {
		$args['post__not_in'] = array( (int) $exclude );
	}

	return get_posts( $args );
}

/**
 * Get fallback discovery posts when no view data exists yet.
 *
 * @param int    $limit Number of posts.
 * @param string $post_type Post type.
 * @param int    $exclude Post ID to exclude.
 * @return WP_Post[]
 */
function gyad_get_popular_fallback( $limit = 5, $post_type = '', $exclude = 0 ) {
	$args = array(
		'post_type'           => $post_type ? $post_type : 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => max( 1, (int) $limit ),
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	if ( $exclude ) {
		$args['post__not_in'] = array( (int) $exclude );
	}

	return get_posts( $args );
}

/**
 * Return a useful most-read list with a fresh-content fallback.
 *
 * @param int    $limit Number of posts.
 * @param string $post_type Post type.
 * @param int    $exclude Post ID to exclude.
 * @return WP_Post[]
 */
function gyad_get_discovery_posts( $limit = 5, $post_type = '', $exclude = 0 ) {
	$items = gyad_get_most_read( $limit, $post_type, $exclude );

	$has_views = false;
	foreach ( $items as $item ) {
		if ( function_exists( 'gyad_get_post_views' ) && gyad_get_post_views( $item ) > 0 ) {
			$has_views = true;
			break;
		}
	}

	if ( $has_views ) {
		return $items;
	}

	return gyad_get_popular_fallback( $limit, $post_type, $exclude );
}
