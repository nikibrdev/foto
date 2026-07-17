document.addEventListener('DOMContentLoaded', function () {
  const aboutHero = document.querySelector('.about-hero');
  const title = document.querySelector('.about-hero__title');
  const imgWrap = document.querySelector('.about-hero__img-wrap');
  const headline = document.querySelector('.about-hero__headline');

  if (!aboutHero) return;

  if (window.innerWidth < 1024) {
    console.log('Анимация отключена для экранов меньше 1024px');
    return;
  }

  if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
    console.warn('GSAP или ScrollTrigger не загружены - анимация не будет работать');
    return;
  }

  if (!title || !imgWrap || !headline) {
    console.warn('Не все элементы для анимации найдены');
    return;
  }

  try {
    gsap.registerPlugin(ScrollTrigger);

    gsap.set(title, {
      position: 'relative',
      zIndex: 5,
      opacity: 1
    });

    gsap.set(imgWrap, {
      position: 'relative',
      zIndex: 50,
      y: 50
    });

    gsap.to(title, {
      fontSize: '190px',
      y: 100,
      opacity: 0,
      scrollTrigger: {
        trigger: aboutHero,
        start: 'top top',
        end: () => `+=${imgWrap.offsetHeight / 2}`,
        scrub: 1,
        pin: headline,
        pinSpacing: false,
        markers: false,
        invalidateOnRefresh: true
      }
    });

    gsap.to(imgWrap, {
      y: -window.innerHeight / 2,
      scrollTrigger: {
        trigger: aboutHero,
        start: 'top top',
        end: () => `+=${imgWrap.offsetHeight / 2}`,
        scrub: 1
      }
    });
  } catch (error) {
    console.error('Ошибка при инициализации анимации:', error);
  }
});
