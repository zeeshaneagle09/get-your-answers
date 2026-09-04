<?php
/** Smart related-content intelligence. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function gyad_get_smart_related_posts( $post = null, $limit = 4 ) {
	$post = get_post( $post );
	$limit = max( 1, min( 8, (int) $limit ) );
	if ( ! $post ) return array();
	$config = function_exists( 'gyad_get_single_config' ) ? gyad_get_single_config( $post->post_type ) : array( 'taxonomy' => '' );
	$taxonomy = ! empty( $config['taxonomy'] ) ? $config['taxonomy'] : '';
	$term_ids = array();
	if ( $taxonomy ) {
		$terms = get_the_terms( $post->ID, $taxonomy );
		if ( $terms && ! is_wp_error( $terms ) ) $term_ids = wp_list_pluck( $terms, 'term_id' );
	}
	$candidates = get_posts( array( 'post_type' => $post->post_type, 'post_status' => 'publish', 'posts_per_page' => min( 24, max( 10, $limit * 4 ) ), 'post__not_in' => array( $post->ID ), 'ignore_sticky_posts' => true, 'no_found_rows' => true, 'orderby' => 'date', 'order' => 'DESC' ) );
	$scored = array();
	foreach ( $candidates as $candidate ) {
		$score = 0;
		if ( $term_ids && $taxonomy ) {
			$candidate_terms = get_the_terms( $candidate->ID, $taxonomy );
			if ( $candidate_terms && ! is_wp_error( $candidate_terms ) ) $score += min( 50, count( array_intersect( $term_ids, wp_list_pluck( $candidate_terms, 'term_id' ) ) ) * 25 );
		}
		$views = function_exists( 'gyad_get_post_views' ) ? (int) gyad_get_post_views( $candidate->ID ) : 0;
		$score += min( 25, (int) log( max( 1, $views + 1 ), 2 ) * 3 );
		$age_days = max( 0, ( time() - get_post_time( 'U', true, $candidate ) ) / DAY_IN_SECONDS );
		$score += max( 0, 20 - min( 20, (int) floor( $age_days / 7 ) ) );
		if ( (int) $candidate->post_author === (int) $post->post_author ) $score += 8;
		$scored[] = array( 'post' => $candidate, 'score' => $score );
	}
	usort( $scored, function ( $a, $b ) { return $b['score'] <=> $a['score']; } );
	return array_map( function ( $item ) { return $item['post']; }, array_slice( $scored, 0, $limit ) );
}

function gyad_insert_inline_read_next( $content ) {
	if ( ! is_singular() || ! in_the_loop() || ! is_main_query() || ! $content ) return $content;
	$related = gyad_get_smart_related_posts( get_post(), 1 );
	if ( empty( $related[0] ) ) return $content;
	$item = $related[0];
	$type = function_exists( 'gyad_get_content_type_label' ) ? gyad_get_content_type_label( $item ) : 'Related update';
	$card  = '<aside class="article-read-next" aria-label="Read next">';
	$card .= '<span class="article-read-next__eyebrow">Read next</span>';
	$card .= '<a class="article-read-next__link" href="' . esc_url( get_permalink( $item ) ) . '">';
	$card .= '<span class="article-read-next__type">' . esc_html( $type ) . '</span>';
	$card .= '<strong class="article-read-next__title">' . esc_html( get_the_title( $item ) ) . '</strong>';
	$card .= '<span class="article-read-next__action">Continue reading →</span></a></aside>';
	$parts = preg_split( '/(<\/p>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE );
	if ( count( $parts ) < 5 ) return $content . $card;
	$output = ''; $paragraphs = 0;
	foreach ( $parts as $part ) {
		$output .= $part;
		if ( preg_match( '/<\/p>/i', $part ) ) { $paragraphs++; if ( 2 === $paragraphs ) $output .= $card; }
	}
	return $output;
}
add_filter( 'the_content', 'gyad_insert_inline_read_next', 12 );
