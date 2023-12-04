import Splide from '@splidejs/splide';

const carousel = document.querySelector('.splide ');

console.log(carousel);

if(carousel){
    var splide = new Splide( carousel, {
        arrows : false,
        direction: 'ttb',
        height   : '15rem',
        perPage: 2,
        wheel    : true,
      } );
      
      splide.mount();
};

