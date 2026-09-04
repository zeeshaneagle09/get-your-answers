<?php
/**
 * Custom taxonomies.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Register custom taxonomies.
 *
 * @return void
 */
function gyad_register_taxonomies() {

	$taxonomies = array(

		'admission_type' => array(
			'post_types' => array( 'admission' ),
			'singular'   => 'Admission Type',
			'plural'     => 'Admission Types',
			'slug'       => 'admission-type',
		),

		'job_type' => array(
			'post_types' => array( 'job' ),
			'singular'   => 'Job Type',
			'plural'     => 'Job Types',
			'slug'       => 'job-type',
		),

		'result_board' => array(
			'post_types' => array( 'result' ),
			'singular'   => 'Board',
			'plural'     => 'Boards',
			'slug'       => 'result-board',
		),

		'exam_type' => array(
			'post_types' => array( 'exam' ),
			'singular'   => 'Exam Type',
			'plural'     => 'Exam Types',
			'slug'       => 'exam-type',
		),

		'scholarship_type' => array(
			'post_types' => array( 'scholarship' ),
			'singular'   => 'Scholarship Type',
			'plural'     => 'Scholarship Types',
			'slug'       => 'scholarship-type',
		),

		'course_category' => array(
			'post_types' => array( 'course' ),
			'singular'   => 'Course Category',
			'plural'     => 'Course Categories',
			'slug'       => 'course-category',
		),

	);

	foreach ( $taxonomies as $taxonomy => $data ) {

		$labels = array(
			'name'              => $data['plural'],
			'singular_name'     => $data['singular'],
			'search_items'      => 'Search ' . $data['plural'],
			'all_items'         => 'All ' . $data['plural'],
			'parent_item'       => 'Parent ' . $data['singular'],
			'parent_item_colon' => 'Parent ' . $data['singular'] . ':',
			'edit_item'         => 'Edit ' . $data['singular'],
			'update_item'       => 'Update ' . $data['singular'],
			'add_new_item'      => 'Add New ' . $data['singular'],
			'new_item_name'     => 'New ' . $data['singular'] . ' Name',
			'menu_name'        => $data['plural'],
		);

		register_taxonomy(
			$taxonomy,
			$data['post_types'],
			array(
				'labels'            => $labels,
				'public'            => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'hierarchical'      => true,
				'rewrite'           => array(
					'slug'       => $data['slug'],
					'with_front' => false,
				),
			)
		);
	}
}

add_action( 'init', 'gyad_register_taxonomies' );