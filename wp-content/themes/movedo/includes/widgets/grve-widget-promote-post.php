<?php
/**
 * Plugin Name: Greatives Promote Post
 * Description: A widget that displays a promote post.
 * @author		Greatives Team
 * @URI			http://greatives.eu
 */

add_action( 'widgets_init', 'movedo_grve_widget_promote_post' );

function movedo_grve_widget_promote_post() {
	register_widget( 'Movedo_GRVE_Widget_Promote_Post' );
}

class Movedo_GRVE_Widget_Promote_Post extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname' => 'grve-promote-post',
			'description' => esc_html__( 'A widget that displays a promote post', 'movedo'),
		);
		$control_ops = array(
			'width' => 300,
			'height' => 400,
			'id_base' => 'grve-widget-promote-post',
		);
		parent::__construct( 'grve-widget-promote-post', '(Greatives) ' . esc_html__( 'Promote Post', 'movedo' ), $widget_ops, $control_ops );
	}

	function Movedo_GRVE_Widget_Promote_Post() {
		$this->__construct();
	}

	function widget( $args, $instance ) {

		//Our variables from the widget settings.
		extract( $args );

		$promote_post_id = $instance['promote_post_id'];
		$promote_image_size = ! empty( $instance['promote_image_size'] ) ? $instance['promote_image_size'] : 'landscape';

		echo $before_widget; // XSS OK

		// Display the widget title
		$title = apply_filters( 'widget_title', $instance['title'] );
		if ( $title ) {
			echo $before_title . esc_html( $title ) . $after_title; // XSS OK
		}

		if (strpos($promote_post_id, ',') === false) {
			$promote_post_id = array( $promote_post_id );
		} else {
			$promote_post_id = explode(',', $promote_post_id);
		}

		$args = array(
			'post_type' => 'post',
			'post_status'=> 'publish',
			'post__in' => $promote_post_id,
			'paged' => 1,
			'posts_per_page' => 1,
		);
		//Loop posts
		$query = new WP_Query( $args );

		if ( $query->have_posts() ) :

		$image_size = movedo_grve_get_image_size( $promote_image_size );

		$movedo_grve_empty_image_url = get_template_directory_uri() . '/images/transparent/' . $image_size . '.png';

		while ( $query->have_posts() ) : $query->the_post();

			$movedo_grve_link = get_permalink();
			$movedo_grve_target = '_self';

			if ( 'link' == get_post_format() ) {
				$movedo_grve_link = get_post_meta( get_the_ID(), '_movedo_grve_post_link_url', true );
				$new_window = get_post_meta( get_the_ID(), '_movedo_grve_post_link_new_window', true );
				if( empty( $movedo_grve_link ) ) {
					$movedo_grve_link = get_permalink();
				}

				if( !empty( $new_window ) ) {
					$movedo_grve_target = '_blank';
				}
			}

		?>
			<a href="<?php echo esc_url( $movedo_grve_link ); ?>" target="<?php echo esc_attr( $movedo_grve_target ); ?>" title="<?php the_title_attribute(); ?>">
				<div class="grve-media grve-image-hover grve-gradient-overlay">
					<?php if ( has_post_thumbnail() ) { ?>
						<?php the_post_thumbnail( $image_size ); ?>
					<?php } else { ?>
						<img width="80" height="80" src="<?php echo esc_url( $movedo_grve_empty_image_url ); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
					<?php } ?>
					<div class="grve-promote-content">
						<div class="grve-promote-date grve-small-text"><?php echo esc_html( get_the_date() ); ?></div>
						<div class="grve-title grve-link-text"><?php the_title(); ?></div>
					</div>
					<div class="grve-post-meta-wrapper">
						<ul class="grve-post-meta">
							<li class="grve-small-text grve-post-author"><i class="grve-icon-user"></i>
								<span><?php echo get_the_author(); ?></span>
							</li>
							<li class="grve-small-text grve-post-comments"><i class="grve-icon-comment"></i>
								<span><?php comments_number( '0' , '1', '%' ); ?></span>
							</li>
							<?php movedo_grve_print_like_counter(); ?>
						</ul>
					</div>
				</div>
			</a>

		<?php
		endwhile;
		else :
		endif;

		wp_reset_postdata();

		echo $after_widget; // XSS OK
	}

	//Update the widget

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['promote_post_id'] = strip_tags( $new_instance['promote_post_id'] );
		$instance['promote_image_size'] = strip_tags( $new_instance['promote_image_size'] );

		return $instance;
	}


	function form( $instance ) {

		//Set up some default widget settings.
		$defaults = array(
			'title' => '',
			'promote_post_id' => '',
			'promote_image_size' => 'landscape',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>


		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'movedo' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'promote_post_id' ) ); ?>"><?php echo esc_html__( 'Post ID:', 'movedo' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'promote_post_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'promote_post_id' ) ); ?>" value="<?php echo esc_attr( $instance['promote_post_id'] ); ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'promote_image_size' ) ); ?>"><?php echo esc_html__( 'Image Size:', 'movedo' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id('promote_image_size') ); ?>" name="<?php echo esc_attr( $this->get_field_name('promote_image_size') ); ?>" style="width:100%;">
				<option value="landscape" <?php selected('landscape', $instance['promote_image_size'] ); ?>><?php esc_html_e( 'Landscape Small Crop', 'movedo' ); ?></option>
				<option value="portrait" <?php selected('portrait', $instance['promote_image_size'] ); ?>><?php esc_html_e( 'Portrait Small Crop', 'movedo' ); ?></option>
				<option value="square" <?php selected('square', $instance['promote_image_size'] ); ?>><?php esc_html_e( 'Square Small Crop', 'movedo' ); ?></option>
				<option value="large" <?php selected('large', $instance['promote_image_size'] ); ?>><?php esc_html_e( 'Resize ( Large )', 'movedo' ); ?></option>
				<option value="medium_large" <?php selected('medium_large', $instance['promote_image_size'] ); ?>><?php esc_html_e( 'Resize ( Medium Large )', 'movedo' ); ?></option>
				<option value="medium" <?php selected('medium', $instance['promote_image_size'] ); ?>><?php esc_html_e( 'Resize ( Medium )', 'movedo' ); ?></option>
			</select>
		</p>

	<?php
	}
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
