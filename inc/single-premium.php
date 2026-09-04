<?php
/**
 * Premium single article helpers.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get a reusable author data object for article modules.
 *
 * @param int|WP_Post|null $post Post.
 * @return array
 */
function gyad_get_author_data( $post = null ) {
	$post = get_post( $post );

	if ( ! $post ) {
		return array();
	}

	$author_id = (int) $post->post_author;

	return array(
		'id'          => $author_id,
		'name'        => get_the_author_meta( 'display_name', $author_id ),
		'description' => get_the_author_meta( 'description', $author_id ),
		'url'         => get_author_posts_url( $author_id ),
		'avatar'      => get_avatar_url( $author_id, array( 'size' => 160 ) ),
	);
}

/**
 * Get related posts using taxonomy first, then a safe post-type fallback.
 *
 * @param int|WP_Post|null $post Post.
 * @param int              $limit Number of posts.
 * @return WP_Post[]
 */
function gyad_get_related_posts( $post = null, $limit = 6 ) {
	$post = get_post( $post );
	$limit = max( 1, min( 12, (int) $limit ) );

	if ( ! $post ) {
		return array();
	}

	$config = function_exists( 'gyad_get_single_config' )
		? gyad_get_single_config( $post->post_type )
		: array( 'taxonomy' => '' );

	$args = array(
		'post_type'           => $post->post_type,
		'post_status'         => 'publish',
		'posts_per_page'      => $limit,
		'post__not_in'        => array( $post->ID ),
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'orderby'             => 'date',
		'order'               => 'DESC',
	);

	$taxonomy = ! empty( $config['taxonomy'] ) ? $config['taxonomy'] : '';
	$term_ids = array();

	if ( $taxonomy ) {
		$terms = get_the_terms( $post->ID, $taxonomy );
		if ( $terms && ! is_wp_error( $terms ) ) {
			$term_ids = wp_list_pluck( $terms, 'term_id' );
		}
	}

	if ( $taxonomy && $term_ids ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => $taxonomy,
				'field'    => 'term_id',
				'terms'    => $term_ids,
			),
		);
	}

	$posts = get_posts( $args );

	if ( count( $posts ) >= $limit || ! $term_ids ) {
		return $posts;
	}

	$fallback = get_posts(
		array(
			'post_type'           => $post->post_type,
			'post_status'         => 'publish',
			'posts_per_page'      => $limit - count( $posts ),
			'post__not_in'        => array_merge( array( $post->ID ), wp_list_pluck( $posts, 'ID' ) ),
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'orderby'             => 'date',
			'order'               => 'DESC',
		)
	);

	return array_merge( $posts, $fallback );
}

/**
 * Get more posts from the current author.
 *
 * @param int|WP_Post|null $post Post.
 * @param int              $limit Number of posts.
 * @return WP_Post[]
 */
function gyad_get_more_from_author( $post = null, $limit = 4 ) {
	$post = get_post( $post );
	$limit = max( 1, min( 8, (int) $limit ) );

	if ( ! $post || ! $post->post_author ) {
		return array();
	}

	return get_posts(
		array(
			'post_type'           => $post->post_type,
			'post_status'         => 'publish',
			'author'              => (int) $post->post_author,
			'posts_per_page'      => $limit,
			'post__not_in'        => array( $post->ID ),
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'orderby'             => 'date',
			'order'               => 'DESC',
		)
	);
}

/**
 * Get more posts from the primary category/taxonomy.
 *
 * @param int|WP_Post|null $post Post.
 * @param int              $limit Number of posts.
 * @return WP_Post[]
 */
function gyad_get_more_from_category( $post = null, $limit = 4 ) {
	$post = get_post( $post );
	$limit = max( 1, min( 8, (int) $limit ) );

	if ( ! $post || ! function_exists( 'gyad_get_single_config' ) ) {
		return array();
	}

	$config = gyad_get_single_config( $post->post_type );
	$taxonomy = ! empty( $config['taxonomy'] ) ? $config['taxonomy'] : '';

	if ( ! $taxonomy ) {
		return array();
	}

	$terms = get_the_terms( $post->ID, $taxonomy );
	if ( ! $terms || is_wp_error( $terms ) ) {
		return array();
	}

	return get_posts(
		array(
			'post_type'           => $post->post_type,
			'post_status'         => 'publish',
			'posts_per_page'      => $limit,
			'post__not_in'        => array( $post->ID ),
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'orderby'             => 'date',
			'order'               => 'DESC',
			'tax_query'           => array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'term_id',
					'terms'    => wp_list_pluck( $terms, 'term_id' ),
				),
			),
		)
	);
}

/**
 * Build a lightweight table of contents from rendered article HTML.
 *
 * @param string $content Content HTML.
 * @return array
 */
function gyad_get_table_of_contents( $content = '' ) {
	if ( ! $content ) {
		return array();
	}

	if ( ! preg_match_all( '/<h([23])([^>]*)>(.*?)<\/h\1>/is', $content, $matches, PREG_SET_ORDER ) ) {
		return array();
	}

	$items = array();
	$used = array();

	foreach ( $matches as $match ) {
		$level = (int) $match[1];
		$title = trim( wp_strip_all_tags( $match[3] ) );
		if ( '' === $title ) {
			continue;
		}

		$id = sanitize_title( $title );
		$base = $id;
		$index = 2;
		while ( isset( $used[ $id ] ) ) {
			$id = $base . '-' . $index;
			$index++;
		}
		$used[ $id ] = true;

		$items[] = array(
			'id'    => $id,
			'level' => $level,
			'title' => $title,
		);
	}

	return $items;
}

/**
 * Get share URLs for the current article.
 *
 * @param int|WP_Post|null $post Post.
 * @return array
 */
function gyad_get_share_urls( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return array();
	}

	$url = get_permalink( $post );
	$title = get_the_title( $post );

	return array(
		'facebook' => function_exists( 'gyad_get_share_url' ) ? gyad_get_share_url( 'facebook', $url, $title ) : '',
		'whatsapp' => function_exists( 'gyad_get_share_url' ) ? gyad_get_share_url( 'whatsapp', $url, $title ) : '',
		'x'        => function_exists( 'gyad_get_share_url' ) ? gyad_get_share_url( 'x', $url, $title ) : '',
		'url'      => $url,
		'title'    => $title,
	);
}

/**
 * Get normalized education-specific metadata for a single article.
 *
 * @param int|WP_Post|null $post Post.
 * @return array
 */
function gyad_get_content_meta( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return array();
	}

	$keys = array(
		'institution_name',
		'application_deadline',
		'application_fee',
		'location',
		'salary',
		'result_class',
		'result_date',
		'exam_date',
		'eligibility',
		'course_duration',
		'course_level',
		'official_url',
	);

	$data = array();
	foreach ( $keys as $key ) {
		$value = get_post_meta( $post->ID, $key, true );
		if ( '' !== $value && null !== $value ) {
			$data[ $key ] = $value;
		}
	}

	return $data;
}

/**
 * Get official source information as a consistent array.
 *
 * @param int|WP_Post|null $post Post.
 * @return array
 */
function gyad_get_official_source( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return array();
	}

	$url = function_exists( 'gyad_get_single_official_url' )
		? gyad_get_single_official_url( $post )
		: get_post_meta( $post->ID, 'official_url', true );

	return array(
		'url'   => esc_url_raw( $url ),
		'label' => function_exists( 'gyad_get_single_source_label' )
			? gyad_get_single_source_label( $post )
			: get_bloginfo( 'name' ),
	);
}

/**
 * Add native Web Share and copy-link data attributes to the page.
 *
 * @param array $data Data passed to wp_localize_script-like consumers.
 * @return array
 */
function gyad_single_share_data( $data = array() ) {
	if ( ! is_singular() ) {
		return $data;
	}

	$post_id = get_queried_object_id();
	$data['gyadShare'] = array(
		'url'   => esc_url_raw( get_permalink( $post_id ) ),
		'title' => wp_strip_all_tags( get_the_title( $post_id ) ),
	);

	return $data;
}
