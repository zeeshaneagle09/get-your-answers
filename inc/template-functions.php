<?php
/**
 * Theme template helper functions.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render a small inline SVG icon.
 *
 * Keeping icons inline means:
 * - no icon font
 * - no external library
 * - no extra HTTP requests
 * - easy styling with CSS
 *
 * @param string $name Icon name.
 * @param string $class Optional class.
 * @return string
 */
function gyad_icon( $name, $class = '' ) {

	$icons = array(

		'search' => '
			<svg viewBox="0 0 24 24" aria-hidden="true">
				<circle cx="11" cy="11" r="6.5"></circle>
				<path d="M16 16l5 5"></path>
			</svg>
		',

		'menu' => '
			<svg viewBox="0 0 24 24" aria-hidden="true">
				<path d="M4 7h16"></path>
				<path d="M4 12h16"></path>
				<path d="M4 17h16"></path>
			</svg>
		',

		'home' => '
			<svg viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">
				<path d="M12 3 3 10v10a1 1 0 0 0 1 1h5v-6h6v6h5a1 1 0 0 0 1-1V10l-9-7z"></path>
			</svg>
		',

		'chevron-down' => '
			<svg viewBox="0 0 24 24" aria-hidden="true">
				<path d="m6 9 6 6 6-6"></path>
			</svg>
		',

		'arrow-right' => '
			<svg viewBox="0 0 24 24" aria-hidden="true">
				<path d="M5 12h13"></path>
				<path d="m13 6 6 6-6 6"></path>
			</svg>
		',

		'bell' => '
	<svg viewBox="0 0 24 24" aria-hidden="true" fill="none">
		<path
			d="M18 9.5a6 6 0 0 0-12 0c0 6.5-2.5 7.5-2.5 9h17c0-1.5-2.5-2.5-2.5-9Z"
			stroke="currentColor"
			stroke-width="1.8"
			stroke-linecap="round"
			stroke-linejoin="round"
		/>
		<path
			d="M10 21h4"
			stroke="currentColor"
			stroke-width="1.8"
			stroke-linecap="round"
		/>
	</svg>
',

		'facebook' => '
			<svg viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">
				<path d="M14 8h3V4h-3c-3.3 0-5 2-5 5v3H6v4h3v5h4v-5h3.2l.8-4H13V9c0-.7.3-1 1-1z"></path>
			</svg>
		',

		'instagram' => '
			<svg viewBox="0 0 24 24" aria-hidden="true" fill="none">
				<rect x="3" y="3" width="18" height="18" rx="5"></rect>
				<circle cx="12" cy="12" r="4"></circle>
				<circle cx="17.5" cy="6.5" r="1"></circle>
			</svg>
		',

		'youtube' => '
			<svg viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">
				<path d="M21 7.2a2.7 2.7 0 0 0-1.9-1.9C17.4 4.8 12 4.8 12 4.8s-5.4 0-7.1.5A2.7 2.7 0 0 0 3 7.2C2.5 8.9 2.5 12 2.5 12s0 3.1.5 4.8a2.7 2.7 0 0 0 1.9 1.9c1.7.5 7.1.5 7.1.5s5.4 0 7.1-.5a2.7 2.7 0 0 0 1.9-1.9c.5-1.7.5-4.8.5-4.8s0-3.1-.5-4.8zM10 15.5v-7l6 3.5-6 3.5z"></path>
			</svg>
		',

	);

	if ( ! isset( $icons[ $name ] ) ) {
		return '';
	}

	$classes = 'gyad-icon';

	if ( $class ) {
		$classes .= ' ' . $class;
	}

	return sprintf(
		'<span class="%1$s">%2$s</span>',
		esc_attr( $classes ),
		$icons[ $name ]
	);
}