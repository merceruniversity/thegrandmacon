<?php
/**
 * Plugin Name: Greatives Banner
 * Description: A widget that displays an image banner.
 * @author		Greatives Team
 * @URI			http://greatives.eu
 */

add_action( 'widgets_init', 'movedo_grve_widget_image_banner' );

function movedo_grve_widget_image_banner() {
	register_widget( 'Movedo_GRVE_Widget_Image_Banner' );
}

class Movedo_GRVE_Widget_Image_Banner extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname' => 'grve-image-banner',
			'description' => esc_html__( 'A widget that displays an image banner', 'movedo'),
		);
		$control_ops = array(
			'width' => 300,
			'height' => 400,
			'id_base' => 'grve-widget-image-banner',
		);
		parent::__construct( 'grve-widget-image-banner', '(Greatives) ' . esc_html__( 'Image Banner', 'movedo' ), $widget_ops, $control_ops );
	}

	function Movedo_GRVE_Widget_Image_Banner() {
		$this->__construct();
	}

	function widget( $args, $instance ) {

		//Our variables from the widget settings.
		extract( $args );

		$image = ! empty( $instance['image'] ) ? $instance['image'] : '';
		$widget_text = ! empty( $instance['text'] ) ? $instance['text'] : '';

		$link_url = ! empty( $instance['link_url'] ) ? $instance['link_url'] : '';
		$target = ! empty( $instance['target'] ) ? $instance['target'] : '_self';
		$align = ! empty( $instance['align'] ) ? $instance['align'] : 'left';
		$image_full = ! empty( $instance['image_full'] ) ? $instance['image_full'] : 'no';
		$image_shape = ! empty( $instance['image_shape'] ) ? $instance['image_shape'] : 'square';

		echo $before_widget; // XSS OK

		// Display the widget title
		$title = apply_filters( 'widget_title', $instance['title'] );
		$text = apply_filters( 'widget_text', $widget_text, $instance, $this );
		$alt = "Banner Image";

		if ( $title ) {
			echo $before_title . esc_html( $title ) . $after_title; // XSS OK
			$alt = $title;
		}

		echo '<div class="grve-align-' . esc_attr( $align) . '">';

		if ( !empty( $image ) ) {
			$image_url = str_replace( array( 'http:', 'https:' ), '', $image );

			$image_wrapper_classes = array( 'grve-media' );
			if ( 'yes' == $image_full ) {
				$image_wrapper_classes[] = 'grve-full-image';
			}
			if ( 'square' != $image_shape ) {
				$image_wrapper_classes[] = 'grve-' . $image_shape ;
			}
			$image_wrapper_class_string = implode( ' ', $image_wrapper_classes );


		?>
			<div class="<?php echo esc_attr( $image_wrapper_class_string); ?>">
				<?php if( !empty( $link_url ) ) { ?>
				<a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $target ); ?>">
				<?php } ?>
					<img src="<?php echo esc_url( $image_url ) ; ?>" alt="<?php echo esc_attr( $alt ); ?>" title="<?php echo esc_attr( $title ); ?>"/>
				<?php if( !empty( $link_url ) ) { ?>
				</a>
				<?php } ?>
			</div>
		<?php
		}
		if ( !empty( $text ) ) {
		?>
			<div class="grve-image-banner-content"><?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></div>
		<?php
		}
		echo '</div>';
		echo $after_widget; // XSS OK
	}

	//Update the widget

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['image'] = strip_tags( $new_instance['image'] );
		$instance['link_url'] = strip_tags( $new_instance['link_url'] );
		$instance['target'] = strip_tags( $new_instance['target'] );
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text'] = $new_instance['text'];
		} else {
			$instance['text'] = wp_kses_post( $new_instance['text'] );
		}
		$instance['filter'] = ! empty( $new_instance['filter'] );
		$instance['align'] = strip_tags( $new_instance['align'] );
		$instance['image_full'] = strip_tags( $new_instance['image_full'] );
		$instance['image_shape'] = strip_tags( $new_instance['image_shape'] );

		return $instance;
	}


	function form( $instance ) {

		//Set up some default widget settings.
		$defaults = array(
			'title' => '',
			'image' => '',
			'text' => '',
			'link_url' => '',
			'target' => '_self',
			'filter' => '0',
			'align' => 'left',
			'image_full' => 'no',
			'image_shape' => 'square',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$image_shape = movedo_grve_array_value( $instance, 'image_shape');
		$image_full = movedo_grve_array_value( $instance, 'image_full');
		$filter = movedo_grve_array_value( $instance, 'filter');
		?>


		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'movedo' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php echo esc_html__( 'Image URL:', 'movedo' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" type="text" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" value="<?php echo esc_attr( $instance['image'] ); ?>" style="width:100%;"/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_full' ) ); ?>"><?php echo esc_html__( 'Image Fullwidth:', 'movedo' ); ?></label>
			<select  name="<?php echo esc_attr( $this->get_field_name( 'image_full' ) ); ?>" style="width:100%;">
				<option value="no" <?php selected( "no", $image_full ); ?>><?php echo esc_html__( 'No', 'movedo' ); ?></option>
				<option value="yes" <?php selected( "yes", $image_full ); ?>><?php echo esc_html__( 'Yes', 'movedo' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_shape' ) ); ?>"><?php echo esc_html__( 'Image Shape (Image Fullwidth only):', 'movedo' ); ?></label>
			<select  name="<?php echo esc_attr( $this->get_field_name( 'image_shape' ) ); ?>" style="width:100%;">
				<option value="square" <?php selected( "square", $image_shape ); ?>><?php echo esc_html__( 'Square', 'movedo' ); ?></option>
				<option value="extra-round" <?php selected( "extra-round", $image_shape ); ?>><?php echo esc_html__( 'Round', 'movedo' ); ?></option>
				<option value="circle" <?php selected( "circle", $image_shape ); ?>><?php echo esc_html__( 'Circle', 'movedo' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'link_url' ) ); ?>"><?php echo esc_html__( 'Link URL:', 'movedo' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'link_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link_url' ) ); ?>" value="<?php echo esc_attr( $instance['link_url'] ); ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php echo esc_html__( 'Link Target:', 'movedo' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id('target') ); ?>" name="<?php echo esc_attr( $this->get_field_name('target') ); ?>" style="width:100%;">
				<option value="_self" <?php selected('_self', $instance['target']) ?>><?php esc_html_e( 'Same Page', 'movedo' ); ?></option>
				<option value="_blank" <?php selected('_blank', $instance['target']) ?>><?php esc_html_e( 'New Page', 'movedo' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'align' ) ); ?>"><?php echo esc_html__( 'Alignment:', 'movedo' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id('align') ); ?>" name="<?php echo esc_attr( $this->get_field_name('align') ); ?>" style="width:100%;">
				<option value="left" <?php selected('left', $instance['align']) ?>><?php esc_html_e( 'Left', 'movedo' ); ?></option>
				<option value="center" <?php selected('center', $instance['align']) ?>><?php esc_html_e( 'Center', 'movedo' ); ?></option>
				<option value="right" <?php selected('right', $instance['align']) ?>><?php esc_html_e( 'Right', 'movedo' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php echo esc_html__( 'Content:', 'movedo'  ); ?></label>
			<textarea class="widefat" rows="16" cols="20" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"><?php echo esc_textarea( $instance['text'] ); ?></textarea>
		</p>
		<p>
			<input id="<?php echo esc_attr( $this->get_field_id('filter') ); ?>" name="<?php echo esc_attr( $this->get_field_name('filter') ); ?>" type="checkbox"<?php checked( $filter ); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id('filter') ); ?>"><?php esc_html_e( 'Automatically add paragraphs', 'movedo' ); ?></label>
		</p>
	<?php
	}
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
