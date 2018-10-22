<?php

function my_save_options() {
    $nonce = $_POST['nonce_ajax'];

    // if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        // die ( 'Busted!');
    
    if ( isset($_POST['delivery_enabled']) ) {
        $delivery_enabled = $_POST['delivery_enabled'];
        // update_option('wacs_delivery_enabled', $delivery_enabled);

        if ( $delivery_enabled == 'yes' ) {
            echo 'TUDO CERTO!';
        } else {
            echo 'ALGO ERRADO!';
        }
    }
  
    exit;
}
