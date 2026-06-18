(function () {
  const body = document.body;
  const menuToggle = document.querySelector('.kff-menu-toggle');
  const menu = document.querySelector('.kff-menu');
  const darkToggle = document.querySelector('.kff-dark-toggle');

  if (localStorage.getItem('kff-dark') === '1') {
    body.classList.add('kff-dark');
  }

  if (menuToggle && menu) {
    menuToggle.addEventListener('click', () => {
      const open = menu.classList.toggle('is-open');
      menuToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  if (darkToggle) {
    darkToggle.addEventListener('click', () => {
      body.classList.toggle('kff-dark');
      localStorage.setItem('kff-dark', body.classList.contains('kff-dark') ? '1' : '0');
    });
  }

  document.querySelectorAll('[data-reveal]').forEach((button) => {
    button.addEventListener('click', () => {
      const scratch = button.closest('[data-scratch]');
      if (scratch) scratch.classList.add('is-revealed');
    });
  });

  document.querySelectorAll('[data-refresh]').forEach((button) => {
    button.addEventListener('click', () => window.location.reload());
  });

  document.querySelectorAll('[data-share]').forEach((button) => {
    button.addEventListener('click', async () => {
      const text = `${KFF_THEME.shareText} - ${window.location.href}`;
      if (navigator.share) {
        await navigator.share({ title: KFF_THEME.siteName, text, url: window.location.href });
      } else if (navigator.clipboard) {
        await navigator.clipboard.writeText(text);
        button.textContent = 'Copied';
        setTimeout(() => { button.textContent = 'Share'; }, 1400);
      }
    });
  });

  const fromInput = document.querySelector('[data-old-from]');
  const toInput = document.querySelector('[data-old-to]');
  const filterButton = document.querySelector('[data-old-filter]');
  const resetButton = document.querySelector('[data-old-reset]');
  const oldRows = document.querySelectorAll('.kff-old-table tbody tr[data-date]');

  function filterOldRows() {
    const from = fromInput && fromInput.value ? fromInput.value : '';
    const to = toInput && toInput.value ? toInput.value : '';
    oldRows.forEach((row) => {
      const date = row.dataset.date;
      const hidden = (from && date < from) || (to && date > to);
      row.classList.toggle('is-hidden', hidden);
    });
  }

  if (filterButton) filterButton.addEventListener('click', filterOldRows);
  if (resetButton) {
    resetButton.addEventListener('click', () => {
      if (fromInput) fromInput.value = '';
      if (toInput) toInput.value = '';
      filterOldRows();
    });
  }

  document.querySelectorAll('[data-chart-tab]').forEach((tab) => {
    tab.addEventListener('click', () => {
      document.querySelectorAll('[data-chart-tab]').forEach((item) => item.classList.remove('is-active'));
      document.querySelectorAll('[data-chart-panel]').forEach((panel) => panel.classList.remove('is-active'));
      tab.classList.add('is-active');
      const panel = document.querySelector(`[data-chart-panel="${tab.dataset.chartTab}"]`);
      if (panel) panel.classList.add('is-active');
    });
  });

  const pattiInput = document.querySelector('[data-patti-input]');
  const pattiButton = document.querySelector('[data-patti-calc]');
  const pattiResult = document.querySelector('[data-patti-result]');
  function calculatePatti() {
    if (!pattiInput || !pattiResult) return;
    const digits = pattiInput.value.replace(/\D/g, '').slice(0, 3);
    pattiInput.value = digits;
    if (digits.length !== 3) {
      pattiResult.textContent = '-';
      return;
    }
    const total = digits.split('').reduce((sum, digit) => sum + Number(digit), 0);
    pattiResult.textContent = String(total % 10);
  }
  if (pattiButton) pattiButton.addEventListener('click', calculatePatti);
  if (pattiInput) pattiInput.addEventListener('input', calculatePatti);
})();
