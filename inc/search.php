<?php
/**
 * Search helpers.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/* =========================================================
   SEARCH QUERY VARIABLES
   ========================================================= */

/**
 * Register custom query variables.
 *
 * These are used by archive filters and the global
 * search content-type selector.
 *
 * @param array $vars Existing query variables.
 * @return array
 */
function gyad_register_query_vars( $vars ) {

	$vars[] = 'admission_type';
	$vars[] = 'job_type';
	$vars[] = 'result_board';
	$vars[] = 'exam_type';
	$vars[] = 'scholarship_type';
	$vars[] = 'course_category';
	$vars[] = 'content_type';

	return $vars;
}

add_filter(
	'query_vars',
	'gyad_register_query_vars'
);


/* =========================================================
   SEARCH CONTENT TYPES
   ========================================================= */

/**
 * Get supported global search content types.
 *
 * @return array
 */
function gyad_search_content_types() {

	return array(
		''            => 'All Categories',
		'post'        => 'Education News',
		'admission'   => 'Admissions',
		'job'         => 'Jobs',
		'result'      => 'Results',
		'exam'        => 'Exams',
		'scholarship' => 'Scholarships',
		'course'      => 'Courses',
	);
}


/**
 * Get selected global search content type.
 *
 * @return string
 */
function gyad_get_selected_content_type() {

	if ( isset( $_GET['content_type'] ) ) {

		return sanitize_key(
			wp_unslash(
				$_GET['content_type']
			)
		);
	}

	$query_value = get_query_var(
		'content_type'
	);

	return $query_value
		? sanitize_key( $query_value )
		: '';
}