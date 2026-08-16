(() => {
  'use strict';

  const toggle = document.querySelector('[data-am-menu-toggle]');
  const menu = document.querySelector('[data-am-menu]');

  if (!toggle || !menu) {
    return;
  }

  const closeMenu = () => {
    toggle.setAttribute('aria-expanded', 'false');
    menu.removeAttribute('data-open');
  };

  toggle.addEventListener('click', () => {
    const open = toggle.getAttribute('aria-expanded') === 'true';
    toggle.setAttribute('aria-expanded', String(!open));
    menu.toggleAttribute('data-open', !open);
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      closeMenu();
      toggle.focus();
    }
  });

  window.addEventListener('resize', () => {
    if (window.matchMedia('(min-width: 64rem)').matches) {
      closeMenu();
    }
  });
})();
