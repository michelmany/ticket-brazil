<?php

/**
 * Edit WooCommerce Checkout Fields
 */
function custom_override_checkout_fields( $fields ) {
    unset($fields['billing']['billing_company']);

    // $nationality = get_user_meta(get_current_user_id(), 'nationality');
    // $pdocument_label = ($nationality == 'brazilian') ? 'CPF' : 'Passport';

    //  $fields['billing']['pdocument'] = array(
    //     'label'     => __($pdocument_label, 'base-camp'),
    //     'required'  => true,
    //     'class'     => array('form-row-wide'),
    //     'clear'     => true
    //  );

     return $fields;
}
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );



/**
 * Display field value on the order edit page
 */
 function my_custom_checkout_field_display_admin_order_meta($order){
    echo '<p><strong>'.__('CPF').':</strong> ' . get_post_meta( $order->get_id(), '_pdocument', true ) . '</p>';
}
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );