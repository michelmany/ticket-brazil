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
    $nationality = get_user_meta($order->get_customer_id(), 'nationality');
    $pdocument_label = ($nationality == 'brazilian') ? 'CPF' : 'Passport';
    echo '<p><strong>'.__($pdocument_label).':</strong> ' . get_user_meta( $order->get_customer_id(), 'pdocument', true ) . '</p>';

}
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function action_woocommerce_admin_order_data_after_shipping_address() {

}
remove_action('woocommerce_admin_order_data_after_shipping_address', 'action_woocommerce_admin_order_data_after_shipping_address', 10, 3 );

function custom_checkout_field_display_admin_order_meta_shipping($order) {
    $delivery_enable = get_post_meta( $order->get_id(), '_delivery_enabled', true );
    $delivery_type = get_post_meta( $order->get_id(), '_delivery_type', true );

    echo '<h3>'.__('Delivery', 'base-camp').' ====== </h3>';
    echo '<p><strong>'.__('Type', 'base-camp').':</strong> ' . ucfirst($delivery_type) . '</p>';

    if ( $delivery_enable == 'yes' ) {
        echo '<p>';
        echo '<strong>'.__('Arrival date', 'base-camp').':</strong> ' . get_post_meta( $order->get_id(), '_delivery_arrival_date', true ) . '<br />';
        echo '<strong>'.__('Departure date', 'base-camp').':</strong> ' . get_post_meta( $order->get_id(), '_delivery_departure_date', true ) . '<br />';
        echo '</p>';

        if ( $delivery_type == 'hotel' ) {
            echo '<p>';
            echo '<strong>'.__('Hotel Name', 'base-camp').':</strong> ' . get_post_meta( $order->get_id(), '_delivery_hotel_name', true ) . '<br />';
            echo '<strong>'.__('Reservation #', 'base-camp').':</strong> ' . get_post_meta( $order->get_id(), '_delivery_hotel_reservation', true ) . '<br />';
            echo '<strong>'.__('Customer name', 'base-camp').':</strong> ' . get_post_meta( $order->get_id(), '_delivery_hotel_customer_name', true ) . '<br />';
            echo '</p>';
        }
        
        if ( $delivery_type == 'ship' ) {
            echo '<p>';
            echo '<strong>'.__('Ship name', 'base-camp').':</strong> ' . get_post_meta( $order->get_id(), '_delivery_ship_name', true ) . '<br />';
            echo '<strong>'.__('Cabin number', 'base-camp').':</strong> ' . get_post_meta( $order->get_id(), '_delivery_ship_cabin_number', true ) . '<br />';
            echo '</p>';
        }        

        if ( $delivery_type == 'residence' ) {
            echo '<p>';
            echo '<strong>'.__('Zip code', 'base-camp').':</strong> ' . get_post_meta( $order->get_id(), '_delivery_residence_cep', true ) . '<br />';
            echo '<strong>'.__('Address', 'base-camp').':</strong> ' . get_post_meta( $order->get_id(), '_delivery_residence_logradouro', true ) . '<br />';
            echo '<strong>'.__('Number', 'base-camp').':</strong> ' . get_post_meta( $order->get_id(), '_delivery_residence_numero', true ) . '<br />';
            echo '<strong>'.__('Neighborhood', 'base-camp').':</strong> ' . get_post_meta( $order->get_id(), '_delivery_residence_bairro', true ) . '<br />';
            echo '<strong>'.__('Other information', 'base-camp').':</strong> ' . get_post_meta( $order->get_id(), '_delivery_residence_complemento', true ) . '<br />';
            echo '</p>';
        }
    }

}
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'custom_checkout_field_display_admin_order_meta_shipping', 10, 1 );
