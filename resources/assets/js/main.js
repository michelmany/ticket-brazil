
import Vue from 'vue';
import Example from './components/Example';
import Slick from 'vue-slick';

Vue.component('slick', Slick)

new Vue({
    el: '#app',
    components: {
        Example,
    },
    data() {
        return {
            slickOptions: {
                dots: true,
                arrows: false,
                fade: false,
                autoplay: true,
                slidesToShow: 4,
                slidesToScroll: 4,
                infinite: false,
                appendDots: '.slick__dots',
                focusOnSelect: false,     
                swipeToSlide: false,
                touchThreshold: 50,                
                responsive: [
                    {
                      breakpoint: 1440,
                      settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                      }
                    },
                    {
                      breakpoint: 1024,
                      settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                      }
                    },
                    {
                      breakpoint: 480,
                      settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                      }
                    }
                ]                
            },
        };    
    }
});

// Hide Page Loader when DOM and images are ready
$(window).on('load', () => $('.pageloader').removeClass('is-active'));

// Toggle mobile menu
$('.navbar-burger').on('click', () =>
$('.navbar-burger, .navbar-menu').toggleClass('is-active'));
