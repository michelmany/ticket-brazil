<?php

function MySaveOptions() {
    global $woocommerce;

    $nonce = $_POST['nonce']; 
    
    if (isset($_POST['delivery_enabled']) ) {
        $delivery_enabled = $_POST['delivery_enabled'];
        update_option('wacs_delivery_enabled', $delivery_enabled);

        if ( $delivery_enabled == 'yes' ) {
            $_SESSION['delivery'] = 'yes';
            echo 'wacs_delivery_enabled option saved YES';
            return;
        }

        $_SESSION['delivery'] = 'no';
        echo 'wacs_delivery_enabled option saved NO';
    } 
  
    exit;
}
