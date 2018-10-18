<?php

/**
 * Remove Registration privacy policy action
 */

function remove_my_action() {
    remove_action( 'woocommerce_register_form', 'wc_registration_privacy_policy_text', 20 );
}

add_action( 'woocommerce_register_form', 'remove_my_action', 10);


/**
 * Validate the extra register fields.
 *
 */
function wooc_validate_extra_register_fields( $username, $email, $errors ) {
    if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
        $errors->add( 'billing_first_name_error', __( 'First name is required!', 'woocommerce' ) );
    }
    if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
        $errors->add( 'billing_last_name_error', __( 'Last name is required!.', 'woocommerce' ) );
    }
    return $errors;
}
add_filter( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );