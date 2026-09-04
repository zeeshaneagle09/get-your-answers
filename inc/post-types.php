<?php
/**
 * Custom post types.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Register theme custom post types.
 *
 * @return void
 */
function gyad_register_post_types() {

	$post_types = array(

		'admission' => array(
			'singular' => 'Admission',
			'plural'   => 'Admissions',
			'menu'     => 'Admissions',
			'icon'     => 'dashicons-welcome-learn-more',
			'slug'     => 'admissions',
		),

		'job' => array(
			'singular' => 'Job',
			'plural'   => 'Jobs',
			'menu'     => 'Jobs',
			'icon'     => 'dashicons-businessperson',
			'slug'     => 'jobs',
		),

		'result' => array(
			'singular' => 'Result',
			'plural'   => 'Results',
			'menu'     => 'Results',
			'icon'     => 'dashicons-chart-bar',
			'slug'     => 'results',
		),

		'exam' => array(
			'singular' => 'Exam',
			'plural'   => 'Exams',
			'menu'     => 'Exams',
			'icon'     => 'dashicons-clipboard',
			'slug'     => 'exams',
		),

		'scholarship' => array(
			'singular' => 'Scholarship',
			'plural'   => 'Scholarships',
			'menu'     => 'Scholarships',
			'icon'     => 'dashicons-awards',
			'slug'     => 'scholarships',
		),

		'course' => array(
			'singular' => 'Course',
			'plural'   => 'Courses',
			'menu'     => 'Courses',
			'icon'     => 'dashicons-welcome-learn-more',
			'slug'     => 'courses',
		),

	);

	foreach ( $post_types as $post_type => $data ) {

		$labels = array(
			'name'                  => $data['plural'],
			'singular_name'         => $data['singular'],
			'menu_name'             => $data['menu'],
			'name_admin_bar'        => $data['singular'],
			'add_new'               => 'Add New',
			'add_new_item'          => 'Add New ' . $data['singular'],
			'new_item'              => 'New ' . $data['singular'],
			'edit_item'             => 'Edit ' . $data['singular'],
			'view_item'             => 'View ' . $data['singular'],
			'all_items'             => 'All ' . $data['plural'],
			'search_items'          => 'Search ' . $data['plural'],
			'not_found'             => 'No ' . strtolower( $data['plural'] ) . ' found.',
			'not_found_in_trash'    => 'No ' . strtolower( $data['plural'] ) . ' found in Trash.',
			'archives'              => $data['singular'] . ' Archives',
			'attributes'            => $data['singular'] . ' Attributes',
			'insert_into_item'      => 'Insert into ' . strtolower( $data['singular'] ),
			'uploaded_to_this_item' => 'Uploaded to this ' . strtolower( $data['singular'] ),
		);

		register_post_type(
			$post_type,
			array(
				'labels'             => $labels,
				'public'             => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'show_in_rest'       => true,
				'menu_icon'          => $data['icon'],
				'has_archive'        => $data['slug'],
				'rewrite'            => array(
					'slug'       => $data['slug'],
					'with_front' => false,
				),
				'supports'           => array(
					'title',
					'editor',
					'thumbnail',
					'excerpt',
					'author',
					'revisions',
				),
				'publicly_queryable' => true,
				'query_var'          => true,
				'show_in_nav_menus'  => true,
			)
		);
	}
}

add_action( 'init', 'gyad_register_post_types' );