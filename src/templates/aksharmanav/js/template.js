(() => {
  'use strict';

  const toggle = document.querySelector('[data-am-menu-toggle]');
  const menu = document.querySelector('[data-am-menu]');

  const closeMenu = () => {
    if (!toggle || !menu) {
      return;
    }

    toggle.setAttribute('aria-expanded', 'false');
    menu.removeAttribute('data-open');
  };

  if (toggle && menu) {
    toggle.addEventListener('click', () => {
      const open = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', String(!open));
      menu.toggleAttribute('data-open', !open);
    });

    menu.addEventListener('click', (event) => {
      if (event.target.closest('a')) {
        closeMenu();
      }
    });
  }

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      closeMenu();
      toggle?.focus();
    }
  });

  window.addEventListener('resize', () => {
    if (window.matchMedia('(min-width: 64rem)').matches) {
      closeMenu();
    }
  });

  const header = document.querySelector('[data-am-header]');
  const updateHeader = () => header?.toggleAttribute('data-scrolled', window.scrollY > 24);
  updateHeader();
  window.addEventListener('scroll', updateHeader, { passive: true });

  const animated = document.querySelectorAll('[data-am-reveal], [data-am-logo-assembly]');

  if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    animated.forEach((element) => element.setAttribute('data-am-visible', ''));
    return;
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) {
        return;
      }

      entry.target.setAttribute('data-am-visible', '');
      observer.unobserve(entry.target);
    });
  }, { threshold: 0.14 });

  animated.forEach((element) => observer.observe(element));
})();
