<?php
/** no direct access **/
defined('_MECEXEC_') or die();

/**
 * Webnus MEC notifications class
 * @author Webnus <info@webnus.biz>
 */
class MEC_notifications extends MEC_base
{
    public $main;
    public $PT;
    public $notif_settings;
    public $settings;
    public $book;

    /**
     * Constructor method
     * @author Webnus <info@webnus.biz>
     */
    public function __construct()
    {
        // Import MEC Main
        $this->main = $this->getMain();
        
        // MEC Book Post Type Name
        $this->PT = $this->main->get_book_post_type();
        
        // MEC Notification Settings
        $this->notif_settings = $this->main->get_notifications();
        
        // MEC Settings
        $this->settings = $this->main->get_settings();

        // MEC Book
        $this->book = $this->getBook();
    }
    
    /**
     * Send email verification notification
     * @author Webnus <info@webnus.biz>
     * @param int $book_id
     * @return boolean
     */
    public function email_verification($book_id)
    {
        $booker_id = get_post_field('post_author', $book_id);
        $booker = get_userdata($booker_id);
        
        if(!isset($booker->user_email)) return false;
        
        $price = get_post_meta($book_id, 'mec_price', true);
        
        // Auto verification for free bookings is enabled so don't send the verification email
        if($price <= 0 and isset($this->settings['booking_auto_verify_free']) and $this->settings['booking_auto_verify_free'] == 1) return false;
        
        // Auto verification for paid bookings is enabled so don't send the verification email
        if($price > 0 and isset($this->settings['booking_auto_verify_paid']) and $this->settings['booking_auto_verify_paid'] == 1) return false;
        
        $to = $booker->user_email;
        $subject = isset($this->notif_settings['email_verification']['subject']) ? $this->content(__($this->notif_settings['email_verification']['subject'], 'mec'), $book_id) : __('Please verify your email.', 'mec');
        $headers = array();
        
        $recipients_str = isset($this->notif_settings['email_verification']['recipients']) ? $this->notif_settings['email_verification']['recipients'] : '';
        $recipients = trim($recipients_str) ? explode(',', $recipients_str) : array();
        
        foreach($recipients as $recipient)
        {
            // Skip if it's not a valid email
            if(trim($recipient) == '' or !filter_var($recipient, FILTER_VALIDATE_EMAIL)) continue;
            
            $headers[] = 'BCC: '.$recipient;
        }
        
        $message = isset($this->notif_settings['email_verification']['content']) ? $this->content($this->notif_settings['email_verification']['content'], $book_id) : '';
        
        // Book Data
        $key = get_post_meta($book_id, 'mec_verification_key', true);
        
        $event_id = get_post_meta($book_id, 'mec_event_id', true);
        $link = trim(get_permalink($event_id), '/').'/verify/'.$key.'/';
        
        $message = str_replace('%%verification_link%%', $link, $message);
        $message = str_replace('%%link%%', $link, $message);
        
        // Set Email Type to HTML
        add_filter('wp_mail_content_type', array($this->main, 'html_email_type'));
        
        // Send the mail
        wp_mail($to, html_entity_decode(stripslashes($subject), ENT_HTML5), wpautop(stripslashes($message)), $headers);
        
        // Remove the HTML Email filter
        remove_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

        return true;
    }
    
    /**
     * Send booking notification
     * @author Webnus <info@webnus.biz>
     * @param int $book_id
     * @return boolean
     */
    public function booking_notification($book_id)
    {
        $booker_id = get_post_field('post_author', $book_id);
        $booker = get_userdata($booker_id);
        
        if(!isset($booker->user_email)) return false;

        // Booking Notification is disabled
        if(isset($this->notif_settings['booking_notification']['status']) and !$this->notif_settings['booking_notification']['status']) return false;

        $to = $booker->user_email;
        $subject = isset($this->notif_settings['booking_notification']['subject']) ? $this->content(__($this->notif_settings['booking_notification']['subject'], 'mec'), $book_id) : __('Your booking is received.', 'mec');
        $headers = array();
        
        $recipients_str = isset($this->notif_settings['booking_notification']['recipients']) ? $this->notif_settings['booking_notification']['recipients'] : '';
        $recipients = trim($recipients_str) ? explode(',', $recipients_str) : array();
        
        foreach($recipients as $recipient)
        {
            // Skip if it's not a valid email
            if(trim($recipient) == '' or !filter_var($recipient, FILTER_VALIDATE_EMAIL)) continue;
            
            $headers[] = 'BCC: '.$recipient;
        }
        
        // Send the notification to event organizer
        if(isset($this->notif_settings['booking_notification']['send_to_organizer']) and $this->notif_settings['booking_notification']['send_to_organizer'] == 1)
        {
            $organizer_email = $this->get_booking_organizer_email($book_id);
            if($organizer_email !== false) $headers[] = 'BCC: '.trim($organizer_email);
        }
        
        $message = isset($this->notif_settings['booking_notification']['content']) ? $this->content($this->notif_settings['booking_notification']['content'], $book_id) : '';
        
        // Attendee Full Information
        if(strpos($message, '%%attendee_full_info%%') !== false)
        {
            $attendee_full_info = '';

            $meta = $this->main->get_post_meta($book_id);
            $attendee = isset($meta['mec_attendee']) ? $meta['mec_attendee'] : array();

            $reg_form = isset($attendee['reg']) ? $attendee['reg'] : array();
            $reg_fields = $this->main->get_reg_fields();
            
            $attendee_full_info .= __('Name', 'mec').': '.((isset($attendee['name']) and trim($attendee['name'])) ? $attendee['name'] : '---')."\r\n";
            $attendee_full_info .= __('Email', 'mec').': '.((isset($attendee['email']) and trim($attendee['email'])) ? $attendee['email'] : '---')."\r\n";
            
            foreach($reg_form as $field_id=>$value)
            {
                $label = isset($reg_fields[$field_id]) ? $reg_fields[$field_id]['label'] : '';
                $attendee_full_info .= __($label, 'mec').': '.(is_string($value) ? $value : (is_array($value) ? implode(', ', $value) : '---'))."\r\n";
            }
            
            $message = str_replace('%%attendee_full_info%%', $attendee_full_info, $message);
        }
        
        // Set Email Type to HTML
        add_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

        // Send the mail
        wp_mail($to, html_entity_decode(stripslashes($subject), ENT_HTML5), wpautop(stripslashes($message)), $headers);
        
        // Remove the HTML Email filter
        remove_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

        return true;
    }
    
    /**
     * Send booking confirmation notification
     * @author Webnus <info@webnus.biz>
     * @param int $book_id
     * @return boolean
     */
    public function booking_confirmation($book_id)
    {
        $booker_id = get_post_field('post_author', $book_id);
        $booker = get_userdata($booker_id);
        
        if(!isset($booker->user_email)) return false;
        
        $to = $booker->user_email;
        $subject = isset($this->notif_settings['booking_confirmation']['subject']) ? $this->content(__($this->notif_settings['booking_confirmation']['subject'], 'mec'), $book_id) : __('Your booking is confirmed.', 'mec');
        $headers = array();
        
        $recipients_str = isset($this->notif_settings['booking_confirmation']['recipients']) ? $this->notif_settings['booking_confirmation']['recipients'] : '';
        $recipients = trim($recipients_str) ? explode(',', $recipients_str) : array();
        
        foreach($recipients as $recipient)
        {
            // Skip if it's not a valid email
            if(trim($recipient) == '' or !filter_var($recipient, FILTER_VALIDATE_EMAIL)) continue;
            
            $headers[] = 'BCC: '.$recipient;
        }
        
        $message = isset($this->notif_settings['booking_confirmation']['content']) ? $this->content($this->notif_settings['booking_confirmation']['content'], $book_id) : '';
        
        // Book Data
        $key = get_post_meta($book_id, 'mec_cancellation_key', true);
        
        $event_id = get_post_meta($book_id, 'mec_event_id', true);
        $link = trim(get_permalink($event_id), '/').'/cancel/'.$key.'/';
        
        $message = str_replace('%%cancellation_link%%', $link, $message);
        
        // Set Email Type to HTML
        add_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

        // Send the mail
        wp_mail($to, html_entity_decode(stripslashes($subject), ENT_HTML5), wpautop(stripslashes($message)), $headers);
        
        // Remove the HTML Email filter
        remove_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

        return true;
    }
    
    /**
     * Send admin notification
     * @author Webnus <info@webnus.biz>
     * @param int $book_id
     */
    public function admin_notification($book_id)
    {
        $to = get_bloginfo('admin_email');
        $subject = isset($this->notif_settings['admin_notification']['subject']) ? $this->content(__($this->notif_settings['admin_notification']['subject'], 'mec'), $book_id) : __('A new booking is received.', 'mec');
        $headers = array();
        
        $recipients_str = isset($this->notif_settings['admin_notification']['recipients']) ? $this->notif_settings['admin_notification']['recipients'] : '';
        $recipients = trim($recipients_str) ? explode(',', $recipients_str) : array();
        
        foreach($recipients as $recipient)
        {
            // Skip if it's not a valid email
            if(trim($recipient) == '' or !filter_var($recipient, FILTER_VALIDATE_EMAIL)) continue;
            
            $headers[] = 'CC: '.$recipient;
        }
        
        // Send the notification to event organizer
        if(isset($this->notif_settings['admin_notification']['send_to_organizer']) and $this->notif_settings['admin_notification']['send_to_organizer'] == 1)
        {
            $organizer_email = $this->get_booking_organizer_email($book_id);
            if($organizer_email !== false) $headers[] = 'CC: '.trim($organizer_email);
        }
        
        $message = isset($this->notif_settings['admin_notification']['content']) ? $this->content($this->notif_settings['admin_notification']['content'], $book_id) : '';
        
        // Book Data
        $message = str_replace('%%admin_link%%', $this->link(array('post_type'=>$this->main->get_book_post_type()), $this->main->URL('admin').'edit.php'), $message);

        // Attendee Full Information
        if(strpos($message, '%%attendee_full_info%%') !== false)
        {
            $attendee_full_info = '';

            $meta = $this->main->get_post_meta($book_id);
            
            $attendee = isset($meta['mec_attendee']) ? $meta['mec_attendee'] : array();

            $reg_form = isset($attendee['reg']) ? $attendee['reg'] : array();
            $reg_fields = $this->main->get_reg_fields();
            
            $attendee_full_info .= __('Name', 'mec').': '.((isset($attendee['name']) and trim($attendee['name'])) ? $attendee['name'] : '---')."\r\n";
            $attendee_full_info .= __('Email', 'mec').': '.((isset($attendee['email']) and trim($attendee['email'])) ? $attendee['email'] : '---')."\r\n";
            
            foreach($reg_form as $field_id=>$value)
            {
                $label = isset($reg_fields[$field_id]) ? $reg_fields[$field_id]['label'] : '';
                $attendee_full_info .= __($label, 'mec').': '.(is_string($value) ? $value : (is_array($value) ? implode(', ', $value) : '---'))."\r\n";
            }
            
            $message = str_replace('%%attendee_full_info%%', $attendee_full_info, $message);
        }

        // Set Email Type to HTML
        add_filter('wp_mail_content_type', array($this->main, 'html_email_type'));
        
        // Send the mail
        wp_mail($to, html_entity_decode(stripslashes($subject), ENT_HTML5), wpautop(stripslashes($message)), $headers);
        
        // Remove the HTML Email filter
        remove_filter('wp_mail_content_type', array($this->main, 'html_email_type'));
    }

    /**
     * Send booking reminder notification
     * @author Webnus <info@webnus.biz>
     * @param int $book_id
     * @return boolean
     */
    public function booking_reminder($book_id)
    {
        $booker_id = get_post_field('post_author', $book_id);
        $booker = get_userdata($booker_id);

        if(!isset($booker->user_email)) return false;

        $to = $booker->user_email;
        $subject = isset($this->notif_settings['booking_reminder']['subject']) ? $this->content(__($this->notif_settings['booking_reminder']['subject'], 'mec'), $book_id) : __('Booking Reminder', 'mec');
        $headers = array();

        $recipients_str = isset($this->notif_settings['booking_reminder']['recipients']) ? $this->notif_settings['booking_reminder']['recipients'] : '';
        $recipients = trim($recipients_str) ? explode(',', $recipients_str) : array();

        foreach($recipients as $recipient)
        {
            // Skip if it's not a valid email
            if(trim($recipient) == '' or !filter_var($recipient, FILTER_VALIDATE_EMAIL)) continue;

            $headers[] = 'BCC: '.$recipient;
        }

        $message = isset($this->notif_settings['booking_reminder']['content']) ? $this->content($this->notif_settings['booking_reminder']['content'], $book_id) : '';

        // Set Email Type to HTML
        add_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

        // Send the mail
        wp_mail($to, html_entity_decode(stripslashes($subject), ENT_HTML5), wpautop(stripslashes($message)), $headers);

        // Remove the HTML Email filter
        remove_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

        return true;
    }
    
    /**
     * Send booking notification
     * @author Webnus <info@webnus.biz>
     * @param int $event_id
     * @param object $post
     * @param boolean $update
     * @return boolean
     */
    public function new_event($event_id, $post, $update)
    {
        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if(defined('DOING_AUTOSAVE') and DOING_AUTOSAVE) return false;
        
        // MEC Event Post Type
        $event_PT = $this->main->get_main_post_type();
        
        // If it's not a MEC Event
        if(get_post_type($event_id) != $event_PT) return false;
        
        // If it's an update request, then don't send any notification
        if($update) return false;
        
        // New event notification is disabled
        if(!isset($this->notif_settings['new_event']['status']) or (isset($this->notif_settings['new_event']['status']) and !$this->notif_settings['new_event']['status'])) return false;
        
        $status = get_post_status($event_id);

        // Don't send the email if it's auto draft post
        if($status == 'auto-draft') return false;
        
        $to = get_bloginfo('admin_email');
        $subject = (isset($this->notif_settings['new_event']['subject']) and trim($this->notif_settings['new_event']['subject'])) ? __($this->notif_settings['new_event']['subject'], 'mec') : __('A new event is added.', 'mec');
        $headers = array();
        
        $recipients_str = isset($this->notif_settings['new_event']['recipients']) ? $this->notif_settings['new_event']['recipients'] : '';
        $recipients = trim($recipients_str) ? explode(',', $recipients_str) : array();
        
        foreach($recipients as $recipient)
        {
            // Skip if it's not a valid email
            if(trim($recipient) == '' or !filter_var($recipient, FILTER_VALIDATE_EMAIL)) continue;
            
            $headers[] = 'CC: '.$recipient;
        }
        
        $message = (isset($this->notif_settings['new_event']['content']) and trim($this->notif_settings['new_event']['content'])) ? $this->notif_settings['new_event']['content'] : '';
        
        // Site Data
        $message = str_replace('%%blog_name%%', get_bloginfo('name'), $message);
        $message = str_replace('%%blog_url%%', get_bloginfo('url'), $message);
        $message = str_replace('%%blog_description%%', get_bloginfo('description'), $message);
        
        // Book Data
        $message = str_replace('%%admin_link%%', $this->link(array('post_type'=>$event_PT), $this->main->URL('admin').'edit.php'), $message);
        $message = str_replace('%%event_title%%', get_the_title($event_id), $message);
        $message = str_replace('%%event_status%%', $status, $message);
        $message = str_replace('%%event_note%%', get_post_meta($event_id, 'mec_note', true), $message);
        
        // Notification Subject
        $subject = str_replace('%%event_title%%', get_the_title($event_id), $subject);
        
        // Set Email Type to HTML
        add_filter('wp_mail_content_type', array($this->main, 'html_email_type'));
        
        // Send the mail
        wp_mail($to, html_entity_decode(stripslashes($subject), ENT_HTML5), wpautop(stripslashes($message)), $headers);
        
        // Remove the HTML Email filter
        remove_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

        return true;
    }
    
    /**
     * Generate a link based on parameters
     * @author Webnus <info@webnus.biz>
     * @param array $vars
     * @param string $url
     * @return string
     */
    public function link($vars = array(), $url = NULL)
    {
        if(!trim($url)) $url = $this->main->URL('site').$this->main->get_main_slug().'/';
        foreach($vars as $key=>$value) $url = $this->main->add_qs_var($key, $value, $url);
        
        return $url;
    }
    
    /**
     * Generate content of email
     * @author Webnus <info@webnus.biz>
     * @param string $message
     * @param int $book_id
     * @return string
     */
    public function content($message, $book_id)
    {
        $booker_id = get_post_field('post_author', $book_id);
        $booker = get_userdata($booker_id);

        // Attendee Data
        $attendee = get_post_meta($book_id, 'mec_attendee', true);

        $first_name = (isset($booker->first_name) ? $booker->first_name : '');
        $last_name = (isset($booker->last_name) ? $booker->last_name : '');
        $name = (isset($booker->first_name) ? trim($booker->first_name.' '.(isset($booker->last_name) ? $booker->last_name : '')) : '');

        /**
         * Get the attendee name from the value that inserted in booking form instead of registered booker user
         * Sometime clients book multiple tickets with same email but with different names
         */
        if(isset($attendee['name']) and trim($attendee['name']))
        {
            $name = $attendee['name'];
            $attendee_ex_name = explode(' ', $name);

            $first_name = isset($attendee_ex_name[0]) ? $attendee_ex_name[0] : '';
            $last_name = isset($attendee_ex_name[1]) ? $attendee_ex_name[1] : '';
        }

        // Booker Data
        $message = str_replace('%%first_name%%', $first_name, $message);
        $message = str_replace('%%last_name%%', $last_name, $message);
        $message = str_replace('%%name%%', $name, $message);
        $message = str_replace('%%user_email%%', (isset($booker->user_email) ? $booker->user_email : ''), $message);
        $message = str_replace('%%user_id%%', (isset($booker->ID) ? $booker->ID : ''), $message);
        
        // Site Data
        $message = str_replace('%%blog_name%%', get_bloginfo('name'), $message);
        $message = str_replace('%%blog_url%%', get_bloginfo('url'), $message);
        $message = str_replace('%%blog_description%%', get_bloginfo('description'), $message);
        
        // Book Data
        $transaction_id = get_post_meta($book_id, 'mec_transaction_id', true);

        $message = str_replace('%%book_date%%', get_the_date('', $book_id), $message);
        $message = str_replace('%%invoice_link%%', $this->book->get_invoice_link($transaction_id), $message);

        // Booking Price
        $price = get_post_meta($book_id, 'mec_price', true);
        $message = str_replace('%%book_price%%', $this->main->render_price(($price ? $price : 0)), $message);
        $message = str_replace('%%total_attendees%%', $this->book->get_total_attendees($book_id), $message);
        
        // Event Data
        $event_id = get_post_meta($book_id, 'mec_event_id', true);
        $organizer_id = get_post_meta($event_id, 'mec_organizer_id', true);
        $location_id = get_post_meta($event_id, 'mec_location_id', true);

        $organizer = get_term($organizer_id, 'mec_organizer');
        $location = get_term($location_id, 'mec_location');
        
        $message = str_replace('%%event_title%%', get_the_title($event_id), $message);
        
        $message = str_replace('%%event_organizer_name%%', (isset($organizer->name) ? $organizer->name : ''), $message);
        $message = str_replace('%%event_organizer_tel%%', get_term_meta($organizer_id, 'tel', true), $message);
        $message = str_replace('%%event_organizer_email%%', get_term_meta($organizer_id, 'email', true), $message);
        
        $message = str_replace('%%event_location_name%%', (isset($location->name) ? $location->name : ''), $message);
        $message = str_replace('%%event_location_address%%', get_term_meta($location_id, 'address', true), $message);
        
        return $message;
    }
    
    /**
     * Get Booking Organizer Email by Book ID
     * @author Webnus <info@webnus.biz>
     * @param int $book_id
     * @return string
     */
    public function get_booking_organizer_email($book_id)
    {
        $event_id = get_post_meta($book_id, 'mec_event_id', true);
        $organizer_id = get_post_meta($event_id, 'mec_organizer_id', true);
        $email = get_term_meta($organizer_id, 'email', true);
        
        return trim($email) ? $email : false;
    }
}