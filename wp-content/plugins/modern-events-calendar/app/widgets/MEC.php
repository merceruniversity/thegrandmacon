<?php
/** no direct access **/
defined('_MECEXEC_') or die('Restricted access');

/**
 * Webnus MEC Widget
 * @author Webnus <info@webnus.biz>
 */
class MEC_MEC_widget extends WP_Widget
{
    /**
     * Constructor method
     * @author Webnus <info@webnus.biz>
     */
    public function __construct()
    {
        // MEC Render Class
        $this->render = MEC::getInstance('app.libraries.render');
        
        // MEC Main Class
        $this->main = MEC::getInstance('app.libraries.main');
        
        parent::__construct('MEC_MEC_widget', __('Modern Events Calendar', 'mec'), array('description'=>__('Show events based on created shortcodes.', 'mec')));
    }

    /**
     * How to display the widget on the screen.
     * @author Webnus <info@webnus.biz>
     */
    public function widget($args, $instance)
    {
        // Inclue OWL Assets. It's needee if Widget is set to load grid view
        $this->main->load_owl_assets();

        // Before Widget
        echo (isset($args['before_widget']) ? $args['before_widget'] : '');
        
        // Print the widget title
        if(!empty($instance['title']))
        {
			echo (isset($args['before_title']) ? $args['before_title'] : '').apply_filters('widget_title', $instance['title']).(isset($args['after_title']) ? $args['after_title'] : '');
		}
        
        $calendar_id = isset($instance['calendar_id']) ? $instance['calendar_id'] : 0;
        $atts = array('html-class'=>'mec-widget', 'style'=>'classic', 'widget'=>true);
        
        // Print the skin output
        echo $this->render->widget($calendar_id, $atts);
        
        // After Widget
        echo (isset($args['after_widget']) ? $args['after_widget'] : '');
    }

    /**
     * Displays the widget settings controls on the widget panel.
     * @author Webnus <info@webnus.biz>
     */
    public function form($instance)
    {
        $calendars = get_posts(array('post_type'=>'mec_calendars', 'posts_per_page'=>'-1', 'meta_query'=>array(array('key'=>'skin', 'value'=>array('list', 'grid', 'monthly_view'), 'compare'=>'IN'))));
        
        echo '<p class="mec-widget-row-container">'
        .'<label for="'.$this->get_field_id('title').'">'.__('Title:', 'mec').'</label>'
        .'<input class="widefat" type="text" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" value="'.(isset($instance['title']) ? $instance['title'] : '').'" />'
        .'</p>';
        
        if(count($calendars))
        {
            echo '<p class="mec-widget-row-container">'
                .'<label for="'.$this->get_field_id('calendar_id').'">'.__('Shortcode:', 'mec').'</label>'
                .'<select class="widefat" name="'.$this->get_field_name('calendar_id').'" id="'.$this->get_field_id('calendar_id').'"><option value="">-----</option>';
            
            foreach($calendars as $calendar) echo '<option value="'.$calendar->ID.'"'.((isset($instance['calendar_id']) and $instance['calendar_id'] == $calendar->ID) ? ' selected="selected"' : '').'>'.$calendar->post_title.'</option>';
            
            echo '</select>'
                .'</p>';
        }
        else
        {
            echo '<p class="mec-widget-row-container"><a href="'.$this->main->add_qs_var('post_type', 'mec_calendars', $this->main->URL('admin').'edit.php').'">'.__('Create some calendars first.').'</a></p>';
        }
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
        $instance = array();
        $instance['title'] = $new_instance['title'];
        $instance['calendar_id'] = $new_instance['calendar_id'];
        
        return $instance;
    }
}