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

/**
* Below code save extra fields.
*/

function wooc_save_extra_register_fields( $customer_id ) {

    if ( isset( $_POST['nationality']) && !empty($_POST['nationality'] ) ) {
        update_user_meta( $customer_id, 'nationality', sanitize_text_field($_POST['nationality'] ) );
	}	
	if ( isset( $_POST['billing_first_name'] ) ) {
			//First name field which is by default
			update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
			// First name field which is used in WooCommerce
			update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
	}
	if ( isset( $_POST['billing_last_name'] ) ) {
			// Last name field which is by default
			update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
			// Last name field which is used in WooCommerce
			update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
    }
    if ( isset( $_POST['billing_state']) && !empty($_POST['billing_state'] ) ) {
        update_user_meta( $customer_id, 'billing_state', sanitize_text_field($_POST['billing_state'] ) );
    }
    if ( isset( $_POST['billing_country']) && !empty($_POST['billing_country'] ) ) {
        update_user_meta( $customer_id, 'billing_country', sanitize_text_field($_POST['billing_country'] ) );
	}    
    if ( isset( $_POST['pdocument']) && !empty($_POST['pdocument'] ) ) {
        update_user_meta( $customer_id, 'pdocument', sanitize_text_field($_POST['pdocument'] ) );
	}
    if ( isset( $_POST['idnumber']) && !empty($_POST['idnumber'] ) ) {
        update_user_meta( $customer_id, 'idnumber', sanitize_text_field($_POST['idnumber'] ) );
	}
  
}
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );


/**
 * Showing the user field on Edit user page (admin) 
*/
add_action( 'show_user_profile', 'crf_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'crf_show_extra_profile_fields' );

function crf_show_extra_profile_fields( $user ) {
	?>
	<h3><?php esc_html_e( 'Personal Information', 'crf' ); ?></h3>

	<table class="form-table">
		<tr>
			<th><label for="nationality"><?php esc_html_e( 'Nationality', 'base-camp' ); ?></label></th>
			<td><?php echo esc_html( ucfirst(get_user_meta( $user->ID, 'nationality', true )) ); ?></td>
		</tr>
	</table>
	<?php
}