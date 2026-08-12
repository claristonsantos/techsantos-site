(function () {
  var main = document.querySelector('.admin-main');
  if (main && !main.id) main.id = 'adminContent';
  if (main && !main.hasAttribute('tabindex')) main.setAttribute('tabindex', '-1');

  var sidebar = document.getElementById('adminSidebar');
  var toggle = document.getElementById('adminMenuToggle');
  var backdrop = document.getElementById('adminSidebarBackdrop');
  if (!sidebar || !toggle || !backdrop) return;

  function openMenu() {
    sidebar.classList.add('open');
    backdrop.classList.add('open');
    toggle.setAttribute('aria-expanded', 'true');
    sidebar.querySelector('a')?.focus();
  }

  function closeMenu(restoreFocus) {
    sidebar.classList.remove('open');
    backdrop.classList.remove('open');
    toggle.setAttribute('aria-expanded', 'false');
    if (restoreFocus) toggle.focus();
  }

  toggle.addEventListener('click', function () {
    sidebar.classList.contains('open') ? closeMenu(false) : openMenu();
  });
  backdrop.addEventListener('click', function () { closeMenu(false); });
  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && sidebar.classList.contains('open')) closeMenu(true);
  });
  window.addEventListener('resize', function () {
    if (window.innerWidth > 820 && sidebar.classList.contains('open')) closeMenu(false);
  });
})();
