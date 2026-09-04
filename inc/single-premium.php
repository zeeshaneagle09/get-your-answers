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
 * Get reusable author data for article modules.
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
 * Get a human-readable content type label.
 *
 * @param int|WP_Post|null $post Post.
 * @return string
 */
function gyad_get_content_type_label( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return '';
	}

	if ( function_exists( 'gyad_get_single_config' ) ) {
		$config = gyad_get_single_config( $post->post_type );
		return ! empty( $config['label'] ) ? (string) $config['label'] : 'Education';
	}

	return 'Education';
}

/**
 * Get related posts using taxonomy first, then a safe post-type fallback.
 *
 * @param int|WP_Post|null $post Post.
 * @param int              $limit Number of posts.
 * @return WP_Post[]
 */
function gyad_get_related_posts( $post = null, $limit = 6 ) {
	$post  = get_post( $post );
	$limit = max( 1, min( 12, (int) $limit ) );

	if ( ! $post ) {
		return array();
	}

	$config = function_exists( 'gyad_get_single_config' )
		? gyad_get_single_config( $post->post_type )
		: array( 'taxonomy' => '' );

	$taxonomy = ! empty( $config['taxonomy'] ) ? $config['taxonomy'] : '';
	$term_ids = array();

	if ( $taxonomy ) {
		$terms = get_the_terms( $post->ID, $taxonomy );
		if ( $terms && ! is_wp_error( $terms ) ) {
			$term_ids = wp_list_pluck( $terms, 'term_id' );
		}
	}

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
	$post  = get_post( $post );
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
 * Get more posts from the current primary taxonomy.
 *
 * @param int|WP_Post|null $post Post.
 * @param int              $limit Number of posts.
 * @return WP_Post[]
 */
function gyad_get_more_from_category( $post = null, $limit = 4 ) {
	$post  = get_post( $post );
	$limit = max( 1, min( 8, (int) $limit ) );

	if ( ! $post || ! function_exists( 'gyad_get_single_config' ) ) {
		return array();
	}

	$config   = gyad_get_single_config( $post->post_type );
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
 * Build a table of contents and make heading IDs deterministic.
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
	$used  = array();

	foreach ( $matches as $match ) {
		$level = (int) $match[1];
		$title = trim( wp_strip_all_tags( $match[3] ) );
		if ( '' === $title ) {
			continue;
		}

		$id = sanitize_title( $title );
		$base = $id ? $id : 'section';
		$id = $base;
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
 * Add IDs to article H2/H3 headings while preserving existing IDs.
 *
 * @param string $content Content HTML.
 * @return string
 */
function gyad_add_article_heading_ids( $content ) {
	if ( ! $content || false === strpos( $content, '<h' ) ) {
		return $content;
	}

	$used = array();
	$index = 0;

	return preg_replace_callback(
		'/<h([23])([^>]*)>(.*?)<\/h\1>/is',
		function ( $match ) use ( &$used, &$index ) {
			$attributes = $match[2];
			$title      = trim( wp_strip_all_tags( $match[3] ) );

			if ( preg_match( '/\sid=["\']([^"\']+)["\']/i', $attributes, $id_match ) ) {
				$existing = sanitize_title( $id_match[1] );
				if ( $existing ) {
					$used[ $existing ] = true;
				}
				return $match[0];
			}

			$base = sanitize_title( $title );
			$base = $base ? $base : 'section-' . ( $index + 1 );
			$id   = $base;
			$suffix = 2;

			while ( isset( $used[ $id ] ) ) {
				$id = $base . '-' . $suffix;
				$suffix++;
			}

			$used[ $id ] = true;
			$index++;

			return '<h' . $match[1] . $attributes . ' id="' . esc_attr( $id ) . '">' . $match[3] . '</h' . $match[1] . '>';
		},
		$content
	);
}

add_filter( 'the_content', 'gyad_add_article_heading_ids', 20 );

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

	$url   = get_permalink( $post );
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
 * Get normalized education-specific metadata.
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
 * Get deadline/status information for deadline-driven content.
 *
 * @param int|WP_Post|null $post Post.
 * @return array
 */
function gyad_get_deadline_status( $post = null ) {
	$post = get_post( $post );
	if ( ! $post || ! function_exists( 'gyad_get_single_primary_date' ) ) {
		return array();
	}

	$date = gyad_get_single_primary_date( $post );
	if ( ! $date ) {
		return array();
	}

	$state = function_exists( 'gyad_get_single_date_state' )
		? gyad_get_single_date_state( $date )
		: '';

	$text = function_exists( 'gyad_get_single_date_status_text' )
		? gyad_get_single_date_status_text( $date )
		: '';

	return array(
		'date'  => $date,
		'state' => $state,
		'text'  => $text,
	);
}

/**
 * Get official source information.
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
 * Data helper for native Web Share/bookmark consumers.
 *
 * @param array $data Data.
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
