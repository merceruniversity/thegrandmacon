<?php
/** no direct access **/
defined('_MECEXEC_') or die();

/**
 * Webnus MEC envato class.
 * @author Webnus <info@webnus.biz>
 */
class MEC_envato extends MEC_base
{
    /**
     * The plugin current version
     */
    public $current_version = _MEC_VERSION_;

    /**
     * The plugin ite, id
     */
    public $itemid = '17731780';

    /**
     * The plugin url
     */
    public $itemurl = 'https://codecanyon.net/item/modern-events-calendar-responsive-event-scheduler-booking-for-wordpress/17731780?s_rank=1';

    /**
     * User for cashing directory
     */
    public $purchase_code = '';

    /**
     * The plugin remote update path
     */
    public $update_path = '';

    /**
     * Plugin Slug (modern-events-calendar/mec.php)
     */
    public $plugin_slug = _MEC_BASENAME_;

    /**
     * Plugin name
     */
    public $slug;

    /**
     * User for cashing directory
     */
    protected $cache_dir = 'cache';

    public $main;
    public $factory;
    public $settings;

    /**
     *  MEC update constructor
     */
    public function __construct()
    {
        // Import MEC Main
        $this->main = $this->getMain();

        // Import MEC Factory
        $this->factory = $this->getFactory();

        // MEC Settings
        $this->settings = $this->main->get_settings();

        // Set user purchase code
        $this->set_purchase_code(isset($this->settings['purchase_code']) ? $this->settings['purchase_code'] : '');
        
        // Plugin Slug
        list($slice1, $slice2) = explode('/', $this->plugin_slug);
        $this->slug = str_replace('.php', '', $slice2);
    }

    /**
     * Set purchase code.
     * @author Webnus <info@webnus.biz>
     * @param string $purchase_code
     */
    public function set_purchase_code($purchase_code)
    {
        $this->purchase_code = $purchase_code;
    }

    /**
     * Set update path.
     * @author Webnus <info@webnus.biz>
     * @param string $update_path
     */
    public function set_update_path($update_path)
    {
        $this->update_path = $update_path;
    }

    /**
     * GET purchase code.
     * @author Webnus <info@webnus.biz>
     */
    public function get_purchase_code()
    {
        return $this->purchase_code;
    }

    /**
     * Get update path.
     * @author Webnus <info@webnus.biz>
     */
    public function get_update_path()
    {
        return $this->update_path;
    }

    /**
     * Initialize the auto update class
     * @author Webnus <info@webnus.biz>
     */
    public function init()
    {
        // updating checking
        $this->factory->filter('pre_set_site_transient_update_plugins', array($this, 'check_update'));

        // information checking
        $this->factory->filter('plugins_api', array($this, 'check_info'), 10, 3);
    }

    /**
     * Add our self-hosted autoupdate plugin to the filter transien
     * @author Webnus <info@webnus.biz>
     * @param object $transient
     * @return object
     */
    public function check_update($transient)
    {
        if(empty($transient->checked)) return $transient;

        // Get the remote version
        $version = json_decode(json_encode($this->get_MEC_info('version')->version), true);

        // Set mec update path
        $dl_link = !is_null($this->get_MEC_info('dl')) ? $this->set_update_path($this->get_MEC_info('dl')) : NULL;

        // If a newer version is available, add the update
        if(version_compare($this->current_version, $version, '<'))
        {
            $obj = new stdClass();
            $obj->id = $this->itemid;
            $obj->slug = $this->slug;
            $obj->plugin = $this->plugin_slug;
            $obj->requires = '4.0';
            $obj->tested = '4.9';
            $obj->new_version = $version;
            $obj->url = $this->itemurl;
            $obj->package = $this->get_update_path();
            $obj->sections = array
            (
                'description' => 'Modern Events Calendar - Responsive Event Scheduler & Booking For WordPress',
                'changelog' => 'Modern Events Calendar - Responsive Event Scheduler & Booking For WordPress'
            );
            
            $transient->response[$this->plugin_slug] = $obj;
        }
        elseif(isset($transient->response[$this->plugin_slug]))
        {
            unset($transient->response[$this->plugin_slug]);
        }

        return $transient;
    }

    /**
     * Add our self-hosted description to the filter
     * @author Webnus <info@webnus.biz>
     */
    public function check_info($false, $action, $arg)
    {
        if(isset($arg->slug) and $arg->slug === $this->slug)
        {
            $information = $this->get_MEC_info('info');
            if($information->item)
            {
                $arg->fields->short_description = true;
                $arg->fields->description = true;
                $arg->fields->sections = true;
                $arg->slug = $this->slug;
                $arg->plugin_name = 'Modern Events Calendar';
                $arg->author = 'webnus';
                $arg->homepage = $this->itemurl;
                $arg->banners['low'] = 'https://0.s3.envato.com/files/202920118/mec-preview1.png';
                
                return $arg;
            }
        }
        
        return false;
    }

    /**
     * Return details from envato
     * @author Webnus <info@webnus.biz>
     * @param string $type
     * @return mixed
     */
    public function get_MEC_info($type = 'dl')
    {
        // setting the header for the rest of the api
        $code = $this->get_purchase_code();
        $url  = get_home_url();
        $multi  = is_multisite();

        if($type == 'remove') $verify_url = 'http://webnus.net/api/remove?id='.$code;
        elseif($type == 'dl') $verify_url = 'http://webnus.net/api/verify?id='.$code.'&url='.$url.'&multi='.$multi;
        elseif($type == 'version') $verify_url = 'http://webnus.net/api/version';
        else return NULL;
        
        $ch_verify = curl_init($verify_url);

        curl_setopt($ch_verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch_verify, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch_verify, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Envato Marketplace API Wrapper PHP)');

        $cinit_verify_data = curl_exec($ch_verify);
        curl_close($ch_verify);
        
        if($cinit_verify_data != '') return json_decode($cinit_verify_data);  
        else return false;
    }
}