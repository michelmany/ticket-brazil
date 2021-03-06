import Vue from 'vue';
import Slick from 'vue-slick';
import Example from './components/Example';
import Purchase from './components/Purchase';
import axios from 'axios'
import Datepicker from 'vuejs-datepicker'
import {en, ptBR} from 'vuejs-datepicker/dist/locale'
import VueCookie from 'vue-cookie'
import moment from 'moment'
import VueTheMask from 'vue-the-mask'

Vue.use(VueCookie)
Vue.use(VueTheMask)

Vue.component('slick', Slick)
Vue.component('purchase', Purchase)

function defaultModalDeliveryData() {
  return {
    delivery: 'no',
    isOpen: 'no',
    type: 'hotel',
    arrival_date: '',
    departure_date: '',
    hotel: {
      hotel_name: '',
      hotel_reservation: '',
      hotel_customer_name: ''
    },
    ship: {
      ship_name: '',
      ship_cabin_number: ''
    },
    residence: {
      residence_cep: '',
      residence_logradouro: '',
      residence_numero: '',
      residence_bairro: '',
      residence_complemento: ''
    }
  }
}

new Vue({
    el: '#app',
    components: {
        Example,
        Purchase,
        Datepicker
    },
    data() {
        return {
            lang: {
              en,
              br: ptBR
            },
            openModal: false,
            modalDelivery: defaultModalDeliveryData(),
            isLoading: false,
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

    created() {
      this.modalDelivery.delivery = this.$cookie.get('custom_delivery') || 'no'
    },

    methods: {
      openDeliveryModal() {
        this.openModal = true
      },

      closeDeliveryModal(action) {
        if (action == 'save') {
          this.openModal = false
          this.modalDelivery.isOpen = 'no'
          this.modalDelivery.delivery = 'yes'
          this.$cookie.set('custom_delivery', 'yes')
          this.saveOptionToDatabase()
          return
        }
        this.openModal = false
        this.modalDelivery.isOpen = 'no'
        this.modalDelivery.delivery = 'no'
        this.$cookie.set('custom_delivery', 'no')
        this.resetModalDeliveryData()
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
        let deliveryTo = this.modalDelivery.hotel

        if ( this.modalDelivery.type == 'hotel' ) {
          deliveryTo = this.modalDelivery.hotel
        }
        if ( this.modalDelivery.type == 'ship' ) {
          deliveryTo = this.modalDelivery.ship
        }
        if ( this.modalDelivery.type == 'residence' ) {
          deliveryTo = this.modalDelivery.residence
        }

        const data = {
          action: 'my_save_options',
          nonce_ajax: ajax_var.nonce,
          delivery_enabled: this.modalDelivery.delivery,
          delivery_type: this.modalDelivery.type,
          delivery_arrival_date: moment(this.modalDelivery.arrival_date).format('DD MMM YYYY'),
          delivery_departure_date: moment(this.modalDelivery.departure_date).format('DD MMM YYYY'),
          delivery_to: deliveryTo
        }

        axios
          .post(ajax_var.url, $.param(data))
          .then(res => {
            console.log(res.data)
            this.updateCart()
          })
          .catch(error => {
            console.log(error.data)
          })
      },

      resetModalDeliveryData(){
          this.$data.modalDelivery = defaultModalDeliveryData();
      },

      getcep() {
        if ( this.modalDelivery.residence.residence_cep.length === 9 ) {
          this.isLoading = true
          console.log('Consultando cep...')  

          axios.get('https://viacep.com.br/ws/' + this.modalDelivery.residence.residence_cep + '/json/', { crossdomain: true })
            .then( res => {
              this.isLoading = false
              let cep = res.data
              this.modalDelivery.residence.residence_logradouro = cep.logradouro
              this.modalDelivery.residence.residence_bairro = cep.bairro
              this.modalDelivery.residence.residence_cidade = cep.localidade
              this.modalDelivery.residence.residence_complemento = cep.complemento
              this.modalDelivery.residence.residence_uf = cep.uf
            })
        }
      },      

    }

})

// Hide Page Loader when DOM and images are ready
$(window).on('load', () => $('.pageloader').removeClass('is-active'))

// Toggle mobile menu
$('.navbar-burger').on('click', () =>
$('.navbar-burger, .navbar-menu').toggleClass('is-active'))