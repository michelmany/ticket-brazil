<?php

/*
* Saving data from ajax (main.js)
*/
function my_save_options() {
    // $nonce = $_POST['nonce_ajax'];
    // if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        // die ( 'Busted!');    

    $delivery_enabled = $_POST['delivery_enabled'];
    $delivery_type = $_POST['delivery_type'];
    $delivery_to = $_POST['delivery_to'];
    $delivery_arrival_date = $_POST['delivery_arrival_date'];
    $delivery_departure_date = $_POST['delivery_departure_date'];

    WC()->session->set('delivery_enabled', $delivery_enabled);
    WC()->session->set('delivery_type', $delivery_type);
    WC()->session->set('delivery_to', $delivery_to);
    WC()->session->set('delivery_arrival_date', $delivery_arrival_date);
    WC()->session->set('delivery_departure_date', $delivery_departure_date);

    wp_send_json( array( 'success' => true, 'message' => 'Saved to WC session', 'delivery_enabled' => $delivery_enabled ) );
}


/*
* Attaching fields from ajax and saving these in the database
*/
function before_checkout_create_order( $order, $data ) {

    $custom_delivery = WC()->session->get('delivery_enabled');
   
    if ( !empty($custom_delivery) && $custom_delivery == 'yes' ) :
        $delivery_type = WC()->session->get('delivery_type');
        $delivery_arrival_date = WC()->session->get('delivery_arrival_date');
        $delivery_departure_date = WC()->session->get('delivery_departure_date');
                
        if ( !empty($delivery_type) )
            $order->update_meta_data( '_delivery_type', $delivery_type );

        if ( !empty($delivery_arrival_date) )
            $order->update_meta_data( '_delivery_arrival_date', $delivery_arrival_date );

        if ( !empty($delivery_departure_date) )
            $order->update_meta_data( '_delivery_departure_date', $delivery_departure_date );

        $delivery_to_fields = WC()->session->get('delivery_to');
        if ( !empty($delivery_to_fields) && is_array($delivery_to_fields) ) {
            foreach ( $delivery_to_fields as $delivery_key => $delivery_field ) {
                $order->update_meta_data( '_delivery_'.$delivery_key, $delivery_field );
            }
        }
    endif;

    if ( !empty($custom_delivery) && $custom_delivery == 'no' )
        $order->update_meta_data( '_delivery_type', 'pickup' );

}        
add_action('woocommerce_checkout_create_order', 'before_checkout_create_order', 20, 2);