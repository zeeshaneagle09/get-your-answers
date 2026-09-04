/**
 * GYAD Search interactions.
 *
 * @package Get_Your_Answers_Daily
 */

document.addEventListener('DOMContentLoaded', function () {
	'use strict';

	const searchForms = document.querySelectorAll(
		'form[role="search"]'
	);

	searchForms.forEach(function (form) {
		form.addEventListener('submit', function (event) {
			const input = form.querySelector(
				'input[name="s"]'
			);

			if (!input) {
				return;
			}

			const value = input.value.trim();

			/*
			 * Never submit an empty search.
			 * This prevents URLs such as:
			 *
			 * ?s=&content_type=
			 *
			 * and keeps the user on the current page.
			 */
			if (!value) {
				event.preventDefault();

				input.value = '';
				input.focus();

				return;
			}
		});
	});


	/*
	 * Search page category selector.
	 *
	 * Changing the category submits the search only when
	 * there is an actual search term.
	 */
	const searchTypeSelect = document.querySelector(
		'#search-content-type'
	);

	if (searchTypeSelect) {
		searchTypeSelect.addEventListener(
			'change',
			function () {
				const form = searchTypeSelect.closest('form');

				if (!form) {
					return;
				}

				const input = form.querySelector(
					'input[name="s"]'
				);

				if (!input || !input.value.trim()) {
					input.focus();
					return;
				}

				form.submit();
			}
		);
	}
});