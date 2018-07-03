<?php
/** no direct access **/
defined('_MECEXEC_') or die();

$has_events = array();
?>
<?php if($this->style == 'modern'): ?>
<div class="mec-timetable-day-events mec-clear mec-weekly-view-dates-events">
    <?php foreach($this->events as $date=>$events): $week = $this->week_of_days[$date]; ?>
    <?php
        if(!isset($has_events[$week]))
        {
            foreach($this->weeks[$week] as $weekday) if(isset($this->events[$weekday]) and count($this->events[$weekday])) $has_events[$week] = true;
        }
    ?>
    <?php if(count($events)): ?>
    <div class="mec-timetable-events-list <?php echo ($date == $this->active_date ? '' : 'mec-util-hidden'); ?> mec-weekly-view-date-events mec-calendar-day-events mec-clear mec-weekly-view-week-<?php echo $this->id; ?>-<?php echo date('Ym', strtotime($date)).$week; ?>" id="mec_weekly_view_date_events<?php echo $this->id; ?>_<?php echo date('Ymd', strtotime($date)); ?>" data-week-number="<?php echo $week; ?>">
        <?php foreach($events as $event): ?>
            <?php
                $location = isset($event->data->locations[$event->data->meta['mec_location_id']]) ? $event->data->locations[$event->data->meta['mec_location_id']] : array();
                $organizer = isset($event->data->organizers[$event->data->meta['mec_organizer_id']]) ? $event->data->organizers[$event->data->meta['mec_organizer_id']] : array();
                $start_time = (isset($event->data->time) ? $event->data->time['start'] : '');
                $end_time = (isset($event->data->time) ? $event->data->time['end'] : '');
                $event_color = isset($event->data->meta['mec_color']) ? '<span class="event-color" style="background: #'.$event->data->meta['mec_color'].'"></span>' : '';
            ?>
            <article class="mec-timetable-event mec-timetable-day-<?php echo $this->id; ?>-<?php echo date('Ymd', strtotime($date)); ?>">
                <span class="mec-timetable-event-span mec-timetable-event-time">
                    <i class="mec-sl-clock"></i>
                    <?php if(trim($start_time)): ?>
                    <span><?php echo $start_time.(trim($end_time) ? ' - '.$end_time : ''); ?></span>
                    <?php endif; ?>
                </span>
                <span class="mec-timetable-event-span mec-timetable-event-title">
                    <a class="mec-color-hover" data-event-id="<?php echo $event->data->ID; ?>" href="<?php echo $this->main->get_event_date_permalink($event->data->permalink, $event->date['start']['date']); ?>"><?php echo $event->data->title; ?></a><?php echo $event_color; ?>
                </span>
                <span class="mec-timetable-event-span mec-timetable-event-location">
                    <i class="mec-sl-location-pin"></i>
                    <?php if(isset($location['name']) and trim($location['name'])): ?>
                    <span><?php echo (isset($location['name']) ? $location['name'] : ''); ?></span>
                    <?php endif; ?>
                </span>
                <span class="mec-timetable-event-span mec-timetable-event-organizer">
                    <i class="mec-sl-user"></i>
                    <?php if(isset($organizer['name']) and trim($organizer['name'])): ?>
                    <span><?php echo (isset($organizer['name']) ? $organizer['name'] : ''); ?></span>
                    <?php endif; ?>
                </span>
            </article>
        <?php endforeach; ?>
    </div>
    <?php elseif(!isset($has_events[$week])): $has_events[$week] = 'printed'; ?>
    <div class="mec-timetable-events-list mec-weekly-view-date-events mec-util-hidden mec-calendar-day-events mec-clear mec-weekly-view-week-<?php echo $this->id; ?>-<?php echo date('Ym', strtotime($date)).$week; ?>" id="mec_weekly_view_date_events<?php echo $this->id; ?>_<?php echo date('Ymd', strtotime($date)); ?>" data-week-number="<?php echo $week; ?>">
        <article class="mec-event-article"><h4 class="mec-event-title"><?php _e('No Events', 'mec'); ?></h4><div class="mec-event-detail"></div></article>
    </div>
    <?php endif; ?>
    <?php endforeach; ?>
</div>
<div class="mec-event-footer"></div>
<?php elseif($this->style == 'clean'): ?>
<div class="mec-timetable-t2-wrap">
    <?php foreach($this->events as $date=>$events): ?>
    <div class="mec-timetable-t2-col">
        <div class="mec-ttt2-title"> <?php echo date('l', strtotime($date)); ?> </div>
        <?php foreach($events as $event): ?>
        <?php
            $location = isset($event->data->locations[$event->data->meta['mec_location_id']]) ? $event->data->locations[$event->data->meta['mec_location_id']] : array();
            $organizer = isset($event->data->organizers[$event->data->meta['mec_organizer_id']]) ? $event->data->organizers[$event->data->meta['mec_organizer_id']] : array();
            $start_time = (isset($event->data->time) ? $event->data->time['start'] : '');
            $end_time = (isset($event->data->time) ? $event->data->time['end'] : '');
            $event_color = isset($event->data->meta['mec_color']) ? '<span class="event-color" style="background: #'.$event->data->meta['mec_color'].'"></span>' : '';
        ?>
        <article class="mec-event-article">
            <?php echo $event_color; ?>
            <div class="mec-timetable-t2-content">
                <h4 class="mec-event-title">
                    <a class="mec-color-hover" data-event-id="<?php echo $event->data->ID; ?>" href="<?php echo $this->main->get_event_date_permalink($event->data->permalink, $event->date['start']['date']); ?>"><?php echo $event->data->title; ?></a>
                </h4>
                <div class="mec-event-time">
                    <i class="mec-sl-clock-o"></i>
                    <?php if(trim($start_time)): ?>
                    <span><?php echo $start_time.(trim($end_time) ? ' - '.$end_time : ''); ?></span>
                    <?php endif; ?>
                </div>
                <div class="mec-event-loction">
                    <i class="mec-sl-location-pin"></i>
                    <?php if(isset($location['name']) and trim($location['name'])): ?>
                        <span><?php echo (isset($location['name']) ? $location['name'] : ''); ?></span>
                    <?php endif; ?>
                </div>
                <div class="mec-event-organizer">
                    <i class="mec-sl-user"></i>
                    <?php if(isset($organizer['name']) and trim($organizer['name'])): ?>
                        <span><?php echo (isset($organizer['name']) ? $organizer['name'] : ''); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>