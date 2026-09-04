<?php
/** Education-specific article intelligence. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function gyad_get_article_type_intelligence( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	$post_type = get_post_type( $post_id );
	if ( ! in_array( $post_type, array( 'result', 'exam' ), true ) ) { return array(); }
	$date = function_exists( 'gyad_get_single_primary_date' ) ? gyad_get_single_primary_date( $post_id ) : '';
	$timestamp = $date ? strtotime( $date ) : false;
	if ( ! $timestamp ) { return array(); }
	$days = (int) floor( ( $timestamp - current_time( 'timestamp' ) ) / DAY_IN_SECONDS );
	if ( 'result' === $post_type ) {
		if ( $days < 0 ) { return array( 'state' => 'available', 'label' => 'Result date passed', 'detail' => 'Check the official result portal for the latest published result.' ); }
		if ( 0 === $days ) { return array( 'state' => 'today', 'label' => 'Result date today', 'detail' => 'Use the official result source for the latest update.' ); }
		return array( 'state' => 'upcoming', 'label' => sprintf( 'Result expected in %d day%s', $days, 1 === $days ? '' : 's' ), 'detail' => 'The listed result date is still ahead.' );
	}
	if ( $days < 0 ) { return array( 'state' => 'past', 'label' => 'Exam date passed', 'detail' => 'Check the official notice for any revised schedule.' ); }
	if ( 0 === $days ) { return array( 'state' => 'today', 'label' => 'Exam date today', 'detail' => 'Confirm the official notice, venue and timing before attending.' ); }
	if ( $days <= 7 ) { return array( 'state' => 'soon', 'label' => sprintf( 'Exam in %d day%s', $days, 1 === $days ? '' : 's' ), 'detail' => 'Review the official schedule before the exam.' ); }
	return array( 'state' => 'upcoming', 'label' => sprintf( 'Exam in %d days', $days ), 'detail' => 'The listed exam date is still ahead.' );
}

function gyad_insert_article_type_intelligence( $content ) {
	if ( ! is_singular() || ! in_the_loop() || ! is_main_query() || ! $content ) { return $content; }
	$data = gyad_get_article_type_intelligence( get_the_ID() );
	if ( empty( $data ) ) { return $content; }
	$notice  = '<div class="article-type-intelligence article-type-intelligence--' . esc_attr( $data['state'] ) . '" role="status">';
	$notice .= '<strong>' . esc_html( $data['label'] ) . '</strong><span>' . esc_html( $data['detail'] ) . '</span></div>';
	return $notice . $content;
}
add_filter( 'the_content', 'gyad_insert_article_type_intelligence', 3 );
