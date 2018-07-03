<?php
/*
 * Plugin Name: Movedo Dummy Importer
 * Description: Import Movedo Demo Content
 * Author: Greatives Team
 * Author URI: http://greatives.eu
 * Version: 2.2.1
 * Text Domain: movedo-importer
 */

add_action( 'admin_menu', 'movedo_importer_menu_page' );
function movedo_importer_menu_page(){
	add_menu_page( 'Movedo Demos', 'Movedo Demos', 'manage_options', 'admin.php?import=movedo-demo-importer', '', plugin_dir_url(__FILE__).'/assets/images/grve-import.png');
}

/** Display verbose errors */
if ( ! defined( 'MOVEDO_IMPORT_DEBUG' ) ) {
	define( 'MOVEDO_IMPORT_DEBUG', false );
}
if ( ! defined( 'MOVEDO_IMPORT_MIN_PHP_VERSION' ) ) {
	define( 'MOVEDO_IMPORT_MIN_PHP_VERSION', '5.3.0' );
}

// Load Importer API
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( ! class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) )
		require $class_wp_importer;
}

// include WXR file parsers
require dirname( __FILE__ ) . '/parsers.php';

/**
 * Importer class for managing the import process
 */
if ( class_exists( 'WP_Importer' ) ) {
class Movedo_Importer extends WP_Importer {
	var $max_wxr_version = 1.2; // max. supported WXR version

	var $id; // WXR attachment ID

	// information to import from WXR file
	var $version;
	var $authors = array();
	var $posts = array();
	var $terms = array();
	var $categories = array();
	var $tags = array();
	var $base_url = '';

	// mappings from old information to new
	var $processed_authors = array();
	var $author_mapping = array();
	var $processed_terms = array();
	var $processed_posts = array();
	var $post_orphans = array();
	var $processed_menu_items = array();
	var $menu_item_orphans = array();
	var $missing_menu_items = array();

	var $fetch_attachments = false;
	var $fetch_live_images = false;
	var $url_remap = array();
	var $featured_images = array();

	function __construct() {
		add_action( 'wp_ajax_movedo_import_demo_data', array( $this, 'movedo_import_demo_data' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'movedo_demo_importer_scripts' ) );
	}

	function Movedo_Importer() {
		$this->__construct();
	}

	/**
	 * Imports stylesheet and scripts
	 */
	function movedo_demo_importer_scripts( $hook ) {

		if ( 'admin.php' == $hook ) {

			wp_register_style( 'grve-import', plugins_url( '/assets/css/grve-import.css', __FILE__  ), array(), '2.0' );
			wp_register_style( 'grve-import-countdown', plugins_url( '/assets/css/jquery.countdown.css', __FILE__  ), array(), '1.0' );

			$grve_import_texts = array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'confirmation_text' => esc_html__( "You are about to import dummy data!\nIt is recommended to clear your data first.\n\nDo you want to continue?", 'movedo-importer' ),
				'confirmation_text_singular' => esc_html__( "You are about to import partial dummy data!\n\nDo you want to continue?", 'movedo-importer' ),
			);

			wp_register_script( 'grve-import-script', plugins_url( '/assets/js/grve-import.js', __FILE__  ), array( 'jquery'), false, '2.0' );
			wp_localize_script( 'grve-import-script', 'grve_import_texts', $grve_import_texts );
			wp_register_script( 'grve-import-plugin-script', plugins_url( '/assets/js/jquery.plugin.min.js', __FILE__  ), array( 'jquery'), false, '2.0' );
			wp_register_script( 'grve-import-countdown-script', plugins_url( '/assets/js/jquery.countdown.min.js', __FILE__  ), array( 'jquery'), false, '1.0' );

			wp_enqueue_style( 'grve-import' );
			wp_enqueue_style( 'grve-import-countdown' );
			wp_enqueue_script( 'grve-import-script' );
			wp_enqueue_script( 'grve-import-plugin-script' );
			wp_enqueue_script( 'grve-import-countdown-script' );
		}
	}

	/**
	 * Demo data values
 	 */
	function grve_get_demo_data() {
		$grve_dummy_data_list = array(
			array(
				'id'   => 'movedo',
				'name' => 'Movedo Main Demo',
				'dir'  => 'movedo',
				'preview'  => 'movedo',
				'description'  => esc_html__( 'Several sample pages and layouts to get inspired. Elements are also included here to get a simple understanding of how the theme works.', 'movedo-extension' ),
			),
			array(
				'id'   => 'movedo-corporate',
				'name' => 'Movedo Corporate Demo',
				'dir'  => 'movedo-corporate',
				'preview'  => 'movedo/movedo-corporate',
				'description'  => esc_html__( 'Recommended for corporate case studies with professional and clean design.', 'movedo-importer' ),
			),
			array(
				'id'   => 'movedo-store',
				'name' => 'Movedo Small Store Demo',
				'dir'  => 'movedo-store',
				'preview'  => 'movedo/movedo-store',
				'description'  => esc_html__( 'Shop case study with WooCommerce products. Showcase your products and start selling in a few minutes.', 'movedo-importer' ),
			),
			array(
				'id'   => 'movedo-creative-agency',
				'name' => 'Movedo Creative Agency Demo',
				'dir'  => 'movedo-creative-agency',
				'preview'  => 'movedo/movedo-creative-agency',
				'description'  => esc_html__( 'Clean and impressive demo, recommended for agencies, graphic and web designers.', 'movedo-importer' ),
			),
			array(
				'id'   => 'movedo-freelancer',
				'name' => 'Movedo Freelancer Demo',
				'dir'  => 'movedo-freelancer',
				'preview'  => 'movedo/movedo-freelancer',
				'description'  => esc_html__( 'One Page case study with dark style and split menu. Design inspiration for freelancers.', 'movedo-importer' ),
			),
			array(
				'id'   => 'movedo-construction',
				'name' => 'Movedo Construction Demo',
				'dir'  => 'movedo-construction',
				'preview'  => 'movedo/movedo-construction',
				'description'  => esc_html__( 'Elegant construction case study with professional and clean design.', 'movedo-importer' ),
			),
			array(
				'id'   => 'movedo-travel',
				'name' => 'Movedo Travel Case Demo',
				'dir'  => 'movedo-travel',
				'preview'  => 'movedo/movedo-travel',
				'description'  => esc_html__( 'Unique style to share your most memorable travelling experiences with other bloggers.', 'movedo-importer' ),
			),
			array(
				'id'   => 'movedo-personal',
				'name' => 'Personal Case Demo',
				'dir'  => 'movedo-personal',
				'preview'  => 'movedo/movedo-personal',
				'description'  => esc_html__( 'Inspirational and creative personal case study.', 'movedo-importer' ),
			),
			array(
				'id'   => 'movedo-modern-corporate',
				'name' => 'Movedo Corporate Modern Demo',
				'dir'  => 'movedo-modern-corporate',
				'preview'  => 'movedo/movedo-corporate-ii',
				'description'  => esc_html__( 'Professional and clean design combined with the hottest web trends.', 'movedo-importer' ),
			),
			array(
				'id'   => 'movedo-hosting',
				'name' => 'Movedo Hosting Demo',
				'dir'  => 'movedo-hosting',
				'preview'  => 'movedo/movedo-hosting',
				'description'  => esc_html__( 'Business and minimal style, recommended for hosting companies and resellers.', 'movedo-importer' ),
			),
			array(
				'id'   => 'movedo-blog',
				'name' => 'Movedo Blog Demo',
				'dir'  => 'movedo-blog',
				'preview'  => 'movedo/movedo-blog',
				'description'  => esc_html__( 'Are you a Blogger? If you publish regularly, you will love Movedo Blog.', 'movedo-importer' ),
			),
			array(
				'id'   => 'movedo-landing',
				'name' => 'Movedo Landing Demo',
				'dir'  => 'movedo-landing',
				'preview'  => 'movedo/movedo-landing',
				'description'  => esc_html__( 'Another handcrafted one-page case study, not just for startups.', 'movedo-importer' ),
			),
			array(
				'id'   => 'movedo-restaurant',
				'name' => 'Movedo Restaurant Demo',
				'dir'  => 'movedo-restaurant',
				'preview'  => 'movedo/movedo-restaurant',
				'description'  => esc_html__( 'One page case study for restaurants, bistros, coffee shops and similar projects.', 'movedo-importer' ),
			),
			array(
				'id'   => 'movedo-lawyer',
				'name' => 'Movedo Lawyer Demo',
				'dir'  => 'movedo-lawyer',
				'preview'  => 'movedo/movedo-lawyer',
				'description'  => esc_html__( 'Clean, elegant, corporate demo suitable for Lawyers, Lawfirms and legal agency websites.', 'movedo-importer' ),
			),
		);

		return $grve_dummy_data_list;
	}

	/**
	 * Remove Image Sizes
 	 */
	function movedo_import_remove_image_sizes() {
		remove_image_size( 'movedo-grve-fullscreen');
	}

	/**
	 * Imports dummy data ( Central function )
 	 */
	function movedo_import_demo_data() {

		$importer_info = '';

		if ( isset( $_POST['grve_import_data'] ) ) {

			ob_start();

			$dummy_id = $_POST['grve_import_data'];
			$grve_importer_error = false;
			$grve_changed = false;
			check_ajax_referer( $dummy_id, 'nonce', true );
			echo '<br />';

			$grve_theme_active = false;
			if ( function_exists( 'movedo_grve_info') ) {
				$grve_theme_active = true;
			}

			if ( $grve_theme_active && !version_compare( phpversion(), MOVEDO_IMPORT_MIN_PHP_VERSION, '<' ) ) {

				//Import Singular Data
				if ( isset( $_POST['grve_import_singular'] ) && 'true' == $_POST['grve_import_singular'] ) {
					$import_file = plugin_dir_path(__FILE__) . 'import/data/' . $dummy_id  .  '/dummy.xml';

					if ( ! file_exists( $import_file ) ) {
						$import_file = plugin_dir_path(__FILE__) . 'import/data/' . $dummy_id  .  '/dummy.xml.gz';
					}

					if ( ! file_exists( $import_file ) || empty( $import_file ) ) {
						$grve_importer_error = true;
						$importer_info.=  '<i class="dashicons dashicons-no"></i> ' . esc_html__( "Single Content: File empty ot not existing!", 'movedo-importer' );
						$importer_info.=  '<br />';
					} else {
						if (
							( isset( $_POST['grve_import_single_pages'] ) && !empty( $_POST['grve_import_single_pages'] ) ) ||
							( isset( $_POST['grve_import_single_posts'] ) && !empty( $_POST['grve_import_single_posts'] ) ) ||
							( isset( $_POST['grve_import_single_portfolios'] ) && !empty( $_POST['grve_import_single_portfolios'] ) ) ||
							( isset( $_POST['grve_import_single_products'] ) && !empty( $_POST['grve_import_single_products'] ) ) ||
							( isset( $_POST['grve_import_single_areas'] ) && !empty( $_POST['grve_import_single_areas'] ) )
						) {
							$grve_changed = true;
							set_time_limit(0);
							$this->fetch_attachments = true;
							if ( isset( $_POST['grve_import_demo_images'] ) && 'true' == $_POST['grve_import_demo_images'] ) {
								$this->fetch_live_images = true;
								$this->movedo_import_remove_image_sizes();
							}

							$ids = array();
							$ids1 = $_POST['grve_import_single_pages'];
							$ids2 = $_POST['grve_import_single_posts'];
							$ids3 = $_POST['grve_import_single_portfolios'];
							$ids4 = $_POST['grve_import_single_products'];
							$ids5 = $_POST['grve_import_single_areas'];

							if( !empty( $ids1 ) ) {
								$ids = array_merge($ids, $ids1);
							}
							if( !empty( $ids2 ) ) {
								$ids = array_merge($ids, $ids2);
							}
							if( !empty( $ids3 ) ) {
								$ids = array_merge($ids, $ids3);
							}
							if( !empty( $ids4 ) ) {
								$ids = array_merge($ids, $ids4);
							}
							if( !empty( $ids5 ) ) {
								$ids = array_merge($ids, $ids5);
							}

							$import_output = $this->import( $import_file, $ids );
							if ( is_wp_error( $import_output ) ) {
								$grve_importer_error = true;
								$importer_info.=  '<i class="dashicons dashicons-no"></i> ' . esc_html__( "Single Content: Error During Import!", 'movedo-importer' );
								$importer_info.=  '<br />';
							} else {
								$importer_info.=  '<i class="dashicons dashicons-yes"></i> ' . esc_html__( "Single Content: imported!", 'movedo-importer' );
								$importer_info.=  '<br />';
							}

						}
					}
				}

				//Import Dummy Data
				if ( isset( $_POST['grve_import_content'] ) && 'true' == $_POST['grve_import_content'] ) {
					$grve_changed = true;
					$import_file = plugin_dir_path(__FILE__) . 'import/data/' . $dummy_id  .  '/dummy.xml';

					if ( ! file_exists( $import_file ) ) {
						$import_file = plugin_dir_path(__FILE__) . 'import/data/' . $dummy_id  .  '/dummy.xml.gz';
					}

					if ( ! file_exists( $import_file ) || empty( $import_file ) ) {
						$grve_importer_error = true;
						$importer_info.=  '<i class="dashicons dashicons-no"></i> ' . esc_html__( "Dummy Content: File empty ot not existing!", 'movedo-importer' );
						$importer_info.=  '<br />';
					} else {
						set_time_limit(0);
						$this->fetch_attachments = true;
						if ( isset( $_POST['grve_import_demo_images'] ) && 'true' == $_POST['grve_import_demo_images'] ) {
							$this->fetch_live_images = true;
							//$this->movedo_import_remove_image_sizes();
						}

						$import_output = $this->import( $import_file );
						if ( is_wp_error( $import_output ) ) {
							$grve_importer_error = true;
							$importer_info.=  '<i class="dashicons dashicons-no"></i> ' . esc_html__( "Dummy Content: Error During Import!", 'movedo-importer' );
							$importer_info.=  '<br />';
						} else {

							$grve_menus  = wp_get_nav_menus();
							$locations = get_theme_mod( 'nav_menu_locations' );
							if( ! empty( $grve_menus ) ) {

								foreach ( $grve_menus as $grve_menu ) {

									if( 'main-menu' == $grve_menu->slug || 'main-navigation' == $grve_menu->slug || 'main-nav' == $grve_menu->slug  ) {
										$locations['movedo_header_nav'] = $grve_menu->term_id;
									}
									if( 'bottom-menu' == $grve_menu->slug || 'footer-widget-menu' == $grve_menu->slug ) {
										$locations['movedo_footer_nav'] = $grve_menu->term_id;
									}

								}
								set_theme_mod( 'nav_menu_locations', $locations );
							}

							//Set Home page
							if ( 'movedo' == $dummy_id ) {
								$homepage = get_page_by_title( 'Intro' );
							} else {
								$homepage = get_page_by_title( 'Home' );
							}
							if ( $homepage ) {
								update_option( 'page_on_front', $homepage->ID );
								update_option( 'show_on_front', 'page' );
							}

							//Import Revolution Slider
							if ( class_exists('RevSlider') ) {

								$import_file = plugin_dir_path(__FILE__) . 'import/data/' . $dummy_id  .  '/revslider1.zip';
								if ( ! file_exists( $import_file ) || empty( $import_file ) ) {
									//No revolution slider available for this demo
								} else {
									$revslider = new RevSlider();
									$revslider->importSliderFromPost( false, false, $import_file );
								}

								$import_file = plugin_dir_path(__FILE__) . 'import/data/' . $dummy_id  .  '/revslider2.zip';
								if ( ! file_exists( $import_file ) || empty( $import_file ) ) {
									//No revolution slider available for this demo
								} else {
									$revslider = new RevSlider();
									$revslider->importSliderFromPost( false, false, $import_file );
								}

								$import_file = plugin_dir_path(__FILE__) . 'import/data/' . $dummy_id  .  '/revslider3.zip';
								if ( ! file_exists( $import_file ) || empty( $import_file ) ) {
									//No revolution slider available for this demo
								} else {
									$revslider = new RevSlider();
									$revslider->importSliderFromPost( false, false, $import_file );
								}

							}

							$importer_info.=  '<i class="dashicons dashicons-yes"></i> ' . esc_html__( "Dummy Content: imported!", 'movedo-importer' );
							$importer_info.=  '<br />';
						}
					}
				}

				//Import Theme Options
				if ( isset( $_POST['grve_import_options'] ) && 'true' == $_POST['grve_import_options'] ) {
					$grve_changed = true;
					$import_file = plugin_dir_path(__FILE__) . 'import/data/' . $dummy_id  .  '/grve-options.json';
					if ( ! file_exists( $import_file ) || empty( $import_file ) ) {
						$grve_importer_error = true;
						$importer_info.=  '<i class="dashicons dashicons-no"></i> ' . esc_html__( "Theme Options: file empty ot not existing!", 'movedo-importer' );
						$importer_info.=  '<br/>';
					} else {
						if ( $this->grve_import_options( $import_file, $dummy_id ) ) {
							$importer_info.=  '<i class="dashicons dashicons-yes"></i> ' . esc_html__( "Theme Options: imported!", 'movedo-importer' );
							$importer_info.=  '<br/>';
						}
					}
				}

				//Import Widgets
				if ( isset( $_POST['grve_import_widgets'] ) && 'true' == $_POST['grve_import_widgets'] ) {
					$grve_changed = true;
					$import_file = plugin_dir_path(__FILE__) . 'import/data/' . $dummy_id  .  '/widget_data.json';
					if ( ! file_exists( $import_file ) || empty( $import_file ) ) {
						$importer_info.=  '<i class="dashicons dashicons-info"></i> ' . esc_html__( "Widgets: no widgets available for this Demo!", 'movedo-importer' );
						$importer_info.=  '<br/>';
					} else {
						if ( $this->grve_import_demo_widgets( $import_file ) ) {
							$importer_info.=  '<i class="dashicons dashicons-yes"></i> ' . esc_html__( "Widgets: imported!", 'movedo-importer' );
							$importer_info.=  '<br/>';
						}
					}
				}

				if ( !$grve_importer_error ) {
					if( $grve_changed ) {
						$importer_info.=  '<br/>';
						$importer_info.=  '<i class="dashicons dashicons-yes"></i> <b>' .  esc_html__( "Import finished!", 'movedo-importer' ) . '</b>';
						$importer_info.=  ' <a href="' . home_url() . '">' .  esc_html__( "Visit Site", 'movedo-importer' ) . '</a>';
						$importer_info.=  '<br/>';
					} else {
						$importer_info.=  '<i class="dashicons dashicons-info"></i> <b>' .  esc_html__( "No options selected, please select some options and press the import button!", 'movedo-importer' ) . '</b>';
						$importer_info.=  '<br/>';
					}
				} else {
					$importer_info.=  '<br/>';
					$importer_info.=  '<i class="dashicons dashicons-no"></i> <b>' .  esc_html__( "Import finished with errors!", 'movedo-importer' ) . '</b>';
					$importer_info.=  ' <a href="' . home_url() . '">' .  esc_html__( "Visit Site", 'movedo-importer' ) . '</a>';
					$importer_info.=  '<br/>';
				}
			} else {

					if ( version_compare( phpversion(), MOVEDO_IMPORT_MIN_PHP_VERSION, '<' ) ) {
						$importer_info.=  '<i class="dashicons dashicons-no"></i> <b>' .  esc_html__( "The minimum PHP version required for the Dummy Importer is:", 'movedo-importer' ) . ' ' . MOVEDO_IMPORT_MIN_PHP_VERSION . '</b>';
						$importer_info.=  '<br/>';
					}

					if ( !$grve_theme_active ) {
						$importer_info.=  '<i class="dashicons dashicons-no"></i> <b>' .  esc_html__( "Movedo Theme is not activated! Movedo Theme needs to be installed and activated!", 'movedo-importer' ) . '</b>';
						$importer_info.=  '<br/>';
					}

			}

			$importer_output = "";
			$importer_debug_output = ob_get_clean();

			if ( defined('MOVEDO_IMPORT_DEBUG') && MOVEDO_IMPORT_DEBUG ) {
				$importer_output = $importer_debug_output;
			}

			$response = array(
				'errors' => $grve_importer_error,
				'changed' => $grve_changed,
				'info' => $importer_info,
				'output' => $importer_output,
			);
			wp_send_json( $response );

		}
		if ( isset( $_POST['grve_import_data'] ) ) { die(); }
	}

	/**
	 * Additional function to get a new widget name
	 * Used from grve_import_demo_widgets
 	 */
	function grve_get_new_widget_name( $widget_name, $widget_index ) {
		$current_sidebars = get_option( 'sidebars_widgets' );
		$all_widget_array = array( );
		foreach ( $current_sidebars as $sidebar => $widgets ) {
			if ( ! empty( $widgets ) && is_array( $widgets ) && 'wp_inactive_widgets' != $sidebar ) {
				foreach ( $widgets as $widget ) {
					$all_widget_array[] = $widget;
				}
			}
		}
		while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
			$widget_index++;
		}
		$new_widget_name = $widget_name . '-' . $widget_index;
		return $new_widget_name;
	}

	/**
	 * Imports widgets from file
 	 */
	function grve_import_demo_widgets( $import_file ) {

		if ( file_exists( $import_file ) ){

			$import_array = file_get_contents( $import_file );
			$import_array = json_decode( $import_array, true );

			$sidebars_data = $import_array[0];
			$widget_data = $import_array[1];
			$new_widgets = array( );

			//Get Existing Custom sidebars
			$grve_custom_sidebars = get_option( '_movedo_grve_custom_sidebars' );
			if ( empty( $grve_custom_sidebars ) ) {
				$grve_custom_sidebars = array();
			}

			$custom_sidebars_ids = array();
			if ( ! empty( $grve_custom_sidebars ) ) {
				foreach ( $grve_custom_sidebars as $grve_custom_sidebar ) {
					array_push( $custom_sidebars_ids, $grve_custom_sidebar['id'] );
				}
			}

			$current_sidebars = wp_get_sidebars_widgets();

			$current_sidebars['grve-default-sidebar'] = array();
			$current_sidebars['grve-single-portfolio-sidebar'] = array();
			$current_sidebars['grve-footer-1-sidebar'] = array();
			$current_sidebars['grve-footer-2-sidebar'] = array();
			$current_sidebars['grve-footer-3-sidebar'] = array();
			$current_sidebars['grve-footer-4-sidebar'] = array();

			//Check if includes custom sidebars
			$sidebar_index = 0;
			$new_sidebars = false;

			foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

				if( strpos( $import_sidebar, "movedo_grve_sidebar_" ) !== false ) {
					if ( !in_array( $import_sidebar, $custom_sidebars_ids ) ) {
						$sidebar_index++;
						$this_sidebar = array ( 'id' => $import_sidebar , 'name' => "Demo Sidebar " . $sidebar_index );
						array_push( $grve_custom_sidebars, $this_sidebar );
						if( ! isset( $current_sidebars[ $import_sidebar ] ) ) {
							$current_sidebars[ $import_sidebar ] = array();
						}
						$new_sidebars = true;
					}
				}

			endforeach;

			//Update and Register Custom Sidebars if needed
			if ( ! empty( $grve_custom_sidebars ) && $new_sidebars ) {
				update_option( '_movedo_grve_custom_sidebars', $grve_custom_sidebars );
				wp_set_sidebars_widgets( $current_sidebars );
			}

			//Get Current Sidebars and Widgets
			$current_sidebars = wp_get_sidebars_widgets();

			//Import Widget Data
			foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

				foreach ( $import_widgets as $import_widget ) :
					//if the sidebar exists
					if ( isset( $current_sidebars[$import_sidebar] ) ) :
						$title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
						$index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
						$current_widget_data = get_option( 'widget_' . $title );
						$new_widget_name = $this->grve_get_new_widget_name( $title, $index );
						$new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

						if ( ! empty( $new_widgets[ $title ] ) && is_array( $new_widgets[ $title ] ) ) {
							while ( array_key_exists( $new_index, $new_widgets[ $title ] ) ) {
								$new_index++;
							}
						}
						$current_sidebars[ $import_sidebar ][] = $title . '-' . $new_index;
						if ( array_key_exists( $title, $new_widgets ) ) {
							$new_widgets[$title][ $new_index ] = $widget_data[ $title ][ $index ];
							$multiwidget = $new_widgets[ $title ]['_multiwidget'];
							unset( $new_widgets[ $title ]['_multiwidget'] );
							$new_widgets[ $title ]['_multiwidget'] = $multiwidget;
						} else {
							$current_widget_data[ $new_index ] = $widget_data[ $title ][ $index ];
							$current_multiwidget = '';
							if ( isset($current_widget_data['_multiwidget'] ) ) {
								$current_multiwidget = $current_widget_data['_multiwidget'];
							}
							$new_multiwidget = $widget_data[ $title ]['_multiwidget'];
							$multiwidget = ( $current_multiwidget != $new_multiwidget ) ? $current_multiwidget : 1;
							unset( $current_widget_data['_multiwidget'] );
							$current_widget_data['_multiwidget'] = $multiwidget;
							$new_widgets[ $title ] = $current_widget_data;
						}

					endif;
				endforeach;
			endforeach;

			if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
				wp_set_sidebars_widgets( $current_sidebars );

				foreach ( $new_widgets as $title => $content )
					update_option( 'widget_' . $title, $content );

				return true;
			}

			return false;

		}
		else{
			return false; //Widget File not found
		}
	}

	/**
	 * Imports theme options from file ( Redux Framework )
 	 */
	function grve_import_options( $import_file, $dummy_id = 'movedo'  ) {
		global $movedo_grve_redux_framework;

		$import_array = file_get_contents( $import_file );

		if ( !empty( $import_array ) ) {

			$imported_options = array();
			$imported_options = json_decode( htmlspecialchars_decode( $import_array ), true );

			$imported_options['logo'] = array( 'url' => get_template_directory_uri() .'/images/logos/logo-default.png', 'width' => '158', 'height' => '40', 'id' => "" );
			$imported_options['logo_dark'] = array( 'url' => get_template_directory_uri() .'/images/logos/logo-default.png', 'width' => '158', 'height' => '40', 'id' => "" );
			$imported_options['logo_light'] = array( 'url' => get_template_directory_uri() .'/images/logos/logo-light.png', 'width' => '158', 'height' => '40', 'id' => "" );
			$imported_options['logo_side'] = array( 'url' => get_template_directory_uri() .'/images/logos/logo-side.png', 'width' => '230', 'height' => '180', 'id' => "" );
			$imported_options['logo_sticky'] = array( 'url' => get_template_directory_uri() .'/images/logos/logo-sticky.png', 'width' => '40', 'height' => '40', 'id' => "" );
			$imported_options['logo_responsive'] = array( 'url' => get_template_directory_uri() .'/images/logos/logo-responsive.png', 'width' => '30', 'height' => '30', 'id' => "" );
			switch ( $dummy_id ) {
				case 'movedo-store':
					$imported_options['logo'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-dark.png', 'width' => '80', 'height' => '80' );
					$imported_options['logo_dark'] = $imported_options['logo'];
					$imported_options['logo_light'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-light.png', 'width' => '80', 'height' => '80' );
					$imported_options['logo_sticky'] = $imported_options['logo_light'];
					$imported_options['logo_responsive'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-responsive.png', 'width' => '60', 'height' => '60' );
				break;
				case 'movedo-creative-agency':
					$imported_options['logo'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-dark.png', 'width' => '102', 'height' => '124' );
					$imported_options['logo_dark'] = $imported_options['logo_side'] = $imported_options['logo'];
					$imported_options['logo_light'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-light.png', 'width' => '102', 'height' => '124' );
					$imported_options['logo_sticky'] = $imported_options['logo_responsive'] = $imported_options['logo_light'];
				break;
				case 'movedo-construction':
					$imported_options['logo'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-dark.png', 'width' => '40', 'height' => '40' );
					$imported_options['logo_dark'] = $imported_options['logo_sticky'] = $imported_options['logo_responsive']  = $imported_options['logo'];
					$imported_options['logo_light'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-light.png', 'width' => '40', 'height' => '40' );
				break;
				case 'movedo-travel':
					$imported_options['logo'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-dark.png', 'width' => '84', 'height' => '60' );
					$imported_options['logo_dark'] = $imported_options['logo'];
					$imported_options['logo_light'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-light.png', 'width' => '84', 'height' => '60' );
					$imported_options['logo_responsive'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-sticky.png', 'width' => '52', 'height' => '38' );
					$imported_options['logo_sticky'] = $imported_options['logo_responsive'];
				break;
				case 'movedo-freelancer':
					$imported_options['logo'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-dark.png', 'width' => '80', 'height' => '80' );
					$imported_options['logo_dark'] = $imported_options['logo_light'] = $imported_options['logo_sticky'] = $imported_options['logo'];
				break;
				case 'movedo-corporate':
					$imported_options['logo'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-dark.png', 'width' => '130', 'height' => '28' );
					$imported_options['logo_dark'] = $imported_options['logo_sticky'] = $imported_options['logo_responsive']  = $imported_options['logo'];
					$imported_options['logo_light'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-light.png', 'width' => '130', 'height' => '28' );
				break;
				case 'movedo-personal':
					$imported_options['logo'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-dark.png', 'width' => '58', 'height' => '60' );
					$imported_options['logo_dark'] = $imported_options['logo'];
					$imported_options['logo_light'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-light.png', 'width' => '58', 'height' => '60' );
					$imported_options['logo_sticky'] = $imported_options['logo_light'];
					$imported_options['logo_responsive'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-responsive.png', 'width' => '48', 'height' => '50' );
				break;
				case 'movedo-blog':
					$imported_options['logo'] = array();
					$imported_options['logo_side'] = $imported_options['logo_responsive'] = $imported_options['logo_sticky'] = $imported_options['logo_light'] = $imported_options['logo_dark'] = $imported_options['logo'];
				break;
				case 'movedo-modern-corporate':
					$imported_options['logo'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-default.png', 'width' => '80', 'height' => '80' );
					$imported_options['logo_dark'] = $imported_options['logo_light'] = $imported_options['logo_sticky'] = $imported_options['logo'];
					$imported_options['logo_responsive'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-responsive.png', 'width' => '60', 'height' => '60' );
				break;
				case 'movedo-hosted':
					$imported_options['logo'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-dark.png', 'width' => '42', 'height' => '170' );
					$imported_options['logo_dark'] = $imported_options['logo'];
					$imported_options['logo_light'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-light.png', 'width' => '42', 'height' => '170' );
					$imported_options['logo_side'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-side.png', 'width' => '180', 'height' => '130', 'id' => "" );
					$imported_options['logo_sticky'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-sticky.png', 'width' => '40', 'height' => '40' );
					$imported_options['logo_responsive'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-responsive.png', 'width' => '30', 'height' => '30' );
				break;
				case 'movedo-landing':
					$imported_options['logo'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-default.png', 'width' => '80', 'height' => '80' );
					$imported_options['logo_responsive'] = $imported_options['logo_dark'] = $imported_options['logo_light'] = $imported_options['logo_sticky'] = $imported_options['logo'];
				break;
				case 'movedo-restaurant':
					$imported_options['logo'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-default.png', 'width' => '80', 'height' => '80' );
					$imported_options['logo_dark'] = $imported_options['logo_light'] = $imported_options['logo'];
					$imported_options['logo_sticky'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-sticky.png', 'width' => '60', 'height' => '60' );
					$imported_options['logo_responsive'] = $imported_options['logo_sticky'];
				break;
				case 'movedo-lawyer':
					$imported_options['logo'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-light.png', 'width' => '98', 'height' => '440' );
					$imported_options['logo_light']= $imported_options['logo'];
					$imported_options['logo_dark'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-dark.png', 'width' => '98', 'height' => '440' );
					$imported_options['logo_sticky'] = array( 'url' => get_template_directory_uri() .'/images/logos/' . $dummy_id . '/logo-sticky.png', 'width' => '80', 'height' => '64' );
					$imported_options['logo_responsive'] = $imported_options['logo_sticky'];
				break;
				default:
				break;
			}

			foreach($imported_options as $key => $value) {
				$movedo_grve_redux_framework->ReduxFramework->set($key, $value);
			}

		} else {
			return false;
		}

		return true;
	}

	/**
	 * Registered callback function for the WordPress Importer
	 *
	 * Manages the three separate stages of the WXR import process
	 */
	function dispatch() {
		$this->header();

		$step = empty( $_GET['step'] ) ? 1 : (int) $_GET['step'];
		switch ( $step ) {
			case 2:
				$this->demoSelection();
			break;
			case 3:
				$this->contentSelection();
			break;
			case 4:
				$this->finish();
			break;
			case 1:
			default:
				$this->greet();
			break;
		}

		$this->footer();
	}

	/**
	 * The main controller for the actual import stage.
	 *
	 * @param string $file Path to the WXR file for importing
	 */
	function import( $file, $ids = array() ) {
		add_filter( 'import_post_meta_key', array( $this, 'is_valid_meta_key' ) );


		if ( !empty( $ids ) ) {
			$ids_array = array();
			$ids_string = implode ( ',' , $ids  );
			$ids_array = explode( ',' , $ids_string);
			$ids_array = array_unique( $ids_array );
		} else {
			$ids_array = array();
		}

		$this->import_start( $file );

		wp_suspend_cache_invalidation( true );
		$this->process_categories();
		$this->process_tags();
		$this->process_terms();
		$this->process_posts( $ids_array );
		wp_suspend_cache_invalidation( false );

		// update incorrect/missing information in the DB
		$this->backfill_parents();
		$this->backfill_attachment_urls();
		$this->remap_featured_images();

		$this->import_end();
	}

	/**
	 * Parses the WXR file and prepares us for the task of processing parsed data
	 *
	 * @param string $file Path to the WXR file for importing
	 */
	function import_start( $file ) {
		if ( ! is_file($file) ) {
			echo '<p><strong>' . esc_html__( 'Sorry, there has been an error.', 'movedo-importer' ) . '</strong><br />';
			echo esc_html__( 'The file/demo does not exist, please try again.', 'movedo-importer' ) . '</p>';
			$this->footer();
			die();
		}

		$import_data = $this->parse( $file );

		if ( is_wp_error( $import_data ) ) {
			echo '<p><strong>' . esc_html__( 'Sorry, there has been an error.', 'movedo-importer' ) . '</strong><br />';
			echo esc_html( $import_data->get_error_message() ) . '</p>';
			$this->footer();
			die();
		}

		$this->version = $import_data['version'];
		$this->get_authors_from_import( $import_data );
		$this->posts = $import_data['posts'];
		$this->terms = $import_data['terms'];
		$this->categories = $import_data['categories'];
		$this->tags = $import_data['tags'];
		$this->base_url = esc_url( $import_data['base_url'] );

		wp_defer_term_counting( true );
		wp_defer_comment_counting( true );

		do_action( 'import_start' );
	}

	function grve_print_singular_selectors( $dummy_id ) {

		$file = plugin_dir_path(__FILE__) . 'import/data/' . $dummy_id  .  '/dummy.xml';
		if ( ! file_exists( $file ) ) {
			$file = plugin_dir_path(__FILE__) . 'import/data/' . $dummy_id  .  '/dummy.xml.gz';
		}

		if ( ! is_file($file) ) {
			echo '<p><strong>' . esc_html__( 'Sorry, there has been an error.', 'movedo-importer' ) . '</strong><br />';
			echo esc_html__( 'The file/demo does not exist, please try again.', 'movedo-importer' ) . '</p>';
			$this->footer();
			die();
		}

		$import_data = $this->parse( $file );

		if ( is_wp_error( $import_data ) ) {
			echo '<p><strong>' . esc_html__( 'Sorry, there has been an error.', 'movedo-importer' ) . '</strong><br />';
			echo esc_html( $import_data->get_error_message() ) . '</p>';
			$this->footer();
			die();
		}

		$woo_enabled = false;
		$cols = 2;
		if ( class_exists( 'woocommerce' ) ) {
			$woo_enabled = true;
		}

		$page_array = array();
		$post_array = array();
		$portfolio_array = array();
		$product_array = array();
		$area_array = array();
		foreach ($import_data['posts'] as $key => $value) {

			switch ( $value['post_type'] ) {
				case 'page':
				case 'post':
				case 'portfolio':
				case 'product':
				case 'area-item':
					$results = array();
					$results[] = $value['post_id'];

					$regexp = '|ids="([^"]*)"|';
					preg_match_all( $regexp, $value['post_content'], $matches);
					if( isset( $matches[1] ) ) {
						foreach( $matches[1] as $match ) {
							$results[] = $match;
						}
					}
					$regexp = '|image="([^"]*)"|';
					preg_match_all( $regexp, $value['post_content'], $matches);
					if( isset( $matches[1] ) ) {
						foreach( $matches[1] as $match ) {
							$results[] = $match;
						}
					}
					$regexp = '|retina_image="([^"]*)"|';
					preg_match_all( $regexp, $value['post_content'], $matches);
					if( isset( $matches[1] ) ) {
						foreach( $matches[1] as $match ) {
							$results[] = $match;
						}
					}
					$regexp = '|image2="([^"]*)"|';
					preg_match_all( $regexp, $value['post_content'], $matches);
					if( isset( $matches[1] ) ) {
						foreach( $matches[1] as $match ) {
							$results[] = $match;
						}
					}
					$regexp = '|retina_image2="([^"]*)"|';
					preg_match_all( $regexp, $value['post_content'], $matches);
					if( isset( $matches[1] ) ) {
						foreach( $matches[1] as $match ) {
							$results[] = $match;
						}
					}
					$regexp = '|bg_image="([^"]*)"|';
					preg_match_all( $regexp, $value['post_content'], $matches);
					if( isset( $matches[1] ) ) {
						foreach( $matches[1] as $match ) {
							$results[] = $match;
						}
					}
					$regexp = '|contact-form-7 id="([^"]*)"|';
					preg_match_all( $regexp, $value['post_content'], $matches);
					if( isset( $matches[1] ) ) {
						foreach( $matches[1] as $match ) {
							$results[] = $match;
						}
					}

					if (isset($value['postmeta'])) {
						foreach ($value['postmeta'] as $meta_key => $meta_value) {

							if ( '_movedo_grve_feature_section' === $meta_value['key'] ) {
								$section = maybe_unserialize( $meta_value['value'] );
								if ( !empty( $section ) && is_array( $section ) ) {
									$single_image = array_column( $section, 'bg_image_id' );
									$match = implode ( ',' , $single_image );
									if( !empty( $match ) ) {
										$results[] = $match;
									}
								}
								if( isset( $section['slider_items'] ) ) {
									$slider_items = $section['slider_items'];
									if ( !empty( $slider_items ) && is_array( $slider_items ) ) {
										$slider_images = array_column( $slider_items, 'bg_image_id' );
										$match = implode ( ',' , $slider_images );
										if( !empty( $match ) ) {
											$results[] = $match;
										}
									}
								}
							} elseif ( '_movedo_grve_post_slider_items' === $meta_value['key'] || '_movedo_grve_portfolio_slider_items' === $meta_value['key']  ) {
								$items = maybe_unserialize( $meta_value['value'] );
								if ( !empty( $items ) && is_array( $items ) ) {
									$slider_images = array_column( $items, 'id' );
									$match = implode ( ',' , $slider_images );
									if( !empty( $match ) ) {
										$results[] = $match;
									}
								}
							} elseif (
								'_thumbnail_id' === $meta_value['key'] ||
								'_movedo_grve_area_image_id' === $meta_value['key'] ||
								'_movedo_grve_second_featured_image' === $meta_value['key'] ||
								'_product_image_gallery' === $meta_value['key'] ) {
								if( !empty( $meta_value['value'] ) )  {
									$results[] = $meta_value['value'];
								}
							}
						}
					}

					if( 'page' == $value['post_type'] ) {
						$page_array[$value['post_title']] = array(
							'id' => $results,
						);
					} elseif ( 'portfolio' == $value['post_type'] ) {
						$portfolio_array[$value['post_title']] = array(
							'id' => $results,
						);
					} elseif ( 'post' == $value['post_type'] ) {
						$post_array[$value['post_title']] = array(
							'id' => $results,
						);
					} elseif ( 'product' == $value['post_type'] ) {
						$product_array[$value['post_title']] = array(
							'id' => $results,
						);
					} elseif ( 'area-item' == $value['post_type'] ) {
						$area_array[$value['post_title']] = array(
							'id' => $results,
						);
					}

				break;

			}
		}
?>
	<div class="grve-selectors-wrapper">
	<?php if ( !empty( $page_array ) ) { ?>
		<div class="grve-single-selector-wrapper grve-cols-<?php echo esc_attr( $cols ); ?>">
			<div class="grve-single-selector-inner">
				<span class="grve-single-label"><?php esc_html_e( 'Pages', 'movedo-importer' ); ?></span>
				<select class="grve-single-selector grve-admin-dummy-option-single-pages" name="grve-admin-option-single-pages[]" multiple>
					<?php
					ksort($page_array);
					foreach ($page_array as $key => $value) {
						echo '<option value="'.esc_attr(implode(',', $value['id'])).'">' . $key . '</option>';
					}
					?>
				</select>
			</div>
		</div>
	<?php } ?>
	<?php if ( !empty( $portfolio_array ) ) { ?>
		<div class="grve-single-selector-wrapper grve-cols-<?php echo esc_attr( $cols ); ?>">
			<div class="grve-single-selector-inner">
				<span class="grve-single-label"><?php esc_html_e( 'Portfolio Items', 'movedo-importer' ); ?></span>
				<select class="grve-single-selector grve-admin-dummy-option-single-portfolios" name="grve-admin-option-single-portfolios[]" multiple>
				<?php
				ksort($portfolio_array);
				foreach ($portfolio_array as $key => $value) {
					echo '<option value="'.esc_attr(implode(',', $value['id'])).'">' . $key . '</option>';
				}
				?>
				</select>
			</div>
		</div>
	<?php } ?>
	<?php if ( !empty( $post_array ) ) { ?>
		<div class="grve-single-selector-wrapper grve-cols-<?php echo esc_attr( $cols ); ?>">
			<div class="grve-single-selector-inner">
				<span class="grve-single-label"><?php esc_html_e( 'Posts', 'movedo-importer' ); ?></span>
				<select class="grve-single-selector grve-admin-dummy-option-single-posts" name="grve-admin-option-single-posts[]" multiple>
				<?php
				ksort($post_array);
				foreach ($post_array as $key => $value) {
					echo '<option value="'.esc_attr(implode(',', $value['id'])).'">' . $key . '</option>';
				}
				?>
				</select>
			</div>
		</div>
	<?php } ?>
	<?php if ( !empty( $product_array ) && $woo_enabled ) { ?>
		<div class="grve-single-selector-wrapper grve-cols-<?php echo esc_attr( $cols ); ?>">
			<div class="grve-single-selector-inner">
				<span class="grve-single-label"><?php esc_html_e( 'Products', 'movedo-importer' ); ?></span>
				<select class="grve-single-selector grve-admin-dummy-option-single-products" name="grve-admin-option-single-products[]" multiple>
				<?php
				ksort($product_array);
				foreach ($product_array as $key => $value) {
					echo '<option value="'.esc_attr(implode(',', $value['id'])).'">' . $key . '</option>';
				}
				?>
				</select>
			</div>
		</div>
	<?php } ?>
	<?php if ( !empty( $area_array ) ) { ?>
		<div class="grve-single-selector-wrapper grve-cols-<?php echo esc_attr( $cols ); ?>">
			<div class="grve-single-selector-inner">
				<span class="grve-single-label"><?php esc_html_e( 'Area Items', 'movedo-importer' ); ?></span>
				<select class="grve-single-selector grve-admin-dummy-option-single-areas" name="grve-admin-option-single-areas[]" multiple>
				<?php
				ksort($area_array);
				foreach ($area_array as $key => $value) {
					echo '<option value="'.esc_attr(implode(',', $value['id'])).'">' . $key . '</option>';
				}
				?>
				</select>
			</div>
		</div>
	<?php } ?>
	</div>
<?php
	}

	/**
	 * Performs post-import cleanup of files and the cache
	 */
	function import_end() {
		wp_import_cleanup( $this->id );

		wp_cache_flush();
		foreach ( get_taxonomies() as $tax ) {
			delete_option( "{$tax}_children" );
			_get_term_hierarchy( $tax );
		}

		wp_defer_term_counting( false );
		wp_defer_comment_counting( false );

		do_action( 'import_end' );
	}

	/**
	 * Handles the WXR upload and initial parsing of the file to prepare for
	 * displaying author import options
	 *
	 * @return bool False if error uploading or invalid file, true otherwise
	 */
	function handle_upload() {
		$file = wp_import_handle_upload();

		if ( isset( $file['error'] ) ) {
			echo '<p><strong>' . esc_html__( 'Sorry, there has been an error.', 'movedo-importer' ) . '</strong><br />';
			echo esc_html( $file['error'] ) . '</p>';
			return false;
		} else if ( ! file_exists( $file['file'] ) ) {
			echo '<p><strong>' . esc_html__( 'Sorry, there has been an error.', 'movedo-importer' ) . '</strong><br />';
			printf( __( 'The export file could not be found at <code>%s</code>. It is likely that this was caused by a permissions problem.', 'movedo-importer' ), esc_html( $file['file'] ) );
			echo '</p>';
			return false;
		}

		$this->id = (int) $file['id'];
		$import_data = $this->parse( $file['file'] );
		if ( is_wp_error( $import_data ) ) {
			echo '<p><strong>' . esc_html__( 'Sorry, there has been an error.', 'movedo-importer' ) . '</strong><br />';
			echo esc_html( $import_data->get_error_message() ) . '</p>';
			return false;
		}

		$this->version = $import_data['version'];
		if ( $this->version > $this->max_wxr_version ) {
			echo '<div class="error"><p><strong>';
			printf( esc_html__( 'This WXR file (version %s) may not be supported by this version of the importer. Please consider updating.', 'movedo-importer' ), esc_html($import_data['version']) );
			echo '</strong></p></div>';
		}

		$this->get_authors_from_import( $import_data );

		return true;
	}

	/**
	 * Retrieve authors from parsed WXR data
	 *
	 * Uses the provided author information from WXR 1.1 files
	 * or extracts info from each post for WXR 1.0 files
	 *
	 * @param array $import_data Data returned by a WXR parser
	 */
	function get_authors_from_import( $import_data ) {
		if ( ! empty( $import_data['authors'] ) ) {
			$this->authors = $import_data['authors'];
		// no author information, grab it from the posts
		} else {
			foreach ( $import_data['posts'] as $post ) {
				$login = sanitize_user( $post['post_author'], true );
				if ( empty( $login ) ) {
					printf( __( 'Failed to import author %s. Their posts will be attributed to the current user.', 'movedo-importer' ), esc_html( $post['post_author'] ) );
					echo '<br />';
					continue;
				}

				if ( ! isset($this->authors[$login]) )
					$this->authors[$login] = array(
						'author_login' => $login,
						'author_display_name' => $post['post_author']
					);
			}
		}
	}

	/**
	 * Create new categories based on import information
	 *
	 * Doesn't create a new category if its slug already exists
	 */
	function process_categories() {
		$this->categories = apply_filters( 'wp_import_categories', $this->categories );

		if ( empty( $this->categories ) )
			return;

		foreach ( $this->categories as $cat ) {
			// if the category already exists leave it alone
			$term_id = term_exists( $cat['category_nicename'], 'category' );
			if ( $term_id ) {
				if ( is_array($term_id) ) $term_id = $term_id['term_id'];
				if ( isset($cat['term_id']) )
					$this->processed_terms[intval($cat['term_id'])] = (int) $term_id;
				continue;
			}

			$category_parent = empty( $cat['category_parent'] ) ? 0 : category_exists( $cat['category_parent'] );
			$category_description = isset( $cat['category_description'] ) ? $cat['category_description'] : '';
			$catarr = array(
				'category_nicename' => $cat['category_nicename'],
				'category_parent' => $category_parent,
				'cat_name' => $cat['cat_name'],
				'category_description' => $category_description
			);
			$catarr = wp_slash( $catarr );

			$id = wp_insert_category( $catarr );
			if ( ! is_wp_error( $id ) ) {
				if ( isset($cat['term_id']) )
					$this->processed_terms[intval($cat['term_id'])] = $id;
			} else {
				if ( defined('MOVEDO_IMPORT_DEBUG') && MOVEDO_IMPORT_DEBUG ) {
					printf( __( 'Failed to import category %s', 'movedo-importer' ), esc_html($cat['category_nicename']) );
					echo ': ' . $id->get_error_message();
					echo '<br />';
				}
				continue;
			}
			$this->process_termmeta( $cat, $id['term_id'] );
		}

		unset( $this->categories );
	}

	/**
	 * Create new post tags based on import information
	 *
	 * Doesn't create a tag if its slug already exists
	 */
	function process_tags() {
		$this->tags = apply_filters( 'wp_import_tags', $this->tags );

		if ( empty( $this->tags ) )
			return;

		foreach ( $this->tags as $tag ) {
			// if the tag already exists leave it alone
			$term_id = term_exists( $tag['tag_slug'], 'post_tag' );
			if ( $term_id ) {
				if ( is_array($term_id) ) $term_id = $term_id['term_id'];
				if ( isset($tag['term_id']) )
					$this->processed_terms[intval($tag['term_id'])] = (int) $term_id;
				continue;
			}
			$tag = wp_slash( $tag );
			$tag_desc = isset( $tag['tag_description'] ) ? $tag['tag_description'] : '';
			$tagarr = array( 'slug' => $tag['tag_slug'], 'description' => $tag_desc );

			$id = wp_insert_term( $tag['tag_name'], 'post_tag', $tagarr );
			if ( ! is_wp_error( $id ) ) {
				if ( isset($tag['term_id']) )
					$this->processed_terms[intval($tag['term_id'])] = $id['term_id'];
			} else {
				printf( __( 'Failed to import post tag %s', 'movedo-importer' ), esc_html($tag['tag_name']) );
				if ( defined('MOVEDO_IMPORT_DEBUG') && MOVEDO_IMPORT_DEBUG )
					echo ': ' . $id->get_error_message();
				echo '<br />';
				continue;
			}
			$this->process_termmeta( $tag, $id['term_id'] );
		}

		unset( $this->tags );
	}

	/**
	 * Create new terms based on import information
	 *
	 * Doesn't create a term its slug already exists
	 */
	function process_terms() {
		$this->terms = apply_filters( 'wp_import_terms', $this->terms );

		if ( empty( $this->terms ) )
			return;

		foreach ( $this->terms as $term ) {
			// if the term already exists in the correct taxonomy leave it alone
			$term_id = term_exists( $term['slug'], $term['term_taxonomy'] );
			if ( $term_id ) {
				if ( is_array($term_id) ) $term_id = $term_id['term_id'];
				if ( isset($term['term_id']) )
					$this->processed_terms[intval($term['term_id'])] = (int) $term_id;
				continue;
			}

			if ( empty( $term['term_parent'] ) ) {
				$parent = 0;
			} else {
				$parent = term_exists( $term['term_parent'], $term['term_taxonomy'] );
				if ( is_array( $parent ) ) $parent = $parent['term_id'];
			}
			$term = wp_slash( $term );
			$description = isset( $term['term_description'] ) ? $term['term_description'] : '';
			$termarr = array( 'slug' => $term['slug'], 'description' => $description, 'parent' => intval($parent) );

			$id = wp_insert_term( $term['term_name'], $term['term_taxonomy'], $termarr );
			if ( ! is_wp_error( $id ) ) {
				if ( isset($term['term_id']) )
					$this->processed_terms[intval($term['term_id'])] = $id['term_id'];
			} else {
				if ( defined('MOVEDO_IMPORT_DEBUG') && MOVEDO_IMPORT_DEBUG ) {
					printf( __( 'Failed to import %s %s', 'movedo-importer' ), esc_html($term['term_taxonomy']), esc_html($term['term_name']) );
					echo ': ' . $id->get_error_message();
					echo '<br />';
				}
				continue;
			}
			$this->process_termmeta( $term, $id['term_id'] );
		}

		unset( $this->terms );
	}

	/**
	 * Add metadata to imported term.
	 *
	 */
	protected function process_termmeta( $term, $term_id ) {
		if ( ! isset( $term['termmeta'] ) ) {
			$term['termmeta'] = array();
		}

		/**
		 * Filters the metadata attached to an imported term.
		 */
		$term['termmeta'] = apply_filters( 'wp_import_term_meta', $term['termmeta'], $term_id, $term );

		if ( empty( $term['termmeta'] ) ) {
			return;
		}

		foreach ( $term['termmeta'] as $meta ) {
			$key = apply_filters( 'import_term_meta_key', $meta['key'], $term_id, $term );
			if ( ! $key ) {
				continue;
			}

			// Export gets meta straight from the DB so could have a serialized string
			$value = maybe_unserialize( $meta['value'] );

			add_term_meta( $term_id, $key, $value );
			do_action( 'import_term_meta', $term_id, $key, $value );
		}
	}

	/**
	 * Remap Categories in shortcodes
	 *
	 */
	function grve_categories_callback($matches)
	{
		$matches[0] = '';
		foreach( $matches as $match ){
			$cats = explode(",", $match);
			$new_cats = array();
			foreach( $cats as $cat ){
				if ( isset( $this->processed_terms[intval($cat)] ) ) {
					array_push($new_cats, $this->processed_terms[intval($cat)]);
				}
			}
			if(!empty($new_cats)){
				$matches[0] .= 'categories="' . implode(",", $new_cats) . '"';
			}
		}
		return $matches[0];
	}

	/**
	 * Create new posts based on import information
	 *
	 * Posts marked as having a parent which doesn't exist will become top level items.
	 * Doesn't create a new post if: the post type doesn't exist, the given post ID
	 * is already noted as imported or a post with the same title and date already exists.
	 * Note that new/updated terms, comments and meta are imported for the last of the above.
	 */

	function process_posts( $ids_array = array() ) {
		$this->posts = apply_filters( 'wp_import_posts', $this->posts );

		foreach ( $this->posts as $post ) {
			$post = apply_filters( 'wp_import_post_data_raw', $post );


			if ( !empty( $ids_array ) && !in_array( $post['post_id'], $ids_array ) ) {
				continue;
			}

			if ( ! post_type_exists( $post['post_type'] ) ) {
				if ( defined('MOVEDO_IMPORT_DEBUG') && MOVEDO_IMPORT_DEBUG ) {
					printf( __( 'Failed to import &#8220;%s&#8221;: Invalid post type %s', 'movedo-importer' ),
						esc_html($post['post_title']), esc_html($post['post_type']) );
					echo '<br />';
				}
				do_action( 'wp_import_post_exists', $post );
				continue;
			}

			if ( isset( $this->processed_posts[$post['post_id']] ) && ! empty( $post['post_id'] ) )
				continue;

			if ( $post['status'] == 'auto-draft' )
				continue;

			if ( 'nav_menu_item' == $post['post_type'] ) {
				$this->process_menu_item( $post );
				continue;
			}

			$post_type_object = get_post_type_object( $post['post_type'] );
			$post_exists = post_exists( $post['post_title'], '', $post['post_date'] );

			$post_exists = apply_filters( 'wp_import_existing_post', $post_exists, $post );

			if ( $post_exists && get_post_type( $post_exists ) == $post['post_type'] ) {
				if ( defined('MOVEDO_IMPORT_DEBUG') && MOVEDO_IMPORT_DEBUG ) {
					printf( __('%s &#8220;%s&#8221; already exists.', 'movedo-importer'), $post_type_object->labels->singular_name, esc_html($post['post_title']) );
					echo '<br />';
				}
				$comment_post_ID = $post_id = $post_exists;
				$this->processed_posts[ intval( $post['post_id'] ) ] = intval( $post_exists );
			} else {
				$post_parent = (int) $post['post_parent'];
				if ( $post_parent ) {
					// if we already know the parent, map it to the new local ID
					if ( isset( $this->processed_posts[$post_parent] ) ) {
						$post_parent = $this->processed_posts[$post_parent];
					// otherwise record the parent for later
					} else {
						$this->post_orphans[intval($post['post_id'])] = $post_parent;
						$post_parent = 0;
					}
				}

				// map the post author
				$author = sanitize_user( $post['post_author'], true );
				if ( isset( $this->author_mapping[$author] ) )
					$author = $this->author_mapping[$author];
				else
					$author = (int) get_current_user_id();

				//Remap Categories
				$pattern = '|categories="([^"]*)"|';
				$post['post_content'] = preg_replace_callback($pattern, "self::grve_categories_callback", $post['post_content']);

				if ( 'attachment' != $post['post_type'] ) {
					$post['guid'] = '';
				}
				$postdata = array(
					'import_id' => $post['post_id'], 'post_author' => $author, 'post_date' => $post['post_date'],
					'post_date_gmt' => $post['post_date_gmt'], 'post_content' => $post['post_content'],
					'post_excerpt' => $post['post_excerpt'], 'post_title' => $post['post_title'],
					'post_status' => $post['status'], 'post_name' => $post['post_name'],
					'comment_status' => $post['comment_status'], 'ping_status' => $post['ping_status'],
					'guid' => $post['guid'], 'post_parent' => $post_parent, 'menu_order' => $post['menu_order'],
					'post_type' => $post['post_type'], 'post_password' => $post['post_password']
				);

				$original_post_ID = $post['post_id'];
				$postdata = apply_filters( 'wp_import_post_data_processed', $postdata, $post );
				$postdata = wp_slash( $postdata );
				if ( 'attachment' == $postdata['post_type'] ) {

					$real_remote_url = ! empty($post['attachment_url']) ? $post['attachment_url'] : $post['guid'];
					$remote_url = ! empty($post['attachment_url']) ? $post['attachment_url'] : $post['guid'];

					//Demo Dummy Image
					$parts = pathinfo( $remote_url );
 					if ( ! $this->fetch_live_images && ( 'svg' == $parts['extension'] || 'jpg' == $parts['extension'] || 'png' == $parts['extension'] || 'gif' == $parts['extension'] ) ) {
						$remote_url = plugins_url( '/import/dummy/grve-dummy-sample-image.png', __FILE__ );
						$postdata['upload_date'] = '2000/01';

						if ( isset( $post['postmeta'] ) ) {
							foreach( $post['postmeta'] as $meta ) {
								if ( $meta['key'] == '_wp_attachment_metadata' ) {
									$metavalue = maybe_unserialize( $meta['value'] );

									$width = $metavalue['width'];
									$height = $metavalue['height'];
									if ( $width <= 81 ) {
										$remote_url = plugins_url( '/import/dummy/grve-dummy-sample-image-extra-small.png', __FILE__ );
									} else if ( $width <= 121 ) {
										$remote_url = plugins_url( '/import/dummy/grve-dummy-sample-image-extra-small@2x.png', __FILE__ );
									} else if ( $width <= 201 ) {
										$remote_url = plugins_url( '/import/dummy/grve-dummy-sample-image-small.png', __FILE__ );
									} else if ( $width <= 401 ) {
										$remote_url = plugins_url( '/import/dummy/grve-dummy-sample-image-medium.png', __FILE__ );
									} else if ( $width <= 1121 ) {
										$remote_url = plugins_url( '/import/dummy/grve-dummy-sample-image-large.png', __FILE__ );
									} else {
										if ( $height > 1080 ) {
											$remote_url = plugins_url( '/import/dummy/grve-dummy-sample-image-large.png', __FILE__ );
										} else {
											$remote_url = plugins_url( '/import/dummy/grve-dummy-sample-image.png', __FILE__ );
										}
									}
								}
							}
						}

					} elseif ( 'mp4' == $parts['extension'] || 'webm' == $parts['extension'] || 'ogv' == $parts['extension'] ) {
						$remote_url = plugins_url( '/import/dummy/grve-dummy-video.' . $parts['extension'] , __FILE__ );
						$postdata['upload_date'] = '2000/01';
					}  elseif ( 'mp3' == $parts['extension'] ) {
						continue;
					} else {

						// try to use _wp_attached file for upload folder placement to ensure the same location as the export site
						// e.g. location is 2003/05/image.jpg but the attachment post_date is 2010/09, see media_handle_upload()
						$postdata['upload_date'] = $post['post_date'];
						if ( isset( $post['postmeta'] ) ) {
							foreach( $post['postmeta'] as $meta ) {
								if ( $meta['key'] == '_wp_attached_file' ) {
									if ( preg_match( '%^[0-9]{4}/[0-9]{2}%', $meta['value'], $matches ) )
										$postdata['upload_date'] = $matches[0];
									break;
								}
							}
						}
 					}

					$comment_post_ID = $post_id = $this->process_attachment( $postdata, $remote_url, $real_remote_url );
				} else {
					$comment_post_ID = $post_id = wp_insert_post( $postdata, true );
					do_action( 'wp_import_insert_post', $post_id, $original_post_ID, $postdata, $post );
				}

				if ( is_wp_error( $post_id ) ) {
					if ( defined('MOVEDO_IMPORT_DEBUG') && MOVEDO_IMPORT_DEBUG ) {
						printf( __( 'Failed to import %s &#8220;%s&#8221;', 'movedo-importer' ),
						$post_type_object->labels->singular_name, esc_html($post['post_title']) );
						echo ': ' . $post_id->get_error_message();
						echo '<br />';
					}
					continue;
				}

				if ( $post['is_sticky'] == 1 )
					stick_post( $post_id );
			}

			// map pre-import ID to local ID
			$this->processed_posts[intval($post['post_id'])] = (int) $post_id;

			if ( ! isset( $post['terms'] ) )
				$post['terms'] = array();

			$post['terms'] = apply_filters( 'wp_import_post_terms', $post['terms'], $post_id, $post );

			// add categories, tags and other terms
			if ( ! empty( $post['terms'] ) ) {
				$terms_to_set = array();
				foreach ( $post['terms'] as $term ) {
					// back compat with WXR 1.0 map 'tag' to 'post_tag'
					$taxonomy = ( 'tag' == $term['domain'] ) ? 'post_tag' : $term['domain'];
					$term_exists = term_exists( $term['slug'], $taxonomy );
					$term_id = is_array( $term_exists ) ? $term_exists['term_id'] : $term_exists;
					if ( ! $term_id ) {
						$t = wp_insert_term( $term['name'], $taxonomy, array( 'slug' => $term['slug'] ) );
						if ( ! is_wp_error( $t ) ) {
							$term_id = $t['term_id'];
							do_action( 'wp_import_insert_term', $t, $term, $post_id, $post );
						} else {
							if ( defined('MOVEDO_IMPORT_DEBUG') && MOVEDO_IMPORT_DEBUG ) {
								printf( __( 'Failed to import %s %s', 'movedo-importer' ), esc_html($taxonomy), esc_html($term['name']) );
								echo ': ' . $t->get_error_message();
								echo '<br />';
							}
							do_action( 'wp_import_insert_term_failed', $t, $term, $post_id, $post );
							continue;
						}
					}
					$terms_to_set[$taxonomy][] = intval( $term_id );
				}

				foreach ( $terms_to_set as $tax => $ids ) {
					$tt_ids = wp_set_post_terms( $post_id, $ids, $tax );
					do_action( 'wp_import_set_post_terms', $tt_ids, $ids, $tax, $post_id, $post );
				}
				unset( $post['terms'], $terms_to_set );
			}

			if ( ! isset( $post['comments'] ) )
				$post['comments'] = array();

			$post['comments'] = apply_filters( 'wp_import_post_comments', $post['comments'], $post_id, $post );

			// add/update comments
			if ( ! empty( $post['comments'] ) ) {
				$num_comments = 0;
				$inserted_comments = array();
				foreach ( $post['comments'] as $comment ) {
					$comment_id	= $comment['comment_id'];
					$newcomments[$comment_id]['comment_post_ID']      = $comment_post_ID;
					$newcomments[$comment_id]['comment_author']       = $comment['comment_author'];
					$newcomments[$comment_id]['comment_author_email'] = $comment['comment_author_email'];
					$newcomments[$comment_id]['comment_author_IP']    = $comment['comment_author_IP'];
					$newcomments[$comment_id]['comment_author_url']   = $comment['comment_author_url'];
					$newcomments[$comment_id]['comment_date']         = $comment['comment_date'];
					$newcomments[$comment_id]['comment_date_gmt']     = $comment['comment_date_gmt'];
					$newcomments[$comment_id]['comment_content']      = $comment['comment_content'];
					$newcomments[$comment_id]['comment_approved']     = $comment['comment_approved'];
					$newcomments[$comment_id]['comment_type']         = $comment['comment_type'];
					$newcomments[$comment_id]['comment_parent'] 	  = $comment['comment_parent'];
					$newcomments[$comment_id]['commentmeta']          = isset( $comment['commentmeta'] ) ? $comment['commentmeta'] : array();
					if ( isset( $this->processed_authors[$comment['comment_user_id']] ) )
						$newcomments[$comment_id]['user_id'] = $this->processed_authors[$comment['comment_user_id']];
				}
				ksort( $newcomments );

				foreach ( $newcomments as $key => $comment ) {
					// if this is a new post we can skip the comment_exists() check
					if ( ! $post_exists || ! comment_exists( $comment['comment_author'], $comment['comment_date'] ) ) {
						if ( isset( $inserted_comments[$comment['comment_parent']] ) )
							$comment['comment_parent'] = $inserted_comments[$comment['comment_parent']];
						$comment = wp_slash( $comment );
						$comment = wp_filter_comment( $comment );
						$inserted_comments[$key] = wp_insert_comment( $comment );
						do_action( 'wp_import_insert_comment', $inserted_comments[$key], $comment, $comment_post_ID, $post );

						foreach( $comment['commentmeta'] as $meta ) {
							$value = maybe_unserialize( $meta['value'] );
							add_comment_meta( $inserted_comments[$key], $meta['key'], $value );
						}

						$num_comments++;
					}
				}
				unset( $newcomments, $inserted_comments, $post['comments'] );
			}

			if ( ! isset( $post['postmeta'] ) )
				$post['postmeta'] = array();

			$post['postmeta'] = apply_filters( 'wp_import_post_meta', $post['postmeta'], $post_id, $post );

			// add/update post meta
			if ( ! empty( $post['postmeta'] ) ) {
				foreach ( $post['postmeta'] as $meta ) {
					$key = apply_filters( 'import_post_meta_key', $meta['key'], $post_id, $post );
					$value = false;

					if ( '_edit_last' == $key ) {
						if ( isset( $this->processed_authors[intval($meta['value'])] ) )
							$value = $this->processed_authors[intval($meta['value'])];
						else
							$key = false;
					}

					if ( $key ) {
						// export gets meta straight from the DB so could have a serialized string
						if ( ! $value )
							$value = maybe_unserialize( $meta['value'] );

						add_post_meta( $post_id, $key, $value );
						do_action( 'import_post_meta', $post_id, $key, $value );

						// if the post has a featured image, take note of this in case of remap
						if ( '_thumbnail_id' == $key )
							$this->featured_images[$post_id] = (int) $value;
					}
				}
			}
		}

		unset( $this->posts );
	}

	/**
	 * Attempt to create a new menu item from import data
	 *
	 * Fails for draft, orphaned menu items and those without an associated nav_menu
	 * or an invalid nav_menu term. If the post type or term object which the menu item
	 * represents doesn't exist then the menu item will not be imported (waits until the
	 * end of the import to retry again before discarding).
	 *
	 * @param array $item Menu item details from WXR file
	 */
	function process_menu_item( $item ) {
		// skip draft, orphaned menu items
		if ( 'draft' == $item['status'] )
			return;

		$menu_slug = false;
		if ( isset($item['terms']) ) {
			// loop through terms, assume first nav_menu term is correct menu
			foreach ( $item['terms'] as $term ) {
				if ( 'nav_menu' == $term['domain'] ) {
					$menu_slug = $term['slug'];
					break;
				}
			}
		}

		// no nav_menu term associated with this menu item
		if ( ! $menu_slug ) {
			if ( defined('MOVEDO_IMPORT_DEBUG') && MOVEDO_IMPORT_DEBUG ) {
				esc_html_e( 'Menu item skipped due to missing menu slug', 'movedo-importer' );
				echo '<br />';
			}
			return;
		}

		$menu_id = term_exists( $menu_slug, 'nav_menu' );
		if ( ! $menu_id ) {
			if ( defined('MOVEDO_IMPORT_DEBUG') && MOVEDO_IMPORT_DEBUG ) {
				printf( __( 'Menu item skipped due to invalid menu slug: %s', 'movedo-importer' ), esc_html( $menu_slug ) );
				echo '<br />';
			}
			return;
		} else {
			$menu_id = is_array( $menu_id ) ? $menu_id['term_id'] : $menu_id;
		}

		foreach ( $item['postmeta'] as $meta ) {
			if ( version_compare( PHP_VERSION, '7.0.0' ) >= 0 ) {
				${$meta['key']} = $meta['value'];
			} else {
				$$meta['key'] = $meta['value'];
			}
		}

		if ( 'taxonomy' == $_menu_item_type && isset( $this->processed_terms[intval($_menu_item_object_id)] ) ) {
			$_menu_item_object_id = $this->processed_terms[intval($_menu_item_object_id)];
		} else if ( 'post_type' == $_menu_item_type && isset( $this->processed_posts[intval($_menu_item_object_id)] ) ) {
			$_menu_item_object_id = $this->processed_posts[intval($_menu_item_object_id)];
		} else if ( 'custom' != $_menu_item_type ) {
			// associated object is missing or not imported yet, we'll retry later
			$this->missing_menu_items[] = $item;
			return;
		}

		if ( isset( $this->processed_menu_items[intval($_menu_item_menu_item_parent)] ) ) {
			$_menu_item_menu_item_parent = $this->processed_menu_items[intval($_menu_item_menu_item_parent)];
		} else if ( $_menu_item_menu_item_parent ) {
			$this->menu_item_orphans[intval($item['post_id'])] = (int) $_menu_item_menu_item_parent;
			$_menu_item_menu_item_parent = 0;
		}

		// wp_update_nav_menu_item expects CSS classes as a space separated string
		$_menu_item_classes = maybe_unserialize( $_menu_item_classes );
		if ( is_array( $_menu_item_classes ) )
			$_menu_item_classes = implode( ' ', $_menu_item_classes );

		$args = array(
			'menu-item-object-id' => $_menu_item_object_id,
			'menu-item-object' => $_menu_item_object,
			'menu-item-parent-id' => $_menu_item_menu_item_parent,
			'menu-item-position' => intval( $item['menu_order'] ),
			'menu-item-type' => $_menu_item_type,
			'menu-item-title' => $item['post_title'],
			'menu-item-url' => $_menu_item_url,
			'menu-item-description' => $item['post_content'],
			'menu-item-attr-title' => $item['post_excerpt'],
			'menu-item-target' => $_menu_item_target,
			'menu-item-classes' => $_menu_item_classes,
			'menu-item-xfn' => $_menu_item_xfn,
			'menu-item-status' => $item['status']
		);

		$id = wp_update_nav_menu_item( $menu_id, 0, $args );
		if ( $id && ! is_wp_error( $id ) )
			$this->processed_menu_items[intval($item['post_id'])] = (int) $id;

		if ( $id && ! is_wp_error( $id ) ) {
			foreach($item['postmeta'] as $itemkey => $meta) {
				$key = str_replace('_', '-', ltrim($meta['key'], "_"));
				if( !array_key_exists($key, $args) && $key != "menu-item-menu-item-parent") {
					if(!empty($meta['value'])) {
						update_post_meta($id, $meta['key'], $meta['value']);
					}
				}
			}
		}
	}

	/**
	 * If fetching attachments is enabled then attempt to create a new attachment
	 *
	 * @param array $post Attachment post details from WXR
	 * @param string $url URL to fetch attachment from ( Dummy )
	 * @param string $real_url URL to fetch attachment from
	 * @return int|WP_Error Post ID on success, WP_Error otherwise
	 */
	function process_attachment( $post, $url, $real_url ) {
		if ( ! $this->fetch_attachments )
			return new WP_Error( 'attachment_processing_error',
				__( 'Fetching attachments is not enabled', 'movedo-importer' ) );

		// if the URL is absolute, but does not contain address, then upload it assuming base_site_url
		if ( preg_match( '|^/[\w\W]+$|', $url ) )
			$url = rtrim( $this->base_url, '/' ) . $url;

		if ( preg_match( '|^/[\w\W]+$|', $real_url ) )
			$real_url = rtrim( $this->base_url, '/' ) . $real_url;

		$upload = $this->fetch_remote_file( $url, $real_url, $post );

		if ( is_wp_error( $upload ) ) {
			return $upload;
		}
		if ( $info = wp_check_filetype( $upload['file'] ) )
			$post['post_mime_type'] = $info['type'];
		else
			return new WP_Error( 'attachment_processing_error', esc_html__('Invalid file type', 'movedo-importer') );

		$post['guid'] = $upload['url'];

		// as per wp-admin/includes/upload.php
		$post_id = wp_insert_attachment( $post, $upload['file'] );
		if ( isset( $upload['metadata'] ) && !empty( $upload['metadata'] ) ) {
			wp_update_attachment_metadata( $post_id, $upload['metadata'] );
		} else {
			wp_update_attachment_metadata( $post_id, wp_generate_attachment_metadata( $post_id, $upload['file'] ) );
		}

		// remap resized image URLs, works by stripping the extension and remapping the URL stub.
		if ( preg_match( '!^image/!', $info['type'] ) ) {
			$parts = pathinfo( $url );
			$name = basename( $parts['basename'], ".{$parts['extension']}" ); // PATHINFO_FILENAME in PHP 5.2

			$parts_new = pathinfo( $upload['url'] );
			$name_new = basename( $parts_new['basename'], ".{$parts_new['extension']}" );

			$this->url_remap[$parts['dirname'] . '/' . $name] = $parts_new['dirname'] . '/' . $name_new;
		}

		return $post_id;
	}

	/**
	 * Attempt to download a remote file attachment
	 *
	 * @param string $url URL of item to fetch
	 * @param array $post Attachment details
	 * @return array|WP_Error Local file location details on success, WP_Error otherwise
	 */
	function fetch_remote_file( $url, $real_url, $post ) {
		// extract the file name and extension from the url
		$file_name = basename( $url );

		//Check if attachment already uploaded
		$upload_dir = wp_upload_dir( $post['upload_date'] );
		$upload_file_dir = $upload_dir['path'] . '/' . $file_name;
		if( file_exists( $upload_file_dir ) && ! $this->fetch_live_images ) {
			$upload_file_url = $upload_dir['url'] . '/' . $file_name;

			$import_file = plugin_dir_path(__FILE__) . 'import/dummy/' . $file_name . '.json' ;
			$meta_array = array();
			if ( file_exists( $import_file ) ) {
				$import_array = file_get_contents( $import_file );
				$meta_array = json_decode( $import_array, true );
			}

			$upload = array(
				'file' => $upload_file_dir,
				'url' => $upload_file_url,
				'metadata' => $meta_array,
				'error' => false,
			);
		} else {
			// get placeholder file in the upload dir with a unique, sanitized filename
			$upload = wp_upload_bits( $file_name, 0, '', $post['upload_date'] );

			if ( $upload['error'] )
				return new WP_Error( 'upload_dir_error', $upload['error'] );

			// fetch the remote url and write it to the placeholder file
			$remote_response = wp_safe_remote_get( $url, array(
				'timeout' => 300,
						'stream' => true,
						'filename' => $upload['file'],
				) );

			$headers = wp_remote_retrieve_headers( $remote_response );

			// request failed
			if ( ! $headers ) {
				@unlink( $upload['file'] );
				return new WP_Error( 'import_file_error', esc_html__('Remote server did not respond', 'movedo-importer') );
			}

			$remote_response_code = wp_remote_retrieve_response_code( $remote_response );

			// make sure the fetch was successful
			if ( $remote_response_code != '200' ) {
				@unlink( $upload['file'] );
				return new WP_Error( 'import_file_error', sprintf( __('Remote server returned error response %1$d %2$s', 'movedo-importer'), esc_html($remote_response_code), get_status_header_desc($remote_response_code) ) );
			}

			$filesize = filesize( $upload['file'] );

			// if ( isset( $headers['content-length'] ) && $filesize != $headers['content-length'] ) {
				// @unlink( $upload['file'] );
				// return new WP_Error( 'import_file_error', esc_html__('Remote file is incorrect size', 'movedo-importer') );
			// }

			if ( 0 == $filesize ) {
				@unlink( $upload['file'] );
				return new WP_Error( 'import_file_error', esc_html__('Zero size file downloaded', 'movedo-importer') );
			}

			$max_size = (int) $this->max_attachment_size();
			if ( ! empty( $max_size ) && $filesize > $max_size ) {
				@unlink( $upload['file'] );
				return new WP_Error( 'import_file_error', sprintf(__('Remote file is too large, limit is %s', 'movedo-importer'), size_format($max_size) ) );
			}
		}

		// keep track of the old and new urls so we can substitute them later
		$this->url_remap[$real_url] = $upload['url'];
		//$this->url_remap[$post['guid']] = $upload['url']; // r13735, really needed?
		// keep track of the destination if the remote url is redirected somewhere else
		if ( isset($headers['x-final-location']) && $headers['x-final-location'] != $url )
			$this->url_remap[$headers['x-final-location']] = $upload['url'];

		return $upload;
	}

	function grve_wp_get_http( $url, $file_path ) {
		@set_time_limit( 120 );

		$options = array();
		$options['redirection'] = 5;
		$options['method'] = 'GET';

		$response = wp_safe_remote_request( $url, $options );

		if ( is_wp_error( $response ) )
			return false;

		$headers = wp_remote_retrieve_headers( $response );
		$headers['response'] = wp_remote_retrieve_response_code( $response );

		$out_fp = fopen($file_path, 'w');
		if ( !$out_fp )
			return $headers;

		fwrite( $out_fp,  wp_remote_retrieve_body( $response ) );
		fclose($out_fp);
		clearstatcache();

		return $headers;
	}

	/**
	 * Attempt to associate posts and menu items with previously missing parents
	 *
	 * An imported post's parent may not have been imported when it was first created
	 * so try again. Similarly for child menu items and menu items which were missing
	 * the object (e.g. post) they represent in the menu
	 */
	function backfill_parents() {
		global $wpdb;

		// find parents for post orphans
		foreach ( $this->post_orphans as $child_id => $parent_id ) {
			$local_child_id = $local_parent_id = false;
			if ( isset( $this->processed_posts[$child_id] ) )
				$local_child_id = $this->processed_posts[$child_id];
			if ( isset( $this->processed_posts[$parent_id] ) )
				$local_parent_id = $this->processed_posts[$parent_id];

			if ( $local_child_id && $local_parent_id ) {
				$wpdb->update( $wpdb->posts, array( 'post_parent' => $local_parent_id ), array( 'ID' => $local_child_id ), '%d', '%d' );
				clean_post_cache( $local_child_id );
			}
		}

		// all other posts/terms are imported, retry menu items with missing associated object
		$missing_menu_items = $this->missing_menu_items;
		foreach ( $missing_menu_items as $item )
			$this->process_menu_item( $item );

		// find parents for menu item orphans
		foreach ( $this->menu_item_orphans as $child_id => $parent_id ) {
			$local_child_id = $local_parent_id = 0;
			if ( isset( $this->processed_menu_items[$child_id] ) )
				$local_child_id = $this->processed_menu_items[$child_id];
			if ( isset( $this->processed_menu_items[$parent_id] ) )
				$local_parent_id = $this->processed_menu_items[$parent_id];

			if ( $local_child_id && $local_parent_id )
				update_post_meta( $local_child_id, '_menu_item_menu_item_parent', (int) $local_parent_id );
		}
	}

	/**
	 * Use stored mapping information to update old attachment URLs
	 */
	function backfill_attachment_urls() {
		global $wpdb;
		// make sure we do the longest urls first, in case one is a substring of another
		uksort( $this->url_remap, array(&$this, 'cmpr_strlen') );

		foreach ( $this->url_remap as $from_url => $to_url ) {
			// remap urls in post_content
			$wpdb->query( $wpdb->prepare("UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s)", $from_url, $to_url) );

			// remap _wpb_shortcodes_custom_css urls
			$result = $wpdb->query( $wpdb->prepare("UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key='_wpb_shortcodes_custom_css'", $from_url, $to_url) );
			// remap enclosure urls
			$result = $wpdb->query( $wpdb->prepare("UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key='enclosure'", $from_url, $to_url) );

			// remap video urls
			$result = $wpdb->query( $wpdb->prepare("UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key='_movedo_grve_post_video_webm'", $from_url, $to_url) );
			$result = $wpdb->query( $wpdb->prepare("UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key='_movedo_grve_post_video_mp4'", $from_url, $to_url) );
			$result = $wpdb->query( $wpdb->prepare("UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key='_movedo_grve_post_video_ogv'", $from_url, $to_url) );
			$result = $wpdb->query( $wpdb->prepare("UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key='_movedo_grve_post_video_poster'", $from_url, $to_url) );
			$result = $wpdb->query( $wpdb->prepare("UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key='_movedo_grve_portfolio_video_webm'", $from_url, $to_url) );
			$result = $wpdb->query( $wpdb->prepare("UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key='_movedo_grve_portfolio_video_mp4'", $from_url, $to_url) );
			$result = $wpdb->query( $wpdb->prepare("UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key='_movedo_grve_portfolio_video_ogv'", $from_url, $to_url) );
			$result = $wpdb->query( $wpdb->prepare("UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key='_movedo_grve_portfolio_video_poster'", $from_url, $to_url) );
		}
	}

	/**
	 * Update _thumbnail_id meta to new, imported attachment IDs
	 */
	function remap_featured_images() {
		// cycle through posts that have a featured image
		foreach ( $this->featured_images as $post_id => $value ) {
			if ( isset( $this->processed_posts[$value] ) ) {
				$new_id = $this->processed_posts[$value];
				// only update if there's a difference
				if ( $new_id != $value )
					update_post_meta( $post_id, '_thumbnail_id', $new_id );
			}
		}
	}

	/**
	 * Parse a WXR file
	 *
	 * @param string $file Path to WXR file for parsing
	 * @return array Information gathered from the WXR file
	 */
	function parse( $file ) {
		$parser = new MOVEDO_GRVE_WXR_Parser();
		return $parser->parse( $file );
	}

	// Display import page title
	function header() {
		echo '<div class="wrap">';
	}

	// Close div.wrap
	function footer() {
		echo '</div>';
	}


	/**
	 * Display introductory text
	 */
	function steps( $step = 1 ) {
?>
		<!-- Steps -->
		<ul class="grve-steps">
			<li class="<?php if ( $step >= 1 ) { echo 'active'; } ?>">1. <?php esc_html_e( 'Welcome', 'movedo-importer' ); ?></li>
			<li class="<?php if ( $step >= 2 ) { echo 'active'; } ?>">2. <?php esc_html_e( 'Demos', 'movedo-importer' ); ?></li>
			<li class="<?php if ( $step >= 3 ) { echo 'active'; } ?>">3. <?php esc_html_e( 'Content', 'movedo-importer' ); ?></li>
			<li class="<?php if ( $step >= 4 ) { echo 'active'; } ?>">4. <?php esc_html_e( 'Finish', 'movedo-importer' ); ?></li>
		</ul>
		<!-- End Steps -->
<?php
	}

	/**
	 * Display introductory text
	 */
	function greet() {
?>
	<div id="grve-importer-wrapper">

		<?php $this->steps(1); ?>

		<!-- Welcome -->
		<div id="grve-importer-welcome-page" class="grve-content-wrapper">
			<!-- Content -->
			<div class="grve-importer-content">
				<h3 class="grve-importer-title"><?php esc_html_e( 'Please note the following points:', 'movedo-importer' ); ?></h3>
				<ol>
					<li><?php esc_html_e( 'The import process will work best on a clean installation. You can use a plugin such as WordPress Reset to clear your data first.', 'movedo-importer' ); ?></li>
					<li><?php esc_html_e( 'Ensure all needed plugins are already installed and activated, e.g. WPBakery Visual Composer, Movedo Extension, WooCommerce, Contact Form 7 etc.', 'movedo-importer' ); ?></li>
					<li><?php esc_html_e( 'To import one of our Demos, select all or some of the options of any demo and press the import button.', 'movedo-importer' ); ?></li>
					<li><?php esc_html_e( 'Keep in mind not to run importer twice without clearing your data first. You might end up with duplicate data e.g duplicate menu items and/or widgets.', 'movedo-importer' ); ?></li>
					<li><?php esc_html_e( 'Once you start the process, please leave it running and uninterrupted! After the import, a status will be displayed with the results!', 'movedo-importer' ); ?></li>
				</ol>
				<hr>
				<div class="grve-importer-info">
					<i class="dashicons dashicons-warning grve-color-primary"></i>
					<strong>
						<?php esc_html_e( 'The normal operation time for the Import Full Demo mechanism is less than 3 minutes. For the Import On Demand process only a few seconds will be enough. Actual time may vary depending on your server performance. In case any of the import mechanisms is not successful, please inform us through our support forum to guide you through safely.', 'movedo-importer' ); ?>
						<br/><br/>
						<em><?php esc_html_e( 'It is always recommended to use the Import On Demand process. In combination with the Content Manager feature, Import On Demand is the fastest way to get a simple understanding of how the theme works and demonstrate in a few minutes your work to your customers.', 'movedo-importer' ); ?></em>
					</strong>
				</div>
				<div class="grve-importer-notice">
					<p><?php esc_html_e( 'The images included in preview are for demonstration purposes only. Some of them have been purchased from Shutter Stock and others were downloaded from Unsplash, Death To Stock and similar sources. It is worth noting that after the import process, you will have placeholders instead of the actual images.', 'movedo-importer' ); ?></p>
				</div>
				<?php if ( defined('ENVATO_HOSTED_SITE') ) { ?>
				<div class="grve-buttons-wrapper">
					<a href="<?php echo admin_url( 'admin.php?import=movedo-demo-importer&amp;step=2' ); ?>" class="grve-button grve-bg-primary alignright"><?php echo esc_html__( 'Choose Demo', 'movedo-importer' ); ?></a>
				</div>
				<?php } ?>
			</div>
			<!-- End Content -->
			<?php if ( !defined('ENVATO_HOSTED_SITE') ) { ?>
			<!-- Content -->
			<div class="grve-importer-content">
				<h3 class="grve-importer-title"><?php esc_html_e( 'Server Settings', 'movedo-importer' ); ?></h3>

					<?php
						$mem_limit = ini_get('memory_limit');
						$mem_limit_byte = wp_convert_hr_to_bytes( $mem_limit );
						$is_mem_limit_min = ( $mem_limit_byte < 268435456 );
						$post_max_size = ini_get('post_max_size');
						$post_max_size_byte = wp_convert_hr_to_bytes( $post_max_size );
						$is_post_max_size_min = ( $post_max_size_byte < 67108864 );
						$upload_max_filesize = ini_get('upload_max_filesize');
						$upload_max_filesize_byte = wp_convert_hr_to_bytes( $upload_max_filesize );
						$is_upload_max_filesize_min = ( $upload_max_filesize_byte < 33554432 );

						$wordpress_memory_limit = WP_MEMORY_LIMIT;
						$wordpress_memory_limit_byte = wp_convert_hr_to_bytes( $wordpress_memory_limit );
						$is_wordpress_memory_limit_min = ( $wordpress_memory_limit_byte < 100663296 );

						$php_version = phpversion();
						$is_php_version_min = version_compare( phpversion(), '5.6', '<' );
					?>
				<div class="grve-setting-wrap">
					<div class="grve-setting-inner-wrap">
						<strong class="grve-setting-label"><?php esc_html_e('PHP Version', 'movedo-importer'); ?></strong>
					<?php

						if( $is_php_version_min ) {
							echo '<span class="grve-setting-icon grve-setting-icon-no">';
							echo '<i class="dashicons dashicons-no grve-color-red"></i>';
							echo '</span>';
						} else {
							echo '<span class="grve-setting-icon grve-setting-icon-yes">';
							echo '<i class="dashicons dashicons-yes grve-color-primary"></i>';
							echo '</span>';
						}
						echo '<span class="grve-setting-title">';
						echo esc_html__('Currently:', 'movedo-importer') . ' ' . $php_version;
						echo '</span>';
						if( $is_php_version_min ) {
							echo '<span class="grve-setting-content">'. esc_html__( '(recommended PHP 5.6 or higher)', 'movedo-importer' ).'</span>';
						}
					?>
					</div>
					<div class="grve-setting-inner-wrap">
						<strong class="grve-setting-label"><?php esc_html_e('PHP Memory Limit', 'movedo-importer'); ?></strong>
					<?php

						if( $is_mem_limit_min ) {
							echo '<span class="grve-setting-icon grve-setting-icon-no">';
							echo '<i class="dashicons dashicons-no grve-color-red"></i>';
							echo '</span>';
						} else {
							echo '<span class="grve-setting-icon grve-setting-icon-yes">';
							echo '<i class="dashicons dashicons-yes grve-color-primary"></i>';
							echo '</span>';
						}
						echo '<span class="grve-setting-title">';
						echo esc_html__('Currently:', 'movedo-importer') . ' ' . $mem_limit;
						echo '</span>';
						if( $is_mem_limit_min ) {
							echo '<span class="grve-setting-content">'. esc_html__( '(min:256M)', 'movedo-importer' ).'</span>';
						}
					?>
					</div>
					<div class="grve-setting-inner-wrap">
						<strong class="grve-setting-label"><?php esc_html_e('PHP Max. Post Size', 'movedo-importer'); ?></strong>
					<?php
						if( $is_post_max_size_min ){
							echo '<span class="grve-setting-icon grve-setting-icon-no">';
							echo '<i class="dashicons dashicons-no grve-color-red"></i>';
							echo '</span>';
						} else {
							echo '<span class="grve-setting-icon grve-setting-icon-yes">';
							echo '<i class="dashicons dashicons-yes grve-color-primary"></i>';
							echo '</span>';
						}
						echo '<span class="grve-setting-title">';
						echo esc_html__('Currently:', 'movedo-importer') . ' ' . $post_max_size;
						echo '</span>';
						if($is_post_max_size_min){
							echo '<span class="grve-setting-content">'. esc_html__( '(min:64M)', 'movedo-importer' ).'</span>';
						}
					?>
					</div>
					<div class="grve-setting-inner-wrap">
						<strong class="grve-setting-label"><?php esc_html_e('PHP Upload Max. Filesize', 'movedo-importer'); ?></strong>
					<?php
						if( $is_upload_max_filesize_min ){
							echo '<span class="grve-setting-icon grve-setting-icon-no">';
							echo '<i class="dashicons dashicons-no grve-color-red"></i>';
							echo '</span>';
						} else {
							echo '<span class="grve-setting-icon grve-setting-icon-yes">';
							echo '<i class="dashicons dashicons-yes grve-color-primary"></i>';
							echo '</span>';
						}
						echo '<span class="grve-setting-title">';
						echo esc_html__('Currently:', 'movedo-importer') . ' ' . $upload_max_filesize;
						echo '</span>';
						if( $is_upload_max_filesize_min ){
							echo '<span class="grve-setting-content">'. esc_html__( '(min:32M)', 'movedo-importer' ).'</span>';
						}
					?>
					</div>
					<div class="grve-setting-inner-wrap">
						<strong class="grve-setting-label"><?php esc_html_e('WP Memory Limit', 'movedo-importer'); ?></strong>
					<?php
						if( $is_wordpress_memory_limit_min ){
							echo '<span class="grve-setting-icon grve-setting-icon-no">';
							echo '<i class="dashicons dashicons-no grve-color-red"></i>';
							echo '</span>';
						} else {
							echo '<span class="grve-setting-icon grve-setting-icon-yes">';
							echo '<i class="dashicons dashicons-yes grve-color-primary"></i>';
							echo '</span>';
						}
						echo '<span class="grve-setting-title">';
						echo esc_html__('Currently:', 'movedo-importer') . ' ' . $wordpress_memory_limit;
						echo '</span>';
						if( $is_wordpress_memory_limit_min ){
							echo '<span class="grve-setting-content">'. esc_html__( '(recommended 96M or higher)', 'movedo-importer' ).'</span>';
						}
					?>
					</div>
				</div>
				<div class="grve-buttons-wrapper">
					<a href="//docs.greatives.eu/tutorials/recommended-server-settings-memory-issues" class="grve-button grve-bg-grey alignleft" target="_blank"><?php echo esc_html__( 'Recommended Server Settings', 'movedo-importer' ); ?></a>
					<a href="<?php echo admin_url( 'admin.php?import=movedo-demo-importer&amp;step=2' ); ?>" class="grve-button grve-bg-primary alignright"><?php echo esc_html__( 'Choose Demo', 'movedo-importer' ); ?></a>
				</div>
			</div>
			<!-- End Content -->
			<?php } ?>
		</div>
		<!-- End Welcome -->

	</div>
	<!-- End Importer Wrapper -->
<?php

	}
	/**
	 * Display demo selection
	 */
	function demoSelection() {

	$grve_dummy_data_list = $this->grve_get_demo_data();
?>
	<div id="grve-importer-wrapper">
		<?php $this->steps(2); ?>

		<!-- Demos -->
		<div id="grve-importer-demo-page" class="grve-content-wrapper">
			<div class="grve-importer-content">
				<h3 class="grve-importer-title"><?php esc_html_e( 'Select your Demo', 'movedo-importer' ); ?></h3>
				<p><?php esc_html_e( 'Here you can select the demo of your choice. Nothing will be imported in your installation after clicking any button on this step. Just select one of the available demos, explore and then import any specific content you wish.', 'movedo-importer' ); ?></p>
			</div>
			<div class="grve-importer-demos-wrapper">
<?php
		foreach ( $grve_dummy_data_list as $grve_dummy_data ) {
			$image_src = plugins_url( '/import/data/' . $grve_dummy_data['dir'] . '/screenshot.png', __FILE__ );
?>
			<div class="grve-importer-column-2">
				<div class="grve-importer-content">
					<div class="grve-demo-wrapper">
						<div class="grve-demo-screenshot grve-demo-item">
							<img src="<?php echo esc_url( $image_src ); ?>" title="<?php $grve_dummy_data['name']; ?>" alt="<?php $grve_dummy_data['name']; ?>"/>
						</div>
						<div class="grve-demo-description grve-demo-item">
							<h3 class="grve-importer-title"><?php echo $grve_dummy_data['name']; ?></h3>
							<p><?php echo $grve_dummy_data['description']; ?></p>
							<a href="//greatives.eu/themes/<?php echo esc_attr( $grve_dummy_data['preview'] ); ?>" class="grve-button grve-bg-grey" target="_blank"><?php echo esc_html__( 'Preview Demo', 'movedo-importer' ); ?></a>
							<a href="<?php echo admin_url( 'admin.php?import=movedo-demo-importer&amp;step=3&amp;demo=' . esc_attr( $grve_dummy_data['dir'] ) ); ?>" class="grve-button grve-bg-primary"><?php echo esc_html__( 'Explore Demo', 'movedo-importer' ); ?></a>
						</div>
					</div>
				</div>
			</div>
<?php
		}
?>
			</div>
		</div>
		<!-- End Demos -->
	</div>
	<!-- End Importer Wrapper -->
<?php

	}
	/**
	 * Display content selection
	 */
	function contentSelection() {

	$dummy_id = 'undefined';
	if ( isset( $_GET['demo'] ) && !empty( $_GET['demo'] ) ) {
		$dummy_id = $_GET['demo'];
	}
	$grve_dummy_data = array(
		'id'   => 'undefined',
		'name' => 'Undefined Demo',
		'dir'  => 'undefined',
		'description'  => esc_html( 'Undefined Demo', 'movedo-importer' ),
	);

	$grve_dummy_data_list = $this->grve_get_demo_data();
	foreach ( $grve_dummy_data_list as $grve_dummy_data_item ) {
		if( $dummy_id === $grve_dummy_data_item['dir'] ) {
			$grve_dummy_data = $grve_dummy_data_item;
			break;
		}
	}

?>
	<div id="grve-importer-wrapper">
		<?php $this->steps(3); ?>

		<!-- Installation Loader -->
		<div id="grve-importer-loader" class="grve-content-wrapper" style="display:none;">
			<div class="grve-importer-content">
				<div id="grve-import-loading">
					<div class="grve-spinner"></div>
					<h3 class="grve-importer-title grve-align-center"><?php esc_html_e( 'Import in progress...', 'movedo-importer' ); ?></h3>
					<strong class="grve-align-center"><?php esc_html_e( 'Don\'t close the browser or navigate away', 'movedo-importer' ); ?></strong>
				</div>
				<span id="grve-import-countdown" class="clearfix"></span>
				<div class="clear"></div>
				<div id="grve-import-output-info" class="wrap clearfix" style="display:none;"></div>
				<div id="grve-import-output-container" style="display:none;"></div>
			</div>
		</div>
		<!-- End Installation -->

		<!-- Contents -->
		<div id="grve-importer-contents-page" class="grve-content-wrapper">
			<div class="grve-importer-content grve-admin-dummy-item">
				<h3 class="grve-importer-title"><?php esc_html_e( 'Import On Demand', 'movedo-importer' ); ?> ( <?php echo esc_html( $grve_dummy_data['name'] ); ?> )</h3>
				<p><?php esc_html_e( 'Choose the specific pages, portfolios, posts and products you wish to import into your site. Select the ones you prefer via the available multi selectors below and click the button Import Selected.', 'movedo-importer' ); ?></p>
				<input type="hidden" class="grve-admin-dummy-option-singular" value="true"/>
				<input type="hidden" class="grve-admin-dummy-option-dummy-nonce" value="<?php echo wp_create_nonce( $grve_dummy_data['dir'] ); ?>"/>
				<?php $this->grve_print_singular_selectors( $grve_dummy_data['dir'] ); ?>
				<div class="grve-importer-info">
					<i class="dashicons dashicons-warning grve-color-primary"></i>
					<strong>
						<?php esc_html_e( 'You can select/deselect multiple items too (ctrl + click on PC and command + click on Mac).', 'movedo-importer' ); ?>
					</strong>
				</div>
				<div class="grve-admin-dummy-option">
					<input type="checkbox" class="grve-admin-dummy-option-single-demo-images" value="yes"/><strong><?php esc_html_e( 'Download images from live demo *', 'movedo-importer' ); ?></strong>
					<br><br>
					<strong>
					* <?php esc_html_e( 'Important Note: ', 'movedo-importer' ); ?>
					</strong>
					<?php esc_html_e( 'The actual images included in preview are for demonstration purposes only. They have been purchased from Shutterstock and/or downloaded from Unsplash, Death to Stock and similar sources. In case you use any of these images in your end-product, ensure that they are properly licensed. Greatives does not transfer any licenses for the images used in the demo sites.', 'movedo-importer' ); ?>
				</div>
				<div class="grve-buttons-wrapper">
					<a href="#" class="grve-button grve-bg-grey alignleft grve-import-clear-selection"><?php echo esc_html__( 'Clear Selection', 'movedo-importer' ); ?></a>
					<a href="#" class="grve-button grve-bg-primary alignright grve-import-dummy-data" data-dummy-id="<?php echo $grve_dummy_data['dir']; ?>"><?php echo esc_html__( 'Import Selected', 'movedo-importer' ); ?></a>
				</div>
			</div>
			<div class="grve-importer-content grve-admin-dummy-item">
				<h3 class="grve-importer-title"><?php esc_html_e( 'Import Full Demo', 'movedo-importer' ); ?> ( <?php echo esc_html( $grve_dummy_data['name'] ); ?> )</h3>
				<p><?php esc_html_e( 'The import process will work best on a clean installation. You can use a plugin such as WordPress Reset to clear your data first. The import process will work best on a clean installation. You can use a plugin such as WordPress Reset to clear your data first', 'movedo-importer' ); ?></p>
				<input type="hidden" class="grve-admin-dummy-option-dummy-nonce" value="<?php echo wp_create_nonce( $grve_dummy_data['dir'] ); ?>"/>
				<div class="grve-admin-dummy-option-wrapper">
					<div class="grve-admin-dummy-option">
						<input type="checkbox" class="grve-admin-dummy-option-dummy-content" value="yes"/><strong><?php esc_html_e( 'Dummy Content', 'movedo-importer' ); ?></strong>
					</div>
					<div class="grve-admin-dummy-option">
						<input type="checkbox" class="grve-admin-dummy-option-theme-options" value="yes"/><strong><?php esc_html_e( 'Theme Options', 'movedo-importer' ); ?></strong>
					</div>
					<div class="grve-admin-dummy-option">
						<input type="checkbox" class="grve-admin-dummy-option-widgets" value="yes"/><strong><?php esc_html_e( 'Widgets', 'movedo-importer' ); ?></strong>
					</div>
					<?php if ( 'movedo' != $grve_dummy_data['id'] ) { ?>
					<div class="grve-admin-dummy-option">
						<input type="checkbox" class="grve-admin-dummy-option-full-demo-images" value="yes"/><strong><?php esc_html_e( 'Download images from live demo *', 'movedo-importer' ); ?></strong>
						<br><br>
						<strong>
						* <?php esc_html_e( 'Important Note: ', 'movedo-importer' ); ?>
						</strong>
						<?php esc_html_e( 'The actual images included in preview are for demonstration purposes only. They have been purchased from Shutterstock and/or downloaded from Unsplash, Death to Stock and similar sources. In case you use any of these images in your end-product, ensure that they are properly licensed. Greatives does not transfer any licenses for the images used in the demo sites.', 'movedo-importer' ); ?>
					</div>
					<?php } ?>
				</div>
				<a href="#" class="grve-button grve-bg-primary alignleft grve-import-dummy-data" data-dummy-id="<?php echo $grve_dummy_data['dir']; ?>"><?php echo esc_html__( 'Import Full Demo', 'movedo-importer' ); ?></a>
			</div>
		</div>
		<!-- End Contents -->

		<form id="grve-import-finish-form" action="<?php echo admin_url( 'admin.php?import=movedo-demo-importer&amp;step=4' ); ?>" method="post"></form>
	</div>
	<!-- End Importer Wrapper -->
<?php

	}
	/**
	 * Display finish page
	 */
	function finish() {

?>
	<div id="grve-importer-wrapper">
		<?php $this->steps(4); ?>
		<!-- Finish -->
		<div id="grve-importer-finish-page" class="grve-content-wrapper">
			<div class="grve-importer-content">
				<div class="grve-completed-icon dashicons dashicons-yes grve-color-primary"></div>
				<h3 class="grve-importer-title grve-align-center"><?php esc_html_e( 'Import Completed!', 'movedo-importer' ); ?></h3>
				<div class="grve-buttons-wrapper grve-align-center">
					<a href="<?php echo esc_url( home_url() ); ?>" class="grve-button grve-bg-primary" target="_blank"><?php echo esc_html__( 'Visit Your Site', 'movedo-importer' ); ?></a>
				</div>
			</div>
		</div>
		<!-- End Finish -->
	</div>
	<!-- End Importer Wrapper -->
<?php
	}

	/**
	 * Decide if the given meta key maps to information we will want to import
	 *
	 * @param string $key The meta key to check
	 * @return string|bool The key if we do want to import, false if not
	 */
	function is_valid_meta_key( $key ) {
		// skip attachment metadata since we'll regenerate it from scratch
		// skip _edit_lock as not relevant for import
		if ( in_array( $key, array( '_wp_attached_file', '_wp_attachment_metadata', '_edit_lock' ) ) )
			return false;
		return $key;
	}

	/**
	 * Decide whether or not the importer is allowed to create users.
	 * Default is true, can be filtered via import_allow_create_users
	 *
	 * @return bool True if creating users is allowed
	 */
	function allow_create_users() {
		return apply_filters( 'import_allow_create_users', true );
	}

	/**
	 * Decide whether or not the importer should attempt to download attachment files.
	 * Default is true, can be filtered via import_allow_fetch_attachments. The choice
	 * made at the import options screen must also be true, false here hides that checkbox.
	 *
	 * @return bool True if downloading attachments is allowed
	 */
	function allow_fetch_attachments() {
		return apply_filters( 'import_allow_fetch_attachments', true );
	}

	/**
	 * Decide what the maximum file size for downloaded attachments is.
	 * Default is 0 (unlimited), can be filtered via import_attachment_size_limit
	 *
	 * @return int Maximum attachment file size to import
	 */
	function max_attachment_size() {
		return apply_filters( 'import_attachment_size_limit', 0 );
	}

	/**
	 * Added to http_request_timeout filter to force timeout at 180 seconds during import
	 * @return int 180
	 */
	function bump_request_timeout( $val ) {
		return 180;
	}

	// return the difference in length between two strings
	function cmpr_strlen( $a, $b ) {
		return strlen($b) - strlen($a);
	}
}

}

function movedo_importer_init() {
	load_plugin_textdomain( 'movedo-importer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	$GLOBALS['movedo_importer'] = new Movedo_Importer();
	register_importer( 'movedo-demo-importer', 'Movedo Demo Importer', esc_html__('Import Movedo Demos, Dummy Content, Theme Options and Widgets.', 'movedo-importer'), array( $GLOBALS['movedo_importer'], 'dispatch' ) );
}
add_action( 'admin_init', 'movedo_importer_init' );

// for php < 5.5
if (!function_exists('array_column')) {
	if ( version_compare( phpversion(), '5.3.0', '<' ) ) {
		function array_column($input, $column_key, $index_key = null) {
			return array();
		}
	} else {
		function array_column($input, $column_key, $index_key = null) {
			$arr = array_map(function($d) use ($column_key, $index_key) {
				if (!isset($d[$column_key])) {
					return null;
				}
				if ($index_key !== null) {
					return array($d[$index_key] => $d[$column_key]);
				}
				return $d[$column_key];
			}, $input);

			if ($index_key !== null) {
				$tmp = array();
				foreach ($arr as $ar) {
					$tmp[key($ar)] = current($ar);
				}
				$arr = $tmp;
			}
			return $arr;
		}
	}
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
