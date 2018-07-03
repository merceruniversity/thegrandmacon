<?php
/*
 * Plugin Name: Movedo Extension
 * Description: This plugin extends Page Builder and adds custom post type capabilities.
 * Author: Greatives Team
 * Author URI: http://greatives.eu
 * Version: 2.2.2
 * Text Domain: movedo-extension
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! defined( 'MOVEDO_EXT_VERSION' ) ) {
	define( 'MOVEDO_EXT_VERSION', '2.2.2' );
}

if ( ! defined( 'MOVEDO_EXT_PLUGIN_DIR_PATH' ) ) {
	define( 'MOVEDO_EXT_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'MOVEDO_EXT_PLUGIN_DIR_URL' ) ) {
	define( 'MOVEDO_EXT_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! class_exists( 'Movedo_Extension_Plugin' ) ) {

	class Movedo_Extension_Plugin {

		/**
		 * @action plugins_loaded
		 * @return Movedo_Extension_Plugin
		 * @static
		 */
		public static function init()
		{

			static $instance = false;

			if ( ! $instance ) {
				load_plugin_textdomain( 'movedo-extension' , false , dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
				$instance = new Movedo_Extension_Plugin;
			}
			return $instance;

		}

		/* Add Visual Composer Plugin*/
		private function __construct() {

			if ( is_user_logged_in() ) {
				add_action( 'admin_enqueue_scripts' , $this->marshal( 'movedo_ext_vce_extension_add_scripts' ) );
			}
			add_action( 'wp_enqueue_scripts' , $this->marshal( 'movedo_ext_vce_extension_add_front_end_scripts' ) );

			require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'includes/movedo-ext-functions.php';
			require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'includes/movedo-ext-add-param.php';
			require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'includes/movedo-ext-shortcode-param.php';


			//Shortcodes
			if( function_exists( 'vc_lean_map' ) || function_exists( 'vc_map' ) ) {

				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_title.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_empty_space.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_divider.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_button.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_quote.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_dropcap.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_slogan.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_callout.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_progress_bar.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_pricing_table.php';

				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_message_box.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_icon.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_icon_box.php';

				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_image_text.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_double_image_text.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_split_content.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_media_box.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_single_image.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_gallery.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_slider.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_video.php';

				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_social.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_social_links.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_gmap.php';

				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_team.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_blog.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_blog_leader.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_portfolio.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_testimonial.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_counter.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_pie_chart.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_typed_text.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_promo.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_flexible_carousel.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_countdown.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_modal.php';
				if ( class_exists( 'woocommerce' ) ) {
					require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_products.php';
				}
				if ( class_exists( 'Tribe__Events__Main' ) ) {
					require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_events.php';
				}
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_content_slider.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_portfolio_parallax.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_language_selector.php';
				require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'shortcodes/movedo_instagram.php';


				if ( function_exists( 'movedo_grve_visibility' ) ) {
					$content_manager = movedo_grve_visibility( 'vc_content_manager_visibility' );
					if ( $content_manager ) {
						require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'movedo-templates/movedo-templates.php';
					}
				}
			}

		}

		public function Movedo_Extension_Plugin() {
			$this->__construct();
		}

		public function movedo_ext_vce_extension_add_scripts( $hook ) {
			wp_enqueue_style('movedo-ext-vc-elements', MOVEDO_EXT_PLUGIN_DIR_URL .'assets/css/movedo-ext-vc-elements.css', array(), time(), 'all');
			wp_enqueue_style('movedo-ext-vc-custom-fields', MOVEDO_EXT_PLUGIN_DIR_URL .'assets/css/movedo-ext-vc-custom-fields.css', array(), time(), 'all');
			wp_enqueue_style('movedo-ext-vc-simple-line-icons', MOVEDO_EXT_PLUGIN_DIR_URL .'assets/css/simple-line-icons.css', array(), '2.2.3', 'all');
			wp_enqueue_style('movedo-ext-vc-elegant-line-icons', MOVEDO_EXT_PLUGIN_DIR_URL .'assets/css/et-line-icons.css', array(), '1.0.0', 'all');
		}

		public function movedo_ext_vce_extension_add_front_end_scripts() {
			wp_register_style( 'movedo-ext-vc-simple-line-icons', MOVEDO_EXT_PLUGIN_DIR_URL .'assets/css/simple-line-icons.css', array(), '2.2.3', 'all' );
			wp_register_style( 'movedo-ext-vc-elegant-line-icons', MOVEDO_EXT_PLUGIN_DIR_URL .'assets/css/et-line-icons.css', array(), '1.0.0', 'all' );
		}

		public function marshal( $method_name ) {
			return array( &$this , $method_name );
		}
	}

	/**
	 * Initialize the Visual Composer Extension Plugin
	 */
	add_action( 'init' , array( 'Movedo_Extension_Plugin' , 'init' ), 12 );


	/**
	 * Initialize Custom Post Types
	 */
	function movedo_ext_vce_rewrite_flush() {
		movedo_ext_vce_register_custom_post_init();
		flush_rewrite_rules();
	}
	register_activation_hook( __FILE__, 'movedo_ext_vce_rewrite_flush' );

	function movedo_ext_vce_register_custom_post_init() {
		require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'includes/movedo-portfolio-post-type.php';
		require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'includes/movedo-testimonial-post-type.php';
		require_once MOVEDO_EXT_PLUGIN_DIR_PATH . 'includes/movedo-area-item-post-type.php';
	}
	add_action( 'init', 'movedo_ext_vce_register_custom_post_init', 9 );

	//Add shortcodes to widget text
	add_filter( 'widget_text' , 'do_shortcode' );

	function movedo_ext_vce_body_class( $classes ){
		$movedo_ext_ver = 'grve-vce-ver-' . MOVEDO_EXT_VERSION;
		return array_merge( $classes, array( $movedo_ext_ver ) );
	}
	add_filter( 'body_class', 'movedo_ext_vce_body_class' );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.