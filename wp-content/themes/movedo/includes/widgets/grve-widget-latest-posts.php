<?php
/**
 * Plugin Name: Greatives Latest Posts
 * Description: A widget that displays latest posts.
 * @author		Greatives Team
 * @URI			http://greatives.eu
 */

add_action( 'widgets_init', 'movedo_grve_widget_latest_posts' );

function movedo_grve_widget_latest_posts() {
	register_widget( 'Movedo_GRVE_Widget_Latest_Posts' );
}

class Movedo_GRVE_Widget_Latest_Posts extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname' => 'grve-latest-news',
			'description' => esc_html__( 'A widget that displays latest posts', 'movedo'),
		);
		$control_ops = array(
			'width' => 300,
			'height' => 400,
			'id_base' => 'grve-widget-latest-posts',
		);
		parent::__construct( 'grve-widget-latest-posts', '(Greatives) ' . esc_html__( 'Latest Posts', 'movedo' ), $widget_ops, $control_ops );
	}

	function Movedo_GRVE_Widget_Latest_Posts() {
		$this->__construct();
	}

	function widget( $args, $instance ) {

		//Our variables from the widget settings.
		extract( $args );

		$show_image = $instance['show_image'];
		$num_of_posts = $instance['num_of_posts'];
		$categories = movedo_grve_array_value( $instance, 'categories' );
		if( empty( $num_of_posts ) ) {
			$num_of_posts = 5;
		}

		echo $before_widget; // XSS OK

		// Display the widget title
		$title = apply_filters( 'widget_title', $instance['title'] );
		if ( $title ) {
			echo $before_title . esc_html( $title ) . $after_title; // XSS OK
		}

		$args = array(
			'post_type' => 'post',
			'post_status'=>'publish',
			'paged' => 1,
			'cat' => $categories,
			'posts_per_page' => $num_of_posts,
		);
		//Loop posts
		$query = new WP_Query( $args );

		if ( $query->have_posts() ) :
		?>
			<ul>
		<?php

		$movedo_grve_empty_image_url = get_template_directory_uri() . '/images/empty/thumbnail.jpg';

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

				<li <?php post_class(); ?>>
					<?php if( $show_image && '1' == $show_image ) { ?>
						<a href="<?php echo esc_url( $movedo_grve_link ); ?>" target="<?php echo esc_attr( $movedo_grve_target ); ?>" title="<?php the_title_attribute(); ?>" class="grve-post-thumb">
						<?php if ( has_post_thumbnail() ) { ?>
							<div class="grve-bg-wrapper grve-small-square">
								<?php movedo_grve_print_post_bg_image( 'thumbnail' ); ?>
							</div>
							<?php the_post_thumbnail( 'thumbnail' ); ?>
						<?php } else { ?>
							<img width="80" height="80" src="<?php echo esc_url( $movedo_grve_empty_image_url ); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
						<?php } ?>
						</a>
					<?php } ?>
					<div class="grve-news-content">
						<a href="<?php echo esc_url( $movedo_grve_link ); ?>" target="<?php echo esc_attr( $movedo_grve_target ); ?>" class="grve-title" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						<?php if ( movedo_grve_visibility( 'blog_date_visibility', '1' ) ) { ?>
						<div class="grve-latest-news-date"><?php echo esc_html( get_the_date() ); ?></div>
						<?php } ?>
					</div>
				</li>

		<?php
		endwhile;
		?>
			</ul>
		<?php
		else :
		?>
				<?php echo esc_html__( 'No Posts Found!', 'movedo' ); ?>
		<?php
		endif;

		wp_reset_postdata();

		echo $after_widget; // XSS OK
	}

	//Update the widget

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['num_of_posts'] = strip_tags( $new_instance['num_of_posts'] );
		$instance['show_image'] = strip_tags( $new_instance['show_image'] );
		$instance['categories'] = implode(',',$new_instance['categories']);

		return $instance;
	}


	function form( $instance ) {

		//Set up some default widget settings.
		$defaults = array(
			'title' => '',
			'num_of_posts' => '5',
			'show_image' => '0',
			'categories' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>


		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'movedo' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'num_of_posts' ) ); ?>"><?php echo esc_html__( 'Number of Posts:', 'movedo' ); ?></label>
			<select  name="<?php echo esc_attr( $this->get_field_name( 'num_of_posts' ) ); ?>" style="width:100%;">
				<?php
				for ( $i = 1; $i <= 20; $i++ ) {
				?>
				    <option value="<?php echo esc_attr( $i ); ?>" <?php selected( $instance['num_of_posts'], $i ); ?>><?php echo esc_html( $i ); ?></option>
				<?php
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_image' ) ); ?>"><?php echo esc_html__( 'Show Featured Image:', 'movedo' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id('show_image') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_image') ); ?>" type="checkbox" value="1" <?php checked( $instance['show_image'], 1 ); ?> />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'categories' ) ); ?>"><?php echo esc_html__( 'Categories:', 'movedo' ) ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'categories' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'categories' ) ); ?>[]" multiple="multiple" style="width:100%;">
				<option value=""><?php echo esc_html__( 'Choose Categories ...', 'movedo' ) ?></option>
			<?php
				$categories = get_terms( 'category' );
				foreach ( $categories as $category ) {
					$selected = '';
					$cats = explode( ',', $instance['categories'] );
					foreach ( $cats as $cat ) {
						if ( $cat == $category->term_id ){
							$selected = $cat;
							break;
						}
					}
				?>
				<option value="<?php echo esc_attr( $category->term_id ); ?>" <?php selected( $category->term_id  ,$selected ); ?> >
					<?php echo esc_html( $category->name ); ?>
				</option>
			<?php
				}
			?>
			</select>
		</p>

	<?php
	}
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
