<?php
/** no direct access **/
defined('_MECEXEC_') or die();

// MEC Settings
$settings = $this->get_settings();

// BuddyPress integration is disabled
if(!isset($settings['bp_status']) or (isset($settings['bp_status']) and !$settings['bp_status'])) return;
        
// Attendees Module is disabled
if(!isset($settings['bp_attendees_module']) or (isset($settings['bp_attendees_module']) and !$settings['bp_attendees_module'])) return;

// BuddyPress is not installed or activated
if(!function_exists('bp_activity_add')) return;

$date = $event->date;
$start_date = (isset($date['start']) and isset($date['start']['date'])) ? $date['start']['date'] : date('Y-m-d');

$limit = isset($settings['bp_attendees_module_limit']) ? $settings['bp_attendees_module_limit'] : 20;
$bookings = $this->get_bookings($event->data->ID, $start_date, $limit);

// Start Date belongs to future but booking module cannot show so return without any output
if(!$this->can_show_booking_module($event) and strtotime($start_date) > time()) return;

$attendees = array();
foreach($bookings as $booking)
{
    if(!isset($attendees[$booking->post_author])) $attendees[$booking->post_author] = 1;
    else $attendees[$booking->post_author]++;
}
?>
<div class="mec-attendees-list-details mec-frontbox" id="mec_attendees_list_details">
    <h3 class="mec-attendees-list mec-frontbox-title"><?php _e('Event Attendees', 'mec'); ?></h3>
    <?php if(!count($attendees)): ?>
    <p><?php _e('No attendee found! Be the first one to book!', 'mec'); ?></p>
    <?php else: ?>
    <ul>
        <?php foreach($attendees as $attendee_id=>$tickets): ?>
        <li>
            <div class="mec-attendee-avatar">
                <a href="<?php echo bp_core_get_user_domain($attendee_id); ?>" title="<?php echo bp_core_get_user_displayname($attendee_id); ?>">
                    <?php echo bp_core_fetch_avatar(array('item_id'=>$attendee_id, 'type'=>'thumb')); ?>
                </a>
            </div>
            <div class="mec-attendee-profile-link">
                <?php echo bp_core_get_userlink($attendee_id).($tickets > 0 ? ' <span>'.sprintf(__('%s tickets', 'mec'), $tickets).'</span>' : ''); ?>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</div>