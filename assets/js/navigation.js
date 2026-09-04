/**
 * GYAD Navigation
 *
 * @package Get_Your_Answers_Daily
 */

document.addEventListener('DOMContentLoaded', function () {
	'use strict';

	document.documentElement.classList.add('js-ready');

	const navigation = document.querySelector('.main-navigation');

	if (!navigation) {
		return;
	}

	const parents = navigation.querySelectorAll(
		'.menu-item-has-children'
	);

	parents.forEach(function (parent) {
		const link = parent.querySelector(':scope > a');

		if (!link) {
			return;
		}

		link.addEventListener('keydown', function (event) {
			if (event.key === 'Escape') {
				parent.classList.remove('is-open');
				link.focus();
			}
		});

		link.addEventListener('click', function (event) {
			if (window.innerWidth > 700) {
				return;
			}

			const submenu = parent.querySelector(':scope > .sub-menu');

			if (!submenu) {
				return;
			}

			const isOpen = parent.classList.contains('is-open');

			if (!isOpen) {
				event.preventDefault();

				parents.forEach(function (item) {
					if (item !== parent) {
						item.classList.remove('is-open');
					}
				});

				parent.classList.add('is-open');
			}
		});
	});

	window.addEventListener('resize', function () {
		if (window.innerWidth > 700) {
			parents.forEach(function (parent) {
				parent.classList.remove('is-open');
			});
		}
	});
});