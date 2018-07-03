<?php
/** no direct access **/
defined('_MECEXEC_') or die();

/**
 * Webnus MEC class.
 * @author Webnus <info@webnus.biz>
 */
class MEC_feature_mec extends MEC_base
{
    /**
     * Constructor method
     * @author Webnus <info@webnus.biz>
     */
    public function __construct()
    {
        // Import MEC Factory
        $this->factory = $this->getFactory();
        
        // Import MEC DB
        $this->db = $this->getDB();
        
        // Import MEC Main
        $this->main = $this->getMain();
        
        // Import MEC Notifications
        $this->notifications = $this->getNotifications();
        
        // MEC Settings
        $this->settings = $this->main->get_settings();
    }
    
    /**
     * Initialize calendars feature
     * @author Webnus <info@webnus.biz>
     */
    public function init()
    {
        $this->factory->action('admin_menu', array($this, 'menus'));
        $this->factory->action('init', array($this, 'register_post_type'));
        $this->factory->action('add_meta_boxes', array($this, 'register_meta_boxes'), 1);
        
        $this->factory->action('parent_file', array($this, 'mec_parent_menu_highlight'));
        $this->factory->action('submenu_file', array($this, 'mec_sub_menu_highlight'));
        
        // Google recaptcha
        $this->factory->filter('mec_grecaptcha_include', array($this, 'grecaptcha_include'));
        
        // Google Maps API
        $this->factory->filter('mec_gm_include', array($this, 'gm_include'));
        
        $this->factory->filter('manage_mec_calendars_posts_columns', array($this, 'filter_columns'));
        $this->factory->action('manage_mec_calendars_posts_custom_column', array($this, 'filter_columns_content'), 10, 2);
        
        $this->factory->action('save_post', array($this, 'save_calendar'), 10);
        
        // BuddyPress Integration
        $this->factory->action('mec_booking_confirmed', array($this->main, 'bp_add_activity'), 10);
        $this->factory->action('mec_booking_verified', array($this->main, 'bp_add_activity'), 10);
        $this->factory->action('bp_register_activity_actions', array($this->main, 'bp_register_activity_actions'), 10);
        
        // Mailchimp Integration
        $this->factory->action('mec_booking_verified', array($this->main, 'mailchimp_add_subscriber'), 10);
        
        // MEC Notifications
        $this->factory->action('mec_booking_completed', array($this->notifications, 'email_verification'), 10);
        $this->factory->action('mec_booking_completed', array($this->notifications, 'booking_notification'), 11);
        $this->factory->action('mec_booking_completed', array($this->notifications, 'admin_notification'), 12);
        $this->factory->action('mec_booking_confirmed', array($this->notifications, 'booking_confirmation'), 10);
        $this->factory->action('save_post', array($this->notifications, 'new_event'), 50, 3);
        
        $this->page = isset($_GET['page']) ? $_GET['page'] : 'MEC-settings';
        
        // MEC Post Type Name
        $this->PT = $this->main->get_main_post_type();
    }

    /**
     * highlighting menu when click on taxonomy
     * @author Webnus <info@webnus.biz>
     */
    public function mec_parent_menu_highlight($parent_file)
    {
        global $current_screen;
        
        $taxonomy = $current_screen->taxonomy;
        $post_type = $current_screen->post_type;
        
        // Don't do amything if the post type is not our post type
        if($post_type != $this->PT) return $parent_file;
        
        switch($taxonomy)
        {
            case 'mec_category':
            case 'post_tag':
            case 'mec_label':
            case 'mec_location':
            case 'mec_organizer':
                
                $parent_file = 'mec-intro';
                break;
            
            default:
                //nothing
                break;
        }
        
        return $parent_file;
    }
    
    public function mec_sub_menu_highlight($submenu_file)
    {
        global $current_screen;
        
        $taxonomy = $current_screen->taxonomy;
        $post_type = $current_screen->post_type;
        
        // Don't do amything if the post type is not our post type
        if($post_type != $this->PT) return $submenu_file;
        
        switch($taxonomy)
        {
            case 'mec_category':
                
                $submenu_file = 'edit-tags.php?taxonomy=mec_category&post_type='.$this->PT;
                break;
            case 'post_tag':
                
                $submenu_file = 'edit-tags.php?taxonomy=post_tag&post_type='.$this->PT;
                break;
            case 'mec_label':
                
                $submenu_file = 'edit-tags.php?taxonomy=mec_label&post_type='.$this->PT;
                break;
            case 'mec_location':
                
                $submenu_file = 'edit-tags.php?taxonomy=mec_location&post_type='.$this->PT;
                break;
            case 'mec_organizer':
                
                $submenu_file = 'edit-tags.php?taxonomy=mec_organizer&post_type='.$this->PT;
                break;
            default:
                //nothing
                break;
        }
        
        return $submenu_file;
    }

    /**
     * Add the calendars menu
     * @author Webnus <info@webnus.biz>
     */
    public function menus()
    {
        global $submenu;
        unset($submenu['mec-intro'][2]);
        
        remove_menu_page('edit.php?post_type=mec-events');
        remove_menu_page('edit.php?post_type=mec_calendars');
        
        add_submenu_page('mec-intro', __('Add Event', 'mec'), __('Add Event', 'mec'), 'edit_posts', 'post-new.php?post_type='.$this->PT);
        add_submenu_page('mec-intro', __('Tags', 'mec'), __('Tags', 'mec'), 'edit_others_posts', 'edit-tags.php?taxonomy=post_tag&post_type='.$this->PT);
        add_submenu_page('mec-intro', $this->main->m('taxonomy_categories', __('Categories', 'mec')), $this->main->m('taxonomy_categories', __('Categories', 'mec')), 'edit_others_posts', 'edit-tags.php?taxonomy=mec_category&post_type='.$this->PT);
        add_submenu_page('mec-intro', $this->main->m('taxonomy_labels', __('Labels', 'mec')), $this->main->m('taxonomy_labels', __('Labels', 'mec')), 'edit_others_posts', 'edit-tags.php?taxonomy=mec_label&post_type='.$this->PT);
        add_submenu_page('mec-intro', $this->main->m('taxonomy_locations', __('Locations', 'mec')), $this->main->m('taxonomy_locations', __('Locations', 'mec')), 'edit_others_posts', 'edit-tags.php?taxonomy=mec_location&post_type='.$this->PT);
        add_submenu_page('mec-intro', $this->main->m('taxonomy_organizers', __('Organizers', 'mec')), $this->main->m('taxonomy_organizers', __('Organizers', 'mec')), 'edit_others_posts', 'edit-tags.php?taxonomy=mec_organizer&post_type='.$this->PT);
        add_submenu_page('mec-intro', __('Shortcodes', 'mec'), __('Shortcodes', 'mec'), 'edit_others_posts', 'edit.php?post_type=mec_calendars');
        add_submenu_page('mec-intro', __('MEC - Settings', 'mec'), __('Settings', 'mec'), 'manage_options', 'MEC-settings', array($this, 'page'));
    }
    
    /**
     * Register post type of calendars/custom shortcodes
     * @author Webnus <info@webnus.biz>
     */
    public function register_post_type()
    {
        register_post_type('mec_calendars',
            array(
                'labels'=>array
                (
                    'name'=>__('Shortcodes', 'mec'),
                    'singular_name'=>__('Shortcode', 'mec'),
                    'add_new'=>__('Add Shortcode', 'mec'),
                    'add_new_item'=>__('Add New Shortcode', 'mec'),
                    'not_found'=>__('No shortcodes found!', 'mec'),
                    'all_items'=>__('All Shortcodes', 'mec'),
                    'edit_item'=>__('Edit shortcodes', 'mec'),
                    'not_found_in_trash'=>__('No shortcodes found in Trash!', 'mec')
                ),
                'public'=>false,
                'show_in_nav_menus'=>false,
                'show_in_admin_bar'=>false,
                'show_ui'=>true,
                'has_archive'=>false,
                'exclude_from_search'=>true,
                'publicly_queryable'=>false,
                'show_in_menu'=>'mec-intro',
                'supports'=>array('title')
            )
        );
    }
    
    /**
     * Filter columns of calendars/custom shortcodes
     * @author Webnus <info@webnus.biz>
     * @param array $columns
     * @return array
     */
    public function filter_columns($columns)
    {
        $columns['shortcode'] = __('Shortcode', 'mec');
        return $columns;
    }
    
    /**
     * Filter column content of calendars/custom shortcodes
     * @author Webnus <info@webnus.biz>
     * @param string $column_name
     * @param int $post_id
     */
    public function filter_columns_content($column_name, $post_id)
    {
        if($column_name == 'shortcode')
        {
            echo '[MEC id="'.$post_id.'"]';
        }
    }
    
    /**
     * Register meta boxes of calendars/custom shortcodes
     * @author Webnus <info@webnus.biz>
     */
    public function register_meta_boxes()
    {
		add_meta_box('mec_calendar_display_options', __('Display Options', 'mec'), array($this, 'meta_box_display_options'), 'mec_calendars', 'normal', 'high');
        add_meta_box('mec_calendar_filter', __('Filter Options', 'mec'), array($this, 'meta_box_filter'), 'mec_calendars', 'normal', 'high');
        add_meta_box('mec_calendar_shortcode', __('Shortcode', 'mec'), array($this, 'meta_box_shortcode'), 'mec_calendars', 'side');
        add_meta_box('mec_calendar_search_form', __('Search Form', 'mec'), array($this, 'meta_box_search_form'), 'mec_calendars', 'side');
    }
    
    /**
     * Save calendars/custom shortcodes
     * @author Webnus <info@webnus.biz>
     * @param int $post_id
     * @return void
     */
    public function save_calendar($post_id)
    {
        // Check if our nonce is set.
        if(!isset($_POST['mec_calendar_nonce'])) return;

        // Verify that the nonce is valid.
        if(!wp_verify_nonce($_POST['mec_calendar_nonce'], 'mec_calendar_data')) return;

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if(defined('DOING_AUTOSAVE') and DOING_AUTOSAVE) return;
        
        $terms = isset($_POST['mec_tax_input']) ? $_POST['mec_tax_input'] : array();
        
        $categories = (isset($terms['mec_category']) and is_array($terms['mec_category'])) ? implode(',', $terms['mec_category']) : '';
        $locations = (isset($terms['mec_location']) and is_array($terms['mec_location'])) ? implode(',', $terms['mec_location']) : '';
        $organizers = (isset($terms['mec_organizer']) and is_array($terms['mec_organizer'])) ? implode(',', $terms['mec_organizer']) : '';
        $labels = (isset($terms['mec_label']) and is_array($terms['mec_label'])) ? implode(',', $terms['mec_label']) : '';
        $tags = (isset($terms['mec_tag'])) ? explode(',', trim($terms['mec_tag'])) : '';
        $authors = (isset($terms['mec_author']) and is_array($terms['mec_author'])) ? implode(',', $terms['mec_author']) : '';
        
        // Fox tags
        if(is_array($tags) and count($tags) == 1 and trim($tags[0]) == '') $tags = array();
        if(is_array($tags))
        {
            $tags = array_map('trim', $tags);
            $tags = implode(',', $tags);
        }
        
        update_post_meta($post_id, 'label', $labels);
        update_post_meta($post_id, 'category', $categories);
        update_post_meta($post_id, 'location', $locations);
        update_post_meta($post_id, 'organizer', $organizers);
        update_post_meta($post_id, 'tag', $tags);
        update_post_meta($post_id, 'author', $authors);
        
        $mec = isset($_POST['mec']) ? $_POST['mec'] : array();
        
        foreach($mec as $key=>$value) update_post_meta($post_id, $key, $value);
    }
    
    /**
     * Show content of filter meta box
     * @author Webnus <info@webnus.biz>
     * @param object $post
     */
    public function meta_box_filter($post)
    {
        $path = MEC::import('app.features.mec.meta_boxes.filter', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }
    
    /**
     * Show content of shortcode meta box
     * @author Webnus <info@webnus.biz>
     * @param object $post
     */
    public function meta_box_shortcode($post)
    {
        $path = MEC::import('app.features.mec.meta_boxes.shortcode', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }
    
    /**
     * Show content of search form meta box
     * @author Webnus <info@webnus.biz>
     * @param object $post
     */
    public function meta_box_search_form($post)
    {
        $path = MEC::import('app.features.mec.meta_boxes.search_form', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }
    
    /**
     * Show content of display options meta box
     * @author Webnus <info@webnus.biz>
     * @param object $post
     */
    public function meta_box_display_options($post)
    {
        $path = MEC::import('app.features.mec.meta_boxes.display_options', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }
    
    /**
     * Show content of skin options meta box
     * @author Webnus <info@webnus.biz>
     * @param object $post
     */
    public function meta_box_skin_options($post)
    {
        $path = MEC::import('app.features.mec.meta_boxes.skin_options', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }
    
    /**
     * Show content settings menu
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function page()
    {
        $tab = isset($_GET['tab']) ? $_GET['tab'] : 'MEC-settings';
        
        if($tab == 'MEC-customcss') $this->styles();
        elseif($tab == 'MEC-support') $this->support();
        elseif($tab == 'MEC-reg-form') $this->regform();
        elseif($tab == 'MEC-gateways') $this->gateways();
        elseif($tab == 'MEC-notifications') $this->notifications();
        elseif($tab == 'MEC-messages') $this->messages();
        elseif($tab == 'MEC-styling') $this->styling();
        else $this->settings();
    }
    
    /**
     * Show content of settings tab
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function settings()
    {
        // Get Envato Class
        $envato = $this->getEnvato();
        
        $path = MEC::import('app.features.mec.settings', true, true);
        
        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }
    
    /**
     * Show content of styles tab
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function styles()
    {
        $path = MEC::import('app.features.mec.styles', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }
    
    /**
     * Show content of styling tab
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function styling()
    {
        $path = MEC::import('app.features.mec.styling', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }
    
    /**
     * Show content of support tab
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function support()
    {
        $path = MEC::import('app.features.mec.support', true, true);
        
        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }
    
    /**
     * Show content of registration form tab
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function regform()
    {
        $path = MEC::import('app.features.mec.regform', true, true);
        
        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }
    
    /**
     * Show content of gateways tab
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function gateways()
    {
        $path = MEC::import('app.features.mec.gateways', true, true);
        
        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }
    
    /**
     * Show content of notifications tab
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function notifications()
    {
        $path = MEC::import('app.features.mec.notifications', true, true);
        
        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }
    
    /**
     * Show content of messages tab
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function messages()
    {
        $path = MEC::import('app.features.mec.messages', true, true);
        
        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }
    
    /**
     * Whether to include google recaptcha library
     * @author Webnus <info@webnus.biz>
     * @param boolean $grecaptcha_include
     * @return boolean
     */
    public function grecaptcha_include($grecaptcha_include)
    {
        // Don't include the library if google recaptcha is not enabled
        if(!$this->main->get_recaptcha_status()) return false;
        
        return $grecaptcha_include;
    }
    
    /**
     * Whether to include google map library
     * @author Webnus <info@webnus.biz>
     * @param boolean $gm_include
     * @return boolean
     */
    public function gm_include($gm_include)
    {
        // Don't include the library if google Maps API is set to don't load
        if(isset($this->settings['google_maps_dont_load_api']) and $this->settings['google_maps_dont_load_api']) return false;
        
        return $gm_include;
    }
    
    /**
     * Single Event Display Method
     */
    public function sed_method_field($skin, $value = 0)
    {
        return '<div class="mec-form-row">
            <div class="mec-col-4">
                <label for="mec_skin_'.$skin.'_sed_method">'.__('Single Event Display Method', 'mec').'</label>
            </div>
            <div class="mec-col-4">
                <input type="hidden" name="mec[sk-options]['.$skin.'][sed_method]" value="0" id="mec_skin_'.$skin.'_sed_method_field" />
                <ul class="mec-sed-methods" data-for="#mec_skin_'.$skin.'_sed_method_field">
                    <li data-method="0" class="'.(!$value ? 'active' : '').'">'.__('Separate Window', 'mec').'</li>
                    <li data-method="m1" class="'.($value === 'm1' ? 'active' : '').'">'.__('Modal 1', 'mec').'</li>
                </ul>
            </div>
        </div>';
    }
}