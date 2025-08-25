import Swiper from 'swiper';
import { Navigation, Pagination, EffectFade, Autoplay } from 'swiper/modules';
Swiper.use([Navigation, Pagination, EffectFade, Autoplay]);
const slider = new Swiper('.slider', {
  slidesPerView: 1,
  loop: true,
  effect: "fade",
  fadeEffect: {
    transform: true,
    crossFade: true,
  },
  speed: 1500,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  navigation: {
    nextEl: '.slider__btn-next',
    prevEl: '.slider__btn-prev',
  },
});
