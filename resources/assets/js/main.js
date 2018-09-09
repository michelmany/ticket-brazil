
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
                slidesToShow: 3,
                dots: true,
                arrows: false,
                fade: false,
                autoplay: true,
                appendDots: '.slick__dots'
            },
        };    
    }
});

// Hide Page Loader when DOM and images are ready
$(window).on('load', () => $('.pageloader').removeClass('is-active'));

// Toggle mobile menu
$('.navbar-burger').on('click', () =>
$('.navbar-burger, .navbar-menu').toggleClass('is-active'));
