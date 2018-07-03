<?php
/*
*	Greatives Portfolio Items
*
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/

	add_action( 'add_meta_boxes', 'movedo_grve_portfolio_options_add_custom_boxes' );
	add_action( 'save_post', 'movedo_grve_portfolio_options_save_postdata', 10, 2 );

	$movedo_grve_portfolio_options = array (
		//Media
		array(
			'name' => 'Media Selection',
			'id' => '_movedo_grve_portfolio_media_selection',
		),
		array(
			'name' => 'Media Fullwidth',
			'id' => '_movedo_grve_portfolio_media_fullwidth',
		),
		array(
			'name' => 'Media Margin Bottom',
			'id' => '_movedo_grve_portfolio_media_margin_bottom',
		),
		array(
			'name' => 'Media Image Mode',
			'id' => '_movedo_grve_portfolio_media_image_mode',
		),
		array(
			'name' => 'Media Image Link Mode',
			'id' => '_movedo_grve_portfolio_media_image_link_mode',
		),
		array(
			'name' => 'Masonry Size',
			'id' => '_movedo_grve_portfolio_media_masonry_size',
		),
		array(
			'name' => 'Video webm format',
			'id' => '_movedo_grve_portfolio_video_webm',
		),
		array(
			'name' => 'Video mp4 format',
			'id' => '_movedo_grve_portfolio_video_mp4',
		),
		array(
			'name' => 'Video ogv format',
			'id' => '_movedo_grve_portfolio_video_ogv',
		),
		array(
			'name' => 'Video Poster',
			'id' => '_movedo_grve_portfolio_video_poster',
		),
		array(
			'name' => 'Video embed Vimeo/Youtube',
			'id' => '_movedo_grve_portfolio_video_embed',
		),
		array(
			'name' => 'Video code',
			'id' => '_movedo_grve_portfolio_video_code',
		),

		//Link Mode
		array(
			'name' => 'Link Mode',
			'id' => '_movedo_grve_portfolio_link_mode',
		),
		array(
			'name' => 'Link URL',
			'id' => '_movedo_grve_portfolio_link_url',
		),
		array(
			'name' => 'Open Link in a new window',
			'id' => '_movedo_grve_portfolio_link_new_window',
		),
		array(
			'name' => 'Link Extra Class',
			'id' => '_movedo_grve_portfolio_link_extra_class',
		),
		//Overview Mode
		array(
			'name' => 'Custom Overview Mode',
			'id' => '_movedo_grve_portfolio_overview_mode',
		),
		array(
			'name' => 'Overview Color',
			'id' => '_movedo_grve_portfolio_overview_color',
		),
		array(
			'name' => 'Overview Background Color',
			'id' => '_movedo_grve_portfolio_overview_bg_color',
		),
		array(
			'name' => 'Overview custom text',
			'id' => '_movedo_grve_portfolio_overview_text',
		),
		array(
			'name' => 'Overview custom text size',
			'id' => '_movedo_grve_portfolio_overview_text_heading',
		),
		array(
			'name' => 'Second Featured Image',
			'id' => '_movedo_grve_second_featured_image',
		),

	);

	function movedo_grve_portfolio_options_add_custom_boxes() {

		if ( function_exists( 'vc_is_inline' ) && vc_is_inline() ) {
			return;
		}

		add_meta_box(
			'portfolio_link_mode',
			esc_html__( 'Portfolio Link Options', 'movedo' ),
			'movedo_grve_portfolio_link_mode_box',
			'portfolio'
		);
		add_meta_box(
			'portfolio_overview_mode',
			esc_html__( 'Portfolio Overview Options', 'movedo' ),
			'movedo_grve_portfolio_overview_mode_box',
			'portfolio'
		);
		add_meta_box(
			'portfolio_media_section',
			esc_html__( 'Portfolio Media', 'movedo' ),
			'movedo_grve_portfolio_media_section_box',
			'portfolio'
		);
		add_meta_box(
			'portfolio_second_featured_image',
			esc_html__( 'Second Featured Image', 'movedo' ),
			'movedo_grve_second_featured_image_section_box',
			'portfolio',
			'side',
			'low'
		);

	}

	function movedo_grve_second_featured_image_section_box( $post ) {

		$second_featured_image = get_post_meta( $post->ID, '_movedo_grve_second_featured_image', true );

	?>

		<div id="grve-second-featured-image-wrapper">
	<?php

		movedo_grve_print_admin_option(
			array(
				'type' => 'select-image',
				'name' => '_movedo_grve_second_featured_image',
				'value' => $second_featured_image,
				'label' => array(
					"desc" => esc_html__( 'Set Second Fetured Image', 'movedo' ),
				),
				'width' => 'fullwidth',
				'wrap_class' => 'grve-metabox-side',
			)
		);
	?>
		</div>
	<?php
	}

	function movedo_grve_portfolio_link_mode_box( $post ) {

		$link_mode = get_post_meta( $post->ID, '_movedo_grve_portfolio_link_mode', true );
		$link_url = get_post_meta( $post->ID, '_movedo_grve_portfolio_link_url', true );
		$new_window = get_post_meta( $post->ID, '_movedo_grve_portfolio_link_new_window', true );
		$link_class = get_post_meta( $post->ID, '_movedo_grve_portfolio_link_extra_class', true );

		wp_nonce_field( 'movedo_grve_nonce_portfolio_save', '_movedo_grve_nonce_portfolio_save' );

	?>
		<table class="form-table grve-metabox">
			<tbody>
				<tr>
					<td colspan="2">
						<p class="howto"><?php esc_html_e( 'Select link mode for Portfolio Overview (Used in Portfolio Element Link Type: Custom Link).', 'movedo' ); ?></p>
					</td>
				</tr>
			</tbody>
		</table>

		<div id="grve-portfolio-custom-overview">
	<?php

		movedo_grve_print_admin_option(
			array(
				'type' => 'select',
				'name' => '_movedo_grve_portfolio_link_mode',
				'id' => 'grve-portfolio-link-mode',
				'options' => array(
					'' => esc_html__( 'Portfolio Item', 'movedo' ),
					'link' => esc_html__( 'Custom Link', 'movedo' ),
					'none' => esc_html__( 'None', 'movedo' ),
				),
				'value' => $link_mode,
				'default_value' => '',
				'label' => array(
					'title' => esc_html__( 'Link Mode', 'movedo' ),
					'desc' => esc_html__( 'Select Link Mode', 'movedo' ),
				),
				'group_id' => 'grve-portfolio-custom-overview',
				'highlight' => 'highlight',
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'textfield',
				'name' => '_movedo_grve_portfolio_link_url',
				'value' => $link_url,
				'label' => array(
					'title' => esc_html__( 'Link URL', 'movedo' ),
					'desc' => esc_html__( 'Enter the full URL of your link.', 'movedo' ),
				),
				'width' => 'fullwidth',
				'dependency' =>
				'[
					{ "id" : "grve-portfolio-link-mode", "values" : ["link"] }
				]',
			)
		);
		movedo_grve_print_admin_option(
			array(
				'type' => 'checkbox',
				'name' => '_movedo_grve_portfolio_link_new_window',
				'value' => $new_window ,
				'label' => array(
					'title' => esc_html__( 'Open Link in new window', 'movedo' ),
					'desc' => esc_html__( 'If selected, link will open in a new window.', 'movedo' ),
				),
				'dependency' =>
				'[
					{ "id" : "grve-portfolio-link-mode", "values" : ["link"] }
				]',
			)
		);
		movedo_grve_print_admin_option(
			array(
				'type' => 'textfield',
				'name' => '_movedo_grve_portfolio_link_extra_class',
				'value' => $link_class,
				'label' => array(
					'title' => esc_html__( 'Link extra class name', 'movedo' ),
				),
				'dependency' =>
				'[
					{ "id" : "grve-portfolio-link-mode", "values" : ["link"] }
				]',
			)
		);
	?>
		</div>
	<?php
	}

	function movedo_grve_portfolio_overview_mode_box( $post ) {

		$overview_mode = get_post_meta( $post->ID, '_movedo_grve_portfolio_overview_mode', true );
		$overview_color = get_post_meta( $post->ID, '_movedo_grve_portfolio_overview_color', true );
		$overview_bg_color = get_post_meta( $post->ID, '_movedo_grve_portfolio_overview_bg_color', true );
		$overview_text = get_post_meta( $post->ID, '_movedo_grve_portfolio_overview_text', true );
		$overview_text_heading = get_post_meta( $post->ID, '_movedo_grve_portfolio_overview_text_heading', true );


		wp_nonce_field( 'movedo_grve_nonce_portfolio_save', '_movedo_grve_nonce_portfolio_save' );

	?>
		<table class="form-table grve-metabox">
			<tbody>
				<tr>
					<td colspan="2">
						<p class="howto"><?php esc_html_e( 'Select overview mode for Portfolio Overview (Used in Portfolio Element Overview Type: Custom Overview).', 'movedo' ); ?></p>
					</td>
				</tr>
			</tbody>
		</table>

		<div id="grve-portfolio-custom-overview">
	<?php
		global $movedo_grve_button_color_selection;

		movedo_grve_print_admin_option(
			array(
				'type' => 'select',
				'name' => '_movedo_grve_portfolio_overview_mode',
				'id' => 'grve-portfolio-overview-mode',
				'options' => array(
					'' => esc_html__( 'Featured Image', 'movedo' ),
					'color' => esc_html__( 'Color', 'movedo' ),
				),
				'value' => $overview_mode,
				'default_value' => '',
				'label' => esc_html__( 'Overview Mode', 'movedo' ),
				'group_id' => 'grve-portfolio-custom-overview',
				'highlight' => 'highlight',
			)
		);
		movedo_grve_print_admin_option(
			array(
				'type' => 'select',
				'name' => '_movedo_grve_portfolio_overview_bg_color',
				'options' => $movedo_grve_button_color_selection,
				'value' => $overview_bg_color,
				'default_value' => 'primary-1',
				'label' => esc_html__( 'Background color', 'movedo' ),
				'dependency' =>
				'[
					{ "id" : "grve-portfolio-overview-mode", "values" : ["color"] }
				]',
			)
		);
		movedo_grve_print_admin_option(
			array(
				'type' => 'select',
				'name' => '_movedo_grve_portfolio_overview_color',
				'options' => $movedo_grve_button_color_selection,
				'value' => $overview_color,
				'default_value' => 'black',
				'label' => esc_html__( 'Text Color', 'movedo' ),
				'dependency' =>
				'[
					{ "id" : "grve-portfolio-overview-mode", "values" : ["color"] }
				]',
			)
		);
		movedo_grve_print_admin_option(
			array(
				'type' => 'textarea',
				'name' => '_movedo_grve_portfolio_overview_text',
				'value' => $overview_text,
				'label' => array(
					'title' => esc_html__( 'Custom Text', 'movedo' ),
					'desc' => esc_html__( 'If entered, this text will replace default title and description.', 'movedo' ),
				),
				'width' => 'fullwidth',
				'dependency' =>
				'[
					{ "id" : "grve-portfolio-overview-mode", "values" : ["color"] }
				]',
			)
		);

		movedo_grve_print_admin_option(
			array(
				'type' => 'select',
				'name' => '_movedo_grve_portfolio_overview_text_heading',
				'options' => array(
					'h2'  => 'h2',
					'h3'  => 'h3',
					'h4'  => 'h4',
					'h5'  => 'h5',
					'h6'  => 'h6',
					'leader-text' => esc_html__( 'Leader Text', 'movedo' ),
					'subtitle-text' => esc_html__( 'Subtitle Text', 'movedo' ),
					'small-text' => esc_html__( 'Small Text', 'movedo' ),
					'link-text' => esc_html__( 'Link Text', 'movedo' ),
				),
				'value' => $overview_text_heading,
				'default_value' => 'h3',
				'label' => array(
					'title' => esc_html__( 'Custom Text size', 'movedo' ),
					'desc' => esc_html__( 'Custom Text size and typography', 'movedo' ),
				),
				'dependency' =>
				'[
					{ "id" : "grve-portfolio-overview-mode", "values" : ["color"] }
				]',
			)
		);
	?>
		</div>
	<?php
	}

	function movedo_grve_portfolio_media_section_box( $post ) {

		wp_nonce_field( 'movedo_grve_nonce_portfolio_save', 'grve_portfolio_media_save_nonce' );

		$portfolio_masonry_size = get_post_meta( $post->ID, '_movedo_grve_portfolio_media_masonry_size', true );
		$portfolio_media = get_post_meta( $post->ID, '_movedo_grve_portfolio_media_selection', true );
		$portfolio_media_fullwidth = get_post_meta( $post->ID, '_movedo_grve_portfolio_media_fullwidth', true );
		$portfolio_media_margin_bottom = get_post_meta( $post->ID, '_movedo_grve_portfolio_media_margin_bottom', true );

		$portfolio_image_mode = get_post_meta( $post->ID, '_movedo_grve_portfolio_media_image_mode', true );
		$portfolio_image_link_mode = get_post_meta( $post->ID, '_movedo_grve_portfolio_media_image_link_mode', true );

		$grve_portfolio_video_webm = get_post_meta( $post->ID, '_movedo_grve_portfolio_video_webm', true );
		$grve_portfolio_video_mp4 = get_post_meta( $post->ID, '_movedo_grve_portfolio_video_mp4', true );
		$grve_portfolio_video_ogv = get_post_meta( $post->ID, '_movedo_grve_portfolio_video_ogv', true );
		$grve_portfolio_video_poster = get_post_meta( $post->ID, '_movedo_grve_portfolio_video_poster', true );
		$grve_portfolio_video_embed = get_post_meta( $post->ID, '_movedo_grve_portfolio_video_embed', true );
		$grve_portfolio_video_code = get_post_meta( $post->ID, '_movedo_grve_portfolio_video_code', true );

		$media_slider_items = get_post_meta( $post->ID, '_movedo_grve_portfolio_slider_items', true );
		$media_slider_settings = get_post_meta( $post->ID, '_movedo_grve_portfolio_slider_settings', true );
		$media_slider_speed = movedo_grve_array_value( $media_slider_settings, 'slideshow_speed', '3500' );
		$media_slider_dir_nav = movedo_grve_array_value( $media_slider_settings, 'direction_nav', '1' );
		$media_slider_dir_nav_color = movedo_grve_array_value( $media_slider_settings, 'direction_nav_color', 'dark' );

	?>
			<table class="form-table grve-metabox">
				<tbody>
					<tr>
						<th>
							<label for="grve-portfolio-media-masonry-size">
								<strong><?php esc_html_e( 'Masonry Size', 'movedo' ); ?></strong>
								<span>
									<?php esc_html_e( 'Select your masonry image size.', 'movedo' ); ?>
									<br/>
									<strong><?php esc_html_e( 'Used in Portfolio Element with style Masonry.', 'movedo' ); ?></strong>
								</span>
							</label>
						</th>
						<td>
							<select id="grve-portfolio-media-masonry-size" name="_movedo_grve_portfolio_media_masonry_size">
								<option value="square" <?php selected( 'square', $portfolio_masonry_size ); ?>><?php esc_html_e( 'Square', 'movedo' ); ?></option>
								<option value="landscape" <?php selected( 'landscape', $portfolio_masonry_size ); ?>><?php esc_html_e( 'Landscape', 'movedo' ); ?></option>
								<option value="portrait" <?php selected( 'portrait', $portfolio_masonry_size ); ?>><?php esc_html_e( 'Portrait', 'movedo' ); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<th>
							<label for="grve-portfolio-media-selection">
								<strong><?php esc_html_e( 'Media Selection', 'movedo' ); ?></strong>
								<span>
									<?php esc_html_e( 'Choose your portfolio media.', 'movedo' ); ?>
									<br/>
									<strong><?php esc_html_e( 'In overview only Featured Image is displayed.', 'movedo' ); ?></strong>
								</span>
							</label>
						</th>
						<td>
							<select id="grve-portfolio-media-selection" name="_movedo_grve_portfolio_media_selection">
								<option value="" <?php selected( '', $portfolio_media ); ?>><?php esc_html_e( 'Featured Image', 'movedo' ); ?></option>
								<option value="second-image" <?php selected( 'second-image', $portfolio_media ); ?>><?php esc_html_e( 'Second Featured Image', 'movedo' ); ?></option>
								<option value="gallery" <?php selected( 'gallery', $portfolio_media ); ?>><?php esc_html_e( 'Classic Gallery', 'movedo' ); ?></option>
								<option value="gallery-vertical" <?php selected( 'gallery-vertical', $portfolio_media ); ?>><?php esc_html_e( 'Vertical Gallery', 'movedo' ); ?></option>
								<option value="slider" <?php selected( 'slider', $portfolio_media ); ?>><?php esc_html_e( 'Slider', 'movedo' ); ?></option>
								<option value="video" <?php selected( 'video', $portfolio_media ); ?>><?php esc_html_e( 'YouTube/Vimeo Video', 'movedo' ); ?></option>
								<option value="video-html5" <?php selected( 'video-html5', $portfolio_media ); ?>><?php esc_html_e( 'HMTL5 Video', 'movedo' ); ?></option>
								<option value="video-code" <?php selected( 'video-code', $portfolio_media ); ?>><?php esc_html_e( 'Embed Video', 'movedo' ); ?></option>
								<option value="none" <?php selected( 'none', $portfolio_media ); ?>><?php esc_html_e( 'None', 'movedo' ); ?></option>
							</select>
						</td>
					</tr>
					<tr class="grve-portfolio-media-item grve-portfolio-media-fullwidth"<?php if ( "none" == $portfolio_media ) { ?> style="display:none;" <?php } ?>>
						<th>
							<label for="grve-portfolio-media-fullwidth">
								<strong><?php esc_html_e( 'Media Fullwidth', 'movedo' ); ?></strong>
								<span>
									<?php esc_html_e( 'Select if you want fullwidth media.', 'movedo' ); ?>
								</span>
							</label>
						</th>
						<td>
							<select id="grve-portfolio-media-fullwidth" name="_movedo_grve_portfolio_media_fullwidth">
								<option value="no" <?php selected( 'no', $portfolio_media_fullwidth ); ?>><?php esc_html_e( 'No', 'movedo' ); ?></option>
								<option value="yes" <?php selected( 'yes', $portfolio_media_fullwidth ); ?>><?php esc_html_e( 'Yes', 'movedo' ); ?></option>
							</select>
						</td>
					</tr>
					<tr class="grve-portfolio-media-item grve-portfolio-media-margin-bottom"<?php if ( "none" == $portfolio_media ) { ?> style="display:none;" <?php } ?>>
						<th>
							<label for="grve-portfolio-media-margin-bottom">
								<strong><?php esc_html_e( 'Margin Bottom', 'movedo' ); ?></strong>
								<span>
									<?php esc_html_e( 'Define the space below the portfolio media.', 'movedo' ); ?> <?php esc_html_e( 'You can use px, em, %, etc. or enter just number and it will use pixels.', 'movedo' ); ?>
								</span>
							</label>
						</th>
						<td>
							<input type="text" id="grve-portfolio-media-margin-bottom" name="_movedo_grve_portfolio_media_margin_bottom" value="<?php echo esc_attr( $portfolio_media_margin_bottom ); ?>" />
						</td>
					</tr>
					<tr class="grve-portfolio-media-item grve-portfolio-video-html5"<?php if ( "video-html5" != $portfolio_media ) { ?> style="display:none;" <?php } ?>>
						<th>
							<label for="grve-portfolio-video-webm">
								<strong><?php esc_html_e( 'WebM File URL', 'movedo' ); ?></strong>
								<span>
									<?php esc_html_e( 'Upload the .webm video file.', 'movedo' ); ?>
									<br/>
									<strong><?php esc_html_e( 'This Format must be included for HTML5 Video.', 'movedo' ); ?></strong>
								</span>
							</label>
						</th>
						<td>
							<input type="text" id="grve-portfolio-video-webm" class="grve-upload-simple-media-field grve-meta-text" name="_movedo_grve_portfolio_video_webm" value="<?php echo esc_attr( $grve_portfolio_video_webm ); ?>"/>
							<input type="button" data-media-type="video" class="grve-upload-simple-media-button button" value="<?php esc_attr_e( 'Upload Media', 'movedo' ); ?>"/>
							<input type="button" class="grve-remove-simple-media-button button" value="<?php esc_attr_e( 'Remove', 'movedo' ); ?>"/>
						</td>
					</tr>
					<tr class="grve-portfolio-media-item grve-portfolio-video-html5"<?php if ( "video-html5" != $portfolio_media ) { ?> style="display:none;" <?php } ?>>
						<th>
							<label for="grve-portfolio-video-mp4">
								<strong><?php esc_html_e( 'MP4 File URL', 'movedo' ); ?></strong>
								<span>
									<?php esc_html_e( 'Upload the .mp4 video file.', 'movedo' ); ?>
									<br/>
									<strong><?php esc_html_e( 'This Format must be included for HTML5 Video.', 'movedo' ); ?></strong>
								</span>
							</label>
						</th>
						<td>
							<input type="text" id="grve-portfolio-video-mp4" class="grve-upload-simple-media-field grve-meta-text" name="_movedo_grve_portfolio_video_mp4" value="<?php echo esc_attr( $grve_portfolio_video_mp4 ); ?>"/>
							<input type="button" data-media-type="video" class="grve-upload-simple-media-button button" value="<?php esc_attr_e( 'Upload Media', 'movedo' ); ?>"/>
							<input type="button" class="grve-remove-simple-media-button button" value="<?php esc_attr_e( 'Remove', 'movedo' ); ?>"/>
						</td>
					</tr>
					<tr class="grve-portfolio-media-item grve-portfolio-video-html5"<?php if ( "video-html5" != $portfolio_media ) { ?> style="display:none;" <?php } ?>>
						<th>
							<label for="grve-portfolio-video-ogv">
								<strong><?php esc_html_e( 'OGV File URL', 'movedo' ); ?></strong>
								<span>
									<?php esc_html_e( 'Upload the .ogv video file (optional).', 'movedo' ); ?>
								</span>
							</label>
						</th>
						<td>
							<input type="text" id="grve-portfolio-video-ogv" class="grve-upload-simple-media-field grve-meta-text" name="_movedo_grve_portfolio_video_ogv" value="<?php echo esc_attr( $grve_portfolio_video_ogv ); ?>"/>
							<input type="button" data-media-type="video" class="grve-upload-simple-media-button button" value="<?php esc_attr_e( 'Upload Media', 'movedo' ); ?>"/>
							<input type="button" class="grve-remove-simple-media-button button" value="<?php esc_attr_e( 'Remove', 'movedo' ); ?>"/>
						</td>
					</tr>
					<tr class="grve-portfolio-media-item grve-portfolio-video-html5"<?php if ( "video-html5" != $portfolio_media ) { ?> style="display:none;" <?php } ?>>
						<th>
							<label for="grve-portfolio-video-poster">
								<strong><?php esc_html_e( 'Poster Image', 'movedo' ); ?></strong>
								<span>
									<?php esc_html_e( 'Use same resolution as video.', 'movedo' ); ?>
								</span>
							</label>
						</th>
						<td>
							<input type="text" id="grve-portfolio-video-poster" class="grve-upload-simple-media-field grve-meta-text" name="_movedo_grve_portfolio_video_poster" value="<?php echo esc_attr( $grve_portfolio_video_poster ); ?>"/>
							<input type="button" data-media-type="image" class="grve-upload-simple-media-button button" value="<?php esc_attr_e( 'Upload Media', 'movedo' ); ?>"/>
							<input type="button" class="grve-remove-simple-media-button button" value="<?php esc_attr_e( 'Remove', 'movedo' ); ?>"/>
						</td>
					</tr>
					<tr class="grve-portfolio-media-item grve-portfolio-video-embed"<?php if ( "video" != $portfolio_media ) { ?> style="display:none;" <?php } ?>>
						<th>
							<label for="grve-portfolio-video-embed">
								<strong><?php esc_html_e( 'Vimeo/YouTube URL', 'movedo' ); ?></strong>
								<span>
									<?php esc_html_e( 'Enter the full URL of your video from Vimeo or YouTube.', 'movedo' ); ?>
								</span>
							</label>
						</th>
						<td>
							<input type="text" id="grve-portfolio-video-embed" class="grve-meta-text" name="_movedo_grve_portfolio_video_embed" value="<?php echo esc_attr( $grve_portfolio_video_embed ); ?>"/>
						</td>
					</tr>
					<tr class="grve-portfolio-media-item grve-portfolio-video-code"<?php if ( "video-code" != $portfolio_media ) { ?> style="display:none;" <?php } ?>>
						<th>
							<label for="grve-portfolio-video-code">
								<strong><?php esc_html_e( 'Video Embed', 'movedo' ); ?></strong>
								<span>
									<?php esc_html_e( 'Enter the embed code of your video.', 'movedo' ); ?>
								</span>
							</label>
						</th>
						<td>
							<textarea id="grve-portfolio-video-code" name="_movedo_grve_portfolio_video_code" cols="40" rows="5"><?php echo esc_textarea( $grve_portfolio_video_code ); ?></textarea>
						</td>
					</tr>
					<tr class="grve-portfolio-media-item grve-portfolio-media-image-mode"<?php if ( "slider" != $portfolio_media || "gallery-vertical" != $portfolio_media ) { ?> style="display:none;" <?php } ?>>
						<th>
							<label for="grve-portfolio-media-image-mode">
								<strong><?php esc_html_e( 'Image Mode', 'movedo' ); ?></strong>
								<span>
									<?php esc_html_e( 'Select image mode.', 'movedo' ); ?>
								</span>
							</label>
						</th>
						<td>
							<select id="grve-portfolio-media-image-mode" name="_movedo_grve_portfolio_media_image_mode">
								<option value="" <?php selected( '', $portfolio_image_mode ); ?>><?php esc_html_e( 'Auto Crop', 'movedo' ); ?></option>
								<option value="resize" <?php selected( 'resize', $portfolio_image_mode ); ?>><?php esc_html_e( 'Resize', 'movedo' ); ?></option>
							</select>
						</td>
					</tr>
					<tr class="grve-portfolio-media-item grve-portfolio-media-image-link-mode"<?php if ( "gallery" != $portfolio_media || "gallery-vertical" != $portfolio_media ) { ?> style="display:none;" <?php } ?>>
						<th>
							<label for="grve-portfolio-media-image-link-mode">
								<strong><?php esc_html_e( 'Image Link Mode', 'movedo' ); ?></strong>
								<span>
									<?php esc_html_e( 'Select image link mode.', 'movedo' ); ?>
								</span>
							</label>
						</th>
						<td>
							<select id="grve-portfolio-media-image-link-mode" name="_movedo_grve_portfolio_media_image_link_mode">
								<option value="" <?php selected( '', $portfolio_image_link_mode ); ?>><?php esc_html_e( 'Popup', 'movedo' ); ?></option>
								<option value="none" <?php selected( 'none', $portfolio_image_link_mode ); ?>><?php esc_html_e( 'None', 'movedo' ); ?></option>
							</select>
						</td>
					</tr>
					<tr id="grve-portfolio-media-slider-speed" class="grve-portfolio-media-item" <?php if ( "slider" != $portfolio_media ) { ?> style="display:none;" <?php } ?>>
						<th>
							<label for="grve-page-slider-speed">
								<strong><?php esc_html_e( 'Slideshow Speed', 'movedo' ); ?></strong>
							</label>
						</th>
						<td>
							<input type="text" id="grve-page-slider-speed" name="_movedo_grve_portfolio_slider_settings_speed" value="<?php echo esc_attr( $media_slider_speed ); ?>" /> ms
						</td>
					</tr>
					<tr id="grve-portfolio-media-slider-direction-nav" class="grve-portfolio-media-item" <?php if ( "slider" != $portfolio_media ) { ?> style="display:none;" <?php } ?>>
						<th>
							<label for="grve-page-slider-direction-nav">
								<strong><?php esc_html_e( 'Navigation Buttons', 'movedo' ); ?></strong>
							</label>
						</th>
						<td>
							<select id="grve-page-slider-direction-nav" name="_movedo_grve_portfolio_slider_settings_direction_nav">
								<option value="1" <?php selected( "1", $media_slider_dir_nav ); ?>><?php esc_html_e( 'Style 1', 'movedo' ); ?></option>
								<option value="0" <?php selected( "0", $media_slider_dir_nav ); ?>><?php esc_html_e( 'No Navigation', 'movedo' ); ?></option>
							</select>
						</td>
					</tr>
					<tr id="grve-portfolio-media-slider-direction-nav-color" class="grve-portfolio-media-item" <?php if ( "slider" != $portfolio_media ) { ?> style="display:none;" <?php } ?>>
						<th>
							<label for="grve-page-slider-direction-nav-color">
								<strong><?php esc_html_e( 'Navigation Buttons Color', 'movedo' ); ?></strong>
							</label>
						</th>
						<td>
							<select id="grve-page-slider-direction-nav-color" name="_movedo_grve_portfolio_slider_settings_direction_nav_color">
								<option value="dark" <?php selected( "dark", $media_slider_dir_nav_color ); ?>><?php esc_html_e( 'Dark', 'movedo' ); ?></option>
								<option value="light" <?php selected( "light", $media_slider_dir_nav_color ); ?>><?php esc_html_e( 'Light', 'movedo' ); ?></option>
							</select>
						</td>
					</tr>
					<tr id="grve-portfolio-media-slider" class="grve-portfolio-media-item" <?php if ( "" == $portfolio_media || "none" == $portfolio_media ) { ?> style="display:none;" <?php } ?>>
						<th>
							<label><?php esc_html_e( 'Media Items', 'movedo' ); ?></label>
						</th>
						<td>
							<input type="button" class="grve-upload-slider-button button-primary" value="<?php esc_attr_e( 'Insert Images', 'movedo' ); ?>"/>
							<span id="grve-upload-slider-button-spinner" class="grve-action-spinner"></span>
						</td>
					</tr>
				</tbody>
			</table>
			<div id="grve-slider-container" data-mode="minimal" class="grve-portfolio-media-item" <?php if ( "" == $portfolio_media || "none" == $portfolio_media ) { ?> style="display:none;" <?php } ?>>
				<?php
					if( !empty( $media_slider_items ) ) {
						movedo_grve_print_admin_media_slider_items( $media_slider_items );
					}
				?>
			</div>


	<?php
	}

	function movedo_grve_portfolio_options_save_postdata( $post_id , $post ) {
		global $movedo_grve_portfolio_options;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! isset( $_POST['_movedo_grve_nonce_portfolio_save'] ) || !wp_verify_nonce( $_POST['_movedo_grve_nonce_portfolio_save'], 'movedo_grve_nonce_portfolio_save' ) ) {
			return;
		}

		// Check permissions
		if ( 'portfolio' == $_POST['post_type'] )
		{
			if ( !current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		}

		foreach ( $movedo_grve_portfolio_options as $value ) {
			$new_meta_value = ( isset( $_POST[$value['id']] ) ? $_POST[$value['id']] : '' );
			$meta_key = $value['id'];


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

		if ( isset( $_POST['grve_portfolio_media_save_nonce'] ) && wp_verify_nonce( $_POST['grve_portfolio_media_save_nonce'], 'movedo_grve_nonce_portfolio_save' ) ) {


			//Media Slider Items
			$media_slider_items = array();
			if ( isset( $_POST['_movedo_grve_media_slider_item_id'] ) ) {

				$num_of_images = sizeof( $_POST['_movedo_grve_media_slider_item_id'] );
				for ( $i=0; $i < $num_of_images; $i++ ) {

					$this_image = array (
						'id' => $_POST['_movedo_grve_media_slider_item_id'][ $i ],
					);
					array_push( $media_slider_items, $this_image );
				}

			}

			if( empty( $media_slider_items ) ) {
				delete_post_meta( $post->ID, '_movedo_grve_portfolio_slider_items' );
				delete_post_meta( $post->ID, '_movedo_grve_portfolio_slider_settings' );
			} else{
				update_post_meta( $post->ID, '_movedo_grve_portfolio_slider_items', $media_slider_items );

				$media_slider_speed = 3500;
				$media_slider_direction_nav = '1';
				$media_slider_direction_nav_color = 'dark';
				if ( isset( $_POST['_movedo_grve_portfolio_slider_settings_speed'] ) ) {
					$media_slider_speed = $_POST['_movedo_grve_portfolio_slider_settings_speed'];
				}
				if ( isset( $_POST['_movedo_grve_portfolio_slider_settings_direction_nav'] ) ) {
					$media_slider_direction_nav = $_POST['_movedo_grve_portfolio_slider_settings_direction_nav'];
				}
				if ( isset( $_POST['_movedo_grve_portfolio_slider_settings_direction_nav_color'] ) ) {
					$media_slider_direction_nav_color = $_POST['_movedo_grve_portfolio_slider_settings_direction_nav_color'];
				}

				$media_slider_settings = array (
					'slideshow_speed' => $media_slider_speed,
					'direction_nav' => $media_slider_direction_nav,
					'direction_nav_color' => $media_slider_direction_nav_color,
				);
				update_post_meta( $post->ID, '_movedo_grve_portfolio_slider_settings', $media_slider_settings );
			}

		}

	}

//Omit closing PHP tag to avoid accidental whitespace output errors.
