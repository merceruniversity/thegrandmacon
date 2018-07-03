<?php
/** no direct access **/
defined('_MECEXEC_') or die();
?>
<?php foreach($this->events as $date=>$events): ?>
    <div class="mec-events-agenda">

        <div class="mec-agenda-date-wrap">
            <i class="mec-sl-calendar"></i>
            <span class="mec-agenda-day"><?php echo date_i18n($this->date_format_clean_1, strtotime($date)); ?></span>
            <span class="mec-agenda-date"><?php echo date_i18n($this->date_format_clean_2, strtotime($date)); ?></span>
        </div>

        <div class="mec-agenda-events-wrap">
            <?php
                foreach($events as $event)
                {
                    $location = isset($event->data->locations[$event->data->meta['mec_location_id']]) ? $event->data->locations[$event->data->meta['mec_location_id']] : array();
                    $organizer = isset($event->data->organizers[$event->data->meta['mec_organizer_id']]) ? $event->data->organizers[$event->data->meta['mec_organizer_id']] : array();
                    $start_time = (isset($event->data->time) ? $event->data->time['start'] : '');
                    $end_time = (isset($event->data->time) ? $event->data->time['end'] : '');
                    $event_color = isset($event->data->meta['mec_color']) ? '<span class="event-color" style="background: #'.$event->data->meta['mec_color'].'"></span>' : '';
            ?>
                <?php if($this->style == 'clean'): ?>
                    <div class="mec-agenda-event">
                        <i class="mec-sl-clock "></i>
                        <span class="mec-agenda-time">
                            <?php
                                if(trim($start_time))
                                {
                                    echo '<span class="mec-start-time">'.$start_time.'</span>';
                                    if(trim($end_time)) echo ' - <span class="mec-end-time">'.$end_time.'</span>';
                                }
                            ?>
                        </span>
                        <span class="mec-agenda-event-title">
                            <a class="mec-color-hover" data-event-id="<?php echo $event->data->ID; ?>" href="<?php echo $this->main->get_event_date_permalink($event->data->permalink, $event->date['start']['date']); ?>"><?php echo $event->data->title; ?></a>
                            <?php echo $event_color; ?>
                        </span>
                    </div>
                <?php endif; ?>
            <?php } ?>
        </div>
    </div>
<?php endforeach;