<?php
/** no direct access **/
defined('_MECEXEC_') or die();

/**
 * Webnus MEC single class.
 * @author Webnus <info@webnus.biz>
 */
class MEC_skin_single extends MEC_skins
{
    /**
     * @var string
     */
    public $skin = 'single';

    public $uniqueid;
    public $date_format1;
    
    /**
     * Constructor method
     * @author Webnus <info@webnus.biz>
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Registers skin actions into WordPress
     * @author Webnus <info@webnus.biz>
     */
    public function actions()
    {
        $this->factory->action('wp_ajax_mec_load_single_page', array($this, 'load_single_page'));
        $this->factory->action('wp_ajax_nopriv_mec_load_single_page', array($this, 'load_single_page'));
    }
    
    /**
     * Initialize the skin
     * @author Webnus <info@webnus.biz>
     * @param array $atts
     */
    public function initialize($atts)
    {
        $this->atts = $atts;

        // MEC Settings
        $this->settings = $this->main->get_settings();
        
        // Date Formats
        $this->date_format1 = (isset($this->settings['single_date_format1']) and trim($this->settings['single_date_format1'])) ? $this->settings['single_date_format1'] : 'M d Y';

        // Single Event Layout
        $this->layout = isset($this->atts['layout']) ? $this->atts['layout'] : NULL;
        
        // Search Form Status
        $this->sf_status = false;
        
        // HTML class
        $this->html_class = '';
        if(isset($this->atts['html-class']) and trim($this->atts['html-class']) != '') $this->html_class = $this->atts['html-class'];
        
        // From Widget
        $this->widget = (isset($this->atts['widget']) and trim($this->atts['widget'])) ? true : false;
        
        // Init MEC
        $this->args['mec-skin'] = $this->skin;
        
        $this->id = isset($this->atts['id']) ? $this->atts['id'] : 0;
        $this->uniqueid = mt_rand(1000, 10000);
        $this->maximum_dates = isset($this->atts['maximum_dates']) ? $this->atts['maximum_dates'] : 6;
    }
    
    /**
     * Search and returns the filtered events
     * @author Webnus <info@webnus.biz>
     * @return array of objects
     */
    public function search()
    {
        // Original Event ID for Multilingual Websites
        $original_event_id = $this->main->get_original_event($this->id);

        $events = array();
        $rendered = $this->render->data($this->id, (isset($this->atts['content']) ? $this->atts['content'] : ''));

        // Event Repeat Type
        $repeat_type = $rendered->meta['mec_repeat_type'];

        $occurrence = isset($_GET['occurrence']) ? sanitize_text_field($_GET['occurrence']) : NULL;
        
        if(strtotime($occurrence) and in_array($repeat_type, array('certain_weekdays', 'custom_days'))) $occurrence = date('Y-m-d', strtotime($occurrence));
        elseif(strtotime($occurrence)) $occurrence = date('Y-m-d', strtotime('-1 day', strtotime($occurrence)));
        else $occurrence = NULL;

        $data = new stdClass();
        $data->ID = $this->id;
        $data->data = $rendered;
        $data->dates = $this->render->dates($this->id, $rendered, $this->maximum_dates, $occurrence);
        $data->date = isset($data->dates[0]) ? $data->dates[0] : array();

        // Set some data from original event in multilingual websites
        if($this->id != $original_event_id)
        {
            $original_tickets = get_post_meta($original_event_id, 'mec_tickets', true);

            $rendered_tickets = array();
            foreach($original_tickets as $ticket_id=>$original_ticket)
            {
                if(!isset($data->data->tickets[$ticket_id])) continue;
                $rendered_tickets[$ticket_id] = array(
                    'name' => $data->data->tickets[$ticket_id]['name'],
                    'description' => $data->data->tickets[$ticket_id]['description'],
                    'price' => $original_ticket['price'],
                    'price_label' => $original_ticket['price_label'],
                    'limit' => $original_ticket['limit'],
                    'unlimited' => $original_ticket['unlimited'],
                );
            }

            if(count($rendered_tickets)) $data->data->tickets = $rendered_tickets;
            else $data->data->tickets = $original_tickets;

            $data->ID = $original_event_id;
            $data->dates = $this->render->dates($original_event_id, $rendered, $this->maximum_dates, $occurrence);
            $data->date = isset($data->dates[0]) ? $data->dates[0] : array();
        }

        $events[] = $data;
        return $events;
    }
    
    /**
     * Load Single Event Page for AJAX requert
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function load_single_page()
    {
        $id = isset($_GET['id']) ? sanitize_text_field($_GET['id']) : 0;
        $layout = isset($_GET['layout']) ? sanitize_text_field($_GET['layout']) : 'm1';
        
        // Initialize the skin
        $this->initialize(array('id'=>$id, 'layout'=>$layout));
        
        // Fetch the events
        $this->fetch();
        
        // Return the output
        echo $this->output();
        exit;
    }

    /**
     * @author Webnus <info@webnus.biz>
     * @param string $k
     * @param array $arr
     * @return mixed
     */
    public function found_value($k, $arr)
    {
        $dummy = new Mec_Single_Widget();
        $settings = $dummy->get_settings(); 

        $arr = end($settings);
        $ids = array();

        if(is_array($arr) or is_object($arr))
        {
            foreach($arr as $key=>$value)
            {
                if($key === $k) $ids[] = $value;
            }
        }

        return isset($ids[0]) ? $ids[0] : array();
    }

    /**
     * @param object $event
     * @return void
     */
    public function show_other_organizers($event)
    {
        $additional_organizers_status = (!isset($this->settings['additional_organizers']) or (isset($this->settings['additional_organizers']) and $this->settings['additional_organizers'])) ? true : false;
        if(!$additional_organizers_status) return;

        $organizers = array();
        foreach($event->data->organizers as $o) if($o['id'] != $event->data->meta['mec_organizer_id']) $organizers[] = $o;

        if(!count($organizers)) return;
        ?>
        <div class="mec-single-event-additional-organizers">
            <h3 class="mec-events-single-section-title"><?php echo $this->main->m('other_organizers', __('Other Organizers', 'mec')); ?></h3>
            <?php foreach($organizers as $organizer): if($organizer['id'] == $event->data->meta['mec_organizer_id']) continue; ?>
                <div class="mec-single-event-additional-organizer">
                    <?php if(isset($organizer['thumbnail']) and trim($organizer['thumbnail'])): ?>
                        <img class="mec-img-organizer" src="<?php echo esc_url($organizer['thumbnail']); ?>" alt="<?php echo (isset($organizer['name']) ? $organizer['name'] : ''); ?>">
                    <?php endif; ?>
                    <?php if(isset($organizer['thumbnail'])): ?>
                        <dd class="mec-organizer">
                            <i class="mec-sl-home"></i>
                            <h6><?php echo (isset($organizer['name']) ? $organizer['name'] : ''); ?></h6>
                        </dd>
                    <?php endif;
                    if(isset($organizer['tel']) && !empty($organizer['tel'])): ?>
                        <dd class="mec-organizer-tel">
                            <i class="mec-sl-phone"></i>
                            <h6><?php _e('Phone', 'mec'); ?></h6>
                            <a href="tel:<?php echo $organizer['tel']; ?>"><?php echo $organizer['tel']; ?></a>
                        </dd>
                    <?php endif;
                    if(isset($organizer['email']) && !empty($organizer['email'])): ?>
                        <dd class="mec-organizer-email">
                            <i class="mec-sl-envelope"></i>
                            <h6><?php _e('Email', 'mec'); ?></h6>
                            <a href="mailto:<?php echo $organizer['email']; ?>"><?php echo $organizer['email']; ?></a>
                        </dd>
                    <?php endif;
                    if(isset($organizer['url']) && !empty($organizer['url']) and $organizer['url'] != 'http://'): ?>
                        <dd class="mec-organizer-url">
                            <i class="mec-sl-sitemap"></i>
                            <h6><?php _e('Website', 'mec'); ?></h6>
                            <span><a href="<?php echo (strpos($organizer['url'], 'http') === false ? 'http://'.$organizer['url'] : $organizer['url']); ?>" class="mec-color-hover" target="_blank"><?php echo $organizer['url']; ?></a></span>
                        </dd>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}