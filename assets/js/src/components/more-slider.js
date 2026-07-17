import Swiper from 'swiper';

document.addEventListener('DOMContentLoaded', () => {
  const wrapper = document.querySelector('.more__swiper-wrapper');
  const slides = document.querySelectorAll('.more__slide');
  const sliderContainer = document.querySelector('.more__slider');

  if (!sliderContainer || !wrapper || slides.length === 0) {
    return;
  }

  const moreSlider = new Swiper('.more__slider', {
    loop: true,
    speed: 5000,
    autoplay: {
      delay: 1,
      disableOnInteraction: false,
      waitForTransition: false,
      pauseOnMouseEnter: false
    },
    freeMode: {
      enabled: true,
      momentum: false,
      sticky: false
    },
    slidesPerView: 'auto',
    spaceBetween: 30,
    allowTouchMove: false,
    resistance: false,
    resistanceRatio: 0
  });

  slides.forEach(slide => {
    wrapper.appendChild(slide.cloneNode(true));
  });

  let pos = 0;
  const speed = 1;

  function animate() {
    pos = (pos - speed) % (wrapper.scrollWidth / 2);
    wrapper.style.transform = `translateX(${pos}px)`;
    requestAnimationFrame(animate);
  }

  animate();
});
