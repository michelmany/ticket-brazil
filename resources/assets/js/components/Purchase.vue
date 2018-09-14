<template>
    <section class="purchase section">
        <div class="container">

            <div class="purchase__step step-1" v-show="isStep(1)">
                <div class="purchase__step-label">
                    <span class="number">1</span> Select the parade type
                </div>
                <ul class="purchase__items">
                    <label :for="`parade-${index}`" 
                        class="purchase__item button" 
                        v-for="(parade, index) in parades" :key="index" 
                        @click="nextStep(2, index)">
                        <input :id="`parade-${index}`" type="radio" 
                            v-model="selected.parade" :value="parade.name" class="is-hidden">
                        {{ parade.name }}
                    </label>
                </ul>
            </div>

            <transition name="fade">
                <div class="purchase__step step-2" v-show="isStep(2)">
                    <div class="purchase__step-label">
                        <span class="number">2</span> Select the date
                    </div>
                    <ul class="purchase__items">
                        <label :for="`date-${index}`" 
                            class="purchase__item button" 
                            v-for="(date, index) in paradeDate" :key="index"
                            @click="nextStep(3, index)">
                            <input :id="`date-${index}`" type="radio" 
                                v-model="selected.date" :value="date" class="is-hidden">
                            {{ date }}
                        </label>                        
                    </ul>
                </div>
            </transition>

            <transition name="fade">
                <div class="purchase__step step-3" v-show="isStep(3)">
                    <div class="purchase__step-label">
                        <span class="number">3</span> Select the seat type
                    </div>
                    <div class="purchase__items">
                        <input class="purchase__item button" value="Grandstand tickets"
                            @click="nextStep(4)" v-model="selected.seat">
                        <input class="purchase__item button" value="Open front box seats"
                            @click="nextStep(4)"  v-model="selected.seat">
                    </div>
                </div>
            </transition>

            <transition name="fade">
                <div class="purchase__step step-4" v-show="isStep(4)">
                    <div class="purchase__step-label">
                        <span class="number">4</span> Select the sector
                    </div>
                    <ul class="purchase__items">
                        <li class="purchase__item button sector" 
                            @click="nextStep(5)" v-for="(product, i) in products" :key="i">{{ product.name }}</li>
                    </ul>
                </div>
            </transition>

            <transition name="fade">
                <div class="purchase__step step-5" v-show="isStep(5)">
                    <div class="purchase__step-label">
                        <span class="number">5</span> Enter the quantity
                    </div>
                    <div class="purchase__items">
                        <div class="purchase__item-quantity">
                            <button class="button">-</button> 3 <button class="button">+</button>
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
                        <span>3x $18.40</span>

                        <button class="purchase__add-to-cart-btn button">
                            Add to cart
                        </button>
                    </div>
                </div>             
            </transition>

        </div>  
    </section>
</template>

<script>
    export default {
        data() {
            return {
                currentStep: 1,
                activeItem: -1,
                itemSelected: '',
                selected: {
                    parade: String,
                    date: String,
                    seat: String,


                },
                parades: [
                    {
                        id: 'parade-1',
                        name: 'Preliminary Parades',
                        dates: ['Friday (March 01)', 'Saturday (March 02)']
                    },
                    {
                        id: 'parade-2',
                        name: 'Main Parades',
                        dates: ['Sunday (March 03)', 'Monday (March 04)']
                    },
                    {
                        id: 'parade-3',
                        name: 'Champions’ Parade',
                        dates: ['Sábado (09 de Março)']
                    }                    
                ],
                products: [
                    { name: '1', price: '1,00' },
                    { name: '2', price: '1,00' },
                    { name: '3', price: '1,00' },
                    { name: '4', price: '1,00' },
                    { name: '5', price: '1,00' },
                    { name: '6', price: '1,00' },
                    { name: '7', price: '1,00' },
                    { name: '8', price: '1,00' },
                    { name: '9', price: '1,00' },
                    { name: '10', price: '1,00' },
                    { name: '11', price: '1,00' },
                ]
            }
        },

        computed: {
            paradeDate() {
                const dates = this.parades.filter( parade => {
                    return parade.name == this.selected.parade
                })
                
                const resultMap = dates.map(a => a.dates);

                return resultMap[0]
            }
        },

        methods: {
            nextStep(val, idx) {
                this.currentStep = val
                const selected = event.target

                const prevStep = val -1
                console.log("prevStep: " + prevStep)
                
                const divParent = document.querySelector(".step-" + prevStep)
                const purchaseItem = divParent.querySelectorAll(".purchase__item")

                purchaseItem.forEach(item => {
                    item.classList.remove('selected')
                })

                selected.classList.add('selected')

                console.log(this.currentStep)

            },

            isStep(val) {
                return this.currentStep >= val
            }
        },

        mounted() {
            console.log('current step: ' + this.currentStep);
        }
        
    }
</script>

<style lang="sass">

    .fade-enter-active, .fade-leave-active
        transition: opacity .5s;

    .fade-enter, .fade-leave-to
        opacity: 0

</style>