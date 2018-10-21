import Vue from 'vue';
import Slick from 'vue-slick';
import Example from './components/Example';
import Purchase from './components/Purchase';
import axios from 'axios'

Vue.component('slick', Slick)
Vue.component('purchase', Purchase)

new Vue({
    el: '#app',
    components: {
        Example,
        Purchase
    },
    data() {
        return {
            modalDelivery: {
              delivery: 'no',
              isOpen: 'no'
            },
            registerForm: {
              nationality: 'brazilian'
            },
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
            sliderHomeOptions: {
              dots: false,
              arrows: true,
              fade: false,
              autoplay: true,
              slidesToShow: 1,
              slidesToScroll: 1,
              infinite: false,
              appendArrows: '.hero-home__controls',
              focusOnSelect: false,     
              swipeToSlide: false,
              touchThreshold: 50,     
              nextArrow: '<button class="prev"></button>',
              prevArrow: '<button class="next"></button>',  
            },            
            slickOptionsTour: {
              dots: true,
              arrows: false,
              fade: false,
              autoplay: true,
              slidesToShow: 1,
              slidesToScroll: 1,
              infinite: true,
              appendDots: '.slick__dots',
              focusOnSelect: false,     
              swipeToSlide: false,
              touchThreshold: 50,               
            }
        }    
    },

    computed: {
      isBrazilian() {
        return this.registerForm.nationality == 'brazilian'
      }
    },

    mounted() {
      this.updateCartOnChangeQuantity()
    },    

    methods: {
      openDeliveryModal() {
        this.modalDelivery.isOpen = 'yes'
      },

      closeDeliveryModal(action) {
        if (action == 'save') {
          this.modalDelivery.isOpen = 'no'
          this.modalDelivery.delivery = 'yes'
          this.updateCart()
          this.saveOptionToDatabase()
          return
        }
        this.modalDelivery.isOpen = 'no'
        this.modalDelivery.delivery = 'no'
        this.updateCart()
        this.saveOptionToDatabase()
      },

      updateCartOnChangeQuantity() {
        let timeout;
        $('div.woocommerce')
          .on('change textInput input',
              'form.woocommerce-cart-form input.qty', function(){
                
          if (typeof timeout !== undefined) clearTimeout(timeout)

          if ($(this).val() == '') return; //Not if empty

          timeout = setTimeout(function() {
              $('[name="update_cart"]').trigger('click')
          }, 1500)
        })
      },

      updateCart() {
        $('[name="update_cart"]').removeAttr('disabled')
        $('[name="update_cart"]').trigger('click')
      },

      saveOptionToDatabase() {

        const data = {
          action: 'MySaveOptions',
          nonce: ajax_var.nonce,
          delivery_enabled: this.modalDelivery.delivery
        }

        axios
          .post(ajax_var.url, $.param(data))
          .then(res => {
            console.log(res)
            
          })
          .catch(error => {
            console.log(error.data)
          })


      },

    }

})

// Hide Page Loader when DOM and images are ready
$(window).on('load', () => $('.pageloader').removeClass('is-active'))

// Toggle mobile menu
$('.navbar-burger').on('click', () =>
$('.navbar-burger, .navbar-menu').toggleClass('is-active'))
