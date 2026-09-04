<?php
/**
 * Homepage query helpers.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Get the homepage featured stories.
 *
 * The first published Education News post is the lead story.
 * The following four become supporting stories.
 *
 * @return array
 */
function gyad_homepage_featured_query() {

	$query = new WP_Query(
		array(
			'post_type'              => 'post',
			'post_status'            => 'publish',
			'posts_per_page'         => 5,
			'ignore_sticky_posts'    => true,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => true,
		)
	);

	return $query->posts;
}


/**
 * Get homepage latest education news.
 *
 * @param int $limit Number of posts.
 * @return WP_Query
 */
function gyad_homepage_latest_news( $limit = 6 ) {

	return new WP_Query(
		array(
			'post_type'              => 'post',
			'post_status'            => 'publish',
			'posts_per_page'         => absint( $limit ),
			'ignore_sticky_posts'    => true,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => true,
		)
	);
}


/**
 * Get homepage content counts.
 *
 * @return array
 */
function gyad_homepage_content_counts() {

	$types = array(
		'admission',
		'job',
		'result',
		'exam',
		'scholarship',
		'course',
	);

	$counts = array();

	foreach ( $types as $type ) {

		$counts[ $type ] = wp_count_posts( $type );

		$counts[ $type ] = isset(
			$counts[ $type ]->publish
		)
			? (int) $counts[ $type ]->publish
			: 0;
	}

	return $counts;
}


/**
 * Get homepage quick-access configuration.
 *
 * @return array
 */
function gyad_homepage_quick_access_items() {

	return array(

		array(
			'type'    => 'admission',
			'label'   => 'Admissions',
			'short'   => 'Admissions',
			'desc'    => 'Universities & colleges',
			'url'     => home_url( '/admissions/' ),
			'accent'  => 'blue',
			'icon'    => 'arrow-right',
		),

		array(
			'type'    => 'job',
			'label'   => 'Jobs',
			'short'   => 'Jobs',
			'desc'    => 'Latest vacancies',
			'url'     => home_url( '/jobs/' ),
			'accent'  => 'green',
			'icon'    => 'arrow-right',
		),

		array(
			'type'    => 'result',
			'label'   => 'Results',
			'short'   => 'Results',
			'desc'    => 'Board & exam results',
			'url'     => home_url( '/results/' ),
			'accent'  => 'purple',
			'icon'    => 'arrow-right',
		),

		array(
			'type'    => 'exam',
			'label'   => 'Exams',
			'short'   => 'Exams',
			'desc'    => 'Schedules & papers',
			'url'     => home_url( '/exams/' ),
			'accent'  => 'orange',
			'icon'    => 'arrow-right',
		),

		array(
			'type'    => 'scholarship',
			'label'   => 'Scholarships',
			'short'   => 'Scholarships',
			'desc'    => 'Funding opportunities',
			'url'     => home_url( '/scholarships/' ),
			'accent'  => 'teal',
			'icon'    => 'arrow-right',
		),

		array(
			'type'    => 'course',
			'label'   => 'Courses',
			'short'   => 'Courses',
			'desc'    => 'Learning opportunities',
			'url'     => home_url( '/courses/' ),
			'accent'  => 'blue',
			'icon'    => 'arrow-right',
		),
	);
}


/**
 * Get homepage category label.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function gyad_homepage_post_category( $post_id ) {

	$categories = get_the_category( $post_id );

	if ( ! empty( $categories ) ) {
		return $categories[0]->name;
	}

	return 'Education News';
}


/**
 * Get homepage post reading time.
 *
 * @param int $post_id Post ID.
 * @return int
 */
function gyad_homepage_post_reading_time( $post_id ) {

	if ( function_exists( 'gyad_get_reading_time' ) ) {

		return gyad_get_reading_time(
			$post_id
		);
	}

	return 1;
}