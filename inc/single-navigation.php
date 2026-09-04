<?php
/**
 * Single article navigation system.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build and prepend a lightweight table of contents when an article has
 * enough H2/H3 headings to benefit from navigation.
 *
 * @param string $content Article content.
 * @return string
 */
function gyad_prepend_article_toc( $content ) {
	if ( ! is_singular() || ! in_the_loop() || ! is_main_query() || ! $content ) {
		return $content;
	}

	if ( ! function_exists( 'gyad_get_table_of_contents' ) ) {
		return $content;
	}

	$items = gyad_get_table_of_contents( $content );

	if ( count( $items ) < 3 ) {
		return $content;
	}

	$items = array_slice( $items, 0, 12 );

	$toc = '<nav class="article-toc" aria-label="Table of contents">';
	$toc .= '<div class="article-toc__head">';
	$toc .= '<span class="article-toc__label">On this page</span>';
	$toc .= '<button type="button" class="article-toc__toggle" aria-expanded="true">';
	$toc .= '<span>Contents</span><span aria-hidden="true">−</span>';
	$toc .= '</button>';
	$toc .= '</div>';
	$toc .= '<ol class="article-toc__list">';

	foreach ( $items as $item ) {
		$class = 3 === (int) $item['level']
			? ' article-toc__item--sub'
			: '';

		$toc .= '<li class="article-toc__item' . esc_attr( $class ) . '">';
		$toc .= '<a href="#' . esc_attr( $item['id'] ) . '">';
		$toc .= esc_html( $item['title'] );
		$toc .= '</a></li>';
	}

	$toc .= '</ol></nav>';

	return $toc . $content;
}

add_filter( 'the_content', 'gyad_prepend_article_toc', 5 );