document.addEventListener('DOMContentLoaded', () => {
  const section = document.querySelector('.about');

  if (!section) return;

  const images = section.querySelectorAll('.about__img-wrap');

  if (images.length === 0) return;

  const baseFinalPositions = [
    { x: -254, y: -250 },
    { x: 50, y: -201 },
    { x: 203, y: -250 },
    { x: -256, y: 300 },
    { x: 30, y: 150 },
    { x: 256, y: 300 },
  ];

  const baseWidth = 1020;

  function getFinalPositions() {
    const scale = Math.min(window.innerWidth, baseWidth) / baseWidth;
    return baseFinalPositions.map(pos => ({
      x: pos.x * scale,
      y: pos.y * scale
    }));
  }

  if (images.length !== baseFinalPositions.length) {
    console.warn('Количество изображений не соответствует количеству заданных позиций');
    return;
  }

  function render(progress) {
    const finalPositions = getFinalPositions();
    images.forEach((img, i) => {
      const pos = finalPositions[i];
      const x = pos.x * progress;
      const y = pos.y * progress;
      img.style.transform = `translate(-50%, -50%) translate(${x}px, ${y}px)`;
    });
  }

  function onScroll() {
    const rect = section.getBoundingClientRect();
    const windowHeight = window.innerHeight;

    const totalScroll = section.offsetHeight - windowHeight;
    const scrollTop = window.scrollY - section.offsetTop;

    let progress = scrollTop / totalScroll;
    if (progress < 0) progress = 0;
    if (progress > 1) progress = 1;

    render(progress);
  }

  function onResize() {
    onScroll();
  }

  function init() {
    render(0);
    window.addEventListener('scroll', onScroll);
    window.addEventListener('resize', onResize);
  }

  function destroy() {
    window.removeEventListener('scroll', onScroll);
    window.removeEventListener('resize', onResize);
  }

  init();

});
