/**
 * GYAD Single Article Interactions
 *
 * @package Get_Your_Answers_Daily
 */

document.addEventListener('DOMContentLoaded', function () {
	'use strict';

	const article = document.querySelector('.single-article');
	if (!article) return;
	const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	const progressBar = document.querySelector('.article-reading-progress__bar');
	let ticking = false;
	const updateProgress = function () {
		if (!progressBar) return;
		const rect = article.getBoundingClientRect();
		const articleTop = window.scrollY + rect.top;
		const scrollable = article.offsetHeight - window.innerHeight;
		if (scrollable <= 0) { progressBar.style.width = '100%'; return; }
		const progress = ((window.scrollY - articleTop) / scrollable) * 100;
		progressBar.style.width = Math.min(100, Math.max(0, progress)) + '%';
	};
	const requestProgressUpdate = function () {
		if (ticking) return;
		ticking = true;
		window.requestAnimationFrame(function () { updateProgress(); ticking = false; });
	};
	window.addEventListener('scroll', requestProgressUpdate, { passive: true });
	window.addEventListener('resize', requestProgressUpdate);
	updateProgress();

	const headings = Array.from(article.querySelectorAll('h2, h3'));
	const usedIds = new Set();
	headings.forEach(function (heading, index) {
		if (heading.id) { usedIds.add(heading.id); return; }
		const base = (heading.textContent || 'section-' + (index + 1)).trim().toLowerCase().replace(/[^\p{L}\p{N}]+/gu, '-').replace(/^-+|-+$/g, '') || 'section-' + (index + 1);
		let id = base; let suffix = 2;
		while (usedIds.has(id)) { id = base + '-' + suffix; suffix += 1; }
		heading.id = id; usedIds.add(id);
	});

	const toc = document.querySelector('.article-toc');
	if (toc) {
		const tocLinks = Array.from(toc.querySelectorAll('a[href^="#"]'));
		const activateToc = function () {
			if (!tocLinks.length || !headings.length) return;
			let activeId = headings[0].id;
			headings.forEach(function (heading) { if (heading.getBoundingClientRect().top <= 150) activeId = heading.id; });
			tocLinks.forEach(function (link) { link.classList.toggle('is-active', link.getAttribute('href').slice(1) === activeId); });
		};
		window.addEventListener('scroll', activateToc, { passive: true });
		activateToc();
		tocLinks.forEach(function (link) {
			link.addEventListener('click', function (event) {
				const targetId = link.getAttribute('href');
				const target = document.querySelector(targetId);
				if (!target) return;
				event.preventDefault();
				const top = window.scrollY + target.getBoundingClientRect().top - 110;
				window.scrollTo({ top: Math.max(0, top), behavior: prefersReducedMotion ? 'auto' : 'smooth' });
				window.history.replaceState(null, '', targetId);
			});
		});
	}

	const copyUrl = async function (button) {
		const url = button.getAttribute('data-copy-url') || window.location.href;
		try {
			if (navigator.clipboard && window.isSecureContext) await navigator.clipboard.writeText(url);
			else {
				const fallback = document.createElement('textarea'); fallback.value = url; fallback.setAttribute('readonly', ''); fallback.style.position = 'fixed'; fallback.style.opacity = '0'; document.body.appendChild(fallback); fallback.select(); document.execCommand('copy'); fallback.remove();
			}
		} catch (error) { return; }
		const label = button.querySelector('[data-copy-label]');
		button.classList.add('is-copied'); button.setAttribute('aria-label', 'Link copied');
		if (label) label.textContent = 'Copied';
		window.setTimeout(function () { button.classList.remove('is-copied'); button.setAttribute('aria-label', 'Copy link'); if (label) label.textContent = 'Copy'; }, 1800);
	};
	document.querySelectorAll('[data-copy-url]').forEach(function (button) { button.addEventListener('click', function () { copyUrl(button); }); });

	document.querySelectorAll('[data-share-web]').forEach(function (button) {
		if (!navigator.share) { button.hidden = true; return; }
		button.addEventListener('click', async function () { try { await navigator.share({ title: document.title, text: document.querySelector('.single-article-header__excerpt')?.textContent?.trim() || '', url: window.location.href }); } catch (error) {} });
	});

	document.querySelectorAll('[data-bookmark]').forEach(function (button) {
		const postId = button.getAttribute('data-bookmark'); if (!postId) return;
		const storageKey = 'gyad_saved_articles'; let saved = [];
		try { saved = JSON.parse(window.localStorage.getItem(storageKey) || '[]'); if (!Array.isArray(saved)) saved = []; } catch (error) { saved = []; }
		const label = button.querySelector('[data-bookmark-label]');
		const render = function () { const isSaved = saved.indexOf(postId) !== -1; button.classList.toggle('is-saved', isSaved); button.setAttribute('aria-pressed', isSaved ? 'true' : 'false'); button.setAttribute('aria-label', isSaved ? 'Remove saved article' : 'Save article'); if (label) label.textContent = isSaved ? 'Saved' : 'Save'; };
		render();
		button.addEventListener('click', function () { const position = saved.indexOf(postId); if (position === -1) saved.push(postId); else saved.splice(position, 1); try { window.localStorage.setItem(storageKey, JSON.stringify(saved)); } catch (error) { return; } render(); });
	});

	/* Sticky desktop rail + mobile share bar. */
	const shareRail = document.querySelector('.article-share-rail');
	const mobileShare = document.querySelector('.article-mobile-share');
	if (shareRail || mobileShare) {
		const updateShareVisibility = function () {
			const header = document.querySelector('.single-article-header');
			const continuation = document.querySelector('.article-continuation');
			const headerBottom = header ? header.getBoundingClientRect().bottom : 0;
			const continuationTop = continuation ? continuation.getBoundingClientRect().top : Number.POSITIVE_INFINITY;
			const active = headerBottom < 90 && continuationTop > window.innerHeight * .35;
			if (shareRail) shareRail.classList.toggle('is-visible', active && window.innerWidth > 1200);
			if (mobileShare) mobileShare.classList.toggle('is-visible', active && window.innerWidth <= 1200);
		};
		window.addEventListener('scroll', updateShareVisibility, { passive: true });
		window.addEventListener('resize', updateShareVisibility);
		updateShareVisibility();
	}

	const shareButtons = document.querySelectorAll('.article-share-rail [data-copy-url], .article-mobile-share [data-copy-url]');
	shareButtons.forEach(function (button) { button.addEventListener('click', function () { copyUrl(button); }); });

	const webShareButtons = document.querySelectorAll('.article-share-rail [data-share-web], .article-mobile-share [data-share-web]');
	webShareButtons.forEach(function (button) {
		if (!navigator.share) { button.hidden = true; return; }
		button.addEventListener('click', async function () { try { await navigator.share({ title: document.title, url: window.location.href }); } catch (error) {} });
	});

	const backTop = document.querySelector('.article-back-top');
	if (backTop) {
		const updateBackTop = function () { backTop.classList.toggle('is-visible', window.scrollY > 700); };
		window.addEventListener('scroll', updateBackTop, { passive: true }); updateBackTop();
		backTop.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: prefersReducedMotion ? 'auto' : 'smooth' }); });
	}
});