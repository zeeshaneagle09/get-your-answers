<?php
/**
 * Premium SEO enrichment.
 * Adds non-duplicating social article metadata and breadcrumb structured data.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function gyad_output_premium_article_meta() {
	if ( ! is_singular() ) {
		return;
	}

	$published = get_the_date( 'c' );
	$modified  = get_the_modified_date( 'c' );

	printf( '<meta property="article:published_time" content="%s">\n', esc_attr( $published ) );
	printf( '<meta property="article:modified_time" content="%s">\n', esc_attr( $modified ) );
	printf( '<meta property="og:updated_time" content="%s">\n', esc_attr( $modified ) );

	$author_id = (int) get_post_field( 'post_author', get_the_ID() );
	if ( $author_id ) {
		printf( '<meta property="article:author" content="%s">\n', esc_attr( get_author_posts_url( $author_id ) ) );
	}
}
add_action( 'wp_head', 'gyad_output_premium_article_meta', 6 );

function gyad_output_breadcrumb_schema() {
	if ( is_front_page() ) {
		return;
	}

	$items = array(
		array(
			'@type'    => 'ListItem',
			'position' => 1,
			'name'     => 'Home',
			'item'     => home_url( '/' ),
		),
	);

	$position = 2;

	if ( is_singular() ) {
		$post_type = get_post_type();
		$archive   = $post_type ? get_post_type_archive_link( $post_type ) : false;
		$obj       = $post_type ? get_post_type_object( $post_type ) : false;

		if ( $archive && $obj ) {
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $position++,
				'name'     => $obj->labels->name,
				'item'     => $archive,
			);
		}

		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $position,
			'name'     => wp_strip_all_tags( get_the_title() ),
			'item'     => get_permalink(),
		);
	} elseif ( is_post_type_archive() ) {
		$post_type = get_query_var( 'post_type' );
		$obj       = $post_type ? get_post_type_object( $post_type ) : false;
		$url       = $post_type ? get_post_type_archive_link( $post_type ) : false;

		if ( $obj && $url ) {
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $position,
				'name'     => $obj->labels->name,
				'item'     => $url,
			);
		}
	} elseif ( is_search() ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $position,
			'name'     => 'Search',
			'item'     => home_url( '/?s=' . rawurlencode( get_search_query() ) ),
		);
	} elseif ( is_404() ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $position,
			'name'     => 'Page Not Found',
			'item'     => home_url( '/' ),
		);
	}

	if ( count( $items ) < 2 ) {
		return;
	}

	echo '<script type="application/ld+json">' . wp_json_encode(
		array(
			'@context'        => 'https://schema.org',
			'@type'           => 'BreadcrumbList',
			'itemListElement' => $items,
		),
		JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
	) . '</script>\n';
}
add_action( 'wp_head', 'gyad_output_breadcrumb_schema', 7 );
