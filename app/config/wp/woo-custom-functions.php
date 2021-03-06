<?php

/**
 * Handle Custom WooCommerce Redirects
 */
add_action('template_redirect', 'woocommerce_custom_redirections');

function woocommerce_custom_redirections() {
    /* Case1: Non logged user on checkout page (cart empty or not empty) */
    if ( !is_user_logged_in() && is_checkout() ) {
        wp_redirect( get_permalink( get_option('woocommerce_myaccount_page_id') ).'?ischeckout=true' );
        exit;
    }

    /* Case2: Logged user on my account page with something in cart */
    $is_checkout = isset($_GET['ischeckout']) ?: false;
    if ( is_user_logged_in() && ! WC()->cart->is_empty() && is_account_page() && $is_checkout == true )
        wp_redirect( get_permalink( get_option('woocommerce_checkout_page_id') ) );
}


/**
 * Adding meta data to of the products and showing on the admin order page
 */
function wdm_add_custom_order_line_item_meta($item, $cart_item_key, $values, $order) {
    $prods_acf = get_fields($values['product_id']);
    foreach ($prods_acf as $acf_key => $prod_acf) {
        $item->add_meta_data($acf_key, $prod_acf->name);
    }
}
add_action( 'woocommerce_checkout_create_order_line_item', 'wdm_add_custom_order_line_item_meta', 10, 4 );
