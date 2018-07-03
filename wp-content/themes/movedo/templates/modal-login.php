
<?php if( ! is_user_logged_in() ) { ?>
	<div class="grve-login-modal">
		<?php
			$movedo_version = trim( MOVEDO_GRVE_THEME_VERSION );
			$login_redirect_url = movedo_grve_option( 'login_redirect_url' );
			wp_enqueue_script( 'movedo-grve-login', get_template_directory_uri() . '/js/ajax-login.js', array( 'jquery' ), esc_attr( $movedo_version ), true );

			wp_localize_script( 'movedo-grve-login', 'grve_form', array(
				'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
				'redirect_url' => esc_url( $login_redirect_url ),
			));

			if( get_option('users_can_register') ){ ?>

				<!-- Register form -->
				<div class="grve-register-form grve-login-form-item grve-align-center">

					<div class="grve-login-form-title grve-h3 grve-with-line grve-align-center"><?php printf( esc_html__( 'Join %s', 'movedo' ), get_bloginfo('name') ); ?></div>

					<form id="grve_registration_form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="POST">

						<div class="grve-form-field">
							<input class="grve-form-control required" name="grve_user_login" type="text" placeholder="<?php esc_html_e( 'Username *', 'movedo' ); ?>"/>
						</div>
						<div class="grve-form-field">
							<input class="grve-form-control required" name="grve_user_email" id="grve_user_email" type="email" placeholder="<?php esc_html_e( 'Email *', 'movedo' ); ?>"/>
						</div>
						<?php do_action( 'movedo_grve_register_form' ); ?>
						<div class="grve-form-field">
							<input type="hidden" name="action" value="movedo_grve_register_user"/>
							<button class="btn grve-fullwidth-btn" data-loading-text="<?php esc_attr_e( 'Loading...', 'movedo' ) ?>" type="submit"><?php esc_html_e('Sign up', 'movedo'); ?></button>
						</div>
						<div class="grve-form-field">
							<span class="grve-login-link grve-link-text"><?php esc_html_e( 'Already have an account?', 'movedo' ); ?> <a class="grve-text-hover-primary-1 grve-login-form-btn" href="#"><?php esc_html_e('Login', 'movedo'); ?></a></span>
						</div>
						<?php wp_nonce_field( 'movedo_grve_nonce', '_movedo_grve_nonce_register' ); ?>
					</form>
					<div class="grve-form-errors grve-align-center grve-text-primary-1 grve-link-text"></div>
				</div>

			<?php } ?>

				<!-- Login form -->
				<div class="grve-login-form grve-login-form-item grve-align-center">

					<div class="grve-login-form-title grve-h3 grve-with-line grve-align-center"><?php printf( esc_html__('Login to %s', 'movedo'), get_bloginfo('name') ); ?></div>

					<form id="grve_login_form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">

						<div class="grve-form-field">
							<input class="grve-form-control required" name="grve_user_login" type="text" placeholder="<?php esc_html_e( 'Username *', 'movedo' ); ?>"/>
						</div>
						<div class="grve-form-field">
							<input class="grve-form-control required" name="grve_user_pass" id="grve_user_pass" type="password" placeholder="<?php esc_html_e( 'Password *', 'movedo' ); ?>"/>
						</div>
						<?php do_action( 'movedo_grve_login_form' ); ?>
						<div class="grve-form-field">
							<input type="hidden" name="action" value="movedo_grve_login_user"/>
							<button class="btn grve-fullwidth-btn" data-loading-text="<?php esc_html_e('Loading...', 'movedo') ?>" type="submit"><?php esc_html_e('Login', 'movedo'); ?></button>
							<a class="grve-reset-password-form-btn grve-link-text grve-text-hover-primary-1" href="#"><?php esc_html_e('Lost Password?', 'movedo') ?></a>
						</div>
						<?php if( get_option('users_can_register') ) { ?>
						<div class="grve-form-field">
							<span class="grve-register-link grve-link-text"><?php esc_html_e('Don\'t have an account?', 'movedo' ); ?> <a class="grve-register-form-btn" href="#"><?php esc_html_e('Sign Up', 'movedo'); ?></a></span>
						</div>
						<?php } ?>
						<?php wp_nonce_field( 'movedo_grve_nonce', '_movedo_grve_nonce_login' ); ?>
					</form>
					<div class="grve-form-errors grve-align-center grve-text-primary-1 grve-link-text"></div>
				</div>

				<!-- Lost Password form -->
				<div class="grve-reset-password-form grve-login-form-item grve-align-center">

					<div class="grve-login-form-title grve-h3 grve-with-line grve-align-center"><?php esc_html_e('Reset Password', 'movedo'); ?></div>
					<span class="grve-login-form-description grve-link-text"><?php esc_html_e( 'Enter the username or e-mail you used in your profile. A password reset link will be sent to you by email.', 'movedo'); ?></span>

					<form id="grve_reset_password_form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">
						<div class="grve-form-field">
							<input class="grve-form-control required" name="grve_user_or_email" id="grve_user_or_email" type="text" placeholder="<?php esc_html_e( 'Username or E-mail', 'movedo' ); ?>"/>
						</div>
						<?php do_action( 'movedo_grve_reset_password_form' ); ?>
						<div class="grve-form-field">
							<input type="hidden" name="action" value="movedo_grve_reset_password_user"/>
							<button class="btn grve-fullwidth-btn" data-loading-text="<?php esc_attr_e('Loading...', 'movedo') ?>" type="submit"><?php esc_html_e('Get new password', 'movedo'); ?></button>
						</div>
						<div class="grve-form-field">
							<span class="grve-login-link grve-link-text"><?php esc_html_e( 'Already have an account?', 'movedo' ); ?>
								<a class="grve-text-hover-primary-1 grve-login-form-btn" href="#"><?php esc_html_e('Login', 'movedo'); ?></a>
							</span>
						</div>
						<?php wp_nonce_field( 'movedo_grve_nonce', '_movedo_grve_nonce_password' ); ?>
					</form>
					<div class="grve-form-errors grve-align-center grve-text-primary-1 grve-link-text"></div>
				</div>
	</div>
<?php } else { ?>
	<div class="grve-login-modal-footer">
		<div class="grve-alert grve-alert-info grve-align-center grve-link-text"><?php $current_user = wp_get_current_user(); printf( __( 'You have already logged in as %1$s. <a class="grve-text-hover-primary-1" href="%2$s">Logout?</a>', 'movedo' ), $current_user->user_login, wp_logout_url( home_url() ) ); ?></div>
	</div>
<?php } ?>
