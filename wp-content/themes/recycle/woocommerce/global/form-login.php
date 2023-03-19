<?php
/**
 * Login form
 * 
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( is_user_logged_in() ) {
	return;
}

?>
<form class="woocommerce-form woocommerce-form-login login row" method="post" <?php echo ( $hidden ) ? 'style="display:none;"' : ''; ?>>

	<?php do_action( 'woocommerce_login_form_start' ); ?>
	<div class="col-md-12 margin-bottom-small">
		<?php echo ( $message ) ? wpautop( wptexturize( $message ) ) : ''; ?>
	</div>
	<div class="col-md-5 name">
		<label for="username"><?php _e( 'Username or email address', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="text" class="block woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( $_POST['username'] ) : ''; ?>" />				
	</div>

	<div class="col-md-5 pass">
		<label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input class="woocommerce-Input woocommerce-Input--text input-text block" type="password" name="password" id="password" />
	</div>

	<?php do_action( 'woocommerce_login_form' ); ?>


	<div class="col-md-2">
		<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
		<input type="submit" class="btn-block btn btn-md btn-flat btn-c3" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>" />

	</div>
	<div class="col-xs-6">
		<p class="woocommerce-LostPassword lost_password">
			<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
		</p>			
	</div>

	<div class="col-xs-6 text-right orion-woo-remember-me">
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
			<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php _e( 'Remember me', 'woocommerce' ); ?></span>
		</label>
	</div>

	<?php do_action( 'woocommerce_login_form_end' ); ?>

</form>
