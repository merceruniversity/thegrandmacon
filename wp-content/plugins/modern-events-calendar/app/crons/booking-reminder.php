<?php
/**
 *  WordPress initializing
 */
function mec_find_wordpress_base_path()
{
    $dir = dirname(__FILE__);
    
    do
    {
        if(file_exists($dir.'/wp-config.php')) return $dir;
    }
    while($dir = realpath($dir.'/..'));
    
    return NULL;
}

define('BASE_PATH', mec_find_wordpress_base_path().'/');
define('WP_USE_THEMES', false);

global $wp, $wp_query, $wp_the_query, $wp_rewrite, $wp_did_header;
require(BASE_PATH.'wp-load.php');

// MEC libraries
$main = MEC::getInstance('app.libraries.main');

// MEC notifications
$notifications = $main->get_notifications();

// The Booking reminder is disabled
if(!isset($notifications['booking_reminder']) or (isset($notifications['booking_reminder']) and !$notifications['booking_reminder']['status']))
{
    echo __('Booking reminder notification is not enabled!', 'mec');
    exit;
}

// MEC Settings
$settings = $main->get_settings();

// Booking is disabled
if(!isset($settings['booking_status']) or (isset($settings['booking_status']) and !$settings['booking_status']))
{
    echo __('Booking module is not enabled!', 'mec');
    exit;
}

$days = isset($notifications['booking_reminder']['days']) ? explode(',', trim($notifications['booking_reminder']['days'], ', ')) : array();

// Days are invalid
if(!is_array($days) or (is_array($days) and !count($days)))
{
    echo __('Inserted days are not valid. Please try 1,3 as a valid value!', 'mec');
    exit;
}

$sent_reminders = 0;
$today = current_time('Y-m-d');

// Notification Sender Library
$notif = $main->getNotifications();

foreach($days as $day)
{
    $day = (int) trim($day, ', ');

    // day is not accepted as a valid value for days
    if($day <= 0) continue;

    // It's time of the day that we're going to check
    $time = strtotime('+'.$day.' days', strtotime($today));

    $q = new WP_Query();
    $bookings = $q->query(array
    (
        'post_type'=>$main->get_book_post_type(),
        'posts_per_page'=>-1,
        'post_status'=>array('future', 'publish'),
        'meta_query'=>array
        (
            array(
                'key'=>'mec_confirmed',
                'value'=>1,
            ),
            array(
                'key'=>'mec_verified',
                'value'=>1,
            ),
        ),
        'year'=>date('Y', $time),
        'monthnum'=>date('n', $time),
        'day'=>date('j', $time),
    ));

    // No booking found for this date so proceed to next date
    if(!count($bookings)) continue;

    foreach($bookings as $booking)
    {
        $result = $notif->booking_reminder($booking->ID);
        if($result) $sent_reminders++;
    }
}

echo sprintf(__('%s reminders sent.', 'mec'), $sent_reminders);
exit;