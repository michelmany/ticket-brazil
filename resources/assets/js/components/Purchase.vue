<template>
    <section class="purchase section">
        <div class="container">

            <div class="purchase__step step-1" v-show="isStep(1)">
                <div class="purchase__step-label">
                    <span class="number">1</span> {{ this.stepsLabelsArray.parade }}
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
                        <span class="number">2</span> {{ this.stepsLabelsArray.date }}
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
                        <span class="number">3</span> {{ this.stepsLabelsArray.seat }}
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
                        <span class="number">4</span> {{ this.stepsLabelsArray.sector }}
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
                                <a class="purchase__add-to-cart-btn button" :href="`?add-to-cart=${selected.product.id}&quantity=${ quantity }&attribute_pa_date=${selected.date.name}`">
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
    export default {
        props: ['products', 'stepsLabels', 'productsAttr'],
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
                stepsLabelsArray: Array,
                parades: Array,
                
            }
        },

        computed: {
            productsFilter() {
                const filteredProducts = this.productsList.filter(el => {
                    return el.acf.date.name == this.selected.date.name
                        && el.acf.seat_type.name == this.selected.seat.name
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
            this.parades = JSON.parse(this.productsAttr)
            this.stepsLabelsArray = JSON.parse(this.stepsLabels)
            this.productsList = JSON.parse(this.products)
            console.log(JSON.parse(this.products))
            console.log(JSON.parse(this.productsAttr))
        },
        
    }
</script>

<style lang="sass">

    .fade-enter-active, .fade-leave-active
        transition: opacity .5s;

    .fade-enter, .fade-leave-to
        opacity: 0

</style>