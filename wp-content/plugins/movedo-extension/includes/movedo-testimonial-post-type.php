<?php
/*
*	Testimonial Post Type Registration
*
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/

if ( ! class_exists( 'Movedo_Testimonial_Post_Type' ) ) {
	class Movedo_Testimonial_Post_Type {

		function __construct() {

			// Adds the testimonial post type and taxonomies
			$this->movedo_ext_testimonial_init();

			// Manage Columns for testimonial overview
			add_filter( 'manage_edit-testimonial_columns',  array( &$this, 'movedo_ext_testimonial_edit_columns' ) );
			add_action( 'manage_posts_custom_column', array( &$this, 'movedo_ext_testimonial_custom_columns' ), 10, 2 );

		}

		function movedo_ext_testimonial_init() {


			$labels = array(
				'name' => esc_html_x( 'Testimonial Items', 'Testimonial General Name', 'movedo-extension' ),
				'singular_name' => esc_html_x( 'Testimonial Item', 'Testimonial Singular Name', 'movedo-extension' ),
				'add_new' => esc_html__( 'Add New', 'movedo-extension' ),
				'add_new_item' => esc_html__( 'Add New Testimonial Item', 'movedo-extension' ),
				'edit_item' => esc_html__( 'Edit Testimonial Item', 'movedo-extension' ),
				'new_item' => esc_html__( 'New Testimonial Item', 'movedo-extension' ),
				'view_item' => esc_html__( 'View Testimonial Item', 'movedo-extension' ),
				'search_items' => esc_html__( 'Search Testimonial Items', 'movedo-extension' ),
				'not_found' =>  esc_html__( 'No Testimonial Items found', 'movedo-extension' ),
				'not_found_in_trash' => esc_html__( 'No Testimonial Items found in Trash', 'movedo-extension' ),
				'parent_item_colon' => '',
			);

			$category_labels = array(
				'name' => esc_html__( 'Testimonial Categories', 'movedo-extension' ),
				'singular_name' => esc_html__( 'Testimonial Category', 'movedo-extension' ),
				'search_items' => esc_html__( 'Search Testimonial Categories', 'movedo-extension' ),
				'all_items' => esc_html__( 'All Testimonial Categories', 'movedo-extension' ),
				'parent_item' => esc_html__( 'Parent Testimonial Category', 'movedo-extension' ),
				'parent_item_colon' => esc_html__( 'Parent Testimonial Category:', 'movedo-extension' ),
				'edit_item' => esc_html__( 'Edit Testimonial Category', 'movedo-extension' ),
				'update_item' => esc_html__( 'Update Testimonial Category', 'movedo-extension' ),
				'add_new_item' => esc_html__( 'Add New Testimonial Category', 'movedo-extension' ),
				'new_item_name' => esc_html__( 'New Testimonial Category Name', 'movedo-extension' ),
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
				'menu_icon' => 'dashicons-testimonial',
				'supports' => array( 'title', 'editor', 'author', 'thumbnail' ),
				'rewrite' => array( 'slug' => 'testimonial', 'with_front' => false ),
			  );

			register_post_type( 'testimonial' , $args );

			register_taxonomy(
				'testimonial_category',
				array( 'testimonial' ),
				array(
					'hierarchical' => true,
					'label' => esc_html__( 'Testimonial Categories', 'movedo-extension' ),
					'labels' => $category_labels,
					'show_in_nav_menus' => false,
					'show_tagcloud' => false,
					'rewrite' => true,
				)
			);
			register_taxonomy_for_object_type( 'testimonial_category', 'testimonial' );

		}

		function movedo_ext_testimonial_edit_columns( $columns ) {
			$columns['cb'] = "<input type=\"checkbox\" />";
			$columns['title'] = esc_html__( 'Title', 'movedo-extension' );
			$columns['testimonial_thumbnail'] = esc_html__( 'Featured Image', 'movedo-extension' );
			$columns['author'] = esc_html__( 'Author', 'movedo-extension' );
			$columns['testimonial_category'] = esc_html__( 'Testimonial Categories', 'movedo-extension' );
			$columns['date'] = esc_html__( 'Date', 'movedo-extension' );
			return $columns;
		}

		function movedo_ext_testimonial_custom_columns( $column, $post_id ) {

			switch ( $column ) {
				case "testimonial_thumbnail":
					if ( has_post_thumbnail( $post_id ) ) {
						$thumbnail_id = get_post_thumbnail_id( $post_id );
						$attachment_src = wp_get_attachment_image_src( $thumbnail_id, array( 80, 80 ) );
						$thumb = $attachment_src[0];
					} else {
						$thumb = get_template_directory_uri() . '/includes/images/no-image.jpg';
					}
					echo '<img class="attachment-80x80" width="80" height="80" alt="testimonial image" src="' . esc_url( $thumb ) . '">';
					break;
				case 'testimonial_category':
					echo get_the_term_list( $post_id, 'testimonial_category', '', ', ','' );
				break;
			}
		}

	}
	new Movedo_Testimonial_Post_Type;
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
