<?php
/** no direct access **/
defined('_MECEXEC_') or die();

/**
 * Webnus MEC render class.
 * @author Webnus <info@webnus.biz>
 */
class MEC_render extends MEC_base
{
    public $db;
    public $main;
    public $file;

    /**
     * Constructor method
     * @author Webnus <info@webnus.biz>
     */
    public function __construct()
    {
        // Add image size for list and carousel 
        add_image_size('thumblist', '300', '300', true);
        add_image_size('meccarouselthumb', '474', '324', true);

        // Import MEC skin class
        MEC::import('app.libraries.skins');
        
        // MEC main library
        $this->main = $this->getMain();
        
        // MEC file library
        $this->file = $this->getFile();
        
        // MEC DB library
        $this->db = $this->getDB();
    }
    
    /**
     * Do the shortcode and return its output
     * @author Webnus <info@webnus.biz>
     * @param array $atts
     * @return string
     */
    public function shortcode($atts)
    {
        $calendar_id = isset($atts['id']) ? $atts['id'] : 0;
        $atts = apply_filters('mec_calendar_atts', $this->parse($calendar_id, $atts));
        
        $skin = isset($atts['skin']) ? $atts['skin'] : $this->get_default_layout();
        return $this->skin($skin, $atts);
    }
    
    /**
     * Do the widget and return its output
     * @author Webnus <info@webnus.biz>
     * @param int $calendar_id
     * @param array $atts
     * @return string
     */
    public function widget($calendar_id, $atts = array())
    {
        $atts = apply_filters('mec_calendar_atts', $this->parse($calendar_id, $atts));
        
        $skin = isset($atts['skin']) ? $atts['skin'] : $this->get_default_layout();
        return $this->skin($skin, $atts);
    }

    /**
     * Do the yearly_view skin and returns its output
     * @author Webnus <info@webnus.biz>
     * @param array $atts
     * @return string
     */
    public function vyear($atts = array())
    {
        $atts = apply_filters('mec_vyear_atts', $atts);
        $skin = 'yearly_view';

        return $this->skin($skin, $atts);
    }

    /**
     * Do the monthly_view skin and returns its output
     * @author Webnus <info@webnus.biz>
     * @param array $atts
     * @return string
     */
    public function vmonth($atts = array())
    {
        $atts = apply_filters('mec_vmonth_atts', $atts);
        $skin = 'monthly_view';
        
        return $this->skin($skin, $atts);
    }
    
    /**
     * Do the full_calendar skin and returns its output
     * @author Webnus <info@webnus.biz>
     * @param array $atts
     * @return string
     */
    public function vfull($atts = array())
    {
        $atts = apply_filters('mec_vfull_atts', $atts);
        $skin = 'full_calendar';
        
        return $this->skin($skin, $atts);
    }
    
    /**
     * Do the weekly_view skin and returns its output
     * @author Webnus <info@webnus.biz>
     * @param array $atts
     * @return string
     */
    public function vweek($atts = array())
    {
        $atts = apply_filters('mec_vweek_atts', $atts);
        $skin = 'weekly_view';
        
        return $this->skin($skin, $atts);
    }

    /**
     * Do the timetable skin and returns its output
     * @author Webnus <info@webnus.biz>
     * @param array $atts
     * @return string
     */
    public function vtimetable($atts = array())
    {
        $atts = apply_filters('mec_vtimetable_atts', $atts);
        $skin = 'timetable';

        return $this->skin($skin, $atts);
    }

    /**
     * Do the Masonry skin and returns its output
     * @author Webnus <info@webnus.biz>
     * @param array $atts
     * @return string
     */
    public function vmasonry($atts = array())
    {
        $atts = apply_filters('mec_vmasonry_atts', $atts);
        $skin = 'masonry';

        return $this->skin($skin, $atts);
    }
    
    /**
     * Do the daily_view skin and returns its output
     * @author Webnus <info@webnus.biz>
     * @param array $atts
     * @return string
     */
    public function vday($atts = array())
    {
        $atts = apply_filters('mec_vday_atts', $atts);
        $skin = 'daily_view';
        
        return $this->skin($skin, $atts);
    }
    
    /**
     * Do the map skin and returns its output
     * @author Webnus <info@webnus.biz>
     * @param array $atts
     * @return string
     */
    public function vmap($atts = array())
    {
        $atts = apply_filters('mec_vmap_atts', $atts);
        $skin = 'map';
        
        return $this->skin($skin, $atts);
    }
    
    /**
     * Do the list skin and returns its output
     * @author Webnus <info@webnus.biz>
     * @param array $atts
     * @return string
     */
    public function vlist($atts = array())
    {
        $atts = apply_filters('mec_vlist_atts', $atts);
        $skin = 'list';
        
        return $this->skin($skin, $atts);
    }
    
    /**
     * Do the grid skin and returns its output
     * @author Webnus <info@webnus.biz>
     * @param array $atts
     * @return string
     */
    public function vgrid($atts = array())
    {
        $atts = apply_filters('mec_vgrid_atts', $atts);
        $skin = 'grid';
        
        return $this->skin($skin, $atts);
    }

    /**
     * Do the agenda skin and returns its output
     * @author Webnus <info@webnus.biz>
     * @param array $atts
     * @return string
     */
    public function vagenda($atts = array())
    {
        $atts = apply_filters('mec_vagenda_atts', $atts);
        $skin = 'agenda';

        return $this->skin($skin, $atts);
    }
    
    /**
     * Do the default archive skin and returns its output
     * @author Webnus <info@webnus.biz>
     * @param array $atts
     * @return string
     */
    public function vdefault($atts = array())
    {
        $settings = $this->main->get_settings();
        
        if(!isset($settings['default_skin_archive']) or (isset($settings['default_skin_archive']) and trim($settings['default_skin_archive']) == ''))
        {
            return $this->vmonth($atts);
        }
        
        if($settings['default_skin_archive'] == 'monthly_view') $content = $this->vmonth($atts);
        elseif($settings['default_skin_archive'] == 'full_calendar') $content = $this->vfull($atts);
        elseif($settings['default_skin_archive'] == 'yearly_view') $content = $this->vyear($atts);
        elseif($settings['default_skin_archive'] == 'weekly_view') $content = $this->vweek($atts);
        elseif($settings['default_skin_archive'] == 'daily_view') $content = $this->vday($atts);
        elseif($settings['default_skin_archive'] == 'timetable') $content = $this->vtimetable($atts);
        elseif($settings['default_skin_archive'] == 'masonry') $content = $this->vmasonry($atts);
        elseif($settings['default_skin_archive'] == 'list') $content = $this->vlist($atts);
        elseif($settings['default_skin_archive'] == 'grid') $content = $this->vgrid($atts);
        elseif($settings['default_skin_archive'] == 'agenda') $content = $this->vagenda($atts);
        elseif($settings['default_skin_archive'] == 'map') $content = $this->vmap($atts);
        else $content = apply_filters('mec_default_skin_content', '');
        
        return $content;
    }
    
    /**
     * Do the single skin and returns its output
     * @author Webnus <info@webnus.biz>
     * @param array $atts
     * @return string
     */
    public function vsingle($atts)
    {
        // Force to array
        if(!is_array($atts)) $atts = array();
        
        // Get event ID
        $event_id = isset($atts['id']) ? $atts['id'] : 0;
        
        // MEC Settings
        $settings = $this->main->get_settings();
        
        $defaults = array('maximum_dates'=>(isset($settings['booking_maximum_dates']) ? $settings['booking_maximum_dates'] : 6));
        $atts = apply_filters('mec_vsingle_atts', $this->parse($event_id, wp_parse_args($atts, $defaults)));
        
        $skin = 'single';
        return $this->skin($skin, $atts);
    }
    
    /**
     * Do the category archive skin and returns its output
     * @author Webnus <info@webnus.biz>
     * @param array $atts
     * @return string
     */
    public function vcategory($atts = array())
    {
        $settings = $this->main->get_settings();

        // Skin
        $skin = (isset($settings['default_skin_category']) and trim($settings['default_skin_category']) != '') ? $settings['default_skin_category'] : 'list';

        // Show Only Expired Events
        if(isset($settings['category_events_method']) and $settings['category_events_method'] == 2) $atts['show_only_past_events'] = 1;

        if($skin == 'full_calendar') $content = $this->vfull($atts);
        elseif($skin == 'yearly_view') $content = $this->vyear($atts);
        elseif($skin == 'monthly_view') $content = $this->vmonth($atts);
        elseif($skin == 'weekly_view') $content = $this->vweek($atts);
        elseif($skin == 'daily_view') $content = $this->vday($atts);
        elseif($skin == 'list') $content = $this->vlist(array_merge($atts, array('sk-options'=>array('list'=>array('style'=>'standard')))));
        elseif($skin == 'grid') $content = $this->vgrid($atts);
        elseif($skin == 'agenda') $content = $this->vagenda($atts);
        elseif($skin == 'map') $content = $this->vmap($atts);
        else $content = apply_filters('mec_default_skin_content', '');
        
        return $content;
    }
    
    /**
     * Merge args
     * @author Webnus <info@webnus.biz>
     * @param int $post_id
     * @param array $atts
     * @return array
     */
    public function parse($post_id, $atts = array())
    {
        $post_atts = array();
        if($post_id) $post_atts = $this->main->get_post_meta($post_id);
        
        return wp_parse_args($atts, $post_atts);
    }
    
    /**
     * Run the skin and returns its output
     * @author Webnus <info@webnus.biz>
     * @param string $skin
     * @param array $atts
     * @return string
     */
    public function skin($skin, $atts = array())
    {
        $path = MEC::import('app.skins.'.$skin, true, true);
        $skin_path = apply_filters('mec_skin_path', $skin);
        
        if($skin_path != $skin and $this->file->exists($skin_path)) $path = $skin_path;
        if(!$this->file->exists($path))
        {
            return __('Skin controller does not exist.', 'mec');
        }
        
        include_once $path;
        
        $skin_class_name = 'MEC_skin_'.$skin;
        
        // Create Skin Object Class
        $SKO = new $skin_class_name();
        
        // Initialize the skin
        $SKO->initialize($atts);
        
        // Fetch the events
        $SKO->fetch();
        
        // Return the output
        return $SKO->output();
    }
    
    /**
     * Returns default skin
     * @author Webnus <info@webnus.biz>
     * @return string
     */
    public function get_default_layout()
    {
        return apply_filters('mec_default_layout', 'list');
    }
    
    /**
     * Renders annd Returns all event data
     * @author Webnus <info@webnus.biz>
     * @param int $post_id
     * @param string $content
     * @return \stdClass
     */
    public function data($post_id, $content = NULL)
    {
        $cached = wp_cache_get($post_id, 'mec-events-data');
        if($cached) return $cached;
        
        $data = new stdClass();
        
        // Post Data
        $data->ID = $post_id;
        $data->title = get_the_title($post_id);
        $data->content = (is_null($content) ? $this->main->get_post_content($post_id) : $content);
        
        // All Post Data
        $post = get_post($post_id);
        $data->post = $post;
        
        // All Meta Data
        $meta = $this->main->get_post_meta($post_id);
        $data->meta = $meta;
        
        // All MEC Data
        $data->mec = $this->db->select("SELECT * FROM `#__mec_events` WHERE `post_id`='$post_id'", "loadObject");
        
        $allday = isset($data->meta['mec_allday']) ? $data->meta['mec_allday'] : 0;
        $hide_time = isset($data->meta['mec_hide_time']) ? $data->meta['mec_hide_time'] : 0;
        $hide_end_time = isset($data->meta['mec_hide_end_time']) ? $data->meta['mec_hide_end_time'] : 0;
        
        if($hide_time)
        {
            $data->time = array('start'=>'', 'end'=>'');
        }
        elseif($allday)
        {
            $data->time = array('start'=>__('All of the day', 'mec'), 'end'=>'');
        }
        else
        {
            $data->time = array(
                'start'=>$this->main->get_time($meta['mec_start_day_seconds']),
                'end'=>($hide_end_time ? '' : $this->main->get_time($meta['mec_end_day_seconds']))
            );
        }
        
        $data->hourly_schedules = isset($meta['mec_hourly_schedules']) ? $meta['mec_hourly_schedules'] : array();
        $data->tickets = isset($meta['mec_tickets']) ? $meta['mec_tickets'] : array();
        $data->color = isset($meta['mec_color']) ? $meta['mec_color'] : '';
        
        $data->permalink = ((isset($meta['mec_read_more']) and filter_var($meta['mec_read_more'], FILTER_VALIDATE_URL)) ? $meta['mec_read_more'] : get_post_permalink($post_id));
        
        // Thumbnails
        $thumbnail = get_the_post_thumbnail($post_id, 'thumbnail', array('data-mec-postid'=>$post_id));
        $thumblist = get_the_post_thumbnail($post_id, 'thumblist' , array('data-mec-postid'=>$post_id));        
        $meccarouselthumb = get_the_post_thumbnail($post_id, 'meccarouselthumb' , array('data-mec-postid'=>$post_id));
        $medium = get_the_post_thumbnail($post_id, 'medium', array('data-mec-postid'=>$post_id));
        $large = get_the_post_thumbnail($post_id, 'large', array('data-mec-postid'=>$post_id));
        $full = get_the_post_thumbnail($post_id, 'full', array('data-mec-postid'=>$post_id));
        
        if(trim($thumbnail) == '' and trim($medium) != '') $thumbnail = preg_replace("/height=\"[0-9]*\"/", 'height="150"', preg_replace("/width=\"[0-9]*\"/", 'width="150"', $medium));
        elseif(trim($thumbnail) == '' and trim($large) != '') $thumbnail = preg_replace("/height=\"[0-9]*\"/", 'height="150"', preg_replace("/width=\"[0-9]*\"/", 'width="150"', $large));
        
        $data->thumbnails = array(
            'thumbnail'=>$thumbnail,
            'thumblist'=>$thumblist,
            'meccarouselthumb'=>$meccarouselthumb,
            'medium'=>$medium,
            'large'=>$large,
            'full'=>$full
        );
        
        // Featured image URLs
        $data->featured_image = array(
            'thumbnail'=>esc_url(get_the_post_thumbnail_url($post_id, 'thumbnail')),
            'thumblist'=>esc_url(get_the_post_thumbnail_url($post_id, 'thumblist' )),
            'meccarouselthumb'=>esc_url(get_the_post_thumbnail_url($post_id, 'meccarouselthumb')),
            'medium'=>esc_url(get_the_post_thumbnail_url($post_id, 'medium')),
            'large'=>esc_url(get_the_post_thumbnail_url($post_id, 'large')),
            'full'=>esc_url(get_the_post_thumbnail_url($post_id, 'full'))
        );
        
        $labels = wp_get_post_terms($post_id, 'mec_label', array('fields'=>'all'));
        foreach($labels as $label) $data->labels[$label->term_id] = array('id'=>$label->term_id, 'name'=>$label->name, 'color'=>get_metadata('term', $label->term_id, 'color', true));
        
        $organizers = wp_get_post_terms($post_id, 'mec_organizer', array('fields'=>'all'));
        foreach($organizers as $organizer) $data->organizers[$organizer->term_id] = array('id'=>$organizer->term_id, 'name'=>$organizer->name, 'tel'=>get_metadata('term', $organizer->term_id, 'tel', true), 'email'=>get_metadata('term', $organizer->term_id, 'email', true), 'url'=>get_metadata('term', $organizer->term_id, 'url', true), 'thumbnail'=>get_metadata('term', $organizer->term_id, 'thumbnail', true));
        
        $locations = wp_get_post_terms($post_id, 'mec_location', array('fields'=>'all'));
        foreach($locations as $location) $data->locations[$location->term_id] = array('id'=>$location->term_id, 'name'=>$location->name, 'address'=>get_metadata('term', $location->term_id, 'address', true), 'latitude'=>get_metadata('term', $location->term_id, 'latitude', true), 'longitude'=>get_metadata('term', $location->term_id, 'longitude', true), 'thumbnail'=>get_metadata('term', $location->term_id, 'thumbnail', true));
        
        $categories = wp_get_post_terms($post_id, 'mec_category', array('fields'=>'all'));
        foreach($categories as $category) $data->categories[$category->term_id] = array('id'=>$category->term_id, 'name'=>$category->name);
        
        $tags = wp_get_post_terms($post_id, 'post_tag', array('fields'=>'all'));
        foreach($tags as $tag) $data->tags[$tag->term_id] = array('id'=>$tag->term_id, 'name'=>$tag->name);
        
        // Set to cache
        wp_cache_set($post_id, $data, 'mec-events-data', 43200);
        
        return $data;
    }
    
    /**
     * Renders and Returns event dats
     * @author Webnus <info@webnus.biz>
     * @param int $event_id
     * @param object $event
     * @param int $maximum
     * @param string $today
     * @return object|array
     */
    public function dates($event_id, $event = NULL, $maximum = 6, $today = NULL)
    {
        if(!trim($today)) $today = date('Y-m-d');
        
        // Original Start Date
        $original_start_date = $today;
        
        $cached = wp_cache_get($event_id.'-'.$original_start_date, 'mec-events-dates');
        if($cached) return $cached;
        
        $dates = array();
        
        // Get event data if it is NULL
        if(is_null($event)) $event = $this->data($event_id);
        
        $start_date = isset($event->meta['mec_date']['start']) ? $event->meta['mec_date']['start'] : array();
        $end_date = isset($event->meta['mec_date']['end']) ? $event->meta['mec_date']['end'] : array();
        
        // Return empty array if date is not valid
        if(!isset($start_date['date']) or (isset($start_date['date']) and !strtotime($start_date['date']))) return $dates;
        
        // Return empty array if mec data is not exists on mec_events table
        if(!isset($event->mec->end)) return $dates;
        
        $allday = isset($event->meta['mec_allday']) ? $event->meta['mec_allday'] : 0;
        $hide_time = isset($event->meta['mec_hide_time']) ? $event->meta['mec_hide_time'] : 0;
        
        $event_period = $this->main->date_diff($start_date['date'], $end_date['date']);
        $event_period_days = $event_period ? $event_period->days : 0;
        
        $finish_date = array('date'=>$event->mec->end, 'hour'=>$event->meta['mec_date']['end']['hour'], 'minutes'=>$event->meta['mec_date']['end']['minutes'], 'ampm'=>$event->meta['mec_date']['end']['ampm']);
        $exceptional_days = (isset($event->mec->not_in_days) and trim($event->mec->not_in_days)) ? explode(',', trim($event->mec->not_in_days, ', ')) : array();
        
        // Event Passed
        $past = $this->main->is_past($finish_date['date'], $today);
        
        // Event is not passed for custom days
        if($past and isset($event->meta['mec_repeat_type']) and $event->meta['mec_repeat_type'] == 'custom_days') $past = 0;
        
        // Normal event
        if(isset($event->mec->repeat) and $event->mec->repeat == '0')
        {
            $dates[] = array(
                'start'=>$start_date,
                'end'=>$end_date,
                'allday'=>$allday,
                'hide_time'=>$hide_time,
                'past'=>$past
            );
        }
        elseif($past)
        {
            $dates[] = array(
                'start'=>$start_date,
                'end'=>$finish_date,
                'allday'=>$allday,
                'hide_time'=>$hide_time,
                'past'=>$past
            );
        }
        elseif(!$past)
        {
            $repeat_type = $event->meta['mec_repeat_type'];
            $repeat_interval = 1;
            
            if(in_array($repeat_type, array('daily', 'weekly')))
            {
                $repeat_interval = $event->meta['mec_repeat_interval'];
                
                $date_interval = $this->main->date_diff($start_date['date'], $today);
                $passed_days = $date_interval ? $date_interval->days : 0;

                // Check if date interval is negative (It means the event didn't start yet)
                if($date_interval and $date_interval->invert == 1) $remained_days_to_next_repeat = $passed_days;
                else $remained_days_to_next_repeat = $repeat_interval - ($passed_days%$repeat_interval);

                $start_date = date('Y-m-d', strtotime('+'.$remained_days_to_next_repeat.' Days', strtotime($today)));
                if(!in_array($start_date, $exceptional_days)) $dates[] = array(
                    'start'=>array('date'=>$start_date, 'hour'=>$event->meta['mec_date']['start']['hour'], 'minutes'=>$event->meta['mec_date']['start']['minutes'], 'ampm'=>$event->meta['mec_date']['start']['ampm']),
                    'end'=>array('date'=>date('Y-m-d', strtotime('+'.$event_period_days.' Days', strtotime($start_date))), 'hour'=>$event->meta['mec_date']['end']['hour'], 'minutes'=>$event->meta['mec_date']['end']['minutes'], 'ampm'=>$event->meta['mec_date']['end']['ampm']),
                    'allday'=>$allday,
                    'hide_time'=>$hide_time,
                    'past'=>0
                );
                
                for($i=2; $i<=$maximum; $i++)
                {
                    $start_date = date('Y-m-d', strtotime('+'.$repeat_interval.' Days', strtotime($start_date)));
                    
                    // Event finished
                    if($this->main->is_past($finish_date['date'], $start_date)) break;
                    
                    if(!in_array($start_date, $exceptional_days)) $dates[] = array(
                        'start'=>array('date'=>$start_date, 'hour'=>$event->meta['mec_date']['start']['hour'], 'minutes'=>$event->meta['mec_date']['start']['minutes'], 'ampm'=>$event->meta['mec_date']['start']['ampm']),
                        'end'=>array('date'=>date('Y-m-d', strtotime('+'.$event_period_days.' Days', strtotime($start_date))), 'hour'=>$event->meta['mec_date']['end']['hour'], 'minutes'=>$event->meta['mec_date']['end']['minutes'], 'ampm'=>$event->meta['mec_date']['end']['ampm']),
                        'allday'=>$allday,
                        'hide_time'=>$hide_time,
                        'past'=>0
                    );
                }
            }
            elseif(in_array($repeat_type, array('weekday', 'weekend', 'certain_weekdays')))
            {
                $date_interval = $this->main->date_diff($start_date['date'], $today);
                $passed_days = $date_interval ? $date_interval->days : 0;
                
                // Check if date interval is negative (It means the event didn't start yet)
                if($date_interval and $date_interval->invert == 1) $today = date('Y-m-d', strtotime('+'.$passed_days.' Days', strtotime($original_start_date)));
                
                $event_days = explode(',', trim($event->mec->weekdays, ', '));
                
                $today_id = date('N', strtotime($today));
                $found = 0;
                $i = 0;
                
                while($found < $maximum)
                {
                    if($this->main->is_past($finish_date['date'], $today)) break;
                    
                    if(!in_array($today_id, $event_days))
                    {
                        $today = date('Y-m-d', strtotime('+1 Days', strtotime($today)));
                        $today_id = date('N', strtotime($today));
                    
                        $i++;
                        continue;
                    }
                    
                    $start_date = $today;
                    if(!in_array($start_date, $exceptional_days)) $dates[] = array(
                        'start'=>array('date'=>$start_date, 'hour'=>$event->meta['mec_date']['start']['hour'], 'minutes'=>$event->meta['mec_date']['start']['minutes'], 'ampm'=>$event->meta['mec_date']['start']['ampm']),
                        'end'=>array('date'=>date('Y-m-d', strtotime('+'.$event_period_days.' Days', strtotime($start_date))), 'hour'=>$event->meta['mec_date']['end']['hour'], 'minutes'=>$event->meta['mec_date']['end']['minutes'], 'ampm'=>$event->meta['mec_date']['end']['ampm']),
                        'allday'=>$allday,
                        'hide_time'=>$hide_time,
                        'past'=>0
                    );
                    
                    $today = date('Y-m-d', strtotime('+1 Days', strtotime($today)));
                    $today_id = date('N', strtotime($today));
                    
                    $found++;
                    $i++;
                }
            }
            elseif($repeat_type == 'monthly')
            {
                $event_days = explode(',', trim($event->mec->day, ', '));
                
                $event_start_day = $event_days[0];
                $event_end_day = $event_days[(count($event_days)-1)];
                
                $event_period_days = $event_end_day - $event_start_day;
                $found = 0;
                $i = 0;
                
                while($found < $maximum)
                {
                    $today = date('Y-m-d', strtotime('+'.$i.' Months', strtotime($original_start_date)));
                    
                    if($this->main->is_past($finish_date['date'], $today)) break;
                    
                    $year = date('Y', strtotime($today));
                    $month = date('m', strtotime($today));
                    $day = $event_start_day;
                    
                    // Fix for 31st, 30th, 29th of some months
                    while(!checkdate($month, $day, $year)) $day--;
                    
                    $start_date = $year.'-'.$month.'-'.$day;
                    
                    if(strtotime($start_date) < time())
                    {
                        $i++;
                        continue;
                    }
                    
                    if(!in_array($start_date, $exceptional_days)) $dates[] = array(
                        'start'=>array('date'=>$start_date, 'hour'=>$event->meta['mec_date']['start']['hour'], 'minutes'=>$event->meta['mec_date']['start']['minutes'], 'ampm'=>$event->meta['mec_date']['start']['ampm']),
                        'end'=>array('date'=>date('Y-m-d', strtotime('+'.$event_period_days.' Days', strtotime($start_date))), 'hour'=>$event->meta['mec_date']['end']['hour'], 'minutes'=>$event->meta['mec_date']['end']['minutes'], 'ampm'=>$event->meta['mec_date']['end']['ampm']),
                        'allday'=>$allday,
                        'hide_time'=>$hide_time,
                        'past'=>0
                    );
                    
                    $found++;
                    $i++;
                }
            }
            elseif($repeat_type == 'yearly')
            {
                $event_days = explode(',', trim($event->mec->day, ', '));
                $event_months = explode(',', trim($event->mec->month, ', '));
                
                $event_start_day = $event_days[0];
                $event_end_day = $event_days[(count($event_days)-1)];
                
                $event_period_days = $event_end_day - $event_start_day;
                $found = 0;
                $i = 0;
                
                while($found < $maximum and !$this->main->is_past($finish_date['date'], $today))
                {
                    $today = date('Y-m-d', strtotime('+'.$i.' Months', strtotime($original_start_date)));
                    
                    $year = date('Y', strtotime($today));
                    $month = date('m', strtotime($today));
                    
                    if(!in_array($month, $event_months))
                    {
                        $i++;
                        continue;
                    }
                    
                    $day = $event_start_day;
                    
                    // Fix for 31st, 30th, 29th of some months
                    while(!checkdate($month, $day, $year)) $day--;
                    
                    $event_date = $year.'-'.$month.'-'.$day;
                    
                    if(strtotime($event_date) < time())
                    {
                        $i++;
                        continue;
                    }
                    
                    $start_date = $event_date;
                    if(!in_array($start_date, $exceptional_days)) $dates[] = array(
                        'start'=>array('date'=>$start_date, 'hour'=>$event->meta['mec_date']['start']['hour'], 'minutes'=>$event->meta['mec_date']['start']['minutes'], 'ampm'=>$event->meta['mec_date']['start']['ampm']),
                        'end'=>array('date'=>date('Y-m-d', strtotime('+'.$event_period_days.' Days', strtotime($start_date))), 'hour'=>$event->meta['mec_date']['end']['hour'], 'minutes'=>$event->meta['mec_date']['end']['minutes'], 'ampm'=>$event->meta['mec_date']['end']['ampm']),
                        'allday'=>$allday,
                        'hide_time'=>$hide_time,
                        'past'=>0
                    );
                    
                    $found++;
                    $i++;
                }
            }
            elseif($repeat_type == 'custom_days')
            {
                $custom_days = explode(',', trim($event->mec->days, ', '));
                sort($custom_days);
                
                $found = 0;
                if(strtotime($event->mec->start) >= strtotime($today) and !in_array($event->mec->start, $exceptional_days))
                {
                    $dates[] = array(
                        'start'=>array('date'=>$event->mec->start, 'hour'=>$event->meta['mec_date']['start']['hour'], 'minutes'=>$event->meta['mec_date']['start']['minutes'], 'ampm'=>$event->meta['mec_date']['start']['ampm']),
                        'end'=>array('date'=>$event->mec->end, 'hour'=>$event->meta['mec_date']['end']['hour'], 'minutes'=>$event->meta['mec_date']['end']['minutes'], 'ampm'=>$event->meta['mec_date']['end']['ampm']),
                        'allday'=>$allday,
                        'hide_time'=>$hide_time,
                        'past'=>0
                    );
                    
                    $found++;
                }
                
                foreach($custom_days as $custom_day)
                {
                    // Found maximum dates
                    if($found >= $maximum) break;
                    
                    // Date is past
                    if(strtotime($custom_day) < strtotime($today)) continue;
                    
                    if(!in_array($custom_day, $exceptional_days)) $dates[] = array(
                        'start'=>array('date'=>$custom_day, 'hour'=>$event->meta['mec_date']['start']['hour'], 'minutes'=>$event->meta['mec_date']['start']['minutes'], 'ampm'=>$event->meta['mec_date']['start']['ampm']),
                        'end'=>array('date'=>$custom_day, 'hour'=>$event->meta['mec_date']['end']['hour'], 'minutes'=>$event->meta['mec_date']['end']['minutes'], 'ampm'=>$event->meta['mec_date']['end']['ampm']),
                        'allday'=>$allday,
                        'hide_time'=>$hide_time,
                        'past'=>0
                    );
                    
                    $found++;
                }
                
                // No future date found so the event is passed
                if(!count($dates))
                {
                    $dates[] = array(
                        'start'=>$start_date,
                        'end'=>$finish_date,
                        'allday'=>$allday,
                        'hide_time'=>$hide_time,
                        'past'=>$past
                    );
                }
            }
        }
        
        // Set to cache
        wp_cache_set($event_id.'-'.$original_start_date, $dates, 'mec-events-dates', 86400);
        
        return $dates;
    }
    
    /**
     * Render markers
     * @author Webnus <info@webnus.biz>
     * @param array $events
     * @return array
     */
    public function markers($events)
    {
        $markers = array();
        
        $settings = $this->main->get_settings();
        $date_format = (isset($settings['google_maps_date_format1']) and trim($settings['google_maps_date_format1'])) ? $settings['google_maps_date_format1'] : 'M d Y';
        
        foreach($events as $event)
        {
            $location = isset($event->data->locations[$event->data->meta['mec_location_id']]) ? $event->data->locations[$event->data->meta['mec_location_id']] : array();
            
            $latitude = isset($location['latitude']) ? $location['latitude'] : '';
            $longitude = isset($location['longitude']) ? $location['longitude'] : '';
            
            // No latitude/Longitude
            if(trim($latitude) == '' or trim($longitude) == '') continue;
            
            $key = $latitude.','.$longitude;
            if(!isset($markers[$key]))
            {
                $markers[$key] = array(
                    'latitude'=>$latitude,
                    'longitude'=>$longitude,
                    'name'=>((isset($location['name']) and trim($location['name'])) ? $location['name'] : ''),
                    'address'=>((isset($location['address']) and trim($location['address'])) ? $location['address'] : ''),
                    'event_ids'=>array($event->data->ID),
                    'lightbox'=>$this->main->get_marker_lightbox($event, $date_format),
                );
            }
            else
            {
                $markers[$key]['event_ids'][] = $event->data->ID;
                $markers[$key]['lightbox'] .= $this->main->get_marker_lightbox($event, $date_format);
            }
        }
        
        $points = array();
        foreach($markers as $key=>$marker)
        {
            $points[$key] = $marker;
            
            $points[$key]['lightbox'] = '<div><div class="mec-event-detail mec-map-view-event-detail"><i class="mec-sl-map-marker"></i> '.(trim($marker['address']) ? $marker['address'] : $marker['name']).'</div><div>'.$marker['lightbox'].'</div></div>';
            $points[$key]['count'] = count($marker['event_ids']);
            $points[$key]['infowindow'] = $this->main->get_marker_infowindow($marker);
        }
        
        return apply_filters('mec_render_markers', $points);
    }
}