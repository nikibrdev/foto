document.addEventListener('DOMContentLoaded', function() {
  const reviewsItems = document.querySelectorAll('.reviews__item');

  if (!reviewsItems.length) return;

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (prefersReducedMotion) return;

  function handleScroll() {
    const windowHeight = window.innerHeight;
    const windowCenter = windowHeight / 2;

    reviewsItems.forEach(item => {
      const imgWrap = item.querySelector('.reviews__img-wrap');
      if (!imgWrap) return;

      const itemRect = item.getBoundingClientRect();
      const itemCenterY = itemRect.top + itemRect.height / 2;

      const distanceFromCenter = (itemCenterY - windowCenter) / windowHeight;

      const maxOffset = 120;

      const offset = distanceFromCenter * maxOffset;

      imgWrap.style.transform = `translateY(${offset}px)`;
    });
  }

  handleScroll();

  let requestId = null;
  window.addEventListener('scroll', function() {
    if (!requestId) {
      requestId = requestAnimationFrame(() => {
        handleScroll();
        requestId = null;
      });
    }
  }, { passive: true });

  window.addEventListener('resize', handleScroll, { passive: true });
});
