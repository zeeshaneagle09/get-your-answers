/**
 * GYAD Premium Single System 2 interactions.
 *
 * @package Get_Your_Answers_Daily
 */

document.addEventListener('DOMContentLoaded', function () {
	'use strict';

	/* Collapsible article TOC. */
	document.querySelectorAll('.article-toc').forEach(function (toc) {
		const toggle = toc.querySelector('.article-toc__toggle');
		const list = toc.querySelector('.article-toc__list');
		if (!toggle || !list) {
			return;
		}

		toggle.setAttribute('aria-controls', 'article-toc-list');
		list.id = list.id || 'article-toc-list';

		toggle.addEventListener('click', function () {
			const expanded = toggle.getAttribute('aria-expanded') === 'true';
			toggle.setAttribute('aria-expanded', expanded ? 'false' : 'true');
			list.hidden = expanded;
			const icon = toggle.querySelector('[aria-hidden="true"]');
			if (icon) {
				icon.textContent = expanded ? '+' : '−';
			}
		});
	});

	/* Local, privacy-friendly helpfulness feedback. */
	document.querySelectorAll('.article-feedback').forEach(function (feedback) {
		const buttons = Array.from(feedback.querySelectorAll('[data-feedback]'));
		const status = feedback.querySelector('[data-feedback-status]');
		const key = 'gyad_feedback_' + window.location.pathname;
		let selected = '';

		try {
			selected = window.localStorage.getItem(key) || '';
		} catch (error) {
			selected = '';
		}

		const render = function () {
			buttons.forEach(function (button) {
				const active = button.getAttribute('data-feedback') === selected;
				button.classList.toggle('is-selected', active);
				button.setAttribute('aria-pressed', active ? 'true' : 'false');
			});
		};

		render();

		buttons.forEach(function (button) {
			button.addEventListener('click', function () {
				selected = button.getAttribute('data-feedback') || '';
				try {
					window.localStorage.setItem(key, selected);
				} catch (error) {
					/* Storage is optional; the UI still responds. */
				}
				render();
				if (status) {
					status.textContent = 'Thanks for the feedback.';
				}
			});
		});
	});
});
