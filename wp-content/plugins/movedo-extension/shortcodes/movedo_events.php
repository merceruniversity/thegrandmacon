<?php
/**
 * Events Shortcode
 */

if( !function_exists( 'movedo_ext_vce_events_shortcode' ) ) {

	function movedo_ext_vce_events_shortcode( $attr, $content ) {

		$event_row_start = $allow_filter = $class_fullwidth = $el_class = '';

		extract(
			shortcode_atts(
				array(
					'categories' => '',
					'exclude_posts' => '',
					'include_posts' => '',
					'columns_large_screen' => '3',
					'columns' => '3',
					'columns_tablet_landscape' => '2',
					'columns_tablet_portrait' => '2',
					'columns_mobile' => '1',
					'grid_image_mode' => 'landscape',
					'event_filter' => '',
					'filter_style' => 'simple',
					'filter_shape' => 'square',
					'filter_color' => 'primary-1',
					'event_filter_align' => 'left',
					'filter_order_by' => '',
					'filter_order' => 'ASC',
					'item_gutter' => 'yes',
					'gutter_size' => '30',
					'item_spinner' => 'no',
					'items_to_show' => '12',
					'event_title_heading_tag' => 'h3',
					'event_title_heading' => 'h3',
					'overlay_color' => 'light',
					'overlay_opacity' => '90',
					'order_by' => 'date',
					'order' => 'DESC',
					'disable_pagination' => '',
					'animation' => 'grve-zoom-in',
					'margin_bottom' => '',
					'el_class' => '',
				),
				$attr
			)
		);

		$event_classes = array( 'grve-element' );
		$data_string = '';

		$event_row_start = '<div class="grve-isotope-container">';

		$data_string = ' data-spinner="' . esc_attr( $item_spinner ) . '" data-columns="' . esc_attr( $columns ) . '" data-columns-large-screen="' . esc_attr( $columns_large_screen ) . '" data-columns-tablet-landscape="' . esc_attr( $columns_tablet_landscape ) . '" data-columns-tablet-portrait="' . esc_attr( $columns_tablet_portrait ) . '" data-columns-mobile="' . esc_attr( $columns_mobile ) . '" data-layout="fitRows"';
		if ( 'yes' == $item_gutter ) {
			$data_string .= ' data-gutter-size="' . esc_attr( $gutter_size ) . '"';
		}
		if ( 'yes' == $item_gutter ) {
			array_push( $event_classes, 'grve-with-gap' );
		}
		array_push( $event_classes, 'grve-event' );
		array_push( $event_classes, 'grve-event-grid' );
		array_push( $event_classes, 'grve-isotope' );

		$allow_filter = 'yes';

		$isotope_inner_item_classes = array( 'grve-event-item-inner', 'grve-isotope-item-inner', 'grve-hover-item' );

		if ( !empty( $animation ) ) {
			array_push( $isotope_inner_item_classes, $animation);
		}

		$isotope_inner_item_class_string = implode( ' ', $isotope_inner_item_classes );


		if ( !empty ( $el_class ) ) {
			array_push( $event_classes, $el_class);
		}
		$event_class_string = implode( ' ', $event_classes );

		$style = movedo_ext_vce_build_margin_bottom_style( $margin_bottom );

		$event_cat = "";
		$event_category_ids = array();

		if( ! empty( $categories ) ) {
			$event_category_ids = explode( ",", $categories );
			foreach ( $event_category_ids as $category_id ) {
				$category_term = get_term( $category_id, 'tribe_events_cat' );
				if ( isset( $category_term) ) {
					$event_cat = $event_cat.$category_term->slug . ', ';
				}
			}
		}

		$paged = 1;

		if ( 'yes' != $disable_pagination ) {
			if ( get_query_var( 'paged' ) ) {
				$paged = get_query_var( 'paged' );
			} elseif ( get_query_var( 'page' ) ) {
				$paged = get_query_var( 'page' );
			}
		}

		$exclude_ids = array();
		if( !empty( $exclude_posts ) ){
			$exclude_ids = explode( ',', $exclude_posts );
		}

		$include_ids = array();
		if( !empty( $include_posts ) ){
			$include_ids = explode( ',', $include_posts );
			$args = array(
				'post_type' => 'tribe_events',
				'post_status'=>'publish',
				'paged' => $paged,
				'post__in' => $include_ids,
				'posts_per_page' => $items_to_show,
				'orderby' => $order_by,
				'order' => $order,
			);
			$event_filter = 'no';
		} else {
			$args = array(
				'post_type' => 'tribe_events',
				'post_status'=>'publish',
				'paged' => $paged,
				'tribe_events_cat' => $event_cat,
				'post__not_in' => $exclude_ids,
				'posts_per_page' => $items_to_show,
				'orderby' => $order_by,
				'order' => $order,
			);
		}



		$query = new WP_Query( $args );
		ob_start();
		if ( $query->have_posts() ) :
		?>
			<div class="<?php echo esc_attr( $event_class_string ); ?>" style="<?php echo $style; ?>"<?php echo $data_string; ?>>
		<?php

		if ( 'yes' == $event_filter && 'yes' == $allow_filter ) {

			$filter_classes = array( 'grve-filter' );

			array_push( $filter_classes, 'grve-filter-style-' . $filter_style );
			array_push( $filter_classes, 'grve-align-' . $event_filter_align);
			array_push( $filter_classes, 'grve-link-text');

			if ( 'button' == $filter_style ) {
				array_push( $filter_classes, 'grve-link-text');
				array_push( $filter_classes, 'grve-filter-shape-' . $filter_shape );
				array_push( $filter_classes, 'grve-filter-color-' . $filter_color );
			}

			$filter_class_string = implode( ' ', $filter_classes );

			$category_prefix = '.tribe-events-category-';
			$category_filter_list = array();
			$category_filter_array = array();
			$all_string =  apply_filters( 'movedo_grve_vce_event_string_all_categories', esc_html__( 'All', 'movedo-extension' ) );
			$category_filter_string = '<li data-filter="*" class="selected"><span>' . esc_html( $all_string ) . '</span></li>';
			$category_filter_add = false;
			while ( $query->have_posts() ) : $query->the_post();

				if ( $event_categories = get_the_terms( get_the_ID(), 'tribe_events_cat' ) ) {

					foreach($event_categories as $category_term){
						$category_filter_add = false;
						if ( !in_array($category_term->term_id, $category_filter_list) ) {
							if( ! empty( $event_category_ids ) ) {
								if ( in_array($category_term->term_id, $event_category_ids) ) {
									$category_filter_add = true;
								}
							} else {
								$category_filter_add = true;
							}
							if ( $category_filter_add ) {
								$category_filter_list[] = $category_term->term_id;
								if ( 'title' == $filter_order_by ) {
									$category_filter_array[$category_term->name] = $category_term;
								} elseif ( 'slug' == $filter_order_by )  {
									$category_filter_array[$category_term->slug] = $category_term;
								} else {
									$category_filter_array[$category_term->term_id] = $category_term;
								}
							}
						}
					}
				}

			endwhile;


			if ( count( $category_filter_array ) > 1 ) {
				if ( '' != $filter_order_by ) {
					if ( 'ASC' == $filter_order ) {
						ksort( $category_filter_array );
					} else {
						krsort( $category_filter_array );
					}
				}
				foreach($category_filter_array as $category_filter){
					$term_class = sanitize_html_class( $category_filter->slug, $category_filter->term_id );
					if ( is_numeric( $term_class ) || ! trim( $term_class, '-' ) ) {
						$term_class = $category_filter->term_id;
					}
					$category_filter_string .= '<li data-filter="' . $category_prefix . $term_class . '"><span>' . $category_filter->name . '</span></li>';
				}
		?>
				<div class="<?php echo esc_attr( $filter_class_string ); ?>">
					<ul>
						<?php echo $category_filter_string; ?>
					</ul>
				</div>
		<?php
			}
		}
		?>

			<?php echo $event_row_start; ?>

		<?php

		$event_index = 0;

		while ( $query->have_posts() ) : $query->the_post();
			$image_size = 'movedo-grve-small-rect-horizontal';
			$event_index++;
			$event_extra_class = '';

			//Grid - Default
			$event_extra_class = 'grve-isotope-item grve-event-item';
			$image_size = movedo_ext_vce_get_image_size( $grid_image_mode );

?>
			<div id="grve-tribe-events-event-<?php the_ID(); ?><?php echo uniqid('-'); ?>" class="<?php tribe_events_event_classes(); ?> <?php echo esc_attr( $event_extra_class ); ?>">

				<div class="<?php echo esc_attr( $isotope_inner_item_class_string ); ?>">
					<div class="grve-image-hover">
						<div class="grve-media">
							<a class="grve-item-url" href="<?php echo esc_url( get_permalink() ); ?>"></a>
							<div class="grve-bg-<?php echo esc_attr( $overlay_color ); ?> grve-hover-overlay grve-opacity-<?php echo esc_attr( $overlay_opacity ); ?>"></div>
							<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail( $image_size );
								}
							?>
						</div>
						<div class="grve-event-content-wrapper">
							<div class="grve-event-content">
								<a href="<?php echo esc_url( tribe_get_event_link() ); ?>">
									<<?php echo tag_escape( $event_title_heading_tag ); ?> class="grve-title grve-<?php echo esc_attr( $event_title_heading ); ?>"><?php the_title(); ?></<?php echo tag_escape( $event_title_heading_tag ); ?>>
								</a>
								<div class="tribe-event-schedule-details">
									<?php echo tribe_events_event_schedule_details() ?>
								</div>
								<?php if ( tribe_get_cost() ) : ?>
									<div class="tribe-events-event-cost">
										<span><?php echo tribe_get_cost( null, true ); ?></span>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
<?php

		endwhile;
?>
				</div>
<?php
			if ( 'yes' != $disable_pagination ) {
				$total = $query->max_num_pages;
				$big = 999999999; // need an unlikely integer
				if( $total > 1 )  {
					 echo '<div class="grve-pagination grve-link-text grve-heading-color">';

					 if( get_option('permalink_structure') ) {
						 $format = 'page/%#%/';
					 } else {
						 $format = '&paged=%#%';
					 }
					 echo paginate_links(array(
						'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format'		=> $format,
						'current'		=> max( 1, $paged ),
						'total'			=> $total,
						'mid_size'		=> 2,
						'type'			=> 'list',
						'prev_text'	=> '<i class="grve-icon-nav-left-small"></i>',
						'next_text'	=> '<i class="grve-icon-nav-right-small"></i>',
						'add_args' => false,
					 ));
					 echo '</div>';
				}
			}
?>
			</div>

		<?php

		else :
		endif;
		wp_reset_postdata();

		return ob_get_clean();

	}
	add_shortcode( 'movedo_events', 'movedo_ext_vce_events_shortcode' );

}

/**
 * Add shortcode to Visual Composer
 */

if( !function_exists( 'movedo_ext_vce_events_shortcode_params' ) ) {
	function movedo_ext_vce_events_shortcode_params( $tag ) {
		return array(
			"name" => esc_html__( "Events", "movedo-extension" ),
			"description" => esc_html__( "Display event element in multiple styles", "movedo-extension" ),
			"base" => $tag,
			"class" => "",
			"icon"      => "icon-wpb-grve-event",
			"category" => esc_html__( "Content", "js_composer" ),
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Grid Image Size", "movedo-extension" ),
					"param_name" => "grid_image_mode",
					'value' => array(
						esc_html__( 'Square Small Crop', 'movedo-extension' ) => 'square',
						esc_html__( 'Landscape Small Crop', 'movedo-extension' ) => 'landscape',
						esc_html__( 'Landscape Medium Crop', 'movedo-extension' ) => 'landscape-medium',
						esc_html__( 'Portrait Small Crop', 'movedo-extension' ) => 'portrait',
						esc_html__( 'Portrait Medium Crop', 'movedo-extension' ) => 'portrait-medium',
						esc_html__( 'Resize ( Large )', 'movedo-extension' ) => 'large',
						esc_html__( 'Resize ( Medium Large )', 'movedo-extension' ) => 'medium_large',
						esc_html__( 'Resize ( Medium )', 'movedo-extension' ) => 'medium',
					),
					'std' => 'landscape',
					"description" => esc_html__( "Select your Grid Image Size.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Large Screen Columns", "movedo-extension" ),
					"param_name" => "columns_large_screen",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 3,
					"description" => esc_html__( "Select your Events Columns.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Columns", "movedo-extension" ),
					"param_name" => "columns",
					"value" => array( '2', '3', '4', '5' ),
					"std" => 3,
					"description" => esc_html__( "Select your Events Columns.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Landscape Columns", "movedo-extension" ),
					"param_name" => "columns_tablet_landscape",
					"value" => array( '2', '3', '4' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, landscape orientation.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Tablet Portrait Columns", "movedo-extension" ),
					"param_name" => "columns_tablet_portrait",
					"value" => array( '2', '3', '4' ),
					"std" => 2,
					"description" => esc_html__( "Select responsive column on tablet devices, portrait orientation.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Mobile Columns", "movedo-extension" ),
					"param_name" => "columns_mobile",
					"value" => array( '1', '2' ),
					"std" => 1,
					"description" => esc_html__( "Select responsive column on mobile devices.", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Gutter between images", "movedo-extension" ),
					"param_name" => "item_gutter",
					"value" => array(
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
						esc_html__( "No", "movedo-extension" ) => 'no',
					),
					"description" => esc_html__( "Add gutter among images.", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Gutter Size", "movedo-extension" ),
					"param_name" => "gutter_size",
					"value" => '30',
					"dependency" => array( 'element' => "item_gutter", 'value' => array( 'yes' ) ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Items to show", "movedo-extension" ),
					"param_name" => "items_to_show",
					"value" => '12',
					"description" => esc_html__( "Maximum event Items to Show", "movedo-extension" ),
				),
				movedo_ext_vce_add_order_by(),
				movedo_ext_vce_add_order(),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "CSS Animation", "movedo-extension"),
					"param_name" => "animation",
					"value" => array(
						esc_html__( "No", "movedo-extension" ) => '',
						esc_html__( "Fade In", "movedo-extension" ) => "grve-fade-in",
						esc_html__( "Fade In Up", "movedo-extension" ) => "grve-fade-in-up",
						esc_html__( "Fade In Down", "movedo-extension" ) => "grve-fade-in-down",
						esc_html__( "Fade In Left", "movedo-extension" ) => "grve-fade-in-left",
						esc_html__( "Fade In Right", "movedo-extension" ) => "grve-fade-in-right",
						esc_html__( "Zoom In", "movedo-extension" ) => "grve-zoom-in",
					),
					"description" => esc_html__("Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "movedo-extension" ),
					"std" => "grve-zoom-in",
				),
				movedo_ext_vce_add_margin_bottom(),
				movedo_ext_vce_add_el_class(),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Event Title Tag", "movedo-extension" ),
					"param_name" => "event_title_heading_tag",
					"value" => array(
						esc_html__( "h1", "movedo-extension" ) => 'h1',
						esc_html__( "h2", "movedo-extension" ) => 'h2',
						esc_html__( "h3", "movedo-extension" ) => 'h3',
						esc_html__( "h4", "movedo-extension" ) => 'h4',
						esc_html__( "h5", "movedo-extension" ) => 'h5',
						esc_html__( "h6", "movedo-extension" ) => 'h6',
						esc_html__( "div", "movedo-extension" ) => 'div',
					),
					"description" => esc_html__( "event Title Tag for SEO", "movedo-extension" ),
					"std" => 'h3',
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Event Title Size/Typography", "movedo-extension" ),
					"param_name" => "event_title_heading",
					"value" => array(
						esc_html__( "h1", "movedo-extension" ) => 'h1',
						esc_html__( "h2", "movedo-extension" ) => 'h2',
						esc_html__( "h3", "movedo-extension" ) => 'h3',
						esc_html__( "h4", "movedo-extension" ) => 'h4',
						esc_html__( "h5", "movedo-extension" ) => 'h5',
						esc_html__( "h6", "movedo-extension" ) => 'h6',
						esc_html__( "Leader Text", "movedo-extension" ) => 'leader-text',
						esc_html__( "Subtitle Text", "movedo-extension" ) => 'subtitle-text',
						esc_html__( "Small Text", "movedo-extension" ) => 'small-text',
						esc_html__( "Link Text", "movedo-extension" ) => 'link-text',
					),
					"description" => esc_html__( "event Title size and typography, defined in Theme Options - Typography Options", "movedo-extension" ),
					"std" => 'h3',
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Overlay Color", "movedo-extension" ),
					"param_name" => "overlay_color",
					"param_holder_class" => "grve-colored-dropdown",
					"value" => array(
						esc_html__( "Light", "movedo-extension" ) => 'light',
						esc_html__( "Dark", "movedo-extension" ) => 'dark',
						esc_html__( "Primary 1", "movedo-extension" ) => 'primary-1',
						esc_html__( "Primary 2", "movedo-extension" ) => 'primary-2',
						esc_html__( "Primary 3", "movedo-extension" ) => 'primary-3',
						esc_html__( "Primary 4", "movedo-extension" ) => 'primary-4',
						esc_html__( "Primary 5", "movedo-extension" ) => 'primary-5',
						esc_html__( "Primary 6", "movedo-extension" ) => 'primary-6',
					),
					"description" => esc_html__( "Choose the image color overlay.", "movedo-extension" ),
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Enable Loader", "movedo-extension" ),
					"param_name" => "item_spinner",
					"description" => esc_html__( "If selected, this will enable a graphic spinner before load.", "movedo-extension" ),
					"value" => array( esc_html__( "Enable Loader.", "movedo-extension" ) => 'yes' ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => 'checkbox',
					"heading" => esc_html__( "Disable Pagination", "movedo-extension" ),
					"param_name" => "disable_pagination",
					"description" => esc_html__( "If selected, pagination will not be shown.", "movedo-extension" ),
					"value" => array( esc_html__( "Disable Pagination.", "movedo-extension" ) => 'yes' ),
					"group" => esc_html__( "Extras", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Overlay Opacity", "movedo-extension" ),
					"param_name" => "overlay_opacity",
					"value" => array( '0', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100' ),
					"std" => 90,
					"description" => esc_html__( "Choose the opacity for the overlay.", "movedo-extension" ),
					"group" => esc_html__( "Titles & Hovers", "movedo-extension" ),
				),
				array(
					"type" => 'dropdown',
					"heading" => esc_html__( "Filter", "movedo-extension" ),
					"param_name" => "event_filter",
					"value" => array(
						esc_html__( "No", "movedo-extension" ) => '',
						esc_html__( "Yes", "movedo-extension" ) => 'yes',
					),
					"description" => esc_html__( "If selected, an isotope filter will be displayed.", "movedo-extension" ) . " " . esc_html__( "Enable event Filter ( Only for All or Multiple Categories )", "movedo-extension" ),
					"group" => esc_html__( "Filters", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Order By", "movedo-extension" ),
					"param_name" => "filter_order_by",
					"value" => array(
						esc_html__( "Default ( Unordered )", "movedo-extension" ) => '',
						esc_html__( "ID", "movedo-extension" ) => 'id',
						esc_html__( "Slug", "movedo-extension" ) => 'slug',
						esc_html__( "Title", "movedo-extension" ) => 'title',
					),
					"description" => '',
					"dependency" => array( 'element' => "event_filter", 'value' => array( 'yes' ) ),
					"group" => esc_html__( "Filters", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Order", "movedo-extension" ),
					"param_name" => "filter_order",
					"value" => array(
						esc_html__( "Ascending", "movedo-extension" ) => 'ASC',
						esc_html__( "Descending", "movedo-extension" ) => 'DESC',
					),
					"dependency" => array( 'element' => "event_filter", 'value' => array( 'yes' ) ),
					"description" => '',
					"group" => esc_html__( "Filters", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Style", "movedo-extension" ),
					"param_name" => "filter_style",
					"value" => array(
						esc_html__( "Simple", "movedo-extension" ) => 'simple',
						esc_html__( "Button", "movedo-extension" ) => 'button',
						esc_html__( "Classic", "movedo-extension" ) => 'classic',

					),
					"dependency" => array( 'element' => "event_filter", 'value' => array( 'yes' ) ),
					"group" => esc_html__( "Filters", "movedo-extension" ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Filter Alignment", "movedo-extension" ),
					"param_name" => "event_filter_align",
					"value" => array(
						esc_html__( "Left", "movedo-extension" ) => 'left',
						esc_html__( "Right", "movedo-extension" ) => 'right',
						esc_html__( "Center", "movedo-extension" ) => 'center',
					),
					"description" => '',
					"dependency" => array( 'element' => "event_filter", 'value' => array( 'yes' ) ),
					"group" => esc_html__( "Filters", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Exclude Posts", "movedo-extension" ),
					"param_name" => "exclude_posts",
					"value" => '',
					"description" => esc_html__( "Type the post ids you want to exclude separated by comma ( , ).", "movedo-extension" ),
					"group" => esc_html__( "Categories", "movedo-extension" ),
				),
				array(
					"type" => "movedo_ext_multi_checkbox",
					"heading" => __("Event Categories", "movedo-extension" ),
					"param_name" => "categories",
					"value" => movedo_ext_vce_get_event_categories(),
					"description" => esc_html__( "Select all or multiple categories.", "movedo-extension" ),
					"admin_label" => true,
					"group" => esc_html__( "Categories", "movedo-extension" ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Include Specific Posts", "movedo-extension" ),
					"param_name" => "include_posts",
					"value" => '',
					"description" => esc_html__( "Type the specific post ids you want to include separated by comma ( , ). Note: If you define specific post ids, Exclude Posts and Categories will have no effect.", "movedo-extension" ),
					"group" => esc_html__( "Categories", "movedo-extension" ),
				),
			),
		);
	}
}

if( function_exists( 'vc_lean_map' ) ) {
	vc_lean_map( 'movedo_events', 'movedo_ext_vce_events_shortcode_params' );
} else if( function_exists( 'vc_map' ) ) {
	$attributes = movedo_ext_vce_events_shortcode_params( 'movedo_events' );
	vc_map( $attributes );
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
