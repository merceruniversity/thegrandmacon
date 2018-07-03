<?php
/** no direct access **/
defined('_MECEXEC_') or die();

$event_id = $event->ID;
?>
<h4><?php _e('Thanks for your booking.', 'mec'); ?></h4>
<?php if(isset($message)): ?>
<div class="mec-event-book-message">
    <div class="<?php echo (isset($message_class) ? $message_class : ''); ?>"><?php echo $message; ?></div>
</div>
<?php endif;