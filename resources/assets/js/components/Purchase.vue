<template>
    <section class="purchase">
        <div class="container">

            <div class="purchase__step step-1">
                <div class="purchase__step-label">
                    <span>1</span> Select the parade type
                </div>
                <div class="purchase__items">
                    <div class="purchase__item button selected">Preliminary Parades</div>
                    <div class="purchase__item button">Main Parades</div>
                    <div class="purchase__item button">Champions’ Parade</div>
                </div>
            </div>

            <div class="purchase__step step-2">
                <div class="purchase__step-label">
                    <span>2</span> Select the date
                </div>
                <div class="purchase__items">
                    <div class="purchase__item button">Friday (March 01)</div>
                    <div class="purchase__item button">Saturday (March 02)</div>
                </div>
            </div>

            <div class="purchase__step step-3">
                <div class="purchase__step-label">
                    <span>3</span> Select the seat type
                </div>
                <div class="purchase__items">
                    <div class="purchase__item button">Grandstand tickets</div>
                    <div class="purchase__item button">Open front box seats</div>
                </div>
            </div>

            <div class="purchase__step step-4">
                <div class="purchase__step-label">
                    <span>4</span> Select the sector
                </div>
                <div class="purchase__items">
                    <div class="purchase__item button sector">1</div>
                    <div class="purchase__item button sector">2</div>
                    <div class="purchase__item button sector">3</div>
                    <div class="purchase__item button sector">4</div>
                    <div class="purchase__item button sector">5</div>
                    <div class="purchase__item button sector">6</div>
                    <div class="purchase__item button sector">7</div>
                    <div class="purchase__item button sector">8</div>
                    <div class="purchase__item button sector">9</div>
                    <div class="purchase__item button sector">10</div>
                </div>
            </div>

            <div class="purchase__step step-5">
                <div class="purchase__step-label">
                    <span>5</span> Enter the quantity
                </div>
                <div class="purchase__items">
                    <div class="purchase__item-quantity">
                        <button class="button">-</button> 3 <button class="button">+</button>
                    </div>
                </div>
            </div>

            <div class="purchase__step step-6">
                <div class="purchase__step-label">
                    <span>6</span> Add to cart
                </div>
                <div class="purchase__item-total">
                    <span>3x $18.40</span>

                    <button class="purchase__add-to-cart-btn button">
                        Add to cart
                    </button>
                </div>

            </div>             

        </div>  
    </section>
</template>

<script>
    export default {
        
    }
</script>

<style scoped>

</style>