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