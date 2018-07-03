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
$db = $main->getDB();

// Get MEC IX options
$ix = $main->get_ix_options();

$client_id = isset($ix['google_export_client_id']) ? $ix['google_export_client_id'] : NULL;
$client_secret = isset($ix['google_export_client_secret']) ? $ix['google_export_client_secret'] : NULL;
$token = isset($ix['google_export_token']) ? $ix['google_export_token'] : NULL;
$refresh_token = isset($ix['google_export_refresh_token']) ? $ix['google_export_refresh_token'] : NULL;
$calendar_id = isset($ix['google_export_calendar_id']) ? $ix['google_export_calendar_id'] : NULL;

if(!trim($client_id) or !trim($client_secret) or !trim($calendar_id)) exit(__('All of Client App, Client Secret and Calendar ID are required!', 'mec'));

$client = new Google_Client();
$client->setApplicationName('Modern Events Calendar');
$client->setAccessType('offline');
$client->setScopes(array('https://www.googleapis.com/auth/calendar'));
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($main->add_qs_vars(array('mec-ix-action'=>'google-calendar-export-get-token'), $main->URL('backend').'admin.php?page=MEC-ix&tab=MEC-g-calendar-export'));
$client->setAccessToken($token);
$client->refreshToken($refresh_token);

$service = new Google_Service_Calendar($client);

// MEC Render Library
$render = $main->getRender();

// Timezone Options
$timezone = $main->get_timezone();
$gmt_offset = $main->get_gmt_offset('gmt_offset');

$g_events_not_inserted = array();
$g_events_inserted = array();
$g_events_updated = array();

$mec_events = $main->get_events('-1');
foreach($mec_events as $mec_event)
{
    $mec_event_id = $mec_event->ID;
    $data = $render->data($mec_event_id);

    $dates = $render->dates($mec_event_id, $data);
    $date = isset($dates[0]) ? $dates[0] : array();

    $location = isset($data->locations[$data->meta['mec_location_id']]) ? $data->locations[$data->meta['mec_location_id']] : array();
    $organizer = isset($data->organizers[$data->meta['mec_organizer_id']]) ? $data->organizers[$data->meta['mec_organizer_id']] : array();

    $recurrence = array();
    if(isset($data->mec->repeat) and $data->mec->repeat)
    {
        $finish = ($data->mec->end != '0000-00-00' ? date('Ymd\THis\Z', strtotime($data->mec->end.' '.$data->time['end'])) : '');
        $freq = '';
        $interval = '1';
        $byday = '';
        $wkst = '';

        $repeat_type = $data->meta['mec_repeat_type'];
        $week_day_mapping = array('1'=>'MO', '2'=>'TU', '3'=>'WE', '4'=>'TH', '5'=>'FR', '6'=>'SA', '7'=>'SU');

        if($repeat_type == 'daily')
        {
            $freq = 'DAILY';
            $interval = $data->mec->rinterval;
        }
        elseif($repeat_type == 'weekly')
        {
            $freq = 'WEEKLY';
            $interval = ($data->mec->rinterval/7);
        }
        elseif($repeat_type == 'monthly') $freq = 'MONTHLY';
        elseif($repeat_type == 'yearly') $freq = 'YEARLY';
        elseif($repeat_type == 'weekday')
        {
            $mec_weekdays = explode(',', trim($data->mec->weekdays, ','));
            foreach($mec_weekdays as $mec_weekday) $byday .= $week_day_mapping[$mec_weekday].',';

            $byday = trim($byday, ', ');
            $freq = 'WEEKLY';
        }
        elseif($repeat_type == 'weekend')
        {
            $mec_weekdays = explode(',', trim($data->mec->weekdays, ','));
            foreach($mec_weekdays as $mec_weekday) $byday .= $week_day_mapping[$mec_weekday].',';

            $byday = trim($byday, ', ');
            $freq = 'WEEKLY';
        }
        elseif($repeat_type == 'certain_weekdays')
        {
            $mec_weekdays = explode(',', trim($data->mec->weekdays, ','));
            foreach($mec_weekdays as $mec_weekday) $byday .= $week_day_mapping[$mec_weekday].',';

            $byday = trim($byday, ', ');
            $freq = 'WEEKLY';
        }
        elseif($repeat_type == 'custom_days')
        {
            $freq = '';
            $mec_days = explode(',', trim($data->mec->days, ','));

            $days = '';
            foreach($mec_days as $mec_day) $days .= date('Ymd', strtotime($mec_day)).',';

            // Add RDATE
            $recurrence[] = trim('RDATE;VALUE=DATE:'.trim($days, ', '), '; ');
        }

        $rrule = 'RRULE:FREQ='.$freq.';'
                .($interval > 1 ? 'INTERVAL='.$interval.';' : '')
                .(($finish != '0000-00-00' and $finish != '') ? 'UNTIL='.$finish.';' : '')
                .($wkst != '' ? 'WKST='.$wkst.';' : '')
                .($byday != '' ? 'BYDAY='.$byday.';' : '');

        // Add RRULE
        if(trim($freq)) $recurrence[] = trim($rrule, '; ');

        if(trim($data->mec->not_in_days))
        {
            $mec_not_in_days = explode(',', trim($data->mec->not_in_days, ','));

            $not_in_days = '';
            foreach($mec_not_in_days as $mec_not_in_day) $not_in_days .= date('Ymd', strtotime($mec_not_in_day)).',';

            // Add EXDATE
            $recurrence[] = trim('EXDATE;VALUE=DATE:'.trim($not_in_days, ', '), '; ');
        }
    }

    $event = new Google_Service_Calendar_Event(array
    (
        'summary'=>$data->title,
        'location'=>(isset($location['address']) ? $location['address'] : (isset($location['name']) ? $location['name'] : '')),
        'description'=>$data->content,
        'start'=>array(
            'dateTime'=>date('Y-m-d\TH:i:s', strtotime($date['start']['date'].' '.$data->time['start'])).$gmt_offset,
            'timeZone'=>$timezone,
        ),
        'end'=>array(
            'dateTime'=>date('Y-m-d\TH:i:s', strtotime($date['end']['date'].' '.$data->time['end'])).$gmt_offset,
            'timeZone'=>$timezone,
        ),
        'recurrence'=>$recurrence,
        'attendees'=>array(),
        'reminders'=>array(),
    ));

    $iCalUID = 'mec-ical-'.$data->ID;

    $mec_iCalUID = get_post_meta($data->ID, 'mec_gcal_ical_uid', true);
    $mec_calendar_id = get_post_meta($data->ID, 'mec_gcal_calendar_id', true);

    /**
     * Event is imported from same google calendar
     * and now it's exporting to its calendar again
     * so we're trying to update existing one by setting event iCal ID
     */
    if($mec_calendar_id == $calendar_id and trim($mec_iCalUID)) $iCalUID = $mec_iCalUID;

    $event->setICalUID($iCalUID);

    // Set the organizer if exists
    if(isset($organizer['name']))
    {
        $g_organizer = new Google_Service_Calendar_EventOrganizer();
        $g_organizer->setDisplayName($organizer['name']);
        $g_organizer->setEmail($organizer['email']);

        $event->setOrganizer($g_organizer);
    }

    try
    {
        $g_event = $service->events->insert($calendar_id, $event);

        // Set Google Calendar ID to MEC databse for updating it in the future instead of adding it twice
        update_post_meta($data->ID, 'mec_gcal_ical_uid', $g_event->getICalUID());
        update_post_meta($data->ID, 'mec_gcal_id', $g_event->getId());

        $g_events_inserted[] = array('title'=>$data->title, 'message'=>$g_event->htmlLink);
    }
    catch(Exception $ex)
    {
        // Event already existed
        if($ex->getCode() == 409)
        {
            try
            {
                $g_event_id = get_post_meta($data->ID, 'mec_gcal_id', true);
                $g_event = $service->events->get($calendar_id, $g_event_id);
                foreach($event as $k=>$v) $g_event->$k = $v;

                $g_updated_event = $service->events->update($calendar_id, $g_event->getId(), $g_event);
                $g_events_updated[] = array('title'=>$data->title, 'message'=>$g_updated_event->htmlLink);
            }
            catch(Exception $ex)
            {
                $g_events_not_inserted[] = array('title'=>$data->title, 'message'=>$ex->getMessage());
            }
        }
        else $g_events_not_inserted[] = array('title'=>$data->title, 'message'=>$ex->getMessage());
    }
}

$results = '<ul>';
foreach($g_events_not_inserted as $g_event_not_inserted) $results .= '<li><strong>'.$g_event_not_inserted['title'].'</strong>: '.$g_event_not_inserted['message'].'</li>';
$results .= '<ul>';

$message = (count($g_events_inserted) ? sprintf(__('%s events added to Google Calendar successfully.', 'mec'), '<strong>'.count($g_events_inserted).'</strong>') : '');
$message .= (count($g_events_updated) ? ' '.sprintf(__('%s previously added events get updated.', 'mec'), '<strong>'.count($g_events_updated).'</strong>') : '');
$message .= (count($g_events_not_inserted) ? ' '.sprintf(__('%s events failed to add for following reasons: %s', 'mec'), '<strong>'.count($g_events_not_inserted).'</strong>', $results) : '');

exit($message);