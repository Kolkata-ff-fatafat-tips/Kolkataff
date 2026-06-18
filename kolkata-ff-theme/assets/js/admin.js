(function () {
  const tabs = document.querySelectorAll('.kff-admin-tabs button');
  const panels = document.querySelectorAll('.kff-admin-panel');
  tabs.forEach((tab) => {
    tab.addEventListener('click', () => {
      tabs.forEach((item) => item.classList.remove('is-active'));
      panels.forEach((panel) => panel.classList.remove('is-active'));
      tab.classList.add('is-active');
      const panel = document.querySelector(`[data-panel="${tab.dataset.tab}"]`);
      if (panel) panel.classList.add('is-active');
    });
  });
})();
