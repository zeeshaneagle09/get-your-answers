<?php
/** Theme asset loading. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
function gyad_asset_version( $relative_path ) { $file = GYAD_DIR . '/' . ltrim( $relative_path, '/' ); return file_exists( $file ) ? (string) filemtime( $file ) : GYAD_VERSION; }
function gyad_enqueue_assets() {
	wp_enqueue_style( 'gyad-reset', GYAD_URI . '/assets/css/reset.css', array(), gyad_asset_version( 'assets/css/reset.css' ) );
	wp_enqueue_style( 'gyad-variables', GYAD_URI . '/assets/css/variables.css', array( 'gyad-reset' ), gyad_asset_version( 'assets/css/variables.css' ) );
	wp_enqueue_style( 'gyad-base', GYAD_URI . '/assets/css/base.css', array( 'gyad-variables' ), gyad_asset_version( 'assets/css/base.css' ) );
	wp_enqueue_style( 'gyad-typography', GYAD_URI . '/assets/css/typography.css', array( 'gyad-base' ), gyad_asset_version( 'assets/css/typography.css' ) );
	wp_enqueue_style( 'gyad-layout', GYAD_URI . '/assets/css/layout.css', array( 'gyad-base' ), gyad_asset_version( 'assets/css/layout.css' ) );
	wp_enqueue_style( 'gyad-components', GYAD_URI . '/assets/css/components.css', array( 'gyad-base' ), gyad_asset_version( 'assets/css/components.css' ) );
	wp_enqueue_style( 'gyad-design-system-premium', GYAD_URI . '/assets/css/design-system-premium.css', array( 'gyad-components' ), gyad_asset_version( 'assets/css/design-system-premium.css' ) );
	wp_enqueue_style( 'gyad-accessibility', GYAD_URI . '/assets/css/accessibility.css', array( 'gyad-base' ), gyad_asset_version( 'assets/css/accessibility.css' ) );
	wp_enqueue_style( 'gyad-header', GYAD_URI . '/assets/css/header.css', array( 'gyad-layout' ), gyad_asset_version( 'assets/css/header.css' ) );
	wp_enqueue_style( 'gyad-navigation', GYAD_URI . '/assets/css/navigation.css', array( 'gyad-header' ), gyad_asset_version( 'assets/css/navigation.css' ) );
	wp_enqueue_style( 'gyad-cards', GYAD_URI . '/assets/css/cards.css', array( 'gyad-components' ), gyad_asset_version( 'assets/css/cards.css' ) );
	wp_enqueue_style( 'gyad-card-premium', GYAD_URI . '/assets/css/card-premium.css', array( 'gyad-cards', 'gyad-design-system-premium' ), gyad_asset_version( 'assets/css/card-premium.css' ) );
	wp_enqueue_style( 'gyad-sections', GYAD_URI . '/assets/css/sections.css', array( 'gyad-components' ), gyad_asset_version( 'assets/css/sections.css' ) );
	wp_enqueue_style( 'gyad-sidebar', GYAD_URI . '/assets/css/sidebar.css', array( 'gyad-components' ), gyad_asset_version( 'assets/css/sidebar.css' ) );
	wp_enqueue_style( 'gyad-footer', GYAD_URI . '/assets/css/footer.css', array( 'gyad-layout' ), gyad_asset_version( 'assets/css/footer.css' ) );
	wp_enqueue_style( 'gyad-responsive', GYAD_URI . '/assets/css/responsive.css', array( 'gyad-layout' ), gyad_asset_version( 'assets/css/responsive.css' ) );
	wp_enqueue_style( 'gyad-utilities', GYAD_URI . '/assets/css/utilities.css', array( 'gyad-base' ), gyad_asset_version( 'assets/css/utilities.css' ) );
	wp_enqueue_style( 'gyad-performance', GYAD_URI . '/assets/css/performance.css', array( 'gyad-utilities' ), gyad_asset_version( 'assets/css/performance.css' ) );
	wp_enqueue_style( 'gyad-accessibility-premium', GYAD_URI . '/assets/css/accessibility-premium.css', array( 'gyad-accessibility' ), gyad_asset_version( 'assets/css/accessibility-premium.css' ) );
	wp_enqueue_style( 'gyad-footer-premium', GYAD_URI . '/assets/css/footer-premium.css', array( 'gyad-footer' ), gyad_asset_version( 'assets/css/footer-premium.css' ) );
	if ( is_front_page() ) { wp_enqueue_style( 'gyad-homepage', GYAD_URI . '/assets/css/homepage.css', array( 'gyad-sections' ), gyad_asset_version( 'assets/css/homepage.css' ) ); wp_enqueue_style( 'gyad-homepage-premium', GYAD_URI . '/assets/css/homepage-premium.css', array( 'gyad-homepage' ), gyad_asset_version( 'assets/css/homepage-premium.css' ) ); }
	if ( is_search() || is_404() ) wp_enqueue_style( 'gyad-search-premium', GYAD_URI . '/assets/css/search-premium.css', array( 'gyad-card-premium' ), gyad_asset_version( 'assets/css/search-premium.css' ) );
	if ( is_singular() ) {
		wp_enqueue_style( 'gyad-single', GYAD_URI . '/assets/css/single.css', array( 'gyad-utilities' ), gyad_asset_version( 'assets/css/single.css' ) );
		wp_enqueue_style( 'gyad-single-premium-2', GYAD_URI . '/assets/css/single-premium-2.css', array( 'gyad-single' ), gyad_asset_version( 'assets/css/single-premium-2.css' ) );
		wp_enqueue_style( 'gyad-single-navigation-premium', GYAD_URI . '/assets/css/single-navigation-premium.css', array( 'gyad-single-premium-2' ), gyad_asset_version( 'assets/css/single-navigation-premium.css' ) );
		wp_enqueue_style( 'gyad-article-continuation-premium', GYAD_URI . '/assets/css/article-continuation-premium.css', array( 'gyad-single-navigation-premium' ), gyad_asset_version( 'assets/css/article-continuation-premium.css' ) );
		wp_enqueue_style( 'gyad-read-next-premium', GYAD_URI . '/assets/css/read-next-premium.css', array( 'gyad-article-continuation-premium' ), gyad_asset_version( 'assets/css/read-next-premium.css' ) );
	}
	if ( is_post_type_archive() || is_category() || is_tax() ) wp_enqueue_style( 'gyad-archive-premium', GYAD_URI . '/assets/css/archive-premium.css', array( 'gyad-cards' ), gyad_asset_version( 'assets/css/archive-premium.css' ) );
	if ( is_author() ) wp_enqueue_style( 'gyad-author-premium', GYAD_URI . '/assets/css/author-premium.css', array( 'gyad-cards' ), gyad_asset_version( 'assets/css/author-premium.css' ) );
	wp_enqueue_script( 'gyad-navigation', GYAD_URI . '/assets/js/navigation.js', array(), gyad_asset_version( 'assets/js/navigation.js' ), true );
	wp_enqueue_script( 'gyad-mobile-menu', GYAD_URI . '/assets/js/mobile-menu.js', array(), gyad_asset_version( 'assets/js/mobile-menu.js' ), true );
	if ( is_search() || is_front_page() || is_post_type_archive() || is_category() || is_tax() ) wp_enqueue_script( 'gyad-search', GYAD_URI . '/assets/js/search.js', array(), gyad_asset_version( 'assets/js/search.js' ), true );
	if ( is_singular() ) { wp_enqueue_script( 'gyad-single', GYAD_URI . '/assets/js/single.js', array(), gyad_asset_version( 'assets/js/single.js' ), true ); wp_enqueue_script( 'gyad-single-premium-2', GYAD_URI . '/assets/js/single-premium-2.js', array( 'gyad-single' ), gyad_asset_version( 'assets/js/single-premium-2.js' ), true ); }
	wp_enqueue_script( 'gyad-main', GYAD_URI . '/assets/js/main.js', array(), gyad_asset_version( 'assets/js/main.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'gyad_enqueue_assets' );
function gyad_defer_theme_scripts( $tag, $handle, $src ) { $defer_scripts = array( 'gyad-navigation', 'gyad-mobile-menu', 'gyad-search', 'gyad-single', 'gyad-single-premium-2', 'gyad-main' ); if ( ! in_array( $handle, $defer_scripts, true ) ) return $tag; return sprintf( '<script src="%s" defer></script>', esc_url( $src ) ); }
add_filter( 'script_loader_tag', 'gyad_defer_theme_scripts', 10, 3 );
