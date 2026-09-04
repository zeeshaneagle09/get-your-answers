<?php
/**
 * Single post helpers and article utilities.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Get article content type configuration.
 *
 * @param string $post_type Post type.
 * @return array
 */
function gyad_get_single_config( $post_type = '' ) {

	$post_type = $post_type ? $post_type : get_post_type();

	$config = array(

		'post' => array(
			'label'         => 'Education News',
			'taxonomy'      => 'category',
			'date_label'    => 'Published',
			'action_label'  => '',
			'accent'        => 'blue',
		),

		'admission' => array(
			'label'         => 'Admission',
			'taxonomy'      => 'admission_type',
			'date_label'    => 'Application Deadline',
			'action_label'  => 'Apply Now',
			'accent'        => 'blue',
		),

		'job' => array(
			'label'         => 'Job',
			'taxonomy'      => 'job_type',
			'date_label'    => 'Application Deadline',
			'action_label'  => 'Apply Now',
			'accent'        => 'green',
		),

		'result' => array(
			'label'         => 'Result',
			'taxonomy'      => 'result_board',
			'date_label'    => 'Result Date',
			'action_label'  => 'Check Result',
			'accent'        => 'purple',
		),

		'exam' => array(
			'label'         => 'Exam',
			'taxonomy'      => 'exam_type',
			'date_label'    => 'Exam Date',
			'action_label'  => 'Official Website',
			'accent'        => 'orange',
		),

		'scholarship' => array(
			'label'         => 'Scholarship',
			'taxonomy'      => 'scholarship_type',
			'date_label'    => 'Application Deadline',
			'action_label'  => 'Apply Now',
			'accent'        => 'teal',
		),

		'course' => array(
			'label'         => 'Course',
			'taxonomy'      => 'course_category',
			'date_label'    => '',
			'action_label'  => 'Visit Official Website',
			'accent'        => 'blue',
		),
	);

	return isset( $config[ $post_type ] )
		? $config[ $post_type ]
		: $config['post'];
}


/**
 * Get article reading time.
 *
 * @param int|WP_Post|null $post Post.
 * @return int
 */
function gyad_get_reading_time( $post = null ) {

	$post = get_post( $post );

	if ( ! $post ) {
		return 1;
	}

	$content = wp_strip_all_tags(
		strip_shortcodes(
			$post->post_content
		)
	);

	$words = preg_match_all(
		'/\S+/u',
		$content,
		$matches
	);

	$words = $words ? $words : 0;

	/*
	 * Approximate editorial reading speed.
	 * Keep a minimum of one minute.
	 */
	return max(
		1,
		(int) ceil( $words / 220 )
	);
}


/**
 * Format reading time.
 *
 * @param int $minutes Minutes.
 * @return string
 */
function gyad_format_reading_time( $minutes ) {

	$minutes = max( 1, (int) $minutes );

	return sprintf(
		_n(
			'%s min read',
			'%s min read',
			$minutes,
			'gyad'
		),
		number_format_i18n( $minutes )
	);
}


/**
 * Get current article taxonomy terms.
 *
 * @param int|WP_Post|null $post Post.
 * @return array
 */
function gyad_get_single_terms( $post = null ) {

	$post = get_post( $post );

	if ( ! $post ) {
		return array();
	}

	$config = gyad_get_single_config(
		$post->post_type
	);

	$taxonomy = $config['taxonomy'];

	if ( ! $taxonomy ) {
		return array();
	}

	$terms = get_the_terms(
		$post->ID,
		$taxonomy
	);

	if (
		! $terms ||
		is_wp_error( $terms )
	) {
		return array();
	}

	return $terms;
}


/**
 * Get primary article term.
 *
 * @param int|WP_Post|null $post Post.
 * @return WP_Term|null
 */
function gyad_get_primary_single_term( $post = null ) {

	$terms = gyad_get_single_terms( $post );

	return ! empty( $terms )
		? $terms[0]
		: null;
}


/**
 * Get article official URL.
 *
 * @param int|WP_Post|null $post Post.
 * @return string
 */
function gyad_get_single_official_url( $post = null ) {

	$post = get_post( $post );

	if ( ! $post ) {
		return '';
	}

	return (string) get_post_meta(
		$post->ID,
		'official_url',
		true
	);
}


/**
 * Get article deadline/date based on content type.
 *
 * @param int|WP_Post|null $post Post.
 * @return string
 */
function gyad_get_single_primary_date( $post = null ) {

	$post = get_post( $post );

	if ( ! $post ) {
		return '';
	}

	$keys = array();

	switch ( $post->post_type ) {

		case 'admission':
		case 'job':
		case 'scholarship':
			$keys[] = 'application_deadline';
			break;

		case 'result':
			$keys[] = 'result_date';
			break;

		case 'exam':
			$keys[] = 'exam_date';
			break;
	}

	foreach ( $keys as $key ) {

		$value = get_post_meta(
			$post->ID,
			$key,
			true
		);

		if ( $value ) {
			return $value;
		}
	}

	return '';
}


/**
 * Get article institution/provider.
 *
 * @param int|WP_Post|null $post Post.
 * @return string
 */
function gyad_get_single_institution( $post = null ) {

	$post = get_post( $post );

	if ( ! $post ) {
		return '';
	}

	return (string) get_post_meta(
		$post->ID,
		'institution_name',
		true
	);
}


/**
 * Get deadline state.
 *
 * @param string $date Date in Y-m-d.
 * @return string
 */
function gyad_get_single_date_state( $date ) {

	if ( ! $date ) {
		return '';
	}

	$timestamp = strtotime( $date . ' 23:59:59' );

	if ( ! $timestamp ) {
		return '';
	}

	$today = current_time( 'timestamp' );

	if ( $timestamp < $today ) {
		return 'expired';
	}

	if (
		wp_date(
			'Y-m-d',
			$timestamp,
			wp_timezone()
		) === wp_date(
			'Y-m-d',
			$today,
			wp_timezone()
		)
	) {
		return 'today';
	}

	return 'active';
}


/**
 * Human-friendly deadline message.
 *
 * @param string $date Date in Y-m-d.
 * @return string
 */
function gyad_get_single_date_status_text( $date ) {

	if ( ! $date ) {
		return '';
	}

	$timestamp = strtotime( $date . ' 23:59:59' );

	if ( ! $timestamp ) {
		return '';
	}

	$today = current_time( 'timestamp' );

	$state = gyad_get_single_date_state( $date );

	if ( 'expired' === $state ) {
		return 'Closed';
	}

	if ( 'today' === $state ) {
		return 'Deadline today';
	}

	$seconds = $timestamp - $today;

	$days = (int) ceil(
		$seconds / DAY_IN_SECONDS
	);

	return sprintf(
		_n(
			'%s day remaining',
			'%s days remaining',
			$days,
			'gyad'
		),
		number_format_i18n( $days )
	);
}


/**
 * Get article source label.
 *
 * @param int|WP_Post|null $post Post.
 * @return string
 */
function gyad_get_single_source_label( $post = null ) {

	$post = get_post( $post );

	if ( ! $post ) {
		return '';
	}

	$institution = gyad_get_single_institution( $post );

	if ( $institution ) {
		return $institution;
	}

	return get_bloginfo( 'name' );
}


/**
 * Build share URL.
 *
 * @param string $network Network.
 * @param string $url URL.
 * @param string $title Title.
 * @return string
 */
function gyad_get_share_url( $network, $url, $title ) {

	$url   = rawurlencode( $url );
	$title = rawurlencode( $title );

	switch ( $network ) {

		case 'facebook':
			return 'https://www.facebook.com/sharer/sharer.php?u=' . $url;

		case 'whatsapp':
			return 'https://wa.me/?text=' . $title . '%20' . $url;

		case 'x':
			return 'https://twitter.com/intent/tweet?text=' . $title . '&url=' . $url;

		default:
			return '';
	}
}


/**
 * Add body class for single content type.
 *
 * @param array $classes Body classes.
 * @return array
 */
function gyad_single_body_classes( $classes ) {

	if ( ! is_singular() ) {
		return $classes;
	}

	$post_type = get_post_type();

	$classes[] = 'is-single-content';

	$classes[] = 'is-single-' . sanitize_html_class(
		$post_type
	);

	return $classes;
}

add_filter(
	'body_class',
	'gyad_single_body_classes'
);


/**
 * Count article views.
 *
 * Lightweight native view counter.
 *
 * @param int $post_id Post ID.
 * @return void
 */
function gyad_track_post_view( $post_id ) {

	if ( ! $post_id || ! is_singular() ) {
		return;
	}

	if ( is_user_logged_in() ) {
		return;
	}

	if ( ! empty( $_COOKIE['gyad_view_' . $post_id] ) ) {
		return;
	}

	$current_views = (int) get_post_meta(
		$post_id,
	'_gyad_views',
		true
	);

	update_post_meta(
		$post_id,
		'_gyad_views',
		$current_views + 1
	);

	setcookie(
		'gyad_view_' . $post_id,
		'1',
		time() + DAY_IN_SECONDS,
		COOKIEPATH,
		COOKIE_DOMAIN,
		is_ssl(),
		true
	);
}

add_action(
	'wp',
	function () {

		if ( is_singular() ) {
			gyad_track_post_view(
				get_queried_object_id()
			);
		}
	}
);


/**
 * Get article view count.
 *
 * @param int|WP_Post|null $post Post.
 * @return int
 */
function gyad_get_post_views( $post = null ) {

	$post = get_post( $post );

	if ( ! $post ) {
		return 0;
	}

	return (int) get_post_meta(
		$post->ID,
		'_gyad_views',
		true
	);
}