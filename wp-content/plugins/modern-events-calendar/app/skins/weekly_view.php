<?php
/** no direct access **/
defined('_MECEXEC_') or die();

/**
 * Webnus MEC Weekly view class.
 * @author Webnus <info@webnus.biz>
 */
class MEC_skin_weekly_view extends MEC_skins
{
    /**
     * @var string
     */
    public $skin = 'weekly_view';
    
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
        $this->factory->action('wp_ajax_mec_weekly_view_load_month', array($this, 'load_month'));
        $this->factory->action('wp_ajax_nopriv_mec_weekly_view_load_month', array($this, 'load_month'));
    }
    
    /**
     * Initialize the skin
     * @author Webnus <info@webnus.biz>
     * @param array $atts
     */
    public function initialize($atts)
    {
        $this->atts = $atts;
        
        // Skin Options
        $this->skin_options = (isset($this->atts['sk-options']) and isset($this->atts['sk-options'][$this->skin])) ? $this->atts['sk-options'][$this->skin] : array();
        
        // Search Form Options
        $this->sf_options = (isset($this->atts['sf-options']) and isset($this->atts['sf-options'][$this->skin])) ? $this->atts['sf-options'][$this->skin] : array();
        
        // Search Form Status
        $this->sf_status = isset($this->atts['sf_status']) ? $this->atts['sf_status'] : true;
        
        // Generate an ID for the skin
        $this->id = isset($this->atts['id']) ? $this->atts['id'] : mt_rand(100, 999);
        
        // Set the ID
        if(!isset($this->atts['id'])) $this->atts['id'] = $this->id;
        
        // Next/Previous Month
        $this->next_previous_button = isset($this->skin_options['next_previous_button']) ? $this->skin_options['next_previous_button'] : true;
        
        // HTML class
        $this->html_class = '';
        if(isset($this->atts['html-class']) and trim($this->atts['html-class']) != '') $this->html_class = $this->atts['html-class'];
        
        // SED Method
        $this->sed_method = isset($this->skin_options['sed_method']) ? $this->skin_options['sed_method'] : '0';
        
        // From Widget
        $this->widget = (isset($this->atts['widget']) and trim($this->atts['widget'])) ? true : false;
        
        // Init MEC
        $this->args['mec-init'] = true;
        $this->args['mec-skin'] = $this->skin;
        
        // Post Type
        $this->args['post_type'] = $this->main->get_main_post_type();

        // Post Status
        $this->args['post_status'] = 'publish';
        
        // Keyword Query
        $this->args['s'] = $this->keyword_query();
        
        // Taxonomy
        $this->args['tax_query'] = $this->tax_query();
        
        // Meta
        $this->args['meta_query'] = $this->meta_query();
        
        // Tag
        $this->args['tag'] = $this->tag_query();
        
        // Author
        $this->args['author'] = $this->author_query();
        
        // Pagination Options
        $this->paged = get_query_var('paged', 1);
        $this->limit = (isset($this->skin_options['limit']) and trim($this->skin_options['limit'])) ? $this->skin_options['limit'] : 12;
        
        $this->args['posts_per_page'] = $this->limit;
        $this->args['paged'] = $this->paged;
        
        // Sort Options
        $this->args['orderby'] = 'meta_value_num';
        $this->args['order'] = 'ASC';
        $this->args['meta_key'] = 'mec_start_day_seconds';

        // Show Only Expired Events
        $this->show_only_expired_events = (isset($this->atts['show_only_past_events']) and trim($this->atts['show_only_past_events'])) ? '1' : '0';

        // Show Past Events
        if($this->show_only_expired_events) $this->atts['show_past_events'] = '1';

        // Show Past Events
        $this->args['mec-past-events'] = isset($this->atts['show_past_events']) ? $this->atts['show_past_events'] : '0';
        
        // Start Date
        list($this->year, $this->month, $this->day) = $this->get_start_date();
        
        $this->today = $this->year.'-'.$this->month.'-'.$this->day;
        $this->start_date = $this->year.'-'.$this->month.'-01';
        
        // Set the maximum date in current month
        if($this->show_only_expired_events) $this->maximum_date = date('Y-m-d', strtotime('Yesterday'));
        
        // We will extend the end date in the loop
        $this->end_date = $this->start_date;
        
        $this->weeks = $this->main->split_to_weeks($this->start_date, date('Y-m-t', strtotime($this->start_date)));
        
        $this->week_of_days = array();
        foreach($this->weeks as $week_number=>$week) foreach($week as $day) $this->week_of_days[$day] = $week_number;
    }
    
    /**
     * Search and returns the filtered events
     * @author Webnus <info@webnus.biz>
     * @return array of objects
     */
    public function search()
    {
        $i = 0;
        $today = $this->start_date;
        $events = array();
        
        while(date('m', strtotime($today)) == $this->month)
        {
            $this->setToday($today);
            
            // Check Finish Date
            if(isset($this->maximum_date) and strtotime($today) > strtotime($this->maximum_date)) break;
            
            // Extending the end date
            $this->end_date = $today;
            
            // Limit
            $this->args['posts_per_page'] = $this->limit;
            
            // The Query
            $query = new WP_Query($this->args);
            
            if($query->have_posts())
            {
                // The Loop
                while($query->have_posts())
                {
                    $query->the_post();
                    
                    if(!isset($events[$today])) $events[$today] = array();
                    
                    $rendered = $this->render->data(get_the_ID());
                    
                    $data = new stdClass();
                    $data->ID = get_the_ID();
                    $data->data = $rendered;
                    
                    $data->date = array
                    (
                        'start'=>array('date'=>$today),
                        'end'=>array('date'=>$this->main->get_end_date($today, $rendered))
                    );
                    
                    $events[$today][] = $data;
                }
            }
            else
            {
                $events[$today] = array();
            }
            
            // Restore original Post Data
            wp_reset_postdata();
            
            $i++;
            $today = date('Y-m-d', strtotime('+'.$i.' Days', strtotime($this->start_date)));
        }
        
        return $events;
    }
    
    /**
     * Returns start day of skin for filtering events
     * @author Webnus <info@webnus.biz>
     * @return array
     */
    public function get_start_date()
    {
        // Default date
        $date = current_time('Y-m-d');
        
        // Weekdays
        $weekdays = $this->main->get_weekday_labels();
        
        if(isset($this->skin_options['start_date_type']) and $this->skin_options['start_date_type'] == 'start_current_week')
        {
            if(date('w') == $this->main->get_first_day_of_week()) $date = date('Y-m-d', strtotime('This '.$weekdays[0]));
            else $date = date('Y-m-d', strtotime('Last '.$weekdays[0]));
        }
        elseif(isset($this->skin_options['start_date_type']) and $this->skin_options['start_date_type'] == 'start_next_week') $date = date('Y-m-d', strtotime('Next '.$weekdays[0]));
        elseif(isset($this->skin_options['start_date_type']) and $this->skin_options['start_date_type'] == 'start_current_month') $date = date('Y-m-d', strtotime('first day of this month'));
        elseif(isset($this->skin_options['start_date_type']) and $this->skin_options['start_date_type'] == 'start_next_month') $date = date('Y-m-d', strtotime('first day of next month'));
        elseif(isset($this->skin_options['start_date_type']) and $this->skin_options['start_date_type'] == 'date') $date = date('Y-m-d', strtotime($this->skin_options['start_date']));
        
        // Hide past events
        if(isset($this->atts['show_past_events']) and !trim($this->atts['show_past_events']))
        {
            $today = current_time('Y-m-d');
            if(strtotime($date) < strtotime($today)) $date = $today;
        }
        
        // Show only expired events
        if(isset($this->show_only_expired_events) and $this->show_only_expired_events)
        {
            $yesterday = date('Y-m-d', strtotime('Yesterday'));
            if(strtotime($date) > strtotime($yesterday)) $date = $yesterday;
        }
        
        $time = strtotime($date);
        return array(date('Y', $time), date('m', $time), date('d', $time));
    }
    
    /**
     * Load month for AJAX requert
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function load_month()
    {
        $this->sf = $this->request->getVar('sf', array());
        $apply_sf_date = $this->request->getVar('apply_sf_date', 1);
        $atts = $this->sf_apply($this->request->getVar('atts', array()), $this->sf, $apply_sf_date);
        
        // Initialize the skin
        $this->initialize($atts);
        
        // Start Date
        $this->year = $this->request->getVar('mec_year', date('Y'));
        $this->month = $this->request->getVar('mec_month', date('m'));
        $this->week = 1;
        
        $this->start_date = $this->year.'-'.$this->month.'-01';
        
        // We will extend the end date in the loop
        $this->end_date = $this->start_date;
        
        // Weeks
        $this->weeks = $this->main->split_to_weeks($this->start_date, date('Y-m-t', strtotime($this->start_date)));
        
        // Get week of days
        $this->week_of_days = array();
        foreach($this->weeks as $week_number=>$week) foreach($week as $day) $this->week_of_days[$day] = $week_number;
        
        // Some times some months have 6 weeks but next month has 5 or even 4 weeks
        if(!isset($this->weeks[$this->week])) $this->week = $this->week-1;
        if(!isset($this->weeks[$this->week])) $this->week = $this->week-1;
        
        $this->today = $this->weeks[$this->week][0];
        
        // Return the events
        $this->atts['return_items'] = true;
        
        // Fetch the events
        $this->fetch();
        
        // Return the output
        $output = $this->output();
        
        echo json_encode($output);
        exit;
    }
}