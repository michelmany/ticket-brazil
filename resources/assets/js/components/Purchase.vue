<template>
    <section class="purchase section">
        <div class="container">

            <div class="purchase__step step-1" v-show="isStep(1)">
                <div class="purchase__step-label">
                    <span class="number">1</span> {{ this.stepsLabelsArray.parade }}
                </div>
                <div class="purchase__items">
                    <label :for="`parade-${index}`" class="purchase__item button" v-for="(parade, index) in parades" :key="index">
                        <input 
                            :id="`parade-${index}`" 
                            type="radio" 
                            v-model="selected.parade" 
                            :value="parade" 
                            class="is-hidden"
                            @click="nextStep(2, index, parade)">
                        {{ parade.name }}
                    </label>
                </div>
            </div>

            <transition name="fade">
                <div class="purchase__step step-2" v-show="isStep(2)">
                    <div class="purchase__step-label">
                        <span class="number">2</span> {{ this.stepsLabelsArray.date }}
                    </div>
                    <div class="purchase__items">
                        <label :for="`date-${index}`" class="purchase__item button" 
                            v-for="(date, index) in filterDates()" :key="index" >
                            <input 
                                :id="`date-${index}`" 
                                type="radio" 
                                v-model="selected.date" 
                                :value="date" 
                                class="is-hidden"
                                @click="nextStep(3, index)">
                            {{ date.name }}
                        </label>                        
                    </div>
                </div>
            </transition>

            <transition name="fade">
                <div class="purchase__step step-3" v-show="isStep(3)">
                    <div class="purchase__step-label">
                        <span class="number">3</span> {{ this.stepsLabelsArray.seat }}
                    </div>
                    <div class="purchase__items">
                        <label :for="`seat-${index}`" class="purchase__item button" 
                            v-for="(seat, index) in filterSeats()" :key="index" >
                            <input 
                                :id="`seat-${index}`" 
                                type="radio" 
                                v-model="selected.seat" 
                                :value="seat" 
                                class="is-hidden"
                                @click="nextStep(4, index)">
                            {{ seat.name }}
                        </label> 
                    </div>
                </div>
            </transition>

            <transition name="fade">
                <div class="purchase__step step-4" v-show="isStep(4)">
                    <div class="purchase__step-label">
                        <span class="number">4</span> {{ this.stepsLabelsArray.sector }}
                    </div>
                    <div class="purchase__items">
                        <label :for="`sector-${index}`" class="purchase__item button sector" 
                            v-for="(ticket, index) in productsFilter" :key="index" >
                            <input 
                                :id="`sector-${index}`" 
                                type="radio" 
                                v-model="selected.product" 
                                :value="ticket" 
                                class="is-hidden"
                                @click="nextStep(5, index)">
                            {{ ticket.name }} <br>
                            <span class="purchase__item-price">R$ {{ ticket.price }}</span>
                        </label>
                    </div>
                </div>
            </transition>

            <transition name="fade">
                <div class="purchase__step step-5" v-show="isStep(5)">
                    <div class="purchase__step-label">
                        <span class="number">5</span> {{ this.stepsLabelsArray.quantity }}
                    </div>
                    <div class="purchase__items">
                        <div class="purchase__item-quantity">
                            <button class="button" @click="decrease()">-</button>
                            <span>{{ quantity }}</span>
                            <button class="button" @click="increase()">+</button>
                        </div>
                    </div>
                </div>
            </transition>

            <transition name="fade">
                <div class="purchase__step step-6" v-show="isStep(5)">
                    <div class="purchase__step-label">
                        <span class="number">6</span> {{ this.stepsLabelsArray.add_to_cart }}
                    </div>
                    <div class="purchase__item-total">
                        <div class="columns">
                            <div class="column">
                                <span>{{ quantity }}x R${{ selected.product.price }}</span>
                            </div>
                            <div class="column">
                                <a class="purchase__add-to-cart-btn button" :href="`?add-to-cart=${selected.product.ID}&quantity=${ quantity }`">
                                    {{ this.stepsLabelsArray.add_to_cart }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>             
            </transition>

        </div>  
    </section>
</template>

<script>
    import axios from 'axios'

    export default {
        props: ['currentLang', 'stepsLabels', 'paradesList', 'datesList', 'seatsList'],
        
        data() {
            return {
                currentStep: 1,
                quantity: 1,
                selected: {
                    product: Object,
                    parade: Object,
                    date: Object,
                    seat: Object,
                    quantity: Number
                },
                currentSelectedIdx: -1,
                productsList: Object,
                stepsLabelsArray: Array,
                parades: Array,
                dates: Array,
                seats: Array,
                isProductsLoaded: false
                
            }
        },

        computed: {
            productsFilter() {
                if (this.isProductsLoaded == true) {
                    const filteredProducts = this.productsList.filter(el => {
                        return el.acf.date.name == this.selected.date.name
                            && el.acf.seat_type.name == this.selected.seat.name
                    })
                    return filteredProducts
                }
                return
            }
        },

        methods: {
            getProducts(parade_id) {
                axios
                    .get(`/wp-json/tickets/v1/products/${this.currentLang}`)
                    .then(res => {
                        // console.log(res)
                        this.productsList = res.data
                        this.isProductsLoaded = true
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },        

            filterSeats() {
                const filteredItem = this.seats.filter( item => {
                    const items = item.parade_id.filter( id => {
                        return id.includes(this.selected.parade.id)
                    })
                    return items.length > 0
                })
                return filteredItem
            },

            filterDates() {
                const filteredItem = this.dates.filter(item => {
                    return item.parade_id == this.selected.parade.id
                })
                return filteredItem
            },

            nextStep(step, idx, el) {

                if (this.currentSelectedIdx != idx) {
                    this.currentSelectedIdx = idx
                    if (step == 2) {
                        this.getProducts(el.id)
                    }
                }   

                this.currentStep = step
                const selected = event.target.parentElement
                const prevStep = this.currentStep - 1
                const divParent = document.querySelector(".step-" + prevStep)
                const purchaseItem = divParent.querySelectorAll(".purchase__item")

                purchaseItem.forEach(item => {
                    item.classList.remove('selected')
                })                

                selected.classList.add('selected')
                this.clearNextStep(step)
            },

            clearNextStep(step) { // clear next step when call the methods
                const divParentNextStep = document.querySelector(".step-" + step)
                const purchaseItemNextSep = divParentNextStep.querySelectorAll(".purchase__item")

                purchaseItemNextSep.forEach(item => {
                    item.classList.remove('selected')
                })
            },

            isStep(val) {
                return this.currentStep >= val
            },

            increase() {
                return this.quantity += 1
            },

            decrease() {
                if (this.quantity > 1) {
                    return this.quantity -= 1
                }
            }            

        },

        created() {
            this.parades = JSON.parse(this.paradesList)
            this.dates = JSON.parse(this.datesList)
            this.seats = JSON.parse(this.seatsList)
            this.stepsLabelsArray = JSON.parse(this.stepsLabels)
        },
        
    }
</script>

<style lang="sass">

    .fade-enter-active, .fade-leave-active
        transition: opacity .5s;

    .fade-enter, .fade-leave-to
        opacity: 0

</style>