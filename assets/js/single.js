/**
 * GYAD Single Article Interactions
 *
 * @package Get_Your_Answers_Daily
 */

document.addEventListener('DOMContentLoaded', function () {
	'use strict';

	const article = document.querySelector(
		'.single-article'
	);

	if (!article) {
		return;
	}


	/* =======================================================
	   READING PROGRESS
	   ======================================================= */

	const progressBar = document.querySelector(
		'.article-reading-progress__bar'
	);

	const updateProgress = function () {

		if (!progressBar) {
			return;
		}

		const rect = article.getBoundingClientRect();

		const articleTop =
			window.scrollY + rect.top;

		const articleHeight =
			article.offsetHeight;

		const viewportHeight =
			window.innerHeight;

		const scrollable =
			articleHeight - viewportHeight;

		if (scrollable <= 0) {
			progressBar.style.width = '100%';
			return;
		}

		const progress =
			((window.scrollY - articleTop) / scrollable) * 100;

		const clamped =
			Math.min(100, Math.max(0, progress));

		progressBar.style.width =
			clamped + '%';
	};

	let ticking = false;

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

	window.addEventListener(
		'scroll',
		requestProgressUpdate,
		{ passive: true }
	);

	window.addEventListener(
		'resize',
		requestProgressUpdate
	);

	updateProgress();


	/* =======================================================
	   TABLE OF CONTENTS
	   ======================================================= */

	const toc = document.querySelector(
		'.article-toc'
	);

	if (toc) {

		const headings = Array.from(
			article.querySelectorAll(
				'h2[id], h3[id]'
			)
		);

		const tocLinks = Array.from(
			toc.querySelectorAll(
				'a[href^="#"]'
			)
		);

		const activateToc = function () {

			if (!headings.length || !tocLinks.length) {
				return;
			}

			let activeId = headings[0].id;

			headings.forEach(function (heading) {

				const rect =
					heading.getBoundingClientRect();

				if (rect.top <= 150) {
					activeId = heading.id;
				}
			});

			tocLinks.forEach(function (link) {

				const targetId =
					link.getAttribute('href').replace(
						'#',
						''
					);

				link.classList.toggle(
					'is-active',
					targetId === activeId
				);
			});
		};

		window.addEventListener(
			'scroll',
			activateToc,
			{ passive: true }
		);

		activateToc();


		tocLinks.forEach(function (link) {

			link.addEventListener(
				'click',
				function (event) {

					const targetId =
						link.getAttribute('href');

					const target =
						document.querySelector(
							targetId
						);

					if (!target) {
						return;
					}

					event.preventDefault();

					const offset = 110;

					const top =
						window.scrollY +
						target.getBoundingClientRect().top -
						offset;

					window.scrollTo({
						top: Math.max(0, top),
						behavior: 'smooth'
					});

					history.replaceState(
						null,
						'',
						targetId
					);
				}
			);

		});
	}


	/* =======================================================
	   COPY LINK
	   ======================================================= */

	const copyButtons =
		document.querySelectorAll(
			'[data-copy-url]'
		);

	copyButtons.forEach(function (button) {

		button.addEventListener(
			'click',
			async function () {

				const url =
					button.getAttribute(
						'data-copy-url'
					) ||
					window.location.href;

				try {

					await navigator.clipboard.writeText(
						url
					);

				} catch (error) {

					const fallback =
						document.createElement('textarea');

					fallback.value = url;

					document.body.appendChild(
						fallback
					);

					fallback.select();

					document.execCommand(
						'copy'
					);

					fallback.remove();
				}

				const original =
					button.getAttribute(
						'aria-label'
					) || 'Copy link';

				button.setAttribute(
					'aria-label',
					'Link copied'
				);

				button.classList.add(
					'is-copied'
				);

				const label =
					button.querySelector(
						'[data-copy-label]'
					);

				if (label) {
					label.textContent =
						'Copied';
				}

				window.setTimeout(
					function () {

						button.setAttribute(
							'aria-label',
							original
						);

						button.classList.remove(
							'is-copied'
						);

						if (label) {
							label.textContent =
								'Copy Link';
						}

					},
					1800
				);
			}
		);

	});


	/* =======================================================
	   FAQ
	   ======================================================= */

	const faqItems =
		document.querySelectorAll(
			'.article-faq details'
		);

	faqItems.forEach(function (item) {

		item.addEventListener(
			'toggle',
			function () {

				if (!item.open) {
					return;
				}

				faqItems.forEach(
					function (other) {

						if (
							other !== item &&
							other.open
						) {
							other.open = false;
						}

					}
				);
			}
		);

	});


	/* =======================================================
	   BACK TO TOP
	   ======================================================= */

	const backTop =
		document.querySelector(
			'.article-back-top'
		);

	if (backTop) {

		const updateBackTop =
			function () {

				backTop.classList.toggle(
					'is-visible',
					window.scrollY > 700
				);
			};

		window.addEventListener(
			'scroll',
			updateBackTop,
			{ passive: true }
		);

		updateBackTop();

		backTop.addEventListener(
			'click',
			function () {

				window.scrollTo({
					top: 0,
					behavior: 'smooth'
				});

			}
		);
	}

});