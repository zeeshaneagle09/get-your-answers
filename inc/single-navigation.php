<?php
/**
 * Single article navigation system.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function gyad_build_article_toc_items( $content ) {
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
		$id = '';
		if ( preg_match( '/\sid=["\']([^"\']+)["\']/i', $match[2], $id_match ) ) {
			$id = sanitize_title( $id_match[1] );
		}
		if ( ! $id ) {
			$base = sanitize_title( $title );
			$base = $base ? $base : 'section';
			$id   = $base;
			$suffix = 2;
			while ( isset( $used[ $id ] ) ) {
				$id = $base . '-' . $suffix;
				$suffix++;
			}
		}
		$used[ $id ] = true;
		$items[] = array( 'id' => $id, 'level' => $level, 'title' => $title );
	}
	return $items;
}

function gyad_prepend_article_toc( $content ) {
	if ( ! is_singular() || ! in_the_loop() || ! is_main_query() || ! $content ) {
		return $content;
	}
	$items = gyad_build_article_toc_items( $content );
	if ( count( $items ) < 3 ) {
		return $content;
	}
	$items = array_slice( $items, 0, 12 );
	$toc  = '<nav class="article-toc" aria-label="Table of contents">';
	$toc .= '<div class="article-toc__head">';
	$toc .= '<span class="article-toc__label">On this page</span>';
	$toc .= '<button type="button" class="article-toc__toggle" aria-expanded="true" aria-controls="article-toc-list">';
	$toc .= '<span>Contents</span><span class="article-toc__toggle-icon" aria-hidden="true">−</span>';
	$toc .= '</button></div>';
	$toc .= '<ol id="article-toc-list" class="article-toc__list">';
	foreach ( $items as $item ) {
		$class = 3 === (int) $item['level'] ? ' article-toc__item--sub' : '';
		$toc .= '<li class="article-toc__item' . esc_attr( $class ) . '">';
		$toc .= '<a href="#' . esc_attr( $item['id'] ) . '">' . esc_html( $item['title'] ) . '</a></li>';
	}
	$toc .= '</ol></nav>';
	return $toc . $content;
}
add_filter( 'the_content', 'gyad_prepend_article_toc', 5 );

function gyad_add_article_jump_target( $content ) {
	if ( ! is_singular() || ! in_the_loop() || ! is_main_query() || ! $content ) {
		return $content;
	}
	return '<span id="article-content-start" class="article-content-start" tabindex="-1"></span>' . $content;
}
add_filter( 'the_content', 'gyad_add_article_jump_target', 1 );
