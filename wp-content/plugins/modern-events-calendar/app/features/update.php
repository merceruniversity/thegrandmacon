<?php
/** no direct access **/
defined('_MECEXEC_') or die();

/**
 * Webnus MEC update class.
 * @author Webnus <info@webnus.biz>
 */
class MEC_feature_update extends MEC_base
{
    /**
     * Constructor method
     * @author Webnus <info@webnus.biz>
     */
    public function __construct()
    {
        // Import MEC Factory
        $this->factory = $this->getFactory();
        
        // Import MEC Main
        $this->main = $this->getMain();
        
        // Import MEC DB
        $this->db = $this->getDB();
    }
    
    /**
     * Initialize update feature
     * @author Webnus <info@webnus.biz>
     */
    public function init()
    {
		// Plugin is not installed yet so no need to run these upgrades
        if(!get_option('mec_installed', 0)) return;
		
        $version = get_option('mec_version', '1.0.0');

        // It's updated to latest version
        if(version_compare($version, $this->main->get_version(), '>=')) return;

        // Run the updates one by one
        if(version_compare($version, '1.0.3', '<')) $this->version103();
        if(version_compare($version, '1.3.0', '<')) $this->version130();
        if(version_compare($version, '1.5.0', '<')) $this->version150();
        if(version_compare($version, '2.2.0', '<')) $this->version220();

        // Update to latest version to prevent running the code twice
        update_option('mec_version', $this->main->get_version());
    }
    
    /**
     * Update database to version 1.0.3
     * @author Webnus <info@webnus.biz>
     */
    public function version103()
    {
        // Get current MEC options
        $current = get_option('mec_options', array());
        if(is_string($current) and trim($current) == '') $current = array();
        
        // Merge new options with previous options
        $current['notifications']['new_event'] = array
        (
            'status'=>'1',
            'subject'=>'A new event is added.',
            'recipients'=>'',
            'content'=>"Hello,

            A new event just added. The event title is %%event_title%% and it's status is %%event_status%%
            The new event may need to be published. Please use this link for managing your website events: %%admin_link%%

            Regards,
            %%blog_name%%"
        );
        
        // Update it only if options already exists.
        if(get_option('mec_options') !== false)
        {
            // Save new options
            update_option('mec_options', $current);
        }
    }
    
    /**
     * Update database to version 1.3.0
     * @author Webnus <info@webnus.biz>
     */
    public function version130()
    {
        $this->db->q("ALTER TABLE `#__mec_events` ADD `days` TEXT NULL DEFAULT NULL, ADD `time_start` INT(10) NOT NULL DEFAULT '0', ADD `time_end` INT(10) NOT NULL DEFAULT '0'");
    }
    
    /**
     * Update database to version 1.5.0
     * @author Webnus <info@webnus.biz>
     */
    public function version150()
    {
        $this->db->q("ALTER TABLE `#__mec_events` ADD `not_in_days` TEXT NOT NULL DEFAULT '' AFTER `days`");
        $this->db->q("ALTER TABLE `#__mec_events` CHANGE `days` `days` TEXT NOT NULL DEFAULT ''");
    }

    /**
     * Update database to version 2.2.0
     * @author Webnus <info@webnus.biz>
     */
    public function version220()
    {
        // Get current MEC options
        $current = get_option('mec_options', array());
        if(is_string($current) and trim($current) == '') $current = array();

        // Merge new options with previous options
        $current['notifications']['booking_reminder'] = array
        (
            'status'=>'0',
            'subject'=>'Booking Reminder',
            'recipients'=>'',
            'days'=>'1,3',
            'content'=>"Hello,

            This email is to remind you that you booked %%event_title%% event on %%book_date%% date.
            We're looking forward to see you at %%event_location_address%%. You can contact %%event_organizer_email%% if you have any questions.

            Regards,
            %%blog_name%%"
        );

        // Update it only if options already exists.
        if(get_option('mec_options') !== false)
        {
            // Save new options
            update_option('mec_options', $current);
        }
    }
}