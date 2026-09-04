<?php
/**
 * Homepage query helpers.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function gyad_homepage_featured_query() {
	if ( function_exists( 'gyad_get_discovery_posts' ) ) {
		$items = gyad_get_discovery_posts( 5, 'post' );
		if ( ! empty( $items ) ) {
			return $items;
		}
	}

	$query = new WP_Query( array(
		'post_type'              => 'post',
		'post_status'            => 'publish',
		'posts_per_page'         => 5,
		'ignore_sticky_posts'    => true,
		'no_found_rows'          => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => true,
	) );

	return $query->posts;
}

function gyad_homepage_latest_news( $limit = 6 ) {
	return new WP_Query( array(
		'post_type'              => 'post',
		'post_status'            => 'publish',
		'posts_per_page'         => absint( $limit ),
		'ignore_sticky_posts'    => true,
		'no_found_rows'          => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => true,
	) );
}

function gyad_homepage_content_counts() {
	$types  = array( 'admission', 'job', 'result', 'exam', 'scholarship', 'course' );
	$counts = array();

	foreach ( $types as $type ) {
		$published      = wp_count_posts( $type );
		$counts[ $type ] = isset( $published->publish ) ? (int) $published->publish : 0;
	}

	return $counts;
}

function gyad_homepage_quick_access_items() {
	$items = array(
		array( 'type' => 'admission',   'label' => 'Admissions',   'desc' => 'Universities & colleges', 'accent' => 'blue' ),
		array( 'type' => 'job',         'label' => 'Jobs',         'desc' => 'Latest vacancies',       'accent' => 'green' ),
		array( 'type' => 'result',      'label' => 'Results',      'desc' => 'Board & exam results',   'accent' => 'purple' ),
		array( 'type' => 'exam',        'label' => 'Exams',        'desc' => 'Schedules & papers',     'accent' => 'orange' ),
		array( 'type' => 'scholarship', 'label' => 'Scholarships', 'desc' => 'Funding opportunities',  'accent' => 'teal' ),
		array( 'type' => 'course',      'label' => 'Courses',      'desc' => 'Learning opportunities',  'accent' => 'blue' ),
	);

	foreach ( $items as &$item ) {
		$archive = get_post_type_archive_link( $item['type'] );
		$item['url'] = $archive ? $archive : home_url( '/' . $item['type'] . 's/' );
	}
	unset( $item );

	return $items;
}

function gyad_homepage_post_category( $post_id ) {
	$categories = get_the_category( $post_id );
	return ! empty( $categories ) ? $categories[0]->name : 'Education News';
}

function gyad_homepage_post_reading_time( $post_id ) {
	if ( function_exists( 'gyad_get_reading_time' ) ) {
		return gyad_get_reading_time( $post_id );
	}
	return 1;
}
