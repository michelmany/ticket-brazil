<template>
    <section class="purchase section">
        <div class="container">

            <div class="purchase__step step-1" v-show="isStep(1)">
                <div class="purchase__step-label">
                    <span class="number">1</span> Select the parade type
                </div>
                <ul class="purchase__items">
                    <li class="purchase__item button" @click="nextStep(2, index)" 
                        :class="{ selected: index === activeItem }" 
                        v-for="(parade, index) in paradeType" :key="index">{{ parade }}</li>
                </ul>
            </div>

            <transition name="fade">
                <div class="purchase__step step-2" v-show="isStep(2)">
                    <div class="purchase__step-label">
                        <span class="number">2</span> Select the date
                    </div>
                    <ul class="purchase__items">
                        <li class="purchase__item button" @click="nextStep(3)">Friday (March 01)</li>
                        <li class="purchase__item button" @click="nextStep(3)">Saturday (March 02)</li>
                    </ul>
                </div>
            </transition>

            <transition name="fade">
                <div class="purchase__step step-3" v-show="isStep(3)">
                    <div class="purchase__step-label">
                        <span class="number">3</span> Select the seat type
                    </div>
                    <div class="purchase__items">
                        <div class="purchase__item button" @click="nextStep(4)">Grandstand tickets</div>
                        <div class="purchase__item button" @click="nextStep(4)">Open front box seats</div>
                    </div>
                </div>
            </transition>

            <transition name="fade">
                <div class="purchase__step step-4" v-show="isStep(4)">
                    <div class="purchase__step-label">
                        <span class="number">4</span> Select the sector
                    </div>
                    <div class="purchase__items">
                        <div class="purchase__item button sector" @click="nextStep(5)">1</div>
                        <div class="purchase__item button sector" @click="nextStep(5)">2</div>
                        <div class="purchase__item button sector" @click="nextStep(5)">5</div>
                        <div class="purchase__item button sector" @click="nextStep(5)">4</div>
                        <div class="purchase__item button sector" @click="nextStep(5)">5</div>
                        <div class="purchase__item button sector" @click="nextStep(5)">6</div>
                        <div class="purchase__item button sector" @click="nextStep(5)">7</div>
                        <div class="purchase__item button sector" @click="nextStep(5)">8</div>
                        <div class="purchase__item button sector" @click="nextStep(5)">9</div>
                        <div class="purchase__item button sector" @click="nextStep(5)">10</div>
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
                paradeType: ['Preliminary Parades', 'Main Parades', 'Champions’ Parade'],
                activeItem: -1
            }
        },

        computed: {
            
        },

        methods: {
            nextStep(val, idx) {
                this.currentStep = val
                let selected = event.target
                selected.classList.add('selected')
                this.activeItem = idx
            },

            isStep(val) {
                return this.currentStep >= val
            }
        },

        mounted() {
            console.log(this.currentStep);
        }
        
    }
</script>

<style lang="sass">

    .fade-enter-active, .fade-leave-active
        transition: opacity .5s;

    .fade-enter, .fade-leave-to
        opacity: 0

</style>