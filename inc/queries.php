<?php
/**
 * Theme query helpers.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function gyad_get_archive_query_config( $post_type = '' ) {
	$post_type = $post_type ? $post_type : get_post_type();
	$config = array(
		'admission' => array( 'title' => 'Admissions', 'description' => 'Latest university and college admissions, application information and opportunities.', 'taxonomy' => 'admission_type', 'tax_label' => 'Admission Type', 'accent' => 'blue', 'sort_meta' => '' ),
		'job' => array( 'title' => 'Jobs', 'description' => 'Latest government, private and education-related jobs and vacancies.', 'taxonomy' => 'job_type', 'tax_label' => 'Job Type', 'accent' => 'green', 'sort_meta' => 'application_deadline' ),
		'result' => array( 'title' => 'Results', 'description' => 'Latest examination results, board results and result updates.', 'taxonomy' => 'result_board', 'tax_label' => 'Board', 'accent' => 'purple', 'sort_meta' => 'result_date' ),
		'exam' => array( 'title' => 'Exams', 'description' => 'Exam schedules, date sheets, past papers, roll number slips and test updates.', 'taxonomy' => 'exam_type', 'tax_label' => 'Exam Type', 'accent' => 'orange', 'sort_meta' => 'exam_date' ),
		'scholarship' => array( 'title' => 'Scholarships', 'description' => 'Scholarship opportunities, eligibility details and application updates.', 'taxonomy' => 'scholarship_type', 'tax_label' => 'Scholarship Type', 'accent' => 'teal', 'sort_meta' => 'application_deadline' ),
		'course' => array( 'title' => 'Courses', 'description' => 'Explore courses, learning opportunities and useful educational resources.', 'taxonomy' => 'course_category', 'tax_label' => 'Course Category', 'accent' => 'blue', 'sort_meta' => '' ),
	);
	return isset( $config[ $post_type ] ) ? $config[ $post_type ] : array();
}

function gyad_configure_archive_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive() ) {
		return;
	}
	$post_type = get_query_var( 'post_type' );
	if ( ! is_string( $post_type ) || ! $post_type ) {
		return;
	}
	$config = gyad_get_archive_query_config( $post_type );
	if ( empty( $config ) ) {
		return;
	}

	$query->set( 'posts_per_page', 12 );
	$query->set( 'ignore_sticky_posts', true );
	$query->set( 'no_found_rows', false );
	$query->set( 'update_post_meta_cache', true );
	$query->set( 'update_post_term_cache', true );

	$search = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';
	if ( $search ) {
		$query->set( 's', $search );
	}

	$taxonomy = ! empty( $config['taxonomy'] ) ? $config['taxonomy'] : '';
	if ( $taxonomy ) {
		$term_slug = get_query_var( $taxonomy );
		if ( $term_slug ) {
			$term = get_term_by( 'slug', sanitize_title( $term_slug ), $taxonomy );
			if ( $term && ! is_wp_error( $term ) ) {
				$query->set( 'tax_query', array( array( 'taxonomy' => $taxonomy, 'field' => 'term_id', 'terms' => array( $term->term_id ) ) ) );
			}
		}
	}

	$sort = isset( $_GET['sort'] ) ? sanitize_key( wp_unslash( $_GET['sort'] ) ) : 'latest';
	if ( 'oldest' === $sort ) {
		$query->set( 'orderby', 'date' );
		$query->set( 'order', 'ASC' );
	} elseif ( 'deadline' === $sort && ! empty( $config['sort_meta'] ) ) {
		$query->set( 'meta_key', $config['sort_meta'] );
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'meta_type', 'DATE' );
		$query->set( 'order', 'ASC' );
	} else {
		$query->set( 'orderby', 'date' );
		$query->set( 'order', 'DESC' );
	}
}
add_action( 'pre_get_posts', 'gyad_configure_archive_query', 20 );

function gyad_configure_global_search( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
		return;
	}
	$query->set( 'post_type', array( 'post', 'admission', 'job', 'result', 'exam', 'scholarship', 'course' ) );
	$query->set( 'post_status', 'publish' );
	$query->set( 'posts_per_page', 12 );
	$query->set( 'ignore_sticky_posts', true );
	$query->set( 'no_found_rows', false );
	$query->set( 'update_post_meta_cache', true );
	$query->set( 'update_post_term_cache', true );
}
add_action( 'pre_get_posts', 'gyad_configure_global_search', 25 );
