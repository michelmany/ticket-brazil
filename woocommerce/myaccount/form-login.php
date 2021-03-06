<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="u-columns col2-set" id="customer_login">

<?php endif; ?>

	<div class="u-column1 col-1">

		<h2 class="title is-4"><?php esc_html_e( 'New User', 'base-camp' ); ?></h2>

		<form method="post" class="woocommerce-form woocommerce-form-register register">

		<p><small><?php echo __('All fields are mandatory.', 'base-camp'); ?></small></p><br>

			<div class="field">
				<div class="control">
					<label class="radio">
						<input 
							<?php if ( ! empty( $_POST['nationality'] ) ) checked( $_POST['nationality'], 'brazilian', true ); ?>
							type="radio"
							v-model="registerForm.nationality"
							name="nationality"
							value="brazilian">
							&#160;<?php echo __('Brazilian', 'base-camp'); ?>
					</label>
					
					<label class="radio">
						<input
							<?php if ( ! empty( $_POST['nationality'] ) ) checked( $_POST['nationality'], 'foreign', true ); ?>
							type="radio" 
							v-model="registerForm.nationality" 
							name="nationality" 
							value="foreign">
							&#160;<?php echo __('Foreign', 'base-camp'); ?>
					</label>
				</div>
			</div>

			<p class="form-row form-row-first">
				<label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
			</p>

			<p class="form-row form-row-last">
				<label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
			</p>


			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide field">
					<label for="reg_username label"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text input" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
				</p>

			<?php endif; ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide field">
				<label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
				</p>

			<?php endif; ?>

			<?php
				$woo_countries = new WC_Countries();
				// Get default country
				$default_country = $woo_countries->get_base_country();
				// Get states in default country
				$states = $woo_countries->get_states( $default_country );
			?>			
		
			<div class="form-row form-row-wide" v-if="isBrazilian">
				<label for="reg_billing_state"><?php _e( 'State / County', 'woocommerce' ); ?> <span class="required">*</span></label>
				<div class="select" v-if="isBrazilian">
					<select class="state_select js_field-state select short" name="billing_state" id="reg_billing_state">
						<option value=""><?php _e( 'Select a state&hellip;', 'woocommerce' ) ?></option>
						<?php foreach ($states as $state_key => $state) : ?>
							<option value="<?php echo $state_key; ?>"><?php echo $state; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>		

			<input type="hidden" name="billing_country" value="BR" v-if="isBrazilian">
		
			<div class="form-row form-row-wide" v-if="!isBrazilian">
				<label for="reg_billing_country"><?php _e( 'Country', 'woocommerce' ); ?> <span class="required">*</span></label>
				<div class="select" v-if="!isBrazilian">
					<select class="country_select js_field-country select short" name="billing_country" id="reg_billing_country">
						<option value=""><?php _e( 'Select a country&hellip;', 'woocommerce' ) ?></option>
						<option v-if="isBrazilian" value="<?php echo $default_country; ?>" selected>Brasil</option>
						<?php foreach ($woo_countries->countries as $country_key => $country) : ?>
							<option value="<?php echo $country_key; ?>"><?php echo $country; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>							

			<div class="form-row form-row-wide" >
				<label for="reg_pdocument" v-if="isBrazilian">CPF <abbr title="required" class="required">*</abbr></label>
				<label for="reg_pdocument" v-else><?php _e( 'Passport', 'base-camp' ); ?> <abbr title="required" class="required">*</abbr></label>
				<input type="text" class="input-text" name="pdocument" id="reg_pdocument" value="<?php if ( ! empty( $_POST['pdocument'] ) ) esc_attr_e( $_POST['pdocument'] ); ?>" />
			</div>   
			
			<div class="form-row form-row-wide">
				<label for="reg_idnumber"><?php _e( 'ID Number', 'base-camp' ); ?> <abbr title="required" class="required">*</abbr></label>
				<input type="text" class="input-text" name="idnumber" id="reg_idnumber" value="<?php if ( ! empty( $_POST['idnumber'] ) ) esc_attr_e( $_POST['idnumber'] ); ?>" />
			</div>     

			<div class="clear"></div>			

			<?php do_action( 'woocommerce_register_form' ); ?>

			<div class="woocommerce-FormRow form-row">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<button type="submit" style="margin-top: 10px;" class="woocommerce-Button button is-success is-medium is-fullwidth" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
			</div>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>		

	</div>
<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	<div class="u-column2 col-2">

		<h2 class="title is-4"><?php esc_html_e( 'Registered User', 'base-camp' ); ?></h2>
		<form class="woocommerce-form woocommerce-form-login login" method="post">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</div>
			<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
			</div>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<div class="form-row">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<button type="submit" style="margin-top: 10px; margin-bottom: 15px;" class="woocommerce-Button button is-info is-medium is-fullwidth" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
				</label>
			</div>
			<div class="woocommerce-LostPassword lost_password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
			</div>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

	</div>

</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>


