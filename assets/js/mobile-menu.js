/**
 * GYAD Mobile Menu
 *
 * @package Get_Your_Answers_Daily
 */

document.addEventListener('DOMContentLoaded', function () {
	'use strict';

	const button = document.querySelector('.mobile-menu-button');
	const navigation = document.querySelector('.main-navigation');

	if (!button || !navigation) {
		return;
	}

	const closeMenu = function () {
		button.setAttribute('aria-expanded', 'false');
		button.setAttribute('aria-label', 'Open menu');

		navigation.classList.remove('is-visible');

		document.documentElement.classList.remove('menu-open');
	};

	const openMenu = function () {
		button.setAttribute('aria-expanded', 'true');
		button.setAttribute('aria-label', 'Close menu');

		navigation.classList.add('is-visible');

		document.documentElement.classList.add('menu-open');
	};

	const toggleMenu = function () {
		const isOpen =
			button.getAttribute('aria-expanded') === 'true';

		if (isOpen) {
			closeMenu();
		} else {
			openMenu();
		}
	};

	button.addEventListener('click', toggleMenu);

	document.addEventListener('keydown', function (event) {
		if (event.key === 'Escape') {
			const isOpen =
				button.getAttribute('aria-expanded') === 'true';

			if (isOpen) {
				closeMenu();
				button.focus();
			}
		}
	});

	document.addEventListener('click', function (event) {
		const isOpen =
			button.getAttribute('aria-expanded') === 'true';

		if (!isOpen) {
			return;
		}

		if (
			!navigation.contains(event.target) &&
			!button.contains(event.target)
		) {
			closeMenu();
		}
	});

	navigation.addEventListener('click', function (event) {
		const link = event.target.closest('a');

		if (!link) {
			return;
		}

		if (window.innerWidth <= 700) {
			const parent = link.parentElement;

			if (
				parent &&
				parent.classList.contains('menu-item-has-children')
			) {
				return;
			}

			closeMenu();
		}
	});

	window.addEventListener('resize', function () {
		if (window.innerWidth > 700) {
			closeMenu();
		}
	});
});