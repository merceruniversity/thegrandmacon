<?php

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/includes/plugins/tgm-plugin-activation/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'movedo_grve_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function movedo_grve_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		'js_composer' => array(
			'name'					=> esc_html__( 'WPBakery Page Builder', 'movedo' ),
			'slug'					=> 'js_composer',
			'source'				=> get_template_directory() . '/includes/plugins/js_composer.zip',
			'required'				=> true,
			'version'				=> '5.4.7',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url'			=> '',
			'is_callable'			=> '',
		),
		'movedo-extension' => array(
			'name'					=> esc_html__( 'Movedo Extension', 'movedo' ),
			'slug'					=> 'movedo-extension',
			'source'				=> get_template_directory() . '/includes/plugins/movedo-extension.zip',
			'required'				=> true,
			'version'				=> '2.2.2',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url'			=> '',
			'is_callable'			=> '',
		),
		'movedo-dummy-importer' => array(
			'name'					=> esc_html__( 'Movedo Dummy Importer', 'movedo' ),
			'slug'					=> 'movedo-dummy-importer',
			'source'				=> get_template_directory() . '/includes/plugins/movedo-dummy-importer.zip',
			'required'				=> true,
			'version'				=> '2.2.1',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url'			=> '',
			'is_callable'			=> '',
		),
		'revslider' => array(
			'name'					=> esc_html__( 'Revolution Slider', 'movedo' ),
			'slug'					=> 'revslider',
			'source'				=> get_template_directory() . '/includes/plugins/revslider.zip',
			'required'				=> false,
			'version'				=> '5.4.7.2',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url'			=> '',
			'is_callable'			=> '',
		),
		'contact-form-7' => array(
			'name'				=> esc_html__( 'Contact Form 7', 'movedo' ),
			'slug'				=> 'contact-form-7',
			'required'			=> false,
		),
		'woocommerce' => array(
			'name'				=> esc_html__( 'WooCommerce', 'movedo' ),
			'slug'				=> 'woocommerce',
			'required'			=> false,
		),
	);

	$plugins = apply_filters( 'movedo_grve_recommended_plugins', $plugins );

	/**
	* Array of configuration settings. Amend each line as needed.
	* If you want the default strings to be available under your own theme domain,
	* leave the strings uncommented.
	* Some of the strings are added into a sprintf, so see the comments at the
	* end of each line for what each argument will be.
	*/
	$config = array(
		'id'           => 'movedo-tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'movedo-tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'nag_type'	=> 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		)
	);

	tgmpa( $plugins, $config );

}

/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */
if ( ! function_exists( 'movedo_grve_vc_set_as_theme' ) ) {
	function movedo_grve_vc_set_as_theme() {
		vc_set_as_theme();
	}
}
add_action( 'vc_before_init', 'movedo_grve_vc_set_as_theme' );


/**
 * Remove Visual Composer Redirect on activation
 */
remove_action( 'vc_activation_hook', 'vc_page_welcome_set_redirect' );
remove_action( 'init', 'vc_page_welcome_redirect' );

/**
 * Remove Revolution Slider Notices
 */
remove_action('admin_notices', array('RevSliderAdmin', 'add_plugins_page_notices'));

//Omit closing PHP tag to avoid accidental whitespace output errors.
