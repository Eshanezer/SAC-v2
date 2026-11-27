/**
 * SAC presentation enhancements.
 */
(() => {
	'use strict';

	const header = document.querySelector('.site-header');
	if (header && 'ResizeObserver' in window) {
		const headerObserver = new ResizeObserver(() => {
			document.documentElement.style.setProperty('--sac-header-height', `${header.offsetHeight}px`);
		});
		headerObserver.observe(header);
	}

	const setupMobileMenu = () => {
		const menu = document.querySelector('#sacPrimaryMenu');
		const toggle = document.querySelector('.sac-menu-toggle');

		if (!menu || !toggle || !window.bootstrap?.Collapse) return;

		const collapse = window.bootstrap.Collapse.getOrCreateInstance(menu, { toggle: false });
		const backdrop = document.createElement('div');
		backdrop.className = 'sac-menu-backdrop';
		backdrop.setAttribute('aria-hidden', 'true');
		document.body.append(backdrop);

		const obscured = [...document.querySelectorAll('.sac-skip-link, .sac-broadcast-banner, .sac-breadcrumbs, #primary, .site-footer')]
			.filter((element) => !element.inert);
		const visibleMenuItems = () => [...menu.querySelectorAll('a[href], button:not([disabled])')]
			.filter((element) => element.getClientRects().length > 0);
		const closeMenu = () => collapse.hide();
		backdrop.addEventListener('click', closeMenu);
		menu.addEventListener('show.bs.collapse', () => {
			document.body.classList.add('sac-menu-open');
			obscured.forEach((element) => { element.inert = true; });
		});
		menu.addEventListener('shown.bs.collapse', () => visibleMenuItems()[0]?.focus({ preventScroll: true }));
		menu.addEventListener('hidden.bs.collapse', () => {
			document.body.classList.remove('sac-menu-open');
			obscured.forEach((element) => { element.inert = false; });
			toggle.focus({ preventScroll: true });
		});
		menu.addEventListener('click', (event) => {
			if (event.target.closest('a[href]:not([data-bs-toggle="dropdown"])')) closeMenu();
		});
		menu.addEventListener('keydown', (event) => {
			if (event.key === ' ' && event.target.matches('[data-bs-toggle="dropdown"]')) {
				event.preventDefault();
				if (!event.repeat) event.target.click();
			}
		});
		document.addEventListener('keydown', (event) => {
			if (!menu.classList.contains('show')) return;

			if (event.key === 'Escape') {
				if (!event.defaultPrevented) closeMenu();
				return;
			}

			if (event.key !== 'Tab') return;

			const items = [toggle, ...visibleMenuItems()];
			const first = items[0];
			const last = items[items.length - 1];
			const active = document.activeElement;
			if (!items.includes(active) || (event.shiftKey ? active === first : active === last)) {
				event.preventDefault();
				(event.shiftKey ? last : first).focus();
			}
		});
		window.addEventListener('resize', () => {
			if (menu.classList.contains('show')) closeMenu();
		});
	};

	setupMobileMenu();

	document.querySelector('#contact-form [role="status"]')?.focus();

	const snow = document.querySelector('#sac-christmas-snow');
	const snowControl = document.querySelector('.sac-snow-control');
	if (snow && snowControl) {
		snowControl.hidden = false;
		const setSnowHidden = (hidden) => {
			snow.hidden = hidden;
			snowControl.setAttribute('aria-pressed', String(hidden));
		};
		snowControl.addEventListener('click', () => setSnowHidden(!snow.hidden));
		snow.addEventListener('animationend', (event) => {
			if (event.animationName !== 'sac-christmas-snow-visibility') return;

			setSnowHidden(true);
		});
	}

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
