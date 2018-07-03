<?php
/*
*	Portfolio Post Type Registration
*
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/

if ( ! class_exists( 'Movedo_Portfolio_Post_Type' ) ) {
	class Movedo_Portfolio_Post_Type {

		function __construct() {

			// Adds the portfolio post type and taxonomies
			$this->movedo_ext_portfolio_init();


			// Manage Columns for portfolio overview
			add_filter( 'manage_edit-portfolio_columns',  array( &$this, 'movedo_ext_portfolio_edit_columns' ) );
			add_action( 'manage_posts_custom_column', array( &$this, 'movedo_ext_portfolio_custom_columns' ), 10, 2 );

		}

		function movedo_ext_portfolio_init() {

			$portfolio_base_slug = 'portfolio';
			if ( function_exists( 'movedo_grve_option' ) ) {
				$portfolio_base_slug = movedo_grve_option( 'portfolio_slug', 'portfolio' );
			}


			$labels = array(
				'name' => esc_html_x( 'Portfolio Items', 'Portfolio General Name', 'movedo-extension' ),
				'singular_name' => esc_html_x( 'Portfolio Item', 'Portfolio Singular Name', 'movedo-extension' ),
				'add_new' => esc_html__( 'Add New', 'movedo-extension' ),
				'add_new_item' => esc_html__( 'Add New Portfolio Item', 'movedo-extension' ),
				'edit_item' => esc_html__( 'Edit Portfolio Item', 'movedo-extension' ),
				'new_item' => esc_html__( 'New Portfolio Item', 'movedo-extension' ),
				'view_item' => esc_html__( 'View Portfolio Item', 'movedo-extension' ),
				'search_items' => esc_html__( 'Search Portfolio Items', 'movedo-extension' ),
				'not_found' =>  esc_html__( 'No Portfolio Items found', 'movedo-extension' ),
				'not_found_in_trash' => esc_html__( 'No Portfolio Items found in Trash', 'movedo-extension' ),
				'parent_item_colon' => '',
			);

			$category_labels = array(
				'name' => esc_html__( 'Portfolio Categories', 'movedo-extension' ),
				'singular_name' => esc_html__( 'Portfolio Category', 'movedo-extension' ),
				'search_items' => esc_html__( 'Search Portfolio Categories', 'movedo-extension' ),
				'all_items' => esc_html__( 'All Portfolio Categories', 'movedo-extension' ),
				'parent_item' => esc_html__( 'Parent Portfolio Category', 'movedo-extension' ),
				'parent_item_colon' => esc_html__( 'Parent Portfolio Category:', 'movedo-extension' ),
				'edit_item' => esc_html__( 'Edit Portfolio Category', 'movedo-extension' ),
				'update_item' => esc_html__( 'Update Portfolio Category', 'movedo-extension' ),
				'add_new_item' => esc_html__( 'Add New Portfolio Category', 'movedo-extension' ),
				'new_item_name' => esc_html__( 'New Portfolio Category Name', 'movedo-extension' ),
			);

			$field_labels = array(
				'name' => esc_html__( 'Portfolio Fields', 'movedo-extension' ),
				'singular_name' => esc_html__( 'Portfolio Field', 'movedo-extension' ),
				'search_items' => esc_html__( 'Search Portfolio Fields', 'movedo-extension' ),
				'all_items' => esc_html__( 'All Portfolio Fields', 'movedo-extension' ),
				'parent_item' => esc_html__( 'Parent Portfolio Field', 'movedo-extension' ),
				'parent_item_colon' => esc_html__( 'Parent Portfolio Field:', 'movedo-extension' ),
				'edit_item' => esc_html__( 'Edit Portfolio Field', 'movedo-extension' ),
				'update_item' => esc_html__( 'Update Portfolio Field', 'movedo-extension' ),
				'add_new_item' => esc_html__( 'Add New Portfolio Field', 'movedo-extension' ),
				'new_item_name' => esc_html__( 'New Portfolio Field Name', 'movedo-extension' ),
			);

			$args = array(
				'labels' => $labels,
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 5,
				'menu_icon' => 'dashicons-format-gallery',
				'supports' => array( 'title', 'editor', 'author', 'excerpt', 'thumbnail', 'custom-fields', 'comments' ),
				'rewrite' => array( 'slug' => $portfolio_base_slug, 'with_front' => false ),
			);

			register_post_type( 'portfolio' , $args );

			register_taxonomy(
				'portfolio_category',
				array( 'portfolio' ),
				array(
					'hierarchical' => true,
					'label' => esc_html__( 'Portfolio Categories', 'movedo-extension' ),
					'labels' => $category_labels,
					'show_in_nav_menus' => false,
					'show_tagcloud' => false,
					'rewrite' => true,
				)
			);
			register_taxonomy_for_object_type( 'portfolio_category', 'portfolio' );

			register_taxonomy(
				'portfolio_field',
				array( 'portfolio' ),
				array(
					'hierarchical' => true,
					'label' => esc_html__( 'Portfolio Fields', 'movedo-extension' ),
					'labels' => $field_labels,
					'show_in_nav_menus' => false,
					'show_tagcloud' => false,
					'rewrite' => true,
				)
			);
			register_taxonomy_for_object_type( 'portfolio_field', 'portfolio' );

		}

		function movedo_ext_portfolio_edit_columns( $columns ) {
			$columns['cb'] = "<input type=\"checkbox\" />";
			$columns['title'] = esc_html__( 'Title', 'movedo-extension' );
			$columns['portfolio_thumbnail'] = esc_html__( 'Featured Image', 'movedo-extension' );
			$columns['author'] = esc_html__( 'Author', 'movedo-extension' );
			$columns['portfolio_category'] = esc_html__( 'Portfolio Categories', 'movedo-extension' );
			$columns['portfolio_field'] = esc_html__( 'Portfolio Fields', 'movedo-extension' );
			$columns['date'] = esc_html__( 'Date', 'movedo-extension' );
			return $columns;
		}

		function movedo_ext_portfolio_custom_columns( $column, $post_id ) {

			switch ( $column ) {
				case "portfolio_thumbnail":
					if ( has_post_thumbnail( $post_id ) ) {
						$thumbnail_id = get_post_thumbnail_id( $post_id );
						$attachment_src = wp_get_attachment_image_src( $thumbnail_id, array( 80, 80 ) );
						$thumb = $attachment_src[0];
					} else {
						$thumb = get_template_directory_uri() . '/includes/images/no-image.jpg';
					}
					echo '<img class="attachment-80x80" width="80" height="80" alt="portfolio image" src="' . esc_url( $thumb ) . '">';
					break;
				case 'portfolio_category':
					echo get_the_term_list( $post_id, 'portfolio_category', '', ', ','' );
				break;
				case 'portfolio_field':
					echo get_the_term_list( $post_id, 'portfolio_field', '', ', ','' );
				break;
			}
		}

	}
	new Movedo_Portfolio_Post_Type;
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
