<?php
/*
*	Area Item Post Type Registration
*
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/

if ( ! class_exists( 'Movedo_Area_Post_Type' ) ) {
	class Movedo_Area_Post_Type {

		function __construct() {

			// Adds the area post type and taxonomies
			$this->movedo_ext_area_init();

			// Manage Columns for area overview
			add_filter( 'manage_edit-area_columns',  array( &$this, 'movedo_ext_area_edit_columns' ) );

		}

		function movedo_ext_area_init() {


			$labels = array(
				'name' => esc_html_x( 'Area Items', 'Area General Name', 'movedo-extension' ),
				'singular_name' => esc_html_x( 'Area Item', 'Area Singular Name', 'movedo-extension' ),
				'add_new' => esc_html__( 'Add New', 'movedo-extension' ),
				'add_new_item' => esc_html__( 'Add New Area Item', 'movedo-extension' ),
				'edit_item' => esc_html__( 'Edit Area Item', 'movedo-extension' ),
				'new_item' => esc_html__( 'New Area Item', 'movedo-extension' ),
				'view_item' => esc_html__( 'View Area Item', 'movedo-extension' ),
				'search_items' => esc_html__( 'Search Area Items', 'movedo-extension' ),
				'not_found' =>  esc_html__( 'No Area Items found', 'movedo-extension' ),
				'not_found_in_trash' => esc_html__( 'No Area Items found in Trash', 'movedo-extension' ),
				'parent_item_colon' => '',
			);

			$args = array(
				'labels' => $labels,
				'public' => true,
				'publicly_queryable' => true,
				'exclude_from_search' => true,
				'show_in_nav_menus' => false,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 5,
				'menu_icon' => 'dashicons-media-text',
				'supports' => array( 'title', 'editor', 'author', 'thumbnail' ),
				'rewrite' => array( 'slug' => 'area-item', 'with_front' => false ),
			  );

			register_post_type( 'area-item' , $args );


		}

		function movedo_ext_area_edit_columns( $columns ) {
			$columns['cb'] = "<input type=\"checkbox\" />";
			$columns['title'] = esc_html__( 'Title', 'movedo-extension' );
			$columns['author'] = esc_html__( 'Author', 'movedo-extension' );
			$columns['date'] = esc_html__( 'Date', 'movedo-extension' );
			return $columns;
		}

	}
	new Movedo_Area_Post_Type;
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
