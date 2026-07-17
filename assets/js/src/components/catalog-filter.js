document.addEventListener('DOMContentLoaded', function () {
  const buttons = document.querySelectorAll('.catalog__btn');
  const cards = document.querySelectorAll('.project');
  const allFilterButton = document.querySelector('[data-filter="all"]');

  if ((buttons.length === 0 && cards.length === 0) || !allFilterButton) {
    return;
  }

  let activeFilters = new Set();

  if (cards.length > 0) {
    allFilterButton.classList.add('active');
  }

  buttons.forEach(button => {
    button.addEventListener('click', () => {
      const filter = button.dataset.filter;

      if (filter === 'all') {
        activeFilters.clear();
        buttons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
      } else {
        allFilterButton.classList.remove('active');

        if (activeFilters.has(filter)) {
          activeFilters.delete(filter);
          button.classList.remove('active');
        } else {
          activeFilters.add(filter);
          button.classList.add('active');
        }

        if (activeFilters.size === 0) {
          allFilterButton.classList.add('active');
        }
      }

      if (cards.length > 0) {
        filterCards();
      }
    });
  });

  function filterCards() {
    if (activeFilters.size === 0) {
      cards.forEach(card => showCard(card));
      return;
    }

    cards.forEach(card => {
      const categories = (card.dataset.category || '').split(/\s+/).filter(Boolean);
      const isMatch = categories.some(category => activeFilters.has(category));
      if (isMatch) {
        showCard(card);
      } else {
        hideCard(card);
      }
    });
  }

  function showCard(card) {
    card.style.display = '';
    card.classList.remove('fade-out');
    card.classList.add('fade-in');
  }

  function hideCard(card) {
    card.classList.remove('fade-in');
    card.classList.add('fade-out');
    setTimeout(() => {
      card.style.display = 'none';
    }, 300);
  }
});
