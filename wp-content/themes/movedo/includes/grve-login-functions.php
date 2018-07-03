<?php

/*
*	Login Helper functions
*
* 	@version	1.0
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/

 /**
 * Login User
 */
function movedo_grve_login_user(){

	$user_login		= $_POST['grve_user_login'];
	$user_pass		= $_POST['grve_user_pass'];

	$allowed_html = array(
		'br' => array(),
		'em' => array(),
		'strong' => array(),
	);

	if( !check_ajax_referer( 'movedo_grve_nonce', '_movedo_grve_nonce_login', false ) ){
		echo json_encode( array( 'error' => true, 'message'=> '<div class="grve-alert grve-alert-error">' . esc_html__( 'Session token has expired, please reload the page and try again', 'movedo'  ) . '</div>' ) );
	} elseif( empty( $user_login ) || empty( $user_pass ) ) {
		echo json_encode( array( 'error' => true, 'message' => '<div class="grve-alert grve-alert-error">' . esc_html__( 'Please fill all form fields', 'movedo' ) . '</div>' ) );
	} else {
		$user = wp_signon( array( 'user_login' => $user_login, 'user_password' => $user_pass ), false );
		if( is_wp_error( $user ) ) {
			echo json_encode( array( 'error' => true, 'message' => '<div class="grve-alert grve-alert-error">' . wp_kses( $user->get_error_message(), $allowed_html ) . '</div>' ) );
		} else {
			echo json_encode( array( 'error' => false, 'message' => '<div class="grve-alert grve-alert-success">' . esc_html__('Login successful, reloading page...', 'movedo' ) .'</div>' ) );
		}
	}
	die();
}
add_action( 'wp_ajax_nopriv_movedo_grve_login_user', 'movedo_grve_login_user' );


function movedo_grve_register_user(){

	$user_login	= $_POST['grve_user_login'];
	$user_email	= $_POST['grve_user_email'];

	if( !check_ajax_referer( 'movedo_grve_nonce', '_movedo_grve_nonce_register', false) ){
		echo json_encode( array('error' => true, 'message' => '<div class="grve-alert grve-alert-error">' . esc_html__( 'Session token has expired, please reload the page and try again', 'movedo') . '</div>' ) );
		die();
	} elseif( empty($user_login) || empty($user_email) ) {
		echo json_encode( array('error' => true, 'message'=> '<div class="grve-alert grve-alert-error">' . esc_html__( 'Please fill all form fields', 'movedo') . '</div>' ) );
		die();
	}

	$errors = register_new_user( $user_login, $user_email );

	if( is_wp_error($errors) ){

		$registration_error_messages = $errors->errors;

		$display_errors = '<div class="grve-alert grve-alert-error">';

			foreach( $registration_error_messages as $error ) {
				$display_errors .= '<p>' . $error[0] . '</p>';
			}

		$display_errors .= '</div>';

		echo json_encode( array('error' => true, 'message' => $display_errors ) );

	} else {
		echo json_encode( array('error' => false, 'message' => '<div class="grve-alert grve-alert-success">' . esc_html__( 'Registration complete. Please check your e-mail.', 'movedo' ) . '</p>' ) );
	}


	die();
}
add_action( 'wp_ajax_nopriv_movedo_grve_register_user', 'movedo_grve_register_user' );

function movedo_grve_reset_password_user(){

	$username_or_email = $_POST['grve_user_or_email'];

	if( !check_ajax_referer( 'movedo_grve_nonce', '_movedo_grve_nonce_password', false ) ){
		echo json_encode( array('error' => true, 'message' => '<div class="grve-alert grve-alert-error">' . esc_html__( 'Session token has expired, please reload the page and try again', 'movedo' ) . '</div>' ) );
	} elseif( empty( $username_or_email ) ) {
		echo json_encode( array('error' => true, 'message' => '<div class="grve-alert grve-alert-error">' . esc_html__( 'Please fill all form fields', 'movedo' ) . '</div>' ) );
	} else {

		$username = is_email( $username_or_email ) ? sanitize_email( $username_or_email ) : sanitize_user( $username_or_email );
		$user_forgotten = movedo_grve_lost_password_retrieve( $username );

		if( is_wp_error( $user_forgotten ) ){

			$lostpass_error_messages = $user_forgotten->errors;

			$display_errors = '<div class="grve-alert grve-alert-error">';
			foreach( $lostpass_error_messages as $error ){
				$display_errors .= '<p>' . $error[0] . '</p>';
			}
			$display_errors .= '</div>';

			echo json_encode( array('error' => true, 'message' => $display_errors ) );
		} else{
			echo json_encode( array('error' => false, 'message' => '<p class="grve-alert grve-alert-success">' . esc_html__( 'Password Reset. Please check your email.', 'movedo' ) . '</p>' ) );
		}
	}

	die();
}
add_action( 'wp_ajax_nopriv_movedo_grve_reset_password_user', 'movedo_grve_reset_password_user' );

function movedo_grve_lost_password_retrieve( $user_data ) {

	global $wpdb, $current_site, $wp_hasher;

	$errors = new WP_Error();

	if( empty($user_data) ){
		$errors->add( 'empty_username', esc_html__( 'Please enter a username or e-mail address.', 'movedo' ) );
	} elseif( strpos($user_data, '@') ){
		$user_data = get_user_by( 'email', trim( $user_data ) );
		if( empty($user_data)){
			$errors->add( 'invalid_email', esc_html__( 'There is no user registered with that email address.', 'movedo'  ) );
		}
	} else {
		$login = trim( $user_data );
		$user_data = get_user_by('login', $login);
	}

	if( $errors->get_error_code() ){
		return $errors;
	}

	if( !$user_data ){
		$errors->add( 'invalidcombo', esc_html__('Invalid username or e-mail.', 'movedo' ) );
		return $errors;
	}

	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;

	do_action( 'retrieve_password', $user_login );

	$allow = apply_filters('allow_password_reset', true, $user_data->ID );

	if( !$allow ){
		return new WP_Error( 'no_password_reset', esc_html__( 'Password reset is not allowed for this user', 'movedo' ) );
	} elseif ( is_wp_error($allow) ){
		return $allow;
	}

	$key = wp_generate_password(20, false);

	do_action('retrieve_password_key', $user_login, $key);

	if(empty($wp_hasher)){
		require_once ABSPATH.'wp-includes/class-phpass.php';
		$wp_hasher = new PasswordHash(8, true);
	}

	$hashed = time() . ':' . $wp_hasher->HashPassword( $key );

	$wpdb->update($wpdb->users, array('user_activation_key' => $hashed), array('user_login' => $user_login));

	$message = esc_html__( 'Someone requested that the password be reset for the following account:', 'movedo' ) . "\r\n\r\n";
	$message .= network_home_url( '/' ) . "\r\n\r\n";
	$message .= sprintf( esc_html__( 'Username: %s', 'movedo' ), $user_login ) . "\r\n\r\n";
	$message .= esc_html__( 'If this was a mistake, just ignore this email and nothing will happen.', 'movedo' ) . "\r\n\r\n";
	$message .= esc_html__( 'To reset your password, visit the following address:', 'movedo' ) . "\r\n\r\n";
	$message .= '<' . network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . ">\r\n\r\n";

	if ( is_multisite() ) {
		$blogname = $GLOBALS['current_site']->site_name;
	} else {
		$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	}

	$title   = sprintf( esc_html__( '[%s] Password Reset', 'movedo' ), $blogname );
	$title   = apply_filters( 'retrieve_password_title', $title );
	$message = apply_filters( 'retrieve_password_message', $message, $key );

	if ( $message && ! wp_mail( $user_email, $title, $message ) ) {
		$errors->add( 'noemail', __( 'The e-mail could not be sent.<br />Possible reason: your host may have disabled the mail() function.', 'movedo' ) );

		return $errors;

		wp_die();
	}

	return true;
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
