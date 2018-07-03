<?php
/*
*	Collection of functions for admin feature section
*
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/


/**
 * Get Feature Single Image with ajax
 */
function movedo_grve_get_image_media() {


	if( isset( $_POST['attachment_id'] ) ) {

		$media_id  = $_POST['attachment_id'];

		if( !empty( $media_id  ) ) {

			$image_item = array (
				'bg_image_id' => $media_id,
			);

			movedo_grve_print_admin_feature_image_item( $image_item, "new" );

		}
	}

	if( isset( $_POST['attachment_id'] ) ) { die(); }
}
add_action( 'wp_ajax_movedo_grve_get_image_media', 'movedo_grve_get_image_media' );


function movedo_grve_post_select_lookup() {
	global $wpdb;

	$result = array();
	$search = $wpdb->esc_like( $_REQUEST['q'] );

	$args = array(
		'posts_per_page' => -1,
		'post_status' => array( 'publish' ),
		'post_type' => 'post',
		'order' => 'ASC',
		'orderby' => 'title',
		'suppress_filters' => false,
		's' => $search,
	);

	$query = new WP_Query( $args );

	while ( $query->have_posts() ) : $query->the_post();
		$post_title = get_the_title();
		$id = get_the_ID();

		$result[] = array(
			'id' => $id,
			'title' => $post_title,
		);
	endwhile;

	wp_reset_postdata();

	echo json_encode($result);

	die();
}
add_action('wp_ajax_movedo_grve_post_select_lookup', 'movedo_grve_post_select_lookup');

function movedo_grve_get_post_titles() {
	$result = array();

	if (isset($_REQUEST['post_ids'])) {
		$post_ids = $_REQUEST['post_ids'];
		if (strpos($post_ids, ',') === false) {
			$post_ids = array( $post_ids );
		} else {
			$post_ids = explode(',', $post_ids);
		}
	} else {
		$post_ids = array();
	}

	if (is_array($post_ids) && ! empty($post_ids)) {

		$args = array(
			'posts_per_page' => -1,
			'post_status' => array('publish'),
			'post__in' => $post_ids,
			'post_type' => 'post',
		);

		$query = new WP_Query( $args );

		while ( $query->have_posts() ) : $query->the_post();
			$post_title = get_the_title();
			$id = get_the_ID();

			$result[] = array(
				'id' => $id,
				'title' => $post_title,
			);
		endwhile;

		wp_reset_postdata();
	}

	echo json_encode($result);

	die;
}
add_action('wp_ajax_movedo_grve_get_post_titles', 'movedo_grve_get_post_titles');

/**
 * Get Replaced Image with ajax
 */
function movedo_grve_get_replaced_image() {


	if( isset( $_POST['attachment_id'] ) ) {

		if ( isset( $_POST['attachment_mode'] ) && !empty( $_POST['attachment_mode'] ) ) {
			$mode = $_POST['attachment_mode'];
			switch( $mode ) {
				case 'image':
					$input_name = '_movedo_grve_single_item_bg_image_id';
				break;
				case 'custom-image':
					if ( isset( $_POST['field_name'] ) && !empty( $_POST['field_name'] ) ) {
						$input_name = $_POST['field_name'];
					}
				break;
				case 'full-slider':
				default:
					$input_name = '_movedo_grve_slider_item_bg_image_id[]';
				break;
			}
		} else {
			$input_name = '_movedo_grve_slider_item_bg_image_id[]';
		}

		$media_id  = $_POST['attachment_id'];
		$thumb_src = wp_get_attachment_image_src( $media_id, 'thumbnail' );
		$thumbnail_url = $thumb_src[0];
		$alt = get_post_meta( $media_id, '_wp_attachment_image_alt', true );
?>
		<input type="hidden" class="grve-upload-media-id" value="<?php echo esc_attr( $media_id ); ?>" name="<?php echo esc_attr( $input_name ); ?>">
		<?php echo '<img class="grve-thumb" src="' . esc_url( $thumbnail_url ) . '" alt="' . esc_attr( $alt ) . '" width="120" height="120"/>'; ?>
		<a class="grve-upload-remove-image grve-item-new" href="#"></a>
<?php

	}

	if( isset( $_POST['attachment_id'] ) ) { die(); }
}
add_action( 'wp_ajax_movedo_grve_get_replaced_image', 'movedo_grve_get_replaced_image' );

/**
 * Get Single Feature Slider Media with ajax
 */
function movedo_grve_get_admin_feature_slider_media() {


	if( isset( $_POST['attachment_ids'] ) ) {

		$attachment_ids = $_POST['attachment_ids'];

		if( !empty( $attachment_ids ) ) {

			$media_ids = explode(",", $attachment_ids);

			foreach ( $media_ids as $media_id ) {
				$slider_item = array (
					'bg_image_id' => $media_id,
				);

				movedo_grve_print_admin_feature_slider_item( $slider_item, "new" );
			}
		}
	}

	if( isset( $_POST['post_ids'] ) ) {

		$post_ids = $_POST['post_ids'];
		if( !empty( $post_ids ) ) {

			$all_post_ids = explode(",", $post_ids);

			foreach ( $all_post_ids as $post_id ) {
				$slider_item = array (
					'type' => 'post',
					'post_id' => $post_id,
				);
				movedo_grve_print_admin_feature_slider_item( $slider_item, "new" );
			}
		} else {
			$slider_item = array (
				'type' => 'post',
				'post_id' => '0',
			);
			movedo_grve_print_admin_feature_slider_item( $slider_item, "new" );
		}
	}

	if( isset( $_POST['attachment_ids'] ) || isset( $_POST['post_ids'] )  ) { die(); }
}
add_action( 'wp_ajax_movedo_grve_get_admin_feature_slider_media', 'movedo_grve_get_admin_feature_slider_media' );

/**
 * Get Single Feature Map Point with ajax
 */
function movedo_grve_get_map_point() {
	if( isset( $_POST['map_mode'] ) ) {
		$mode = $_POST['map_mode'];
		movedo_grve_print_admin_feature_map_point( array(), $mode );
	}
	if( isset( $_POST['map_mode'] ) ) { die(); }
}
add_action( 'wp_ajax_movedo_grve_get_map_point', 'movedo_grve_get_map_point' );

/**
 * Prints Feature Map Points
 */
function movedo_grve_print_admin_feature_map_items( $map_items ) {

	if( !empty($map_items) ) {
		foreach ( $map_items as $map_item ) {
			movedo_grve_print_admin_feature_map_point( $map_item );
		}
	}

}

/**
 * Prints Feature Single Map Point
 */
function movedo_grve_print_admin_feature_map_point( $map_item, $mode = '' ) {


	$map_item_id = uniqid('_movedo_grve_map_point_');
	$map_uniqid = uniqid('-');
	$map_id = movedo_grve_array_value( $map_item, 'id', $map_item_id );

	$map_lat = movedo_grve_array_value( $map_item, 'lat', '51.516221' );
	$map_lng = movedo_grve_array_value( $map_item, 'lng', '-0.136986' );
	$map_marker = movedo_grve_array_value( $map_item, 'marker' );

	$map_title = movedo_grve_array_value( $map_item, 'title' );
	$map_infotext = movedo_grve_array_value( $map_item, 'info_text','' );
	$map_infotext_open = movedo_grve_array_value( $map_item, 'info_text_open','no' );

	$button_text = movedo_grve_array_value( $map_item, 'button_text' );
	$button_url = movedo_grve_array_value( $map_item, 'button_url' );
	$button_target = movedo_grve_array_value( $map_item, 'button_target', '_self' );
	$button_class = movedo_grve_array_value( $map_item, 'button_class' );
	$movedo_grve_closed_class = 'closed';
	$movedo_grve_item_new = '';
	if( "new" == $mode ) {
		$movedo_grve_item_new = " grve-item-new";
		$movedo_grve_closed_class = "grve-item-new";
	}
?>
	<div class="grve-map-item postbox <?php echo esc_attr( $movedo_grve_closed_class ); ?>">
		<button class="handlediv button-link" type="button">
			<span class="screen-reader-text"><?php esc_attr_e( 'Toggle panel: Feature Section Map Point', 'movedo' ); ?></span>
			<span class="toggle-indicator"></span>
		</button>
		<input class="grve-map-item-delete-button button<?php echo esc_attr( $movedo_grve_item_new ); ?>" type="button" value="<?php esc_attr_e( 'Delete', 'movedo' ); ?>" />
		<span class="grve-button-spacer">&nbsp;</span>
		<span class="grve-modal-spinner"></span>
		<h3 class="grve-title">
			<span><?php esc_html_e( 'Map Point', 'movedo' ); ?>: </span><span id="<?php echo esc_attr( $map_id ); ?>_title_admin_label"><?php if ( !empty ($map_title) ) { echo esc_html( $map_title ); } ?></span>
		</h3>
		<div class="inside">

			<!--  METABOXES -->
			<div class="grve-metabox-content">

				<!-- TABS -->
				<div class="grve-tabs<?php echo esc_attr( $movedo_grve_item_new ); ?>">

					<ul class="grve-tab-links">
						<li class="active"><a href="#grve-feature-single-map-tab-marker<?php echo esc_attr( $map_uniqid ); ?>"><?php esc_html_e( 'Marker', 'movedo' ); ?></a></li>
						<li><a href="#grve-feature-single-map-tab-infobox<?php echo esc_attr( $map_uniqid ); ?>"><?php esc_html_e( 'Info Box', 'movedo' ); ?></a></li>
						<li><a href="#grve-feature-single-map-tab-button<?php echo esc_attr( $map_uniqid ); ?>"><?php esc_html_e( 'Link', 'movedo' ); ?></a></li>
					</ul>

					<div class="grve-tab-content">

						<div id="grve-feature-single-map-tab-marker<?php echo esc_attr( $map_uniqid ); ?>" class="grve-tab-item active">
							<input type="hidden" name="_movedo_grve_map_item_point_id[]" value="<?php echo esc_attr( $map_id ); ?>"/>

							<div class="grve-fields-wrapper">
								<div class="grve-label">
									<label for="grve-page-feature-element">
										<span class="grve-title"><?php esc_html_e( 'Marker', 'movedo' ); ?></span>
									</label>
								</div>
								<div class="grve-field-items-wrapper">
									<div class="grve-field-item grve-field-item-fullwidth">
										<input type="text" name="_movedo_grve_map_item_point_marker[]" class="grve-upload-simple-media-field" value="<?php echo esc_attr( $map_marker ); ?>"/>
										<label></label>
										<input type="button" data-media-type="image" class="grve-upload-simple-media-button button-primary<?php echo esc_attr( $movedo_grve_item_new ); ?>" value="<?php esc_attr_e( 'Insert Marker', 'movedo' ); ?>"/>
										<input type="button" class="grve-remove-simple-media-button button<?php echo esc_attr( $movedo_grve_item_new ); ?>" value="<?php esc_attr_e( 'Remove', 'movedo' ); ?>"/>
									</div>
								</div>
							</div>
							<?php
								movedo_grve_print_admin_option(
									array(
										'type' => 'textfield',
										'name' => '_movedo_grve_map_item_point_lat[]',
										'value' => $map_lat,
										'label' => array(
											"title" => esc_html__( 'Latitude', 'movedo' ),
										),
									)
								);
								movedo_grve_print_admin_option(
									array(
										'type' => 'textfield',
										'name' => '_movedo_grve_map_item_point_lng[]',
										'value' => $map_lng,
										'label' => array(
											"title" => esc_html__( 'Longitude', 'movedo' ),
										),
									)
								);
							?>

						</div>
						<div id="grve-feature-single-map-tab-infobox<?php echo esc_attr( $map_uniqid ); ?>" class="grve-tab-item">
							<?php
								movedo_grve_print_admin_option(
									array(
										'type' => 'label',
										'label' => array(
											"title" => esc_html__( 'Title / Info Text', 'movedo' ),
										),
									)
								);
								movedo_grve_print_admin_option(
									array(
										'type' => 'textfield',
										'name' => '_movedo_grve_map_item_point_title[]',
										'value' => $map_title,
										'label' => array(
											"title" => esc_html__( 'Title', 'movedo' ),
										),
										'id' => $map_id . '_title',
										'extra_class' => 'grve-admin-label-update',
									)
								);
								movedo_grve_print_admin_option(
									array(
										'type' => 'textarea',
										'name' => '_movedo_grve_map_item_point_infotext[]',
										'value' => $map_infotext,
										'label' => array(
											"title" => esc_html__( 'Info Text', 'movedo' ),
										),
										'width' => 'fullwidth',
										'rows' => 2,
									)
								);
								movedo_grve_print_admin_option(
									array(
										'type' => 'select-boolean',
										'name' => '_movedo_grve_map_item_point_infotext_open[]',
										'value' => $map_infotext_open,
										'label' => esc_html__( 'Open Info Text Onload', 'movedo' ),
									)
								);
							?>
						</div>
						<div id="grve-feature-single-map-tab-button<?php echo esc_attr( $map_uniqid ); ?>" class="grve-tab-item">
							<?php
								movedo_grve_print_admin_option(
									array(
										'type' => 'label',
										'label' => array(
											"title" => esc_html__( 'Link', 'movedo' ),
										),
									)
								);
								movedo_grve_print_admin_option(
									array(
										'type' => 'textfield',
										'name' => '_movedo_grve_map_item_point_button_text[]',
										'value' => $button_text,
										'label' => array(
											"title" => esc_html__( 'Link Text', 'movedo' ),
										),
									)
								);
								movedo_grve_print_admin_option(
									array(
										'type' => 'textfield',
										'name' => '_movedo_grve_map_item_point_button_url[]',
										'value' => $button_url,
										'label' => array(
											"title" => esc_html__( 'Link URL', 'movedo' ),
										),
										'width' => 'fullwidth',
									)
								);

								movedo_grve_print_admin_option(
									array(
										'type' => 'select-button-target',
										'name' => '_movedo_grve_map_item_point_button_target[]',
										'value' => $button_target,
										'label' => array(
											"title" => esc_html__( 'Link Target', 'movedo' ),
										),
									)
								);

								movedo_grve_print_admin_option(
									array(
										'type' => 'textfield',
										'name' => '_movedo_grve_map_item_point_button_class[]',
										'value' => $button_class,
										'label' => array(
											"title" => esc_html__( 'Link Class', 'movedo' ),
										),
									)
								);
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
}

/**
 * Prints Section Slider items
 */
function movedo_grve_print_admin_feature_slider_items( $slider_items ) {

	foreach ( $slider_items as $slider_item ) {
		movedo_grve_print_admin_feature_slider_item( $slider_item, '' );
	}

}

/**
* Prints Single Feature Slider Item
*/
function movedo_grve_print_admin_feature_slider_item( $slider_item, $new = "" ) {

	$slide_id = movedo_grve_array_value( $slider_item, 'id', uniqid() );
	$slider_item['id'] = $slide_id;
	$slide_type = movedo_grve_array_value( $slider_item, 'type' );
	$slide_post_id = movedo_grve_array_value( $slider_item, 'post_id' );

	$bg_image_id = movedo_grve_array_value( $slider_item, 'bg_image_id' );
	$bg_image_size = movedo_grve_array_value( $slider_item, 'bg_image_size' );
	$bg_position = movedo_grve_array_value( $slider_item, 'bg_position', 'center-center' );
	$bg_tablet_sm_position = movedo_grve_array_value( $slider_item, 'bg_tablet_sm_position' );


	$header_style = movedo_grve_array_value( $slider_item, 'header_style', 'default' );
	$title = movedo_grve_array_value( $slider_item, 'title' );

	$slider_item_button = movedo_grve_array_value( $slider_item, 'button' );
	$slider_item_button2 = movedo_grve_array_value( $slider_item, 'button2' );

	$movedo_grve_button_class = "grve-feature-slider-item-delete-button";
	$movedo_grve_replace_image_class = "grve-upload-replace-image";
	$movedo_grve_open_modal_class = "grve-open-slider-modal";
	$movedo_grve_closed_class = 'closed';
	$movedo_grve_new_class = '';

	if( "new" == $new ) {
		$movedo_grve_button_class = "grve-feature-slider-item-delete-button grve-item-new";
		$movedo_grve_replace_image_class = "grve-upload-replace-image grve-item-new";
		$movedo_grve_open_modal_class = "grve-open-slider-modal grve-item-new";
		$movedo_grve_closed_class = 'grve-item-new';
		$movedo_grve_new_class = ' grve-item-new';
	}

	$slide_uniqid = '-' . $slide_id;

	$slide_type_string = esc_html__( 'Slide', 'movedo' );
	if ( 'post' == $slide_type ) {
		$slide_type_string = esc_html__( 'Post Slide', 'movedo' );
		if( !empty( $slide_post_id ) ) {
			$title = get_the_title ( $slide_post_id  );
		}
	}

?>

	<div class="grve-slider-item postbox <?php echo esc_attr( $movedo_grve_closed_class ); ?>">
		<button class="handlediv button-link" type="button">
			<span class="screen-reader-text"><?php esc_attr_e( 'Toggle panel: Feature Section Slide', 'movedo' ); ?></span>
			<span class="toggle-indicator"></span>
		</button>
		<input class="<?php echo esc_attr( $movedo_grve_button_class ); ?> button" type="button" value="<?php esc_attr_e( 'Delete', 'movedo' ); ?>">
		<span class="grve-button-spacer">&nbsp;</span>
		<span class="grve-modal-spinner"></span>
		<h3 class="hndle grve-title">
			<span><?php echo esc_html( $slide_type_string ); ?>: </span><span id="_movedo_grve_slider_item_title<?php echo esc_attr( $slide_id ); ?>_admin_label"><?php if ( !empty ($title) ) { echo esc_html( $title ); } ?></span>
		</h3>
		<div class="inside">
			<!--  METABOXES -->
			<div class="grve-metabox-content">

				<!-- TABS -->
				<div class="grve-tabs<?php echo esc_attr( $movedo_grve_new_class ); ?>">

					<ul class="grve-tab-links">
						<li class="active"><a href="#grve-feature-single-tab-bg<?php echo esc_attr( $slide_uniqid ); ?>"><?php esc_html_e( 'Background / Header', 'movedo' ); ?></a></li>
						<li><a href="#grve-feature-single-tab-content<?php echo esc_attr( $slide_uniqid ); ?>"><?php esc_html_e( 'Content', 'movedo' ); ?></a></li>
						<?php if ( 'post' != $slide_type ) { ?>
						<li><a href="#grve-feature-single-tab-button<?php echo esc_attr( $slide_uniqid ); ?>"><?php esc_html_e( 'First Button', 'movedo' ); ?></a></li>
						<li><a href="#grve-feature-single-tab-button2<?php echo esc_attr( $slide_uniqid ); ?>"><?php esc_html_e( 'Second Button', 'movedo' ); ?></a></li>
						<?php } ?>
						<li><a href="#grve-feature-single-tab-extra<?php echo esc_attr( $slide_uniqid ); ?>"><?php esc_html_e( 'Extra', 'movedo' ); ?></a></li>
					</ul>

					<div class="grve-tab-content">

						<div id="grve-feature-single-tab-bg<?php echo esc_attr( $slide_uniqid ); ?>" class="grve-tab-item active">
							<?php

								movedo_grve_print_admin_option(
									array(
										'type' => 'hidden',
										'name' => '_movedo_grve_slider_item_id[]',
										'value' => $slide_id,
									)
								);

								movedo_grve_print_admin_option(
									array(
										'type' => 'hidden',
										'name' => '_movedo_grve_slider_item_type[]',
										'value' => $slide_type,
									)
								);
								if ( 'post' == $slide_type ) {
									movedo_grve_print_admin_option(
										array(
											'type' => 'hiddenfield',
											'name' => '_movedo_grve_slider_item_post_id[]',
											'value' => $slide_post_id,
											'label' => array(
												"title" => esc_html__( 'Post ID', 'movedo' ),
												"desc" => esc_html__( 'Background Image can be still used instead of the Feature Image', 'movedo' ),
											),
										)
									);
								} else {
									movedo_grve_print_admin_option(
										array(
											'type' => 'hidden',
											'name' => '_movedo_grve_slider_item_post_id[]',
											'value' => $slide_post_id,
										)
									);
								}

								movedo_grve_print_admin_option(
									array(
										'type' => 'select-image',
										'name' => '_movedo_grve_slider_item_bg_image_id[]',
										'value' => $bg_image_id,
										'label' => array(
											"title" => esc_html__( 'Background Image', 'movedo' ),
										),
										'width' => 'fullwidth',
									)
								);
								movedo_grve_print_admin_option(
									array(
										'type' => 'select',
										'name' => '_movedo_grve_slider_item_bg_image_size[]',
										'value' => $bg_image_size,
										'options' => array(
											'' => esc_html__( '--Inherit--', 'movedo' ),
											'responsive' => esc_html__( 'Responsive', 'movedo' ),
											'extra-extra-large' => esc_html__( 'Extra Extra Large', 'movedo' ),
											'full' => esc_html__( 'Full', 'movedo' ),
										),
										'label' => array(
											"title" => esc_html__( 'Background Image Size', 'movedo' ),
											"desc" => esc_html__( 'Inherit : Theme Options - Media Sizes.', 'movedo' ),
										),
									)
								);
								movedo_grve_print_admin_option(
									array(
										'type' => 'label',
										'label' => array(
											"title" => esc_html__( 'Header / Background Position', 'movedo' ),
										),
									)
								);
								movedo_grve_print_admin_option(
									array(
										'type' => 'select-bg-position',
										'name' => '_movedo_grve_slider_item_bg_position[]',
										'value' => $bg_position,
										'label' => array(
											"title" => esc_html__( 'Background Position', 'movedo' ),
										),
									)
								);
								movedo_grve_print_admin_option(
									array(
										'type' => 'select-bg-position-inherit',
										'name' => '_movedo_grve_slider_item_bg_tablet_sm_position[]',
										'value' => $bg_tablet_sm_position,
										'label' => array(
											"title" => esc_html__( 'Background Position ( Tablet Portrait )', 'movedo' ),
											"desc" => esc_html__( 'Tablet devices with portrait orientation and below.', 'movedo' ),
										),
									)
								);
								movedo_grve_print_admin_option(
									array(
										'type' => 'select-header-style',
										'name' => '_movedo_grve_slider_item_header_style[]',
										'value' => $header_style,
										'label' => array(
											"title" => esc_html__( 'Header Style', 'movedo' ),
										),
									)
								);

								movedo_grve_print_admin_feature_item_overlay_options( $slider_item, '_movedo_grve_slider_item_', 'multi' );
							?>
						</div>
						<div id="grve-feature-single-tab-content<?php echo esc_attr( $slide_uniqid ); ?>" class="grve-tab-item">
							<?php movedo_grve_print_admin_feature_item_content_options( $slider_item, '_movedo_grve_slider_item_', 'multi' ); ?>
						</div>
						<div id="grve-feature-single-tab-button<?php echo esc_attr( $slide_uniqid ); ?>" class="grve-tab-item">
							<?php movedo_grve_print_admin_feature_item_button_options( $slider_item_button, '_movedo_grve_slider_item_button_', 'multi' ); ?>
						</div>
						<div id="grve-feature-single-tab-button2<?php echo esc_attr( $slide_uniqid ); ?>" class="grve-tab-item">
							<?php movedo_grve_print_admin_feature_item_button_options( $slider_item_button2, '_movedo_grve_slider_item_button2_', 'multi' ); ?>
						</div>
						<div id="grve-feature-single-tab-extra<?php echo esc_attr( $slide_uniqid ); ?>" class="grve-tab-item">
							<?php movedo_grve_print_admin_feature_item_extra_options( $slider_item, '_movedo_grve_slider_item_', 'multi' ); ?>
						</div>
					</div>

				</div>
				<!-- END TABS -->

			</div>
			<!-- END  METABOXES -->
		</div>

	</div>
<?php

}

/**
* Get Revolution Sliders
*/
function movedo_grve_get_revolution_selection() {

	$revsliders = array(
		"" => esc_html__( "None", 'movedo' ),
	);

	if ( class_exists( 'RevSlider' ) ) {
		$slider = new RevSlider();
		$arrSliders = $slider->getArrSliders();

		if ( $arrSliders ) {
			foreach ( $arrSliders as $slider ) {
				$revsliders[ $slider->getAlias() ] = $slider->getTitle();
			}
		}
	}

	return $revsliders;
}

/**
* Prints Item Button Options
*/
function movedo_grve_print_admin_feature_item_button_options( $item, $prefix = '_movedo_grve_single_item_button_', $mode = '' ) {


	$button_id = movedo_grve_array_value( $item, 'id', uniqid() );
	$group_id = $prefix . $button_id;

	$button_text = movedo_grve_array_value( $item, 'text' );
	$button_url = movedo_grve_array_value( $item, 'url' );
	$button_type = movedo_grve_array_value( $item, 'type', '' );
	$button_size = movedo_grve_array_value( $item, 'size', 'medium' );
	$button_color = movedo_grve_array_value( $item, 'color', 'primary-1' );
	$button_hover_color = movedo_grve_array_value( $item, 'hover_color', 'black' );
	$button_gradient_color_1 = movedo_grve_array_value( $item, 'gradient_1_color', 'primary-1' );
	$button_gradient_color_2 = movedo_grve_array_value( $item, 'gradient_2_color', 'primary-2' );
	$button_color = movedo_grve_array_value( $item, 'color', 'primary-1' );
	$button_shape = movedo_grve_array_value( $item, 'shape', 'square' );
	$button_shadow = movedo_grve_array_value( $item, 'shadow' );
	$button_target = movedo_grve_array_value( $item, 'target', '_self' );
	$button_class = movedo_grve_array_value( $item, 'class' );

	$sufix  = '';
	if ( 'multi' == $mode ) {
		$sufix = '[]';
	};
	echo '<div id="' . esc_attr( $group_id ) . '">';


	movedo_grve_print_admin_option(
		array(
			'type' => 'hidden',
			'name' => $prefix . 'id' . $sufix,
			'value' => $button_id,
		)
	);

	movedo_grve_print_admin_option(
		array(
			'type' => 'textfield',
			'name' => $prefix . 'text' . $sufix,
			'id' => $prefix . 'text' . '_' . $button_id,
			'value' => $button_text,
			'label' => esc_html__( 'Button Text', 'movedo' ),
		)
	);
	movedo_grve_print_admin_option(
		array(
			'type' => 'textfield',
			'name' => $prefix . 'url' . $sufix,
			'id' => $prefix . 'url' . '_' . $button_id,
			'value' => $button_url,
			'label' => esc_html__( 'Button URL', 'movedo' ),
			'width' => 'fullwidth',
		)
	);
	movedo_grve_print_admin_option(
		array(
			'type' => 'select-button-target',
			'name' => $prefix . 'target' . $sufix,
			'id' => $prefix . 'target' . '_' . $button_id,
			'value' => $button_target,
			'label' => esc_html__( 'Button Target', 'movedo' ),
		)
	);

	movedo_grve_print_admin_option(
		array(
			'type' => 'select',
			'name' => $prefix . 'type' . $sufix,
			'id' => $prefix . 'type' . '_' . $button_id,
			'options' => array(
				'simple' => esc_html__( 'Simple', 'movedo' ),
				'outline' => esc_html__( 'Outline', 'movedo' ),
				'gradient' => esc_html__( 'Gradient', 'movedo' ),
			),
			'value' => $button_type,
			'group_id' => $group_id,
			'label' => esc_html__( 'Button Type', 'movedo' ),
		)
	);

	movedo_grve_print_admin_option(
		array(
			'type' => 'select-button-color',
			'name' => $prefix . 'color' . $sufix,
			'id' => $prefix . 'color' . '_' . $button_id,
			'value' => $button_color,
			'group_id' => $group_id,
			'label' => esc_html__( 'Button Color', 'movedo' ),
			'dependency' =>
			'[
				{ "id" : "' . $prefix . 'type' . '_' . $button_id . '", "values" : ["simple","outline"] }
			]',
		)
	);
	movedo_grve_print_admin_option(
		array(
			'type' => 'select-button-color',
			'name' => $prefix . 'gradient_1_color' . $sufix,
			'id' => $prefix . 'gradient_1_color' . '_' . $button_id,
			'value' => $button_gradient_color_1,
			'group_id' => $group_id,
			'label' => esc_html__( 'Button Gradient 1 Color', 'movedo' ),
			'dependency' =>
			'[
				{ "id" : "' . $prefix . 'type' . '_' . $button_id . '", "values" : ["gradient"] }
			]',
		)
	);
	movedo_grve_print_admin_option(
		array(
			'type' => 'select-button-color',
			'name' => $prefix . 'gradient_2_color' . $sufix,
			'id' => $prefix . 'gradient_2_color' . '_' . $button_id,
			'value' => $button_gradient_color_2,
			'group_id' => $group_id,
			'label' => esc_html__( 'Button Gradient 2 Color', 'movedo' ),
			'dependency' =>
			'[
				{ "id" : "' . $prefix . 'type' . '_' . $button_id . '", "values" : ["gradient"] }
			]',
		)
	);
	movedo_grve_print_admin_option(
		array(
			'type' => 'select-button-color',
			'name' => $prefix . 'hover_color' . $sufix,
			'id' => $prefix . 'hover_color' . '_' . $button_id,
			'value' => $button_hover_color,
			'group_id' => $group_id,
			'label' => esc_html__( 'Button Hover Color', 'movedo' ),
			'dependency' =>
			'[
				{ "id" : "' . $prefix . 'type' . '_' . $button_id . '", "values" : ["simple","outline","gradient"] }
			]',
		)
	);
	movedo_grve_print_admin_option(
		array(
			'type' => 'select-button-size',
			'name' => $prefix . 'size' . $sufix,
			'value' => $button_size,
			'label' => esc_html__( 'Button Size', 'movedo' ),
		)
	);

	movedo_grve_print_admin_option(
		array(
			'type' => 'select-button-shape',
			'name' => $prefix . 'shape' . $sufix,
			'value' => $button_shape,
			'label' => esc_html__( 'Button Shape', 'movedo' ),
		)
	);

	movedo_grve_print_admin_option(
		array(
			'type' => 'select',
			'name' => $prefix . 'shadow' . $sufix,
			'value' => $button_shadow,
			'options' => array(
				'' => esc_html__( 'None', 'movedo' ),
				'small' => esc_html__( 'Small', 'movedo' ),
				'medium' => esc_html__( 'Medium', 'movedo' ),
				'large' => esc_html__( 'Large', 'movedo' ),
			),
			'label' => esc_html__( 'Button Shadow', 'movedo' ),
		)
	);

	movedo_grve_print_admin_option(
		array(
			'type' => 'textfield',
			'name' => $prefix . 'class' . $sufix,
			'id' => $prefix . 'class' . '_' . $button_id,
			'value' => $button_class,
			'label' => esc_html__( 'Button Class', 'movedo' ),
		)
	);

	echo '</div>';

}


/**
* Prints Item Overlay Options
*/
function movedo_grve_print_admin_feature_item_overlay_options( $item, $prefix = '_movedo_grve_single_item_', $mode = '' ) {

	$overlay_id = movedo_grve_array_value( $item, 'id', uniqid() );
	$group_id = $prefix . 'overlay_container' . $overlay_id;

	$pattern_overlay = movedo_grve_array_value( $item, 'pattern_overlay' );
	$color_overlay = movedo_grve_array_value( $item, 'color_overlay', 'dark' );
	$color_overlay_custom  = movedo_grve_array_value( $item, 'color_overlay_custom', '#000000' );
	$opacity_overlay = movedo_grve_array_value( $item, 'opacity_overlay', '0' );
	$gradient_overlay_custom_1 = movedo_grve_array_value( $item, 'gradient_overlay_custom_1', '#034e90' );
	$gradient_overlay_custom_1_opacity = movedo_grve_array_value( $item, 'gradient_overlay_custom_1_opacity', '0.90' );
	$gradient_overlay_custom_2 = movedo_grve_array_value( $item, 'gradient_overlay_custom_2', '#19b4d7' );
	$gradient_overlay_custom_2_opacity = movedo_grve_array_value( $item, 'gradient_overlay_custom_2_opacity', '0.90' );
	$gradient_overlay_direction  = movedo_grve_array_value( $item, 'gradient_overlay_direction', '90' );

	$sufix  = '';
	if ( 'multi' == $mode ) {
		$sufix = '[]';
	};

	echo '<div id="' . esc_attr( $group_id ) . '">';

	movedo_grve_print_admin_option(
		array(
			'type' => 'select-pattern-overlay',
			'name' => $prefix . 'pattern_overlay' . $sufix,
			'value' => $pattern_overlay,
			'label' => esc_html__( 'Pattern Overlay', 'movedo' ),
		)
	);
	movedo_grve_print_admin_option(
		array(
			'type' => 'select-colorpicker',
			'name' => $prefix . 'color_overlay' . $sufix,
			'id' => $prefix . 'color_overlay' . $overlay_id,
			'value' => $color_overlay,
			'value2' => $color_overlay_custom,
			'label' => esc_html__( 'Color Overlay', 'movedo' ),
			'multiple' => 'multi',
			'type_usage' => 'feature-bg',
			'group_id' => $group_id ,
		)
	);
	movedo_grve_print_admin_option(
		array(
			'type' => 'select-opacity',
			'name' => $prefix . 'opacity_overlay' . $sufix,
			'value' => $opacity_overlay,
			'label' => esc_html__( 'Opacity Overlay', 'movedo' ),
			'dependency' =>
			'[
				{ "id" : "' . $prefix . 'color_overlay' . $overlay_id . '", "value_not_equal_to" : ["gradient"] }
			]',
		)
	);
	movedo_grve_print_admin_option(
		array(
			'type' => 'colorpicker',
			'name' => $prefix . 'gradient_overlay_custom_1' . $sufix,
			'value' => $gradient_overlay_custom_1,
			'label' => esc_html__( 'Custom Color 1', 'movedo' ),
			'dependency' =>
			'[
				{ "id" : "' . $prefix . 'color_overlay' . $overlay_id . '", "values" : ["gradient"] }
			]',
		)
	);
	movedo_grve_print_admin_option(
		array(
			'type' => 'select-opacity',
			'name' => $prefix . 'gradient_overlay_custom_1_opacity' . $sufix,
			'value' => $gradient_overlay_custom_1_opacity,
			'label' => esc_html__( 'Custom Color 1 Opacity', 'movedo' ),
			'dependency' =>
			'[
				{ "id" : "' . $prefix . 'color_overlay' . $overlay_id . '", "values" : ["gradient"] }
			]',
		)
	);
	movedo_grve_print_admin_option(
		array(
			'type' => 'colorpicker',
			'name' => $prefix . 'gradient_overlay_custom_2' . $sufix,
			'value' => $gradient_overlay_custom_2,
			'label' => esc_html__( 'Custom Color 2', 'movedo' ),
			'dependency' =>
			'[
				{ "id" : "' . $prefix . 'color_overlay' . $overlay_id . '", "values" : ["gradient"] }
			]',
		)
	);
	movedo_grve_print_admin_option(
		array(
			'type' => 'select-opacity',
			'name' => $prefix . 'gradient_overlay_custom_2_opacity' . $sufix,
			'value' => $gradient_overlay_custom_2_opacity,
			'label' => esc_html__( 'Custom Color 2 Opacity', 'movedo' ),
			'dependency' =>
			'[
				{ "id" : "' . $prefix . 'color_overlay' . $overlay_id . '", "values" : ["gradient"] }
			]',
		)
	);
	movedo_grve_print_admin_option(
		array(
			'type' => 'select',
			'name' => $prefix . 'gradient_overlay_direction' . $sufix,
			'value' => $gradient_overlay_direction,
			'options' => array(
				'90' => esc_html__( "Left to Right", 'movedo' ),
				'135' => esc_html__( "Left Top to Right Bottom", 'movedo' ),
				'45' => esc_html__( "Left Bottom to Right Top", 'movedo' ),
				'180' => esc_html__( "Bottom to Top", 'movedo' ),
			),
			'label' => array(
				"title" => esc_html__( 'Gradient Direction', 'movedo' ),
			),
			'dependency' =>
			'[
				{ "id" : "' . $prefix . 'color_overlay' . $overlay_id . '", "values" : ["gradient"] }
			]',
		)
	);

	echo '</div>';

}

/**
* Prints Item Content Options
*/
function movedo_grve_print_admin_feature_item_content_options( $item, $prefix = '_movedo_grve_single_item_', $mode = '' ) {

	$item_id = movedo_grve_array_value( $item, 'id' );
	$title = movedo_grve_array_value( $item, 'title' );
	$content_bg_color = movedo_grve_array_value( $item, 'content_bg_color', 'none' );
	$content_bg_color_custom = movedo_grve_array_value( $item, 'content_bg_color_custom', '#ffffff' );
	$title_color = movedo_grve_array_value( $item, 'title_color', 'light' );
	$title_color_custom = movedo_grve_array_value( $item, 'title_color_custom', '#ffffff' );
	$title_tag = movedo_grve_array_value( $item, 'title_tag', 'div' );
	$caption = movedo_grve_array_value( $item, 'caption' );
	$caption_color = movedo_grve_array_value( $item, 'caption_color', 'light' );
	$caption_color_custom = movedo_grve_array_value( $item, 'caption_color_custom', '#ffffff' );
	$caption_tag = movedo_grve_array_value( $item, 'caption_tag', 'div' );
	$subheading = movedo_grve_array_value( $item, 'subheading' );
	$subheading_color = movedo_grve_array_value( $item, 'subheading_color', 'light' );
	$subheading_color_custom = movedo_grve_array_value( $item, 'subheading_color_custom', '#ffffff' );
	$subheading_tag = movedo_grve_array_value( $item, 'subheading_tag', 'div' );

	$subheading_family = movedo_grve_array_value( $item, 'subheading_family' );
	$title_family = movedo_grve_array_value( $item, 'title_family' );
	$caption_family = movedo_grve_array_value( $item, 'caption_family' );

	$content_size = movedo_grve_array_value( $item, 'content_size', 'large' );
	$content_align = movedo_grve_array_value( $item, 'content_align', 'center' );
	$content_position = movedo_grve_array_value( $item, 'content_position', 'center-center' );
	$content_animation = movedo_grve_array_value( $item, 'content_animation', 'fade-in' );
	$content_image_id = movedo_grve_array_value( $item, 'content_image_id', '0' );
	$content_image_size = movedo_grve_array_value( $item, 'content_image_size' );
	$content_image_max_height = movedo_grve_array_value( $item, 'content_image_max_height', '150' );
	$content_image_responsive_max_height = movedo_grve_array_value( $item, 'content_image_responsive_max_height', '50' );

	$container_size = movedo_grve_array_value( $item, 'container_size' );



	$sufix  = '';
	if ( 'multi' == $mode ) {
		$sufix = '[]';
	};

	$type = movedo_grve_array_value( $item, 'type' );

	movedo_grve_print_admin_option(
		array(
			'type' => 'select',
			'name' => $prefix . 'container_size' . $sufix,
			'options' => array(
				'' => esc_html__( 'Default', 'movedo' ),
				'large' => esc_html__( 'Large', 'movedo' ),
			),
			'value' => $container_size,
			'label' => esc_html__( 'Container Size', 'movedo' ),
		)
	);

	if ( 'post' == $type ) {
?>
		<input type="hidden" name="<?php echo esc_attr( $prefix . 'content_image_id' . $sufix ); ?>" value="" />
		<input type="hidden" name="<?php echo esc_attr( $prefix . 'content_image_size' . $sufix ); ?>" value="" />
		<input type="hidden" name="<?php echo esc_attr( $prefix . 'content_image_max_height' . $sufix ); ?>" value="" />
		<input type="hidden" name="<?php echo esc_attr( $prefix . 'content_image_responsive_max_height' . $sufix ); ?>" value="" />
		<input type="hidden" name="<?php echo esc_attr( $prefix . 'subheading' . $sufix ); ?>" value="" />
		<input type="hidden" name="<?php echo esc_attr( $prefix . 'title' . $sufix ); ?>" value="" />
		<input type="hidden" name="<?php echo esc_attr( $prefix . 'caption' . $sufix ); ?>" value="" />
<?php

		movedo_grve_print_admin_option(
			array(
				'type' => 'select-colorpicker',
				'name' => $prefix . 'title_content_bg_color' . $sufix,
				'value' => $content_bg_color,
				'value2' => $content_bg_color_custom,
				'label' => array(
					"title" => esc_html__( 'Content Background Color', 'movedo' ),
				),
				'multiple' => 'multi',
				'type_usage' => 'title-content-bg',
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'select-colorpicker',
				'name' => $prefix . 'subheading_color' . $sufix,
				'value' => $subheading_color,
				'value2' => $subheading_color_custom,
				'label' => esc_html__( 'Post Meta Color', 'movedo' ),
				'multiple' => 'multi',
			)
		);
		movedo_grve_print_admin_option(
			array(
				'type' => 'select-colorpicker',
				'name' => $prefix . 'title_color' . $sufix,
				'value' => $title_color,
				'value2' => $title_color_custom,
				'label' => esc_html__( 'Post Title Color', 'movedo' ),
				'multiple' => 'multi',
			)
		);
		movedo_grve_print_admin_option(
			array(
				'type' => 'select-colorpicker',
				'name' => $prefix . 'caption_color' . $sufix,
				'value' => $caption_color,
				'value2' => $caption_color_custom,
				'label' => esc_html__( 'Post Description Color', 'movedo' ),
				'multiple' => 'multi',
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'select-tag',
				'name' => $prefix . 'subheading_tag' . $sufix,
				'value' => $subheading_tag,
				'label' => esc_html__( 'Post Meta Tag', 'movedo' ),
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'select-tag',
				'name' => $prefix . 'title_tag' . $sufix,
				'value' => $title_tag,
				'label' => esc_html__( 'Post Title Tag', 'movedo' ),
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'select-tag',
				'name' => $prefix . 'caption_tag' . $sufix,
				'value' => $caption_tag,
				'label' => esc_html__( 'Post Description Tag', 'movedo' ),
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'select-custom-font-family',
				'name' => $prefix . 'subheading_family' . $sufix,
				'value' => $subheading_family,
				'label' => esc_html__( 'Post Meta Font Family', 'movedo' ),
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'select-custom-font-family',
				'name' => $prefix . 'title_family' . $sufix,
				'value' => $title_family,
				'label' => esc_html__( 'Post Title Font Family', 'movedo' ),
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'select-custom-font-family',
				'name' => $prefix . 'caption_family' . $sufix,
				'value' => $caption_family,
				'label' => esc_html__( 'Post Description Font Family', 'movedo' ),
			)
		);

	} else {
		movedo_grve_print_admin_option(
			array(
				'type' => 'select-image',
				'name' => $prefix . 'content_image_id' . $sufix,
				'value' => $content_image_id,
				'label' => array(
					"title" => esc_html__( 'Graphic Image', 'movedo' ),
				),
				'width' => 'fullwidth',
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'select',
				'name' => $prefix . 'content_image_size' . $sufix,
				'options' => array(
					'' => esc_html__( 'Resize ( Medium )', 'movedo' ),
					'full' => esc_html__( 'Full size', 'movedo' ),
				),
				'value' => $content_image_size,
				'label' => esc_html__( 'Graphic Image Size', 'movedo' ),
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'textfield',
				'name' => $prefix . 'content_image_max_height' . $sufix,
				'value' => $content_image_max_height,
				'label' => esc_html__( 'Graphic Image Max Height', 'movedo' ),
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'textfield',
				'name' => $prefix . 'content_image_responsive_max_height' . $sufix,
				'value' => $content_image_responsive_max_height,
				'label' => esc_html__( 'Graphic Image responsive Max Height', 'movedo' ),
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'textarea',
				'name' => $prefix . 'subheading' . $sufix,
				'value' => $subheading,
				'label' => esc_html__( 'Sub Heading', 'movedo' ),
				'width' => 'fullwidth',
				'rows' => 2,
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'textarea',
				'name' => $prefix . 'title' . $sufix,
				'value' => $title,
				'label' => esc_html__( 'Title', 'movedo' ),
				'extra_class' =>  'grve-admin-label-update',
				'id' => $prefix . 'title' . $item_id,
				'width' => 'fullwidth',
				'rows' => 2,
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'textarea',
				'name' => $prefix . 'caption' . $sufix,
				'value' => $caption,
				'label' => esc_html__( 'Description', 'movedo' ),
				'width' => 'fullwidth',
				'rows' => 2,
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'select-colorpicker',
				'name' => $prefix . 'title_content_bg_color' . $sufix,
				'value' => $content_bg_color,
				'value2' => $content_bg_color_custom,
				'label' => array(
					"title" => esc_html__( 'Content Background Color', 'movedo' ),
				),
				'multiple' => 'multi',
				'type_usage' => 'title-content-bg',
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'select-colorpicker',
				'name' => $prefix . 'subheading_color' . $sufix,
				'value' => $subheading_color,
				'value2' => $subheading_color_custom,
				'label' => esc_html__( 'Sub Heading Color', 'movedo' ),
				'multiple' => 'multi',
			)
		);
		movedo_grve_print_admin_option(
			array(
				'type' => 'select-colorpicker',
				'name' => $prefix . 'title_color' . $sufix,
				'value' => $title_color,
				'value2' => $title_color_custom,
				'label' => esc_html__( 'Title Color', 'movedo' ),
				'multiple' => 'multi',
			)
		);
		movedo_grve_print_admin_option(
			array(
				'type' => 'select-colorpicker',
				'name' => $prefix . 'caption_color' . $sufix,
				'value' => $caption_color,
				'value2' => $caption_color_custom,
				'label' => esc_html__( 'Description Color', 'movedo' ),
				'multiple' => 'multi',
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'select-tag',
				'name' => $prefix . 'subheading_tag' . $sufix,
				'value' => $subheading_tag,
				'label' => esc_html__( 'Sub Heading Tag', 'movedo' ),
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'select-tag',
				'name' => $prefix . 'title_tag' . $sufix,
				'value' => $title_tag,
				'label' => esc_html__( 'Title Tag', 'movedo' ),
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'select-tag',
				'name' => $prefix . 'caption_tag' . $sufix,
				'value' => $caption_tag,
				'label' => esc_html__( 'Description Tag', 'movedo' ),
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'select-custom-font-family',
				'name' => $prefix . 'subheading_family' . $sufix,
				'value' => $subheading_family,
				'label' => esc_html__( 'Sub Heading Font Family', 'movedo' ),
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'select-custom-font-family',
				'name' => $prefix . 'title_family' . $sufix,
				'value' => $title_family,
				'label' => esc_html__( 'Title Font Family', 'movedo' ),
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'select-custom-font-family',
				'name' => $prefix . 'caption_family' . $sufix,
				'value' => $caption_family,
				'label' => esc_html__( 'Description Font Family', 'movedo' ),
			)
		);

	}

	movedo_grve_print_admin_option(
		array(
			'type' => 'select',
			'name' => $prefix . 'content_size' . $sufix,
			'options' => array(
				'large' => esc_html__( 'Large', 'movedo' ),
				'medium' => esc_html__( 'Medium', 'movedo' ),
				'small' => esc_html__( 'Small', 'movedo' ),
			),
			'value' => $content_size,
			'label' => esc_html__( 'Content Size', 'movedo' ),
		)
	);

	movedo_grve_print_admin_option(
		array(
			'type' => 'select-align',
			'name' => $prefix . 'content_align' . $sufix,
			'value' => $content_align,
			'label' => esc_html__( 'Content Alignment', 'movedo' ),
		)
	);

	movedo_grve_print_admin_option(
		array(
			'type' => 'select-bg-position',
			'name' => $prefix . 'content_position' . $sufix,
			'value' => $content_position,
			'label' => esc_html__( 'Content Position', 'movedo' ),
		)
	);

	movedo_grve_print_admin_option(
		array(
			'type' => 'select-text-animation',
			'name' => $prefix . 'content_animation' . $sufix,
			'value' => $content_animation,
			'label' => esc_html__( 'Content Animation', 'movedo' ),
		)
	);

}

/**
* Prints Item Extra Options
*/
function movedo_grve_print_admin_feature_item_extra_options( $item, $prefix = '_movedo_grve_single_item_', $mode = '' ) {

	$sufix  = '';
	if ( 'multi' == $mode ) {
		$sufix = '[]';
	};

	$el_class = movedo_grve_array_value( $item, 'el_class' );
	$arrow_enabled = movedo_grve_array_value( $item, 'arrow_enabled', 'no' );
	$arrow_color = movedo_grve_array_value( $item, 'arrow_color', 'light' );
	$arrow_color_custom = movedo_grve_array_value( $item, 'arrow_color_custom', '#ffffff' );

	movedo_grve_print_admin_option(
		array(
			'type' => 'select-boolean',
			'name' => $prefix . 'arrow_enabled' . $sufix,
			'value' => $arrow_enabled,
			'label' => esc_html__( 'Enable Bottom Arrow', 'movedo' ),
		)
	);

	movedo_grve_print_admin_option(
		array(
			'type' => 'select-colorpicker',
			'name' => $prefix . 'arrow_color' . $sufix,
			'value' => $arrow_color,
			'value2' => $arrow_color_custom,
			'label' => esc_html__( 'Arrow Color', 'movedo' ),
			'multiple' => 'multi',
		)
	);

	movedo_grve_print_admin_option(
		array(
			'type' => 'textfield',
			'name' => $prefix . 'el_class' . $sufix,
			'value' => $el_class,
			'label' => esc_html__( 'Extra Class', 'movedo' ),
		)
	);

}

/**
 * Prints Item Background Image Options
 */
function movedo_grve_print_admin_feature_item_background_options( $item ) {

	$bg_image_id = movedo_grve_array_value( $item, 'bg_image_id', '0' );
	$bg_image_size = movedo_grve_array_value( $item, 'bg_image_size' );
	$bg_position = movedo_grve_array_value( $item, 'bg_position', 'center-center' );
	$bg_tablet_sm_position = movedo_grve_array_value( $item, 'bg_tablet_sm_position' );
	$image_effect = movedo_grve_array_value( $item, 'image_effect' );


	movedo_grve_print_admin_option(
		array(
			'type' => 'select-image',
			'name' => '_movedo_grve_single_item_bg_image_id',
			'value' => $bg_image_id,
			'label' => array(
				"title" => esc_html__( 'Background Image', 'movedo' ),
				"desc" => esc_html__( 'Used also as fallback image for HTML5 / YouTube Video.', 'movedo' ),
			),
			'width' => 'fullwidth',
		)
	);

	movedo_grve_print_admin_option(
		array(
			'type' => 'select',
			'name' => '_movedo_grve_single_item_bg_image_size',
			'value' => $bg_image_size,
			'options' => array(
				'' => esc_html__( '--Inherit--', 'movedo' ),
				'responsive' => esc_html__( 'Responsive', 'movedo' ),
				'extra-extra-large' => esc_html__( 'Extra Extra Large', 'movedo' ),
				'full' => esc_html__( 'Full', 'movedo' ),
			),
			'label' => array(
				"title" => esc_html__( 'Background Image Size', 'movedo' ),
				"desc" => esc_html__( 'Inherit : Theme Options - Media Sizes.', 'movedo' ),
			),
		)
	);

	movedo_grve_print_admin_option(
		array(
			'type' => 'select-bg-position',
			'name' => '_movedo_grve_single_item_bg_position',
			'value' => $bg_position,
			'label' => esc_html__( 'Background Position', 'movedo' ),
		)
	);
	movedo_grve_print_admin_option(
		array(
			'type' => 'select-bg-position-inherit',
			'name' => '_movedo_grve_single_item_bg_tablet_sm_position',
			'value' => $bg_tablet_sm_position,
			'label' => array(
				"title" => esc_html__( 'Background Position ( Tablet Portrait )', 'movedo' ),
				"desc" => esc_html__( 'Tablet devices with portrait orientation and below.', 'movedo' ),
			),
		)
	);

	movedo_grve_print_admin_option(
		array(
			'type' => 'select',
			'name' => '_movedo_grve_single_item_image_effect',
			'options' => array(
				'' => esc_html__( 'None', 'movedo' ),
				'animated' => esc_html__( 'Animated', 'movedo' ),
				'parallax' => esc_html__( 'Classic Parallax', 'movedo' ),
				'advanced-parallax' => esc_html__( 'Advanced Parallax', 'movedo' ),
				'fixed-section' => esc_html__( 'Fixed Section', 'movedo' ),
			),
			'value' => $image_effect,
			'label' => esc_html__( 'Background Effect', 'movedo' ),
			'wrap_class' => 'grve-feature-required grve-item-feature-image-settings',
		)
	);

}

/**
 * Prints Item Background Video Options
 */
function movedo_grve_print_admin_feature_item_video_options( $item ) {

	$video_webm = movedo_grve_array_value( $item, 'video_webm' );
	$video_mp4 = movedo_grve_array_value( $item, 'video_mp4' );
	$video_ogv = movedo_grve_array_value( $item, 'video_ogv' );
	$video_poster = movedo_grve_array_value( $item, 'video_poster', 'no' );
	$video_device = movedo_grve_array_value( $item, 'video_device', 'no' );
	$video_loop = movedo_grve_array_value( $item, 'video_loop', 'yes' );
	$video_muted = movedo_grve_array_value( $item, 'video_muted', 'yes' );
	$video_effect = movedo_grve_array_value( $item, 'video_effect' );

	movedo_grve_print_admin_option(
		array(
			'type' => 'label',
			'label' => esc_html__( 'HTML5 Video', 'movedo' ),
		)
	);
	movedo_grve_print_admin_option(
		array(
			'type' => 'select-bg-video',
			'name' => '_movedo_grve_single_item_video_webm',
			'value' => $video_webm,
			'label' => esc_html__( 'WebM File URL', 'movedo' ),
			'width' => 'fullwidth',
		)
	);
	movedo_grve_print_admin_option(
		array(
			'type' => 'select-bg-video',
			'name' => '_movedo_grve_single_item_video_mp4',
			'value' => $video_mp4,
			'label' => esc_html__( 'MP4 File URL', 'movedo' ),
			'width' => 'fullwidth',
		)
	);

	movedo_grve_print_admin_option(
		array(
			'type' => 'select-bg-video',
			'name' => '_movedo_grve_single_item_video_ogv',
			'value' => $video_ogv,
			'label' => esc_html__( 'OGV File URL', 'movedo' ),
			'width' => 'fullwidth',
		)
	);

	movedo_grve_print_admin_option(
		array(
			'type' => 'select-boolean',
			'name' => '_movedo_grve_single_item_video_poster',
			'value' => $video_poster,
			'label' => esc_html__( 'Use Fallback Image as Poster', 'movedo' ),
		)
	);
	movedo_grve_print_admin_option(
		array(
			'type' => 'select-boolean',
			'name' => '_movedo_grve_single_item_video_device',
			'value' => $video_device,
			'label' => esc_html__( 'Show video on devices', 'movedo' ),
		)
	);

	movedo_grve_print_admin_option(
		array(
			'type' => 'select-boolean',
			'name' => '_movedo_grve_single_item_video_loop',
			'value' => $video_loop,
			'label' => esc_html__( 'Loop', 'movedo' ),
		)
	);

	movedo_grve_print_admin_option(
		array(
			'type' => 'select-boolean',
			'name' => '_movedo_grve_single_item_video_muted',
			'value' => $video_muted,
			'label' => esc_html__( 'Muted', 'movedo' ),
		)
	);
	movedo_grve_print_admin_option(
		array(
			'type' => 'select',
			'name' => '_movedo_grve_single_item_video_effect',
			'options' => array(
				'' => esc_html__( 'None', 'movedo' ),
				'animated' => esc_html__( 'Animated', 'movedo' ),
				'parallax' => esc_html__( 'Classic Parallax', 'movedo' ),
				'advanced-parallax' => esc_html__( 'Advanced Parallax', 'movedo' ),
				'fixed-section' => esc_html__( 'Fixed Section', 'movedo' ),
			),
			'value' => $video_effect,
			'label' => esc_html__( 'Video Effect', 'movedo' ),
		)
	);


}


/**
 * Prints Item Background Video Options
 */
function movedo_grve_print_admin_feature_item_youtube_options( $item ) {

	$video_url = movedo_grve_array_value( $item, 'video_url' );
	$video_start = movedo_grve_array_value( $item, 'video_start' );
	$video_end = movedo_grve_array_value( $item, 'video_end' );
	movedo_grve_print_admin_option(
		array(
			'type' => 'label',
			'label' => esc_html__( 'YouTube Video', 'movedo' ),
		)
	);

	movedo_grve_print_admin_option(
		array(
			'type' => 'textfield',
			'name' => '_movedo_grve_single_item_video_url',
			'value' => $video_url,
			'label' => array(
				"title" => esc_html__( 'YouTube link', 'movedo' ),
				"desc" => esc_html__( 'e.g: https://www.youtube.com/watch?v=lMJXxhRFO1k', 'movedo' ),
			),
			'width' => 'fullwidth',
		)
	);
	movedo_grve_print_admin_option(
		array(
			'type' => 'textfield',
			'name' => '_movedo_grve_single_item_video_start',
			'value' => $video_start,
			'label' => array(
				"title" => esc_html__( 'Start at:', 'movedo' ),
				"desc" => esc_html__( 'Value in seconds', 'movedo' ),
			),
		)
	);
	movedo_grve_print_admin_option(
		array(
			'type' => 'textfield',
			'name' => '_movedo_grve_single_item_video_end',
			'value' => $video_end,
			'label' => array(
				"title" => esc_html__( 'End at:', 'movedo' ),
				"desc" => esc_html__( 'Value in seconds', 'movedo' ),
			),
		)
	);
}


function movedo_grve_admin_get_feature_section( $post_id ) {

	$post_type = get_post_type( $post_id );

	//Feature Section
	$feature_section = get_post_meta( $post_id, '_movedo_grve_feature_section', true );

	//Feature Settings
	$feature_settings = movedo_grve_array_value( $feature_section, 'feature_settings' );

	$feature_element = movedo_grve_array_value( $feature_settings, 'element' );
	$feature_size = movedo_grve_array_value( $feature_settings, 'size' );
	$feature_height = movedo_grve_array_value( $feature_settings, 'height', '60' );
	$feature_min_height = movedo_grve_array_value( $feature_settings, 'min_height', '200' );
	$feature_bg_color  = movedo_grve_array_value( $feature_settings, 'bg_color', 'dark' );
	$feature_bg_color_custom  = movedo_grve_array_value( $feature_settings, 'bg_color_custom', '#eef1f6' );
	$feature_bg_gradient_color_1  = movedo_grve_array_value( $feature_settings, 'bg_gradient_color_1', '#034e90' );
	$feature_bg_gradient_color_2  = movedo_grve_array_value( $feature_settings, 'bg_gradient_color_2', '#19b4d7' );
	$feature_bg_gradient_direction  = movedo_grve_array_value( $feature_settings, 'bg_gradient_direction', '90' );
	$feature_header_position = movedo_grve_array_value( $feature_settings, 'header_position', 'above' );
	$feature_separator_bottom  = movedo_grve_array_value( $feature_settings, 'separator_bottom' );
	$feature_separator_bottom_size  = movedo_grve_array_value( $feature_settings, 'separator_bottom_size', '90px' );
	$feature_separator_bottom_color  = movedo_grve_array_value( $feature_settings, 'separator_bottom_color', '#ffffff' );

	//Feature Single Item
	$feature_single_item = movedo_grve_array_value( $feature_section, 'single_item' );
	$feature_single_item_button = movedo_grve_array_value( $feature_single_item, 'button' );
	$feature_single_item_button2 = movedo_grve_array_value( $feature_single_item, 'button2' );


	//Slider Item
	$slider_items = movedo_grve_array_value( $feature_section, 'slider_items' );
	$slider_settings = movedo_grve_array_value( $feature_section, 'slider_settings' );

	$slider_speed = movedo_grve_array_value( $slider_settings, 'slideshow_speed', '3500' );
	$slider_pause = movedo_grve_array_value( $slider_settings, 'slider_pause', 'no' );
	$slider_dir_nav = movedo_grve_array_value( $slider_settings, 'direction_nav', '1' );
	$slider_dir_nav_color = movedo_grve_array_value( $slider_settings, 'direction_nav_color', 'light' );
	$slider_transition = movedo_grve_array_value( $slider_settings, 'transition', 'slide' );
	$slider_effect = movedo_grve_array_value( $slider_settings, 'slider_effect' );
	$slider_pagination = movedo_grve_array_value( $slider_settings, 'pagination', 'yes' );

	//Map Item
	$map_items = movedo_grve_array_value( $feature_section, 'map_items' );
	$map_settings = movedo_grve_array_value( $feature_section, 'map_settings' );

	$map_zoom = movedo_grve_array_value( $map_settings, 'zoom', 14 );
	$map_marker_type = movedo_grve_array_value( $map_settings, 'marker_type' );
	$map_marker = movedo_grve_array_value( $map_settings, 'marker' );
	$map_marker_bg_color = movedo_grve_array_value( $map_settings, 'marker_bg_color', 'primary-1' );
	$map_disable_style = movedo_grve_array_value( $map_settings, 'disable_style', 'no' );

	//Revolution slider
	$revslider_alias = movedo_grve_array_value( $feature_section, 'revslider_alias' );

	global $movedo_grve_area_height;

?>

		<div class="grve-fields-wrapper grve-highlight">
			<div class="grve-label">
				<label for="grve-page-feature-element">
					<span class="grve-title"><?php esc_html_e( 'Feature Element', 'movedo' ); ?></span>
					<span class="grve-description"><?php esc_html_e( 'Select feature section element', 'movedo' ); ?></span>
				</label>
			</div>
			<div class="grve-field-items-wrapper">
				<div class="grve-field-item">
					<select id="grve-page-feature-element" name="_movedo_grve_page_feature_element">
						<option value="" <?php selected( "", $feature_element ); ?>><?php esc_html_e( 'None', 'movedo' ); ?></option>
						<option value="title" <?php selected( "title", $feature_element ); ?>><?php esc_html_e( 'Title', 'movedo' ); ?></option>
						<option value="image" <?php selected( "image", $feature_element ); ?>><?php esc_html_e( 'Image', 'movedo' ); ?></option>
						<option value="video" <?php selected( "video", $feature_element ); ?>><?php esc_html_e( 'Video', 'movedo' ); ?></option>
						<option value="youtube" <?php selected( "youtube", $feature_element ); ?>><?php esc_html_e( 'YouTube', 'movedo' ); ?></option>
						<option value="slider" <?php selected( "slider", $feature_element ); ?>><?php esc_html_e( 'Slider', 'movedo' ); ?></option>
						<option value="revslider" <?php selected( "revslider", $feature_element ); ?>><?php esc_html_e( 'Revolution Slider', 'movedo' ); ?></option>
						<option value="map" <?php selected( "map", $feature_element ); ?>><?php esc_html_e( 'Map', 'movedo' ); ?></option>
					</select>
				</div>
			</div>
		</div>

		<div id="grve-feature-section-options" class="grve-feature-section-item postbox" <?php if ( "" != $feature_element ) { ?> style="display:none;" <?php } ?>>

			<div class="grve-fields-wrapper grve-feature-options-wrapper">
				<div class="grve-label">
					<label for="grve-page-feature-element">
						<span class="grve-title"><?php esc_html_e( 'Feature Size', 'movedo' ); ?></span>
						<span class="grve-description"><?php esc_html_e( 'With Custom Size option you can select the feature height.', 'movedo' ); ?></span>
					</label>
				</div>
				<div class="grve-field-items-wrapper">
					<div class="grve-field-item">
						<select name="_movedo_grve_page_feature_size" id="grve-page-feature-size">
							<option value="" <?php selected( "", $feature_size ); ?>><?php esc_html_e( 'Full Screen', 'movedo' ); ?></option>
							<option value="custom" <?php selected( "custom", $feature_size ); ?>><?php esc_html_e( 'Custom Size', 'movedo' ); ?></option>
						</select>
					</div>
					<div class="grve-field-item">
						<span id="grve-feature-section-height" <?php if ( "" == $feature_size ) { ?> style="display:none;" <?php } ?>>
							<select name="_movedo_grve_page_feature_height">
								<?php movedo_grve_print_select_options( $movedo_grve_area_height, $feature_height ); ?>
							</select>
							<span class="grve-sub-title"><?php esc_html_e( 'Height', 'movedo' ); ?></span>
							<input type="text" name="_movedo_grve_page_feature_min_height" value="<?php echo esc_attr( $feature_min_height ); ?>"/>
							<span class="grve-sub-title"><?php esc_html_e( 'Minimum Height in px', 'movedo' ); ?></span>
						</span>
					</div>
				</div>
			</div>
			<?php
				movedo_grve_print_admin_option(
					array(
						'type' => 'select',
						'options' => array(
							'above' => esc_html__( 'Header above Feature', 'movedo' ),
							'below' => esc_html__( 'Header below Feature', 'movedo' ),
						),
						'name' => '_movedo_grve_page_feature_header_position',
						'value' => $feature_header_position,
						'label' => array(
							'title' => esc_html__( 'Feature/Header Position', 'movedo' ),
							'desc' => esc_html__( 'With this option header will be shown above or below feature section.', 'movedo' ),
						),
					)
				);
			?>
			<div id="grve-feature-options-wrapper" class="grve-feature-options-wrapper">
			<?php

				movedo_grve_print_admin_option(
					array(
						'type' => 'select-colorpicker',
						'name' => '_movedo_grve_page_feature_bg_color',
						'id' => '_movedo_grve_page_feature_bg_color',
						'value' => $feature_bg_color,
						'value2' => $feature_bg_color_custom,
						'label' => esc_html__( 'Background Color', 'movedo' ),
						'multiple' => 'multi',
						'type_usage' => 'feature-bg',
						'group_id' => 'grve-feature-options-wrapper',
					)
				);
				movedo_grve_print_admin_option(
					array(
						'type' => 'colorpicker',
						'name' => '_movedo_grve_page_feature_bg_gradient_color_1',
						'value' => $feature_bg_gradient_color_1,
						'label' => esc_html__( 'Custom Color 1', 'movedo' ),
						'dependency' =>
						'[
							{ "id" : "_movedo_grve_page_feature_bg_color", "values" : ["gradient"] }
						]',
					)
				);
				movedo_grve_print_admin_option(
					array(
						'type' => 'colorpicker',
						'name' => '_movedo_grve_page_feature_bg_gradient_color_2',
						'value' => $feature_bg_gradient_color_2,
						'label' => esc_html__( 'Custom Color 2', 'movedo' ),
						'dependency' =>
						'[
							{ "id" : "_movedo_grve_page_feature_bg_color", "values" : ["gradient"] }
						]',
					)
				);
				movedo_grve_print_admin_option(
					array(
						'type' => 'select',
						'name' => '_movedo_grve_page_feature_bg_gradient_direction',
						'value' => $feature_bg_gradient_direction,
						'options' => array(
							'90' => esc_html__( "Left to Right", 'movedo' ),
							'135' => esc_html__( "Left Top to Right Bottom", 'movedo' ),
							'45' => esc_html__( "Left Bottom to Right Top", 'movedo' ),
							'180' => esc_html__( "Bottom to Top", 'movedo' ),
						),
						'label' => array(
							"title" => esc_html__( 'Gradient Direction', 'movedo' ),
						),
						'dependency' =>
						'[
							{ "id" : "_movedo_grve_page_feature_bg_color", "values" : ["gradient"] }
						]',
					)
				);

				$movedo_grve_feature_separator_list = array(
					'' => esc_html__( "None", 'movedo' ),
					'triangle-separator' => esc_html__( "Triangle", 'movedo' ),
					'large-triangle-separator' => esc_html__( "Large Triangle", 'movedo' ),
					'curve-separator' => esc_html__( "Curve", 'movedo' ),
					'curve-left-separator' => esc_html__( "Curve Left", 'movedo' ),
					'curve-right-separator' => esc_html__( "Curve Right", 'movedo' ),
					'tilt-left-separator' => esc_html__( "Tilt Left", 'movedo' ),
					'tilt-right-separator' => esc_html__( "Tilt Right", 'movedo' ),
					'round-split-separator' => esc_html__( "Round Split", 'movedo' ),
					'torn-paper-separator' => esc_html__( "Torn Paper", 'movedo' ),
				);

				$movedo_grve_feature_separator_size_list = array(
					'30px' => esc_html__( "Small", 'movedo' ),
					'60px' => esc_html__( "Medium", 'movedo' ),
					'90px' => esc_html__( "Large", 'movedo' ),
					'120px'=> esc_html__( "Extra Large", 'movedo' ),
					'100%' => esc_html__( "Section Height", 'movedo' ),
				);
				movedo_grve_print_admin_option(
					array(
						'type' => 'select',
						'name' => '_movedo_grve_page_feature_separator_bottom',
						'id' => '_movedo_grve_page_feature_separator_bottom',
						'value' => $feature_separator_bottom,
						'options' => $movedo_grve_feature_separator_list,
						'label' => array(
							"title" => esc_html__( 'Bottom Separator', 'movedo' ),
						),
						'group_id' => 'grve-feature-options-wrapper',
					)
				);
				movedo_grve_print_admin_option(
					array(
						'type' => 'colorpicker',
						'name' => '_movedo_grve_page_feature_separator_bottom_color',
						'value' => $feature_separator_bottom_color,
						'label' => esc_html__( 'Bottom Separator Color', 'movedo' ),
						'dependency' =>
						'[
							{ "id" : "_movedo_grve_page_feature_separator_bottom", "value_not_equal_to" : [""] }
						]',
					)
				);
				movedo_grve_print_admin_option(
					array(
						'type' => 'select',
						'name' => '_movedo_grve_page_feature_separator_bottom_size',
						'value' => $feature_separator_bottom_size,
						'options' => $movedo_grve_feature_separator_size_list,
						'label' => array(
							"title" => esc_html__( 'Bottom Separator Size', 'movedo' ),
						),
						'dependency' =>
						'[
							{ "id" : "_movedo_grve_page_feature_separator_bottom", "value_not_equal_to" : [""] }
						]',
					)
				);
			?>
			</div>

		</div>



		<div id="grve-feature-section-slider" class="grve-feature-section-item" <?php if ( "slider" != $feature_element ) { ?> style="display:none;" <?php } ?>>

			<div class="postbox">
				<h3 class="grve-title">
					<span><?php esc_html_e( 'Slider Settings', 'movedo' ); ?></span>
				</h3>
				<div class="inside">

					<?php
						movedo_grve_print_admin_option(
							array(
								'type' => 'textfield',
								'name' => '_movedo_grve_page_slider_settings_speed',
								'value' => $slider_speed,
								'label' => esc_html__( 'Slideshow Speed', 'movedo' ),
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'name' => '_movedo_grve_page_slider_settings_pause',
								'options' => array(
									'no' => esc_html__( 'No', 'movedo' ),
									'yes' => esc_html__( 'Yes', 'movedo' ),
								),
								'value' => $slider_pause,
								'label' => esc_html__( 'Pause on Hover', 'movedo' ),
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'options' => array(
									'yes' => esc_html__( 'Yes', 'movedo' ),
									'no' => esc_html__( 'No', 'movedo' ),
								),
								'name' => '_movedo_grve_page_slider_settings_pagination',
								'value' => $slider_pagination,
								'label' => array(
									'title' => esc_html__( 'Pagination', 'movedo' ),
								),
							)
						);
						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'options' => array(
									'1' => esc_html__( 'Style 1', 'movedo' ),
									'2' => esc_html__( 'Style 2', 'movedo' ),
									'3' => esc_html__( 'Style 3', 'movedo' ),
									'0' => esc_html__( 'No Navigation', 'movedo' ),
								),
								'name' => '_movedo_grve_page_slider_settings_direction_nav',
								'value' => $slider_dir_nav,
								'label' => array(
									'title' => esc_html__( 'Navigation Buttons', 'movedo' ),
								),
							)
						);

						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'options' => array(
									'slide' => esc_html__( 'Slide', 'movedo' ),
									'fade' => esc_html__( 'Fade', 'movedo' ),
									'backSlide' => esc_html__( 'Back Slide', 'movedo' ),
									'goDown' => esc_html__( 'Go Down', 'movedo' ),
								),
								'name' => '_movedo_grve_page_slider_settings_transition',
								'value' => $slider_transition,
								'label' => array(
									'title' => esc_html__( 'Transition', 'movedo' ),
								),
							)
						);

						movedo_grve_print_admin_option(
							array(
								'type' => 'select',
								'options' => array(
									'' => esc_html__( 'None', 'movedo' ),
									'animated' => esc_html__( 'Animated', 'movedo' ),
									'parallax' => esc_html__( 'Classic Parallax', 'movedo' ),
									'advanced-parallax' => esc_html__( 'Advanced Parallax', 'movedo' ),
									'fixed-section' => esc_html__( 'Fixed Section', 'movedo' ),
								),
								'name' => '_movedo_grve_page_slider_settings_effect',
								'value' => $slider_effect,
								'label' => array(
									'title' => esc_html__( 'Slider Effect', 'movedo' ),
								),
							)
						);
					?>

					<div class="grve-fields-wrapper">
						<div class="grve-label">
							<label for="grve-page-feature-element">
								<span class="grve-title"><?php esc_html_e( 'Add Slides', 'movedo' ); ?></span>
							</label>
						</div>
						<div class="grve-field-items-wrapper">
							<div class="grve-field-item">
								<input type="button" class="grve-upload-feature-slider-button button-primary" value="<?php esc_attr_e( 'Insert Images to Slider', 'movedo' ); ?>"/>
								<span id="grve-upload-feature-slider-button-spinner" class="grve-action-spinner"></span>
							</div>
						</div>
					</div>
					<?php if ( 'product' != $post_type && 'tribe_events' != $post_type ) { ?>
					<div class="grve-fields-wrapper">
						<div class="grve-label">
							<label for="grve-page-feature-element">
								<span class="grve-title"><?php esc_html_e( 'Add Post Slides', 'movedo' ); ?></span>
							</label>
						</div>
						<div class="grve-field-items-wrapper">
							<div class="grve-field-item">
								<input type="button" class="grve-upload-feature-slider-post-button button-primary" value="<?php esc_attr_e( 'Insert Posts to Slider', 'movedo' ); ?>"/>
							</div>
							<div class="grve-field-item">
								<input id="grve-upload-feature-slider-post-selection" type="hidden" class="grve-post-selector-select2"  value="" />
							</div>
						</div>
					</div>
					<?php } ?>

				</div>
			</div>
		</div>
		<div id="grve-feature-slider-container" data-mode="slider-full" class="grve-feature-section-item" <?php if ( 'slider' != $feature_element ) { ?> style="display:none;" <?php } ?>>
			<?php
				if( !empty( $slider_items ) ) {
					movedo_grve_print_admin_feature_slider_items( $slider_items );
				}
			?>
		</div>

		<div id="grve-feature-map-container" class="grve-feature-section-item" <?php if ( 'map' != $feature_element ) { ?> style="display:none;" <?php } ?>>
			<div class="grve-map-item postbox">
				<h3 class="grve-title">
					<span><?php esc_html_e( 'Map', 'movedo' ); ?></span>
				</h3>
				<div class="inside">
					<div class="grve-fields-wrapper">
						<div class="grve-label">
							<label for="grve-page-feature-element">
								<span class="grve-title"><?php esc_html_e( 'Single Point Zoom', 'movedo' ); ?></span>
							</label>
						</div>
						<div class="grve-field-items-wrapper">
							<div class="grve-field-item">
								<select id="grve-page-feature-map-zoom" name="_movedo_grve_page_feature_map_zoom">
									<?php for ( $i=1; $i < 20; $i++ ) { ?>
										<option value="<?php echo esc_attr( $i ); ?>" <?php selected( $i, $map_zoom ); ?>><?php echo esc_html( $i ); ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<?php

					movedo_grve_print_admin_option(
						array(
							'type' => 'select',
							'id' => '_movedo_grve_page_feature_map_marker_type',
							'name' => '_movedo_grve_page_feature_map_marker_type',
							'value' => $map_marker_type,
							'label' => array(
								"title" => esc_html__( 'Global Marker Type', 'movedo' ),
							),
							'options' => array(
								'' => esc_html__( 'Image', 'movedo' ),
								'pulse-dot' => esc_html__( 'Pulse Dot Icon', 'movedo' ),
								'dot' => esc_html__( 'Dot Icon', 'movedo' ),
							),
							'group_id' => 'grve-feature-map-container',
						)
					);

					movedo_grve_print_admin_option(
						array(
							'type' => 'select-bg-image',
							'name' => '_movedo_grve_page_feature_map_marker',
							'value' => $map_marker,
							'label' => array(
								"title" => esc_html__( 'Global Marker', 'movedo' ),
							),
							'width' => 'fullwidth',
							'dependency' =>
							'[
								{ "id" : "_movedo_grve_page_feature_map_marker_type", "values" : [""] }
							]',
							'group_id' => 'grve-feature-map-container',
						)
					);
					movedo_grve_print_admin_option(
						array(
							'type' => 'select-button-color',
							'name' => '_movedo_grve_page_feature_map_marker_bg_color',
							'id' => '_movedo_grve_page_feature_map_marker_bg_color',
							'value' => $map_marker_bg_color,
							'label' => esc_html__( 'Marker Background Color', 'movedo' ),
							'dependency' =>
							'[
								{ "id" : "_movedo_grve_page_feature_map_marker_type", "value_not_equal_to" : [""] }
							]',
							'group_id' => 'grve-feature-map-container',
						)
					);
					?>
					<div class="grve-fields-wrapper">
						<div class="grve-label">
							<label for="grve-page-feature-element">
								<span class="grve-title"><?php esc_html_e( 'Disable Custom Style', 'movedo' ); ?></span>
							</label>
						</div>
						<div class="grve-field-items-wrapper">
							<div class="grve-field-item">
								<select id="grve-page-feature-map-disable-style" name="_movedo_grve_page_feature_map_disable_style">
									<option value="no" <?php selected( "no", $map_disable_style ); ?>><?php esc_html_e( 'No', 'movedo' ); ?></option>
									<option value="yes" <?php selected( "yes", $map_disable_style ); ?>><?php esc_html_e( 'Yes', 'movedo' ); ?></option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="grve-fields-wrapper">
					<div class="grve-label">
						<label for="grve-page-feature-element">
							<span class="grve-title"><?php esc_html_e( 'Add Map Points', 'movedo' ); ?></span>
						</label>
					</div>
					<div class="grve-field-items-wrapper">
						<div class="grve-field-item">
							<input type="button" id="grve-upload-multi-map-point" class="grve-upload-multi-map-point button-primary" value="<?php esc_attr_e( 'Insert Point to Map', 'movedo' ); ?>"/>
							<span id="grve-upload-multi-map-button-spinner" class="grve-action-spinner"></span>
						</div>
					</div>
				</div>
			</div>
			<?php movedo_grve_print_admin_feature_map_items( $map_items ); ?>
		</div>

		<div id="grve-feature-single-container" class="grve-feature-section-item" <?php if ( 'title' != $feature_element && 'image' != $feature_element && 'video' != $feature_element && 'youtube' != $feature_element ) { ?> style="display:none;" <?php } ?>>
			<div class="grve-video-item postbox">
				<span class="grve-modal-spinner"></span>
				<h3 class="grve-title">
					<span><?php esc_html_e( 'Options', 'movedo' ); ?></span>
				</h3>
				<div class="inside">

					<!--  METABOXES -->
					<div class="grve-metabox-content">

						<!-- TABS -->
						<div class="grve-tabs">

							<ul class="grve-tab-links">
								<li class="grve-feature-required grve-item-feature-video-settings active"><a id="grve-feature-single-tab-video-link" href="#grve-feature-single-tab-video"><?php esc_html_e( 'Video', 'movedo' ); ?></a></li>
								<li class="grve-feature-required grve-item-feature-youtube-settings active"><a id="grve-feature-single-tab-youtube-link" href="#grve-feature-single-tab-youtube"><?php esc_html_e( 'YouTube', 'movedo' ); ?></a></li>
								<li class="grve-feature-required grve-item-feature-bg-settings"><a id="grve-feature-single-tab-bg-link" href="#grve-feature-single-tab-bg"><?php esc_html_e( 'Background', 'movedo' ); ?></a></li>
								<li class="grve-feature-required grve-item-feature-content-settings"><a id="grve-feature-single-tab-content-link" href="#grve-feature-single-tab-content"><?php esc_html_e( 'Content', 'movedo' ); ?></a></li>
								<li class="grve-feature-required grve-item-feature-revslider-settings"><a id="grve-feature-single-tab-revslider-link" href="#grve-feature-single-tab-revslider"><?php esc_html_e( 'Revolution Slider', 'movedo' ); ?></a></li>
								<li class="grve-feature-required grve-item-feature-button-settings"><a href="#grve-feature-single-tab-button"><?php esc_html_e( 'First Button', 'movedo' ); ?></a></li>
								<li class="grve-feature-required grve-item-feature-button-settings"><a href="#grve-feature-single-tab-button2"><?php esc_html_e( 'Second Button', 'movedo' ); ?></a></li>
								<li class="grve-feature-required grve-item-feature-extra-settings"><a href="#grve-feature-single-tab-extra"><?php esc_html_e( 'Extra', 'movedo' ); ?></a></li>
							</ul>

							<div class="grve-tab-content">
								<div id="grve-feature-single-tab-video" class="grve-tab-item active">
									<?php movedo_grve_print_admin_feature_item_video_options( $feature_single_item ); ?>
								</div>
								<div id="grve-feature-single-tab-youtube" class="grve-tab-item">
									<?php movedo_grve_print_admin_feature_item_youtube_options( $feature_single_item ); ?>
								</div>
								<div id="grve-feature-single-tab-revslider" class="grve-tab-item">
									<?php
										movedo_grve_print_admin_option(
												array(
													'type' => 'select',
													'options' => movedo_grve_get_revolution_selection(),
													'name' => '_movedo_grve_page_revslider',
													'value' => $revslider_alias,
													'label' => array(
														'title' => esc_html__( 'Revolution Slider', 'movedo' ),
													),
												)
											);
									?>
								</div>
								<div id="grve-feature-single-tab-bg" class="grve-tab-item">
									<?php movedo_grve_print_admin_feature_item_background_options( $feature_single_item ); ?>
									<?php movedo_grve_print_admin_feature_item_overlay_options( $feature_single_item ); ?>
								</div>
								<div id="grve-feature-single-tab-content" class="grve-tab-item">
									<?php movedo_grve_print_admin_feature_item_content_options( $feature_single_item ); ?>
								</div>
								<div id="grve-feature-single-tab-button" class="grve-tab-item">
									<?php movedo_grve_print_admin_feature_item_button_options( $feature_single_item_button, '_movedo_grve_single_item_button_' ); ?>
								</div>
								<div id="grve-feature-single-tab-button2" class="grve-tab-item">
									<?php movedo_grve_print_admin_feature_item_button_options( $feature_single_item_button2, '_movedo_grve_single_item_button2_' ); ?>
								</div>
								<div id="grve-feature-single-tab-extra" class="grve-tab-item">
									<?php movedo_grve_print_admin_feature_item_extra_options( $feature_single_item ); ?>
								</div>
							</div>

						</div>
						<!-- END TABS -->

					</div>
					<!-- END  METABOXES -->
				</div>
			</div>
		</div>
<?php
}

function movedo_grve_admin_save_feature_section( $post_id ) {

	//Feature Section variable
	$feature_section = array();


	if ( isset( $_POST['_movedo_grve_page_feature_element'] ) ) {

		//Feature Settings

		$feature_section['feature_settings'] = array (
			'element' => $_POST['_movedo_grve_page_feature_element'],
			'size' => $_POST['_movedo_grve_page_feature_size'],
			'height' => $_POST['_movedo_grve_page_feature_height'],
			'min_height' => $_POST['_movedo_grve_page_feature_min_height'],
			'header_position' => $_POST['_movedo_grve_page_feature_header_position'],
			'bg_color' => $_POST['_movedo_grve_page_feature_bg_color'],
			'bg_color_custom' => $_POST['_movedo_grve_page_feature_bg_color_custom'],
			'bg_gradient_color_1' => $_POST['_movedo_grve_page_feature_bg_gradient_color_1'],
			'bg_gradient_color_2' => $_POST['_movedo_grve_page_feature_bg_gradient_color_2'],
			'bg_gradient_direction' => $_POST['_movedo_grve_page_feature_bg_gradient_direction'],
			'separator_bottom' => $_POST['_movedo_grve_page_feature_separator_bottom'],
			'separator_bottom_color' => $_POST['_movedo_grve_page_feature_separator_bottom_color'],
			'separator_bottom_size' => $_POST['_movedo_grve_page_feature_separator_bottom_size'],

		);


		//Feature Revolution Slider
		if ( isset( $_POST['_movedo_grve_page_revslider'] ) ) {
			$feature_section['revslider_alias'] = $_POST['_movedo_grve_page_revslider'];
		}

		//Feature Single Item
		if ( isset( $_POST['_movedo_grve_single_item_title'] ) ) {


			$feature_section['single_item'] = array (

				'title' => $_POST['_movedo_grve_single_item_title'],
				'content_bg_color' => $_POST['_movedo_grve_single_item_title_content_bg_color'],
				'content_bg_color_custom' => $_POST['_movedo_grve_single_item_title_content_bg_color_custom'],
				'title_color' => $_POST['_movedo_grve_single_item_title_color'],
				'title_color_custom' => $_POST['_movedo_grve_single_item_title_color_custom'],
				'title_tag' => $_POST['_movedo_grve_single_item_title_tag'],
				'caption' => $_POST['_movedo_grve_single_item_caption'],
				'caption_color' => $_POST['_movedo_grve_single_item_caption_color'],
				'caption_color_custom' => $_POST['_movedo_grve_single_item_caption_color_custom'],
				'caption_tag' => $_POST['_movedo_grve_single_item_caption_tag'],
				'subheading' => $_POST['_movedo_grve_single_item_subheading'],
				'subheading_color' => $_POST['_movedo_grve_single_item_subheading_color'],
				'subheading_color_custom' => $_POST['_movedo_grve_single_item_subheading_color_custom'],
				'subheading_tag' => $_POST['_movedo_grve_single_item_subheading_tag'],
				'subheading_family' => $_POST['_movedo_grve_single_item_subheading_family'],
				'title_family' => $_POST['_movedo_grve_single_item_title_family'],
				'caption_family' => $_POST['_movedo_grve_single_item_caption_family'],
				'content_size' => $_POST['_movedo_grve_single_item_content_size'],
				'content_align' => $_POST['_movedo_grve_single_item_content_align'],
				'content_position' => $_POST['_movedo_grve_single_item_content_position'],
				'content_animation' => $_POST['_movedo_grve_single_item_content_animation'],
				'container_size' => $_POST['_movedo_grve_single_item_container_size'],
				'content_image_id' => $_POST['_movedo_grve_single_item_content_image_id'],
				'content_image_size' => $_POST['_movedo_grve_single_item_content_image_size'],
				'content_image_max_height' => $_POST['_movedo_grve_single_item_content_image_max_height'],
				'content_image_responsive_max_height' => $_POST['_movedo_grve_single_item_content_image_responsive_max_height'],
				'pattern_overlay' => $_POST['_movedo_grve_single_item_pattern_overlay'],
				'color_overlay' => $_POST['_movedo_grve_single_item_color_overlay'],
				'color_overlay_custom' => $_POST['_movedo_grve_single_item_color_overlay_custom'],
				'opacity_overlay' => $_POST['_movedo_grve_single_item_opacity_overlay'],
				'gradient_overlay_custom_1' => $_POST['_movedo_grve_single_item_gradient_overlay_custom_1'],
				'gradient_overlay_custom_1_opacity' => $_POST['_movedo_grve_single_item_gradient_overlay_custom_1_opacity'],
				'gradient_overlay_custom_2' => $_POST['_movedo_grve_single_item_gradient_overlay_custom_2'],
				'gradient_overlay_custom_2_opacity' => $_POST['_movedo_grve_single_item_gradient_overlay_custom_2_opacity'],
				'gradient_overlay_direction' => $_POST['_movedo_grve_single_item_gradient_overlay_direction'],
				'bg_image_id' => $_POST['_movedo_grve_single_item_bg_image_id'],
				'bg_image_size' => $_POST['_movedo_grve_single_item_bg_image_size'],
				'bg_position' => $_POST['_movedo_grve_single_item_bg_position'],
				'bg_tablet_sm_position' => $_POST['_movedo_grve_single_item_bg_tablet_sm_position'],
				'image_effect' => $_POST['_movedo_grve_single_item_image_effect'],
				'video_webm' => $_POST['_movedo_grve_single_item_video_webm'],
				'video_mp4' => $_POST['_movedo_grve_single_item_video_mp4'],
				'video_ogv' => $_POST['_movedo_grve_single_item_video_ogv'],
				'video_poster' => $_POST['_movedo_grve_single_item_video_poster'],
				'video_device' => $_POST['_movedo_grve_single_item_video_device'],
				'video_loop' => $_POST['_movedo_grve_single_item_video_loop'],
				'video_muted' => $_POST['_movedo_grve_single_item_video_muted'],
				'video_effect' => $_POST['_movedo_grve_single_item_video_effect'],
				'video_url' => $_POST['_movedo_grve_single_item_video_url'],
				'video_start' => $_POST['_movedo_grve_single_item_video_start'],
				'video_end' => $_POST['_movedo_grve_single_item_video_end'],
				'button' => array(
					'id' => $_POST['_movedo_grve_single_item_button_id'],
					'text' => $_POST['_movedo_grve_single_item_button_text'],
					'url' => $_POST['_movedo_grve_single_item_button_url'],
					'target' => $_POST['_movedo_grve_single_item_button_target'],
					'color' => $_POST['_movedo_grve_single_item_button_color'],
					'hover_color' => $_POST['_movedo_grve_single_item_button_hover_color'],
					'gradient_1_color' => $_POST['_movedo_grve_single_item_button_gradient_1_color'],
					'gradient_2_color' => $_POST['_movedo_grve_single_item_button_gradient_2_color'],
					'size' => $_POST['_movedo_grve_single_item_button_size'],
					'shape' => $_POST['_movedo_grve_single_item_button_shape'],
					'shadow' => $_POST['_movedo_grve_single_item_button_shadow'],
					'type' => $_POST['_movedo_grve_single_item_button_type'],
					'class' => $_POST['_movedo_grve_single_item_button_class'],
				),
				'button2' => array(
					'id' => $_POST['_movedo_grve_single_item_button2_id'],
					'text' => $_POST['_movedo_grve_single_item_button2_text'],
					'url' => $_POST['_movedo_grve_single_item_button2_url'],
					'target' => $_POST['_movedo_grve_single_item_button2_target'],
					'color' => $_POST['_movedo_grve_single_item_button2_color'],
					'hover_color' => $_POST['_movedo_grve_single_item_button2_hover_color'],
					'gradient_1_color' => $_POST['_movedo_grve_single_item_button2_gradient_1_color'],
					'gradient_2_color' => $_POST['_movedo_grve_single_item_button2_gradient_2_color'],
					'size' => $_POST['_movedo_grve_single_item_button2_size'],
					'shape' => $_POST['_movedo_grve_single_item_button2_shape'],
					'shadow' => $_POST['_movedo_grve_single_item_button2_shadow'],
					'type' => $_POST['_movedo_grve_single_item_button2_type'],
					'class' => $_POST['_movedo_grve_single_item_button2_class'],
				),
				'arrow_enabled' => $_POST['_movedo_grve_single_item_arrow_enabled'],
				'arrow_color' => $_POST['_movedo_grve_single_item_arrow_color'],
				'arrow_color_custom' => $_POST['_movedo_grve_single_item_arrow_color_custom'],
				'el_class' => $_POST['_movedo_grve_single_item_el_class'],

			);
		}

		//Feature Slider Items
		$slider_items = array();
		if ( isset( $_POST['_movedo_grve_slider_item_id'] ) ) {

			$num_of_images = sizeof( $_POST['_movedo_grve_slider_item_id'] );
			for ( $i=0; $i < $num_of_images; $i++ ) {

				$slide = array (
					'id' => $_POST['_movedo_grve_slider_item_id'][ $i ],
					'type' => $_POST['_movedo_grve_slider_item_type'][ $i ],
					'post_id' => $_POST['_movedo_grve_slider_item_post_id'][ $i ],
					'bg_image_id' => $_POST['_movedo_grve_slider_item_bg_image_id'][ $i ],
					'bg_image_size' => $_POST['_movedo_grve_slider_item_bg_image_size'][ $i ],
					'bg_position' => $_POST['_movedo_grve_slider_item_bg_position'][ $i ],
					'bg_tablet_sm_position' => $_POST['_movedo_grve_slider_item_bg_tablet_sm_position'][ $i ],
					'header_style' => $_POST['_movedo_grve_slider_item_header_style'][ $i ],
					'title' => $_POST['_movedo_grve_slider_item_title'][ $i ],
					'content_bg_color' => $_POST['_movedo_grve_slider_item_title_content_bg_color'][ $i ],
					'content_bg_color_custom' => $_POST['_movedo_grve_slider_item_title_content_bg_color_custom'][ $i ],
					'title_color' => $_POST['_movedo_grve_slider_item_title_color'][ $i ],
					'title_color_custom' => $_POST['_movedo_grve_slider_item_title_color_custom'][ $i ],
					'title_tag' => $_POST['_movedo_grve_slider_item_title_tag'][ $i ],
					'caption' => $_POST['_movedo_grve_slider_item_caption'][ $i ],
					'caption_color' => $_POST['_movedo_grve_slider_item_caption_color'][ $i ],
					'caption_color_custom' => $_POST['_movedo_grve_slider_item_caption_color_custom'][ $i ],
					'caption_tag' => $_POST['_movedo_grve_slider_item_caption_tag'][ $i ],
					'subheading' => $_POST['_movedo_grve_slider_item_subheading'][ $i ],
					'subheading_color' => $_POST['_movedo_grve_slider_item_subheading_color'][ $i ],
					'subheading_color_custom' => $_POST['_movedo_grve_slider_item_subheading_color_custom'][ $i ],
					'subheading_tag' => $_POST['_movedo_grve_slider_item_subheading_tag'][ $i ],
					'subheading_family' => $_POST['_movedo_grve_slider_item_subheading_family'][ $i ],
					'title_family' => $_POST['_movedo_grve_slider_item_title_family'][ $i ],
					'caption_family' => $_POST['_movedo_grve_slider_item_caption_family'][ $i ],
					'content_size' => $_POST['_movedo_grve_slider_item_content_size'][ $i ],
					'content_align' => $_POST['_movedo_grve_slider_item_content_align'][ $i ],
					'content_position' => $_POST['_movedo_grve_slider_item_content_position'][ $i ],
					'content_animation' => $_POST['_movedo_grve_slider_item_content_animation'][ $i ],
					'container_size' => $_POST['_movedo_grve_slider_item_container_size'][ $i ],
					'content_image_id' => $_POST['_movedo_grve_slider_item_content_image_id'][ $i ],
					'content_image_size' => $_POST['_movedo_grve_slider_item_content_image_size'][ $i ],
					'content_image_max_height' => $_POST['_movedo_grve_slider_item_content_image_max_height'][ $i ],
					'content_image_responsive_max_height' => $_POST['_movedo_grve_slider_item_content_image_responsive_max_height'][ $i ],
					'pattern_overlay' => $_POST['_movedo_grve_slider_item_pattern_overlay'][ $i ],
					'color_overlay' => $_POST['_movedo_grve_slider_item_color_overlay'][ $i ],
					'color_overlay_custom' => $_POST['_movedo_grve_slider_item_color_overlay_custom'][ $i ],
					'opacity_overlay' => $_POST['_movedo_grve_slider_item_opacity_overlay'][ $i ],
					'gradient_overlay_custom_1' => $_POST['_movedo_grve_slider_item_gradient_overlay_custom_1_opacity'][ $i ],
					'gradient_overlay_custom_1_opacity' => $_POST['_movedo_grve_slider_item_gradient_overlay_custom_1_opacity'][ $i ],
					'gradient_overlay_custom_2' => $_POST['_movedo_grve_slider_item_gradient_overlay_custom_2'][ $i ],
					'gradient_overlay_custom_2_opacity' => $_POST['_movedo_grve_slider_item_gradient_overlay_custom_2_opacity'][ $i ],
					'gradient_overlay_direction' => $_POST['_movedo_grve_slider_item_gradient_overlay_direction'][ $i ],
					'button' => array(
						'id' => $_POST['_movedo_grve_slider_item_button_id'][ $i ],
						'text' => $_POST['_movedo_grve_slider_item_button_text'][ $i ],
						'url' => $_POST['_movedo_grve_slider_item_button_url'][ $i ],
						'target' => $_POST['_movedo_grve_slider_item_button_target'][ $i ],
						'color' => $_POST['_movedo_grve_slider_item_button_color'][ $i ],
						'hover_color' => $_POST['_movedo_grve_slider_item_button_hover_color'][ $i ],
						'gradient_1_color' => $_POST['_movedo_grve_slider_item_button_gradient_1_color'][ $i ],
						'gradient_2_color' => $_POST['_movedo_grve_slider_item_button_gradient_2_color'][ $i ],
						'size' => $_POST['_movedo_grve_slider_item_button_size'][ $i ],
						'shape' => $_POST['_movedo_grve_slider_item_button_shape'][ $i ],
						'shadow' => $_POST['_movedo_grve_slider_item_button_shadow'][ $i ],
						'type' => $_POST['_movedo_grve_slider_item_button_type'][ $i ],
						'class' => $_POST['_movedo_grve_slider_item_button_class'][ $i ],
					),
					'button2' => array(
						'id' => $_POST['_movedo_grve_slider_item_button2_id'][ $i ],
						'text' => $_POST['_movedo_grve_slider_item_button2_text'][ $i ],
						'url' => $_POST['_movedo_grve_slider_item_button2_url'][ $i ],
						'target' => $_POST['_movedo_grve_slider_item_button2_target'][ $i ],
						'color' => $_POST['_movedo_grve_slider_item_button2_color'][ $i ],
						'hover_color' => $_POST['_movedo_grve_slider_item_button2_hover_color'][ $i ],
						'gradient_1_color' => $_POST['_movedo_grve_slider_item_button2_gradient_1_color'][ $i ],
						'gradient_2_color' => $_POST['_movedo_grve_slider_item_button2_gradient_2_color'][ $i ],
						'size' => $_POST['_movedo_grve_slider_item_button2_size'][ $i ],
						'shape' => $_POST['_movedo_grve_slider_item_button2_shape'][ $i ],
						'shadow' => $_POST['_movedo_grve_slider_item_button2_shadow'][ $i ],
						'type' => $_POST['_movedo_grve_slider_item_button2_type'][ $i ],
						'class' => $_POST['_movedo_grve_slider_item_button2_class'][ $i ],
					),
					'arrow_enabled' => $_POST['_movedo_grve_slider_item_arrow_enabled'][ $i ],
					'arrow_color' => $_POST['_movedo_grve_slider_item_arrow_color'][ $i ],
					'arrow_color_custom' => $_POST['_movedo_grve_slider_item_arrow_color_custom'][ $i ],
					'el_class' => $_POST['_movedo_grve_slider_item_el_class'][ $i ],
				);

				$slider_items[] = $slide;
			}

		}



		if( !empty( $slider_items ) ) {
			$feature_section['slider_items'] = $slider_items;

			$feature_section['slider_settings'] = array (
				'slideshow_speed' => $_POST['_movedo_grve_page_slider_settings_speed'],
				'direction_nav' => $_POST['_movedo_grve_page_slider_settings_direction_nav'],
				'slider_pause' => $_POST['_movedo_grve_page_slider_settings_pause'],
				'transition' => $_POST['_movedo_grve_page_slider_settings_transition'],
				'slider_effect' => $_POST['_movedo_grve_page_slider_settings_effect'],
				'pagination' => $_POST['_movedo_grve_page_slider_settings_pagination'],
			);
		}

		//Feature Map Items
		$map_items = array();
		if ( isset( $_POST['_movedo_grve_map_item_point_id'] ) ) {

			$num_of_map_points = sizeof( $_POST['_movedo_grve_map_item_point_id'] );
			for ( $i=0; $i < $num_of_map_points; $i++ ) {

				$this_point = array (
					'id' => $_POST['_movedo_grve_map_item_point_id'][ $i ],
					'lat' => $_POST['_movedo_grve_map_item_point_lat'][ $i ],
					'lng' => $_POST['_movedo_grve_map_item_point_lng'][ $i ],
					'marker' => $_POST['_movedo_grve_map_item_point_marker'][ $i ],
					'title' => $_POST['_movedo_grve_map_item_point_title'][ $i ],
					'info_text' => $_POST['_movedo_grve_map_item_point_infotext'][ $i ],
					'info_text_open' => $_POST['_movedo_grve_map_item_point_infotext_open'][ $i ],
					'button_text' => $_POST['_movedo_grve_map_item_point_button_text'][ $i ],
					'button_url' => $_POST['_movedo_grve_map_item_point_button_url'][ $i ],
					'button_target' => $_POST['_movedo_grve_map_item_point_button_target'][ $i ],
					'button_class' => $_POST['_movedo_grve_map_item_point_button_class'][ $i ],
				);
				$map_items[] =  $this_point;
			}

		}

		if( !empty( $map_items ) ) {

			$feature_section['map_items'] = $map_items;
			$feature_section['map_settings'] = array (
				'zoom' => $_POST['_movedo_grve_page_feature_map_zoom'],
				'marker' => $_POST['_movedo_grve_page_feature_map_marker'],
				'marker_type' => $_POST['_movedo_grve_page_feature_map_marker_type'],
				'marker_bg_color' => $_POST['_movedo_grve_page_feature_map_marker_bg_color'],
				'disable_style' => $_POST['_movedo_grve_page_feature_map_disable_style'],
			);

		}

	}

	//Save Feature Section

	$new_meta_value = $feature_section;
	$meta_key = '_movedo_grve_feature_section';
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	if ( '' != $new_meta_value  && '' == $meta_value ) {
		if ( !add_post_meta( $post_id, $meta_key, $new_meta_value, true ) ) {
			update_post_meta( $post_id, $meta_key, $new_meta_value );
		}
	} elseif ( '' != $new_meta_value && $new_meta_value != $meta_value ) {
		update_post_meta( $post_id, $meta_key, $new_meta_value );
	} elseif ( '' == $new_meta_value && '' != $meta_value ) {
		delete_post_meta( $post_id, $meta_key );
	}

}

//Omit closing PHP tag to avoid accidental whitespace output errors.
