<?php
/** no direct access **/
defined('_MECEXEC_') or die('Restricted access');

/**
 * Webnus MEC Widget
 * @author Webnus <info@webnus.biz>
 */
class Mec_Single_Widget extends WP_Widget
{
	/**
     * Unique identifier.
     */
	protected $widget_slug = 'Mec_Single_Widget';

    /**
     * Constructor method
     * @author Webnus <info@webnus.biz>
     */
	public function __construct()
    {
		parent::__construct($this->get_widget_slug(), __('MEC Single Sidebar Items', 'mec'), array('classname' => $this->get_widget_slug().'-class', 'description' => __('To manage event details page elements.', 'mec')));

		// Refreshing the widget's cached output with each new post
		add_action('save_post', array($this, 'flush_widget_cache'));
		add_action('deleted_post', array($this, 'flush_widget_cache'));
		add_action('switch_theme', array($this, 'flush_widget_cache'));
	}

    /**
     * @return string
     */
    public function get_widget_slug()
    {
        return $this->widget_slug;
    }

    /**
     * How to display the widget on the screen.
     * @author Webnus <info@webnus.biz>
     * @param array $args
     * @param array $instance
     */
	public function widget($args, $instance)
    {
        $cache = array();
        if(!$this->is_preview())
        {
            $cache = wp_cache_get('Mec_Single_Widget', 'widget');
        }

        if(!is_array($cache))
        {
            $cache = array();
        }

        if(!isset($args['widget_id']))
        {
            $args['widget_id'] = $this->id;
        }

        if(isset($cache[$args['widget_id']]))
        {
            echo $cache[$args['widget_id']];
            return;
        }
	}

    /**
     * @param array $instance
     * @return void
     */
	public function form($instance)
    {
        $data_time = isset($instance['data_time']) ? esc_attr($instance['data_time']) : '';
        $local_time = isset($instance['local_time']) ? esc_attr($instance['local_time']) : '';
        $event_cost = isset($instance['event_cost']) ? esc_attr($instance['event_cost']) : '';
        $more_info = isset($instance['more_info']) ? esc_attr($instance['more_info']) : '';
        $event_label = isset($instance['event_label']) ? esc_attr($instance['event_label']) : '';
        $event_location = isset($instance['event_location']) ? esc_attr($instance['event_location']) : '';
        $event_categories = isset($instance['event_categories']) ? esc_attr($instance['event_categories']) : '';
        $event_orgnizer = isset($instance['event_orgnizer']) ? esc_attr($instance['event_orgnizer']) : '';
        $register_btn = isset($instance['register_btn']) ? esc_attr($instance['register_btn']) : '';
        $attende_module = isset($instance['attende_module']) ? esc_attr($instance['attende_module']) : '';
        $next_module = isset($instance['next_module']) ? esc_attr($instance['next_module']) : '';
        $links_module = isset($instance['links_module']) ? esc_attr($instance['links_module']) : '';
        $weather = isset($instance['weather_module']) ? esc_attr($instance['weather_module']) : '';
        $google_map = isset($instance['google_map']) ? esc_attr($instance['google_map']) : '';
        $qrcode = isset($instance['qrcode_module']) ? esc_attr($instance['qrcode_module']) : '';
	?>
		<ul class="mec-sortable">
			<li>
				<label for="<?php echo $this->get_field_id( 'data_time' ); ?>"><?php _e( 'Date Time Module : ', 'mec' ); ?></label>
				<input class="checkbox" type="checkbox" <?php checked( $data_time, 'on' ); ?> id="<?php echo $this->get_field_id( 'data_time' ); ?>" name="<?php echo $this->get_field_name( 'data_time' ); ?>" /> 
			</li>
			<li>
				<label for="<?php echo $this->get_field_id( 'local_time' ); ?>"><?php _e( 'Local Time : ', 'mec' ); ?></label>
				<input class="checkbox" type="checkbox" <?php checked( $local_time, 'on' ); ?> id="<?php echo $this->get_field_id( 'local_time' ); ?>" name="<?php echo $this->get_field_name( 'local_time' ); ?>" /> 
			</li>
			<li>
				<label for="<?php echo $this->get_field_id( 'event_cost' ); ?>"><?php _e( 'Event Cost : ', 'mec' ); ?></label>
				<input class="checkbox" type="checkbox" <?php checked( $event_cost, 'on' ); ?> id="<?php echo $this->get_field_id( 'event_cost' ); ?>" name="<?php echo $this->get_field_name( 'event_cost' ); ?>" /> 
			</li>
			<li>
				<label for="<?php echo $this->get_field_id( 'more_info' ); ?>"><?php _e( 'More Info : ', 'mec' ); ?></label>
				<input class="checkbox" type="checkbox" <?php checked( $more_info, 'on' ); ?> id="<?php echo $this->get_field_id( 'more_info' ); ?>" name="<?php echo $this->get_field_name( 'more_info' ); ?>" /> 
			</li>
			<li>
				<label for="<?php echo $this->get_field_id( 'event_label' ); ?>"><?php _e( 'Event Label : ', 'mec' ); ?></label>
				<input class="checkbox" type="checkbox" <?php checked( $event_label, 'on' ); ?> id="<?php echo $this->get_field_id( 'event_label' ); ?>" name="<?php echo $this->get_field_name( 'event_label' ); ?>" /> 
			</li>
			<li>
				<label for="<?php echo $this->get_field_id( 'event_location' ); ?>"><?php _e( 'Event Location : ', 'mec' ); ?></label>
				<input class="checkbox" type="checkbox" <?php checked( $event_location, 'on' ); ?> id="<?php echo $this->get_field_id( 'event_location' ); ?>" name="<?php echo $this->get_field_name( 'event_location' ); ?>" /> 
			</li>
			<li>
				<label for="<?php echo $this->get_field_id( 'event_categories' ); ?>"><?php _e( 'Event Categories : ', 'mec' ); ?></label>
				<input class="checkbox" type="checkbox" <?php checked( $event_categories, 'on' ); ?> id="<?php echo $this->get_field_id( 'event_categories' ); ?>" name="<?php echo $this->get_field_name( 'event_categories' ); ?>" /> 
			</li>
			<li>
				<label for="<?php echo $this->get_field_id( 'event_orgnizer' ); ?>"><?php _e( 'Event Organizer : ', 'mec' ); ?></label>
				<input class="checkbox" type="checkbox" <?php checked( $event_orgnizer, 'on' ); ?> id="<?php echo $this->get_field_id( 'event_orgnizer' ); ?>" name="<?php echo $this->get_field_name( 'event_orgnizer' ); ?>" /> 
			</li>
			<li>
				<label for="<?php echo $this->get_field_id( 'register_btn' ); ?>"><?php _e( 'Register Button : ', 'mec' ); ?></label>
				<input class="checkbox" type="checkbox" <?php checked( $register_btn, 'on' ); ?> id="<?php echo $this->get_field_id( 'register_btn' ); ?>" name="<?php echo $this->get_field_name( 'register_btn' ); ?>" /> 
			</li>
			<li>
				<label for="<?php echo $this->get_field_id( 'attende_module' ); ?>"><?php _e( 'Attendees Module : ', 'mec' ); ?></label>
				<input class="checkbox" type="checkbox" <?php checked( $attende_module, 'on' ); ?> id="<?php echo $this->get_field_id( 'attende_module' ); ?>" name="<?php echo $this->get_field_name( 'attende_module' ); ?>" /> 
			</li>
			<li>
				<label for="<?php echo $this->get_field_id( 'next_module' ); ?>"><?php _e( 'Next Pervious Module : ', 'mec' ); ?></label>
				<input class="checkbox" type="checkbox" <?php checked( $next_module, 'on' ); ?> id="<?php echo $this->get_field_id( 'next_module' ); ?>" name="<?php echo $this->get_field_name( 'next_module' ); ?>" /> 
			</li>
			<li>
				<label for="<?php echo $this->get_field_id( 'links_module' ); ?>"><?php _e( 'Social Module : ', 'mec' ); ?></label>
				<input class="checkbox" type="checkbox" <?php checked( $links_module, 'on' ); ?> id="<?php echo $this->get_field_id( 'links_module' ); ?>" name="<?php echo $this->get_field_name( 'links_module' ); ?>" /> 
			</li>
            <li>
                <label for="<?php echo $this->get_field_id( 'weather_module' ); ?>"><?php _e( 'Weather Module : ', 'mec' ); ?></label>
                <input class="checkbox" type="checkbox" <?php checked( $weather, 'on' ); ?> id="<?php echo $this->get_field_id( 'weather_module' ); ?>" name="<?php echo $this->get_field_name( 'weather_module' ); ?>" />
            </li>
			<li>
				<label for="<?php echo $this->get_field_id( 'google_map' ); ?>"><?php _e( 'Google Map : ', 'mec' ); ?></label>
				<input class="checkbox" type="checkbox" <?php checked( $google_map, 'on' ); ?> id="<?php echo $this->get_field_id( 'google_map' ); ?>" name="<?php echo $this->get_field_name( 'google_map' ); ?>" /> 
			</li>
            <li>
                <label for="<?php echo $this->get_field_id( 'qrcode_module' ); ?>"><?php _e( 'QR Code : ', 'mec' ); ?></label>
                <input class="checkbox" type="checkbox" <?php checked( $qrcode, 'on' ); ?> id="<?php echo $this->get_field_id( 'qrcode_module' ); ?>" name="<?php echo $this->get_field_name( 'qrcode_module' ); ?>" />
            </li>
		</ul>
    <?php
	}
	
	public function flush_widget_cache() 
	{
		wp_cache_delete($this->get_widget_slug(), 'widget');
	}

    /**
     * Update the widget settings.
     * @author Webnus <info@webnus.biz>
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
	public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['data_time'] = strip_tags($new_instance['data_time']);
        $instance['local_time'] = strip_tags($new_instance['local_time']);
        $instance['event_cost'] = strip_tags($new_instance['event_cost']);
        $instance['more_info'] = strip_tags($new_instance['more_info']);
        $instance['event_label'] = strip_tags($new_instance['event_label']);
        $instance['event_location'] = strip_tags($new_instance['event_location']);
        $instance['event_categories'] = strip_tags($new_instance['event_categories']);
        $instance['event_orgnizer'] = strip_tags($new_instance['event_orgnizer']);
        $instance['register_btn'] = strip_tags($new_instance['register_btn']);
        $instance['attende_module'] = strip_tags($new_instance['attende_module']);
        $instance['next_module'] = strip_tags($new_instance['next_module']);
        $instance['links_module'] = strip_tags($new_instance['links_module']);
        $instance['weather_module'] = strip_tags($new_instance['weather_module']);
        $instance['google_map'] = strip_tags($new_instance['google_map']);
        $instance['qrcode_module'] = strip_tags($new_instance['qrcode_module']);

        $this->flush_widget_cache();

        $alloptions = wp_cache_get('alloptions', 'options');
        if(isset($alloptions['Mec_Single_Widget'])) delete_option('Mec_Single_Widget');

        return $instance;
	}
}