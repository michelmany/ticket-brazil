<?php

/**
 * Handle Custom WooCommerce Redirects
 */
add_action('template_redirect', 'woocommerce_custom_redirections');

function woocommerce_custom_redirections() {
    /* Case1: Non logged user on checkout page (cart empty or not empty) */
    if ( !is_user_logged_in() && is_checkout() )
        wp_redirect( get_permalink( get_option('woocommerce_myaccount_page_id') ) );

    /* Case2: Logged user on my account page with something in cart */
    // if( is_user_logged_in() && ! WC()->cart->is_empty() && is_account_page() )
    //     wp_redirect( get_permalink( get_option('woocommerce_checkout_page_id') ) );
}



add_action( 'woocommerce_checkout_create_order_line_item', 'wdm_add_custom_order_line_item_meta',10,4 );

function wdm_add_custom_order_line_item_meta($item, $cart_item_key, $values, $order) {
    $item->add_meta_data('_many_test', 'test');
}  