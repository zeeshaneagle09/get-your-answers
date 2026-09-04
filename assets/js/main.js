/**
 * GYAD Global Theme Interactions
 *
 * @package Get_Your_Answers_Daily
 */

document.addEventListener('DOMContentLoaded', function () {
	'use strict';

	document.documentElement.classList.add('js-ready');


	/* =======================================================
	   CURRENT YEAR SUPPORT
	   ======================================================= */

	const yearElements =
		document.querySelectorAll(
			'[data-current-year]'
		);

	yearElements.forEach(function (element) {

		element.textContent =
			new Date().getFullYear();

	});


	/* =======================================================
	   EXTERNAL LINK SAFETY
	   ======================================================= */

	const externalLinks =
		document.querySelectorAll(
			'a[target="_blank"]'
		);

	externalLinks.forEach(function (link) {

		const rel =
			link.getAttribute('rel') || '';

		const tokens =
			rel.split(/\s+/).filter(Boolean);

		if (!tokens.includes('noopener')) {
			tokens.push('noopener');
		}

		if (!tokens.includes('noreferrer')) {
			tokens.push('noreferrer');
		}

		link.setAttribute(
			'rel',
			tokens.join(' ')
		);

	});


	/* =======================================================
	   TABLET / MOBILE VIEWPORT CHANGE
	   ======================================================= */

	let previousWidth =
		window.innerWidth;

	window.addEventListener(
		'resize',
		function () {

			const currentWidth =
				window.innerWidth;

			if (
				previousWidth <= 700 &&
				currentWidth > 700
			) {
				document.documentElement.classList.remove(
					'menu-open'
				);
			}

			previousWidth = currentWidth;
		},
		{
			passive: true
		}
	);

});