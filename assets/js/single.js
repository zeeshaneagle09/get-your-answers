/**
 * GYAD Single Article Interactions
 *
 * @package Get_Your_Answers_Daily
 */

document.addEventListener('DOMContentLoaded', function () {
	'use strict';

	const article = document.querySelector('.single-article');
	if (!article) {
		return;
	}

	const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	/* Reading progress */
	const progressBar = document.querySelector('.article-reading-progress__bar');
	let ticking = false;

	const updateProgress = function () {
		if (!progressBar) {
			return;
		}

		const rect = article.getBoundingClientRect();
		const articleTop = window.scrollY + rect.top;
		const articleHeight = article.offsetHeight;
		const scrollable = articleHeight - window.innerHeight;

		if (scrollable <= 0) {
			progressBar.style.width = '100%';
			return;
		}

		const progress = ((window.scrollY - articleTop) / scrollable) * 100;
		progressBar.style.width = Math.min(100, Math.max(0, progress)) + '%';
	};

	const requestProgressUpdate = function () {
		if (ticking) {
			return;
		}
		ticking = true;
		window.requestAnimationFrame(function () {
			updateProgress();
			ticking = false;
		});
	};

	window.addEventListener('scroll', requestProgressUpdate, { passive: true });
	window.addEventListener('resize', requestProgressUpdate);
	updateProgress();

	/* Make sure article headings are navigable even if server-side markup is changed later. */
	const headings = Array.from(article.querySelectorAll('h2, h3'));
	const usedIds = new Set();

	headings.forEach(function (heading, index) {
		if (heading.id) {
			usedIds.add(heading.id);
			return;
		}

		const base = (heading.textContent || 'section-' + (index + 1))
			.trim()
			.toLowerCase()
			.replace(/[^\p{L}\p{N}]+/gu, '-')
			.replace(/^-+|-+$/g, '') || 'section-' + (index + 1);

		let id = base;
		let suffix = 2;
		while (usedIds.has(id)) {
			id = base + '-' + suffix;
			suffix += 1;
		}
		heading.id = id;
		usedIds.add(id);
	});

	/* Table of contents */
	const toc = document.querySelector('.article-toc');
	if (toc) {
		const tocLinks = Array.from(toc.querySelectorAll('a[href^="#"]'));
		const tocHeadings = headings.filter(function (heading) {
			return heading.id;
		});

		const activateToc = function () {
			if (!tocHeadings.length || !tocLinks.length) {
				return;
			}

			let activeId = tocHeadings[0].id;
			tocHeadings.forEach(function (heading) {
				if (heading.getBoundingClientRect().top <= 150) {
					activeId = heading.id;
				}
			});

			tocLinks.forEach(function (link) {
				const targetId = link.getAttribute('href').replace('#', '');
				link.classList.toggle('is-active', targetId === activeId);
			});
		};

		window.addEventListener('scroll', activateToc, { passive: true });
		activateToc();

		tocLinks.forEach(function (link) {
			link.addEventListener('click', function (event) {
				const targetId = link.getAttribute('href');
				const target = document.querySelector(targetId);
				if (!target) {
					return;
				}

				event.preventDefault();
				const offset = 110;
				const top = window.scrollY + target.getBoundingClientRect().top - offset;
				window.scrollTo({
					top: Math.max(0, top),
					behavior: prefersReducedMotion ? 'auto' : 'smooth'
				});
				window.history.replaceState(null, '', targetId);
			});
		});
	}

	/* Copy link */
	document.querySelectorAll('[data-copy-url]').forEach(function (button) {
		button.addEventListener('click', async function () {
			const url = button.getAttribute('data-copy-url') || window.location.href;

			try {
				if (navigator.clipboard && window.isSecureContext) {
					await navigator.clipboard.writeText(url);
				} else {
					const fallback = document.createElement('textarea');
					fallback.value = url;
					fallback.setAttribute('readonly', '');
					fallback.style.position = 'fixed';
					fallback.style.opacity = '0';
					document.body.appendChild(fallback);
					fallback.select();
					document.execCommand('copy');
					fallback.remove();
				}
			} catch (error) {
				return;
			}

			const original = button.getAttribute('aria-label') || 'Copy link';
			const label = button.querySelector('[data-copy-label]');
			button.setAttribute('aria-label', 'Link copied');
			button.classList.add('is-copied');
			if (label) {
				label.textContent = 'Copied';
			}

			window.setTimeout(function () {
				button.setAttribute('aria-label', original);
				button.classList.remove('is-copied');
				if (label) {
					label.textContent = 'Copy';
				}
			}, 1800);
		});
	});

	/* Native Web Share */
	document.querySelectorAll('[data-share-web]').forEach(function (button) {
		if (!navigator.share) {
			button.hidden = true;
			return;
		}

		button.addEventListener('click', async function () {
			try {
				await navigator.share({
					title: document.title,
					text: document.querySelector('.single-article-header__excerpt')?.textContent?.trim() || '',
					url: window.location.href
				});
			} catch (error) {
				/* User cancellation is intentionally silent. */
			}
		});
	});

	/* Local bookmark */
	document.querySelectorAll('[data-bookmark]').forEach(function (button) {
		const postId = button.getAttribute('data-bookmark');
		if (!postId) {
			return;
		}

		const storageKey = 'gyad_saved_articles';
		let saved = [];

		try {
			saved = JSON.parse(window.localStorage.getItem(storageKey) || '[]');
			if (!Array.isArray(saved)) {
				saved = [];
			}
		} catch (error) {
			saved = [];
		}

		const label = button.querySelector('[data-bookmark-label]');
		const render = function () {
			const isSaved = saved.indexOf(postId) !== -1;
			button.classList.toggle('is-saved', isSaved);
			button.setAttribute('aria-pressed', isSaved ? 'true' : 'false');
			button.setAttribute('aria-label', isSaved ? 'Remove saved article' : 'Save article');
			if (label) {
				label.textContent = isSaved ? 'Saved' : 'Save';
			}
		};

		render();

		button.addEventListener('click', function () {
			const position = saved.indexOf(postId);
			if (position === -1) {
				saved.push(postId);
			} else {
				saved.splice(position, 1);
			}

			try {
				window.localStorage.setItem(storageKey, JSON.stringify(saved));
			} catch (error) {
				return;
			}
			render();
		});
	});

	/* FAQ */
	const faqItems = document.querySelectorAll('.article-faq details');
	faqItems.forEach(function (item) {
		item.addEventListener('toggle', function () {
			if (!item.open) {
				return;
			}
			faqItems.forEach(function (other) {
				if (other !== item) {
					other.open = false;
				}
			});
		});
	});

	/* Back to top */
	const backTop = document.querySelector('.article-back-top');
	if (backTop) {
		const updateBackTop = function () {
			backTop.classList.toggle('is-visible', window.scrollY > 700);
		};
		window.addEventListener('scroll', updateBackTop, { passive: true });
		updateBackTop();
		backTop.addEventListener('click', function () {
			window.scrollTo({
				top: 0,
				behavior: prefersReducedMotion ? 'auto' : 'smooth'
			});
		});
	}
});