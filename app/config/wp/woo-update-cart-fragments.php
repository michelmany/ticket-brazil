<?php

add_filter( 'woocommerce_add_to_cart_fragments', 'iconic_cart_count_fragments', 10, 1 );
 
function iconic_cart_count_fragments( $fragments ) {
    
    // $fragments['div.header-cart-count'] = '<div class="header-cart-count">' . WC()->cart->get_cart_contents_count() . '</div>';
    $fragments['span.header-icon-cart'] = '<span class="header-icon-cart badge is-badge-danger is-badge-small" data-badge="'.WC()->cart->get_cart_contents_count().'"><img src="/wp-content/themes/ticket-brazil/resources/assets/images/icon-cart-gray.png" alt="Cart"></span>';

    // $fragments['div.cart-collaterals'] = '<div class="cart-collaterals">Olá</div>';
    
    return $fragments;
    
}