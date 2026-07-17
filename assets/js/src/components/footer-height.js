document.addEventListener('DOMContentLoaded', function () {
  const footer = document.querySelector('.footer');
  let footerHeight;
  const siteContainer = document.querySelector('.site-container');

  function calculateFooterHeight() {
    footer.style.position = 'static';
    footer.style.visibility = 'hidden';

    const height = footer.offsetHeight;

    footer.style.position = 'fixed';
    footer.style.visibility = 'visible';

    return height;
  }

  function initStyles() {
    footerHeight = calculateFooterHeight();

    footer.style.bottom = `-${footerHeight}px`;

    siteContainer.style.paddingBottom = `${footerHeight}px`;
  }

  function handleScroll() {
    const scrollPosition = window.innerHeight + window.scrollY;
    const documentHeight = document.body.offsetHeight;
    const footerTrigger = documentHeight - footerHeight;

    if (scrollPosition >= footerTrigger) {
      footer.style.bottom = '0';
    } else {
      footer.style.bottom = `-${footerHeight}px`;
    }
  }

  function handleResize() {
    const newFooterHeight = calculateFooterHeight();

    if (newFooterHeight !== footerHeight) {
      footerHeight = newFooterHeight;
      footer.style.bottom = `-${footerHeight}px`;
      siteContainer.style.paddingBottom = `${footerHeight}px`;
    }

    handleScroll();
  }

  initStyles();



  let isTicking = false;
  function requestTick() {
    if (!isTicking) {
      window.requestAnimationFrame(function () {
        isTicking = false;
        handleResize();
      });
      isTicking = true;
    }
  }

  window.addEventListener('scroll', function () {
    if (!isTicking) {
      window.requestAnimationFrame(function () {
        handleScroll();
        isTicking = false;
      });
      isTicking = true;
    }
  });

  window.addEventListener('resize', requestTick);

  handleScroll();
});
