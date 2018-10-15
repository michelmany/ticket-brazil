<?php


/**
 * Edit WooCommerce Checout Fields
 */

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

function custom_override_checkout_fields( $fields ) {
    unset($fields['billing']['billing_company']);

     $fields['billing']['billing_cpf'] = array(
        'label'     => __('CPF', 'woocommerce'),
        'placeholder'   => _x('CPF', 'placeholder', 'woocommerce'),
        'required'  => true,
        'class'     => array('form-row-wide'),
        'clear'     => true
     );

     return $fields;
}

/**
 * Display field value on the order edit page
 */
 
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
    echo '<p><strong>'.__('CPF').':</strong> ' . get_post_meta( $order->get_id(), '_billing_cpf', true ) . '</p>';
}