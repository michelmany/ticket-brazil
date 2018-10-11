<template>
    <section class="purchase section">
        <div class="container">

            <div class="purchase__step step-1" v-show="isStep(1)">
                <div class="purchase__step-label">
                    <span class="number">1</span> Select the parade type
                </div>
                <div class="purchase__items">
                    <label :for="`parade-${index}`" class="purchase__item button" 
                        v-for="(parade, index) in parades" :key="index" @click="nextStep(2, index)">
                        <input :id="`parade-${index}`" type="radio" v-model="selected.parade" :value="parade.name" class="is-hidden">
                        {{ parade.name }}
                    </label>
                </div>

                <div v-for="(product, index) in products" :key="index">{{ product.categories }}</div>
            </div>

            <transition name="fade">
                <div class="purchase__step step-2" v-show="isStep(2)">
                    <div class="purchase__step-label">
                        <span class="number">2</span> Select the date
                    </div>
                    <div class="purchase__items">
                        <label :for="`date-${index}`" class="purchase__item button" 
                            v-for="(date, index) in setData('dates')" :key="index" @click="nextStep(3, index)">
                            <input :id="`date-${index}`" type="radio" v-model="selected.date" :value="date" class="is-hidden">
                            {{ date.name }}
                        </label>                        
                    </div>
                </div>
            </transition>

            <transition name="fade">
                <div class="purchase__step step-3" v-show="isStep(3)">
                    <div class="purchase__step-label">
                        <span class="number">3</span> Select the seat type
                    </div>
                    <div class="purchase__items">
                        <label :for="`seat-${index}`" class="purchase__item button" 
                            v-for="(seat, index) in setData('seats')" :key="index" @click="nextStep(4, index)">
                            <input :id="`seat-${index}`" type="radio" v-model="selected.seat" :value="seat" class="is-hidden">
                            {{ seat.name }}
                        </label> 
                    </div>
                </div>
            </transition>

            <transition name="fade">
                <div class="purchase__step step-4" v-show="isStep(4)">
                    <div class="purchase__step-label">
                        <span class="number">4</span> Select the sector
                    </div>
                    <div class="purchase__items">
                        <label :for="`sector-${index}`" class="purchase__item button sector" 
                            v-for="(ticket, index) in productsFilter" :key="index" @click="nextStep(5, index)">
                            <input :id="`sector-${index}`" type="radio" v-model="selected.product" :value="ticket" class="is-hidden">
                            {{ ticket.name }} <br>
                            <span class="purchase__item-price">R$ {{ ticket.price }}</span>
                        </label>                     
                        <!-- <li class="purchase__item button sector" @click="nextStep(5)" 
                            v-for="(ticket, i) in productsFilter" :key="i">{{ ticket.name }} <br>
                            <span class="purchase__item-price">$ {{ ticket.price }}</span>
                        </li> -->
                    </div>
                </div>
            </transition>

            <transition name="fade">
                <div class="purchase__step step-5" v-show="isStep(5)">
                    <div class="purchase__step-label">
                        <span class="number">5</span> Enter the quantity
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
                        <span class="number">6</span> Add to cart
                    </div>
                    <div class="purchase__item-total">
                        <span>{{ quantity }}x R${{ selected.product.price }}</span>

                        <a class="purchase__add-to-cart-btn button" 
                            :href="`?add-to-cart=${selected.product.id}&quantity=${ quantity }`">
                            Add to cart
                        </a>
                    </div>
                </div>             
            </transition>

        </div>  
    </section>
</template>

<script>
    export default {
        props: ['products'],
        data() {
            return {
                currentStep: 1,
                quantity: 1,
                selected: {
                    product: Object,
                    parade: String,
                    date: Object,
                    seat: Object,
                    quantity: Number
                },
                productsList: Array,
                parades: [
                    {
                        name: 'Preliminary Parades',
                        dates: [
                            { name: 'Friday (March 01)', slug: 'friday-march-01'},
                            { name: 'Saturday (March 02)', slug: 'saturday-march-02'}
                        ],
                        seats: [
                            { name: 'Grandstand tickets', slug: 'grandstand-tickets' },
                            { name: 'Open Front Box seats', slug: 'open-front-box-seats' }
                        ]
                    },
                    {
                        name: 'Main Parades',
                        dates: [
                            { name: 'Sunday (March 03)', slug: 'sunday-march-03'},
                            { name: 'Monday (March 04)', slug: 'monday-march-04'}
                        ],
                        seats: [
                            { name: 'Grandstand tickets', slug: 'grandstand-tickets' },
                            { name: 'Open Front Box seats', slug: 'open-front-box-seats' },
                            { name: 'Private Chairs', slug: 'private-chairs' }
                        ]
                    },
                    {
                        name: 'Champions’ Parade',
                        dates: [
                            { name: 'Saturdar (March 09)', slug: 'saturday-march-09'},
                        ],
                        seats: [
                            { name: 'Grandstand tickets', slug: 'grandstand-tickets' },
                            { name: 'Open Front Box seats', slug: 'open-front-box-seats' },
                            { name: 'Private Chairs', slug: 'private-chairs' }
                        ]
                    }                    
                ],
            }
        },

        computed: {
            productsFilter() {
                const filteredProducts = this.productsList.filter(el => {
                    return el.acf.date.slug == this.selected.date.slug
                        && el.acf.seat_type.slug == this.selected.seat.slug
                })

                return filteredProducts
            },
            setQuantity() {
                return this.selected.quantity = this.quantity
            }
        },

        methods: {
            setData(data) {
                const filteredParade = this.parades.filter(parade => {
                    return parade.name == this.selected.parade
                })
                const filtered = filteredParade.map(a => a[data]);
                return filtered[0]                
            },

            nextStep(step, idx) {
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
            this.productsList = JSON.parse(this.products)
        },
        
    }
</script>

<style lang="sass">

    .fade-enter-active, .fade-leave-active
        transition: opacity .5s;

    .fade-enter, .fade-leave-to
        opacity: 0

</style>