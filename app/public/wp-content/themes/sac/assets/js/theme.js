/**
 * SAC presentation enhancements.
 */
(() => {
	'use strict';

	const setupMobileMenu = () => {
		const menu = document.querySelector('#sacPrimaryMenu');
		const toggle = document.querySelector('.sac-menu-toggle');

		if (!menu || !toggle || !window.bootstrap?.Collapse) return;

		const collapse = window.bootstrap.Collapse.getOrCreateInstance(menu, { toggle: false });
		const backdrop = document.createElement('button');
		backdrop.className = 'sac-menu-backdrop';
		backdrop.type = 'button';
		backdrop.tabIndex = -1;
		backdrop.setAttribute('aria-label', 'Close menu');
		document.body.append(backdrop);

		const closeMenu = () => collapse.hide();
		backdrop.addEventListener('click', closeMenu);
		menu.addEventListener('show.bs.collapse', () => document.body.classList.add('sac-menu-open'));
		menu.addEventListener('shown.bs.collapse', () => menu.querySelector('a')?.focus({ preventScroll: true }));
		menu.addEventListener('hidden.bs.collapse', () => {
			document.body.classList.remove('sac-menu-open');
			toggle.focus({ preventScroll: true });
		});
		menu.querySelectorAll('a').forEach((link) => link.addEventListener('click', closeMenu));
		document.addEventListener('keydown', (event) => {
			if (event.key === 'Escape' && menu.classList.contains('show')) closeMenu();
		});
		window.addEventListener('resize', () => {
			if (menu.classList.contains('show')) closeMenu();
		});
	};

	setupMobileMenu();

	const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	if (reduceMotion || !('IntersectionObserver' in window)) {
		document.documentElement.classList.add('sac-motion-disabled');
		return;
	}

	const selectors = [
		'.site-main > section',
		'.site-main > article',
		'.sac-page-hero > .container',
		'.sac-give-hero > .container',
		'.sac-content-card',
		'.sac-vision-card',
		'.sac-impact-card',
		'.sac-give-method',
		'.sac-bank-card',
		'.sac-stewardship-panel',
		'.sac-story-image',
		'.site-footer .row > *'
	];

	const elements = [...document.querySelectorAll(selectors.join(','))];
	document.documentElement.classList.add('sac-motion-ready');

	elements.forEach((element, index) => {
		element.classList.add('sac-reveal');
		element.style.setProperty('--sac-reveal-delay', `${(index % 3) * 90}ms`);
	});

	const observer = new IntersectionObserver((entries) => {
		entries.forEach((entry) => {
			if (!entry.isIntersecting) return;
			entry.target.classList.add('is-revealed');
			observer.unobserve(entry.target);
		});
	}, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });

	elements.forEach((element) => observer.observe(element));
})();
