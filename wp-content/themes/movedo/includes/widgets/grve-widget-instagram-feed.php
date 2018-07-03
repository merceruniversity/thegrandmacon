<?php
/**
 * Plugin Name: Greatives Instagram Feed
 * Description: A widget that displays latest posts.
 * @author		Greatives Team
 * @URI			http://greatives.eu
 */

add_action( 'widgets_init', 'movedo_grve_widget_instagram_feed' );

function movedo_grve_widget_instagram_feed() {
	register_widget( 'Movedo_GRVE_Widget_Instagram_Feed' );
}

class Movedo_GRVE_Widget_Instagram_Feed extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname' => 'grve-instagram-feed',
			'description' => esc_html__( 'A widget that displays instagram feed', 'movedo'),
		);
		$control_ops = array(
			'width' => 300,
			'height' => 400,
			'id_base' => 'grve-widget-instagram-feed',
		);
		parent::__construct( 'grve-widget-instagram-feed', '(Greatives) ' . esc_html__( 'Instagram Feed', 'movedo' ), $widget_ops, $control_ops );
	}

	function Movedo_GRVE_Widget_Instagram_Feed() {
		$this->__construct();
	}

	function widget( $args, $instance ) {

		//Our variables from the widget settings.
		extract( $args );

		$username = $instance['username'];
		$limit = $instance['limit'];
		$order_by = $instance['order_by'];
		$order = $instance['order'];
		$target = $instance['target'];
		$cache = $instance['cache'];

		$access_token = $instance['access_token'];
		$user_id = $instance['user_id'];

		if( !isset( $cache ) ) {
			$cache = '';
		}

		if( empty( $limit ) ) {
			$limit = 9;
		}

		echo $before_widget; // XSS OK

		// Display the widget title
		$title = apply_filters( 'widget_title', $instance['title'] );
		if ( $title ) {
			echo $before_title . esc_html( $title ) . $after_title; // XSS OK
		}

		if ( !empty( $username ) ) {

			$media_array = movedo_grve_get_instagram_array( $username, $limit, $order_by, $order, $cache, $access_token, $user_id  );
			$output = '';

			if ( is_wp_error( $media_array ) ) {

			   echo wp_kses_post( $media_array->get_error_message() );

			} else {

			?>
				<ul class="grve-instagram-images">
			<?php
				foreach ($media_array as $item) {
			?>
					<li>
						<div class="grve-item-wrapper">
							<div class="grve-bg-wrapper grve-small-square">
								<div class="grve-bg-image" style="background-image: url(<?php echo esc_url( $item['thumbnail']['url'] ); ?>);"></div>
							</div>
							<a href="<?php echo esc_url( $item['link'] ); ?>" target="<?php echo esc_attr( $target ); ?>"></a>
							<img width="150" height="150" src="<?php echo esc_url( $item['thumbnail']['url'] ); ?>"  alt="<?php echo esc_attr( $item['description'] ); ?>" title="<?php echo esc_attr( $item['description'] ); ?>"/>
						</div>
					</li>
			<?php
				}
			?>
				</ul>
			<?php
			}
		}

		echo $after_widget; // XSS OK
	}

	//Update the widget

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['limit'] = strip_tags( $new_instance['limit'] );
		$instance['order_by'] = strip_tags( $new_instance['order_by'] );
		$instance['order'] = strip_tags( $new_instance['order'] );
		$instance['target'] = strip_tags( $new_instance['target'] );
		$instance['cache'] = strip_tags( $new_instance['cache'] );
		$instance['access_token'] = strip_tags( $new_instance['access_token'] );
		$instance['user_id'] = strip_tags( $new_instance['user_id'] );

		return $instance;
	}


	function form( $instance ) {

		//Set up some default widget settings.
		$defaults = array(
			'title' => '',
			'username' => '',
			'limit' => '9',
			'order_by' => 'none',
			'order' => 'ASC',
			'target' => '_blank',
			'cache' => '1',
			'access_token' => '',
			'user_id' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr($instance['title']);
		$limit = absint($instance['limit']);
		$order_by = esc_attr($instance['order_by']);
		$order = esc_attr($instance['order']);
		$target = esc_attr($instance['target']);
		$cache = esc_attr($instance['cache']);

		$access_token = $instance['access_token'];
		$user_id = $instance['user_id'];
		$username = $instance['username'];
		$access_token_url = "https://greatives.eu/instagram-feed/";

		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'access_token' ) ); ?>"><?php esc_html_e( 'Access Token:', 'movedo' ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'access_token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'access_token' ) ); ?>" value="<?php echo esc_attr( $access_token ); ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'user_id' ) ); ?>"><?php esc_html_e( 'User ID:', 'movedo' ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'user_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'user_id' ) ); ?>" value="<?php echo esc_attr( $user_id ); ?>" style="width:100%;" />
		</p>
		<p>
			<a href="<?php echo esc_url( $access_token_url ); ?>" target="_blank"><?php esc_html_e( 'Get Access Token and User ID', 'movedo' ); ?></a>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e( 'Username:', 'movedo' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" value="<?php echo esc_attr( $username ); ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'movedo' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php echo esc_html__( 'Number of Images:', 'movedo' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" value="<?php echo esc_attr( $limit ); ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'order_by' ) ); ?>"><?php echo esc_html__( 'Order By:', 'movedo' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id('order_by') ); ?>" name="<?php echo esc_attr( $this->get_field_name('order_by') ); ?>" style="width:100%;">
				<option value="none" <?php selected('none', $order_by) ?>><?php esc_html_e( 'None', 'movedo' ); ?></option>
				<option value="datetime" <?php selected('datetime', $order_by) ?>><?php esc_html_e( 'Recent', 'movedo' ); ?></option>
				<option value="likes" <?php selected('likes', $order_by) ?>><?php esc_html_e( 'Likes', 'movedo' ); ?></option>
				<option value="comments" <?php selected('comments', $order_by) ?>><?php esc_html_e( 'Comments', 'movedo' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php echo esc_html__( 'Order:', 'movedo' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id('order') ); ?>" name="<?php echo esc_attr( $this->get_field_name('order') ); ?>" style="width:100%;">
				<option value="ASC" <?php selected('ASC', $order) ?>><?php esc_html_e( 'Ascending', 'movedo' ); ?></option>
				<option value="DESC" <?php selected('DESC', $order) ?>><?php esc_html_e( 'Descending', 'movedo' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php echo esc_html__( 'Link Target:', 'movedo' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id('target') ); ?>" name="<?php echo esc_attr( $this->get_field_name('target') ); ?>" style="width:100%;">
				<option value="_self" <?php selected('_self', $target) ?>><?php esc_html_e( 'Same Page', 'movedo' ); ?></option>
				<option value="_blank" <?php selected('_blank', $target) ?>><?php esc_html_e( 'New Page', 'movedo' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cache' ) ); ?>"><?php echo esc_html__( 'Caching:', 'movedo' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id('cache') ); ?>" name="<?php echo esc_attr( $this->get_field_name('cache') ); ?>" type="checkbox" value="1" <?php checked( $cache, 1 ); ?> />
		</p>
		<p>
			<em><?php echo esc_html__( 'Note: Uncheck caching if you want to test your configuration. It is recommended to leave caching enabled to increase performance. Caching timeout is 60 minutes.', 'movedo' ); ?></em>
		</p>

	<?php
	}
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
