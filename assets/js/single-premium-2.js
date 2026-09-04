/**
 * GYAD Premium Single System 2 interactions.
 *
 * @package Get_Your_Answers_Daily
 */

document.addEventListener('DOMContentLoaded', function () {
	'use strict';

	document.querySelectorAll('.article-toc').forEach(function (toc, index) {
		const toggle = toc.querySelector('.article-toc__toggle');
		const list = toc.querySelector('.article-toc__list');
		if (!toggle || !list) return;

		const listId = list.id || 'article-toc-list-' + (index + 1);
		list.id = listId;
		toggle.setAttribute('aria-controls', listId);

		toggle.addEventListener('click', function () {
			const expanded = toggle.getAttribute('aria-expanded') === 'true';
			toggle.setAttribute('aria-expanded', expanded ? 'false' : 'true');
			list.hidden = expanded;
			toc.classList.toggle('is-collapsed', expanded);
			const icon = toggle.querySelector('.article-toc__toggle-icon, [aria-hidden="true"]');
			if (icon) icon.textContent = expanded ? '+' : '−';
		});

		toc.querySelectorAll('a[href^="#"]').forEach(function (link) {
			link.addEventListener('click', function () {
				if (window.matchMedia('(max-width: 700px)').matches && toggle.getAttribute('aria-expanded') === 'true') {
					return;
				}
			});
		});
	});

	/* Local, privacy-friendly helpfulness feedback. */
	document.querySelectorAll('.article-feedback').forEach(function (feedback) {
		const buttons = Array.from(feedback.querySelectorAll('[data-feedback]'));
		const status = feedback.querySelector('[data-feedback-status]');
		const key = 'gyad_feedback_' + window.location.pathname;
		let selected = '';
		try { selected = window.localStorage.getItem(key) || ''; } catch (error) { selected = ''; }

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
				try { window.localStorage.setItem(key, selected); } catch (error) {}
				render();
				if (status) status.textContent = 'Thanks for the feedback.';
			});
		});
	});
});
