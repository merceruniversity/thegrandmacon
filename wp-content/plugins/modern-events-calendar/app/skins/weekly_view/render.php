<?php
/** no direct access **/
defined('_MECEXEC_') or die();

$has_events = array();
?>
<ul class="mec-weekly-view-dates-events">
    <?php foreach($this->events as $date=>$events): $week = $this->week_of_days[$date]; ?>
    <?php
        if(!isset($has_events[$week]))
        {
            foreach($this->weeks[$week] as $weekday) if(isset($this->events[$weekday]) and count($this->events[$weekday])) $has_events[$week] = true;
        }
    ?>
    <?php if(count($events)): ?>
    <li class="mec-weekly-view-date-events mec-util-hidden mec-calendar-day-events mec-clear mec-weekly-view-week-<?php echo $this->id; ?>-<?php echo date('Ym', strtotime($date)).$week; ?>" id="mec_weekly_view_date_events<?php echo $this->id; ?>_<?php echo date('Ymd', strtotime($date)); ?>" data-week-number="<?php echo $week; ?>">
        <?php foreach($events as $event): ?>
            <?php
                $location = isset($event->data->locations[$event->data->meta['mec_location_id']])? $event->data->locations[$event->data->meta['mec_location_id']] : array();
                $start_time = (isset($event->data->time) ? $event->data->time['start'] : '');
                $end_time = (isset($event->data->time) ? $event->data->time['end'] : '');
                $event_color = isset($event->data->meta['mec_color'])?'<span class="event-color" style="background: #'.$event->data->meta['mec_color'].'"></span>':'';
            ?>
            <article class="mec-event-article">
                <div class="mec-event-list-weekly-date mec-color"><span class="mec-date-day"><?php echo date_i18n('d', strtotime($event->date['start']['date'])); ?></span><?php echo date_i18n('F', strtotime($event->date['start']['date'])); ?></div>
                <div class="mec-event-image"><?php echo $event->data->thumbnails['thumbnail']; ?></div>
                <?php if(trim($start_time)): ?><div class="mec-event-time mec-color"><i class="mec-sl-clock-o"></i> <?php echo $start_time.(trim($end_time) ? ' - '.$end_time : ''); ?></div><?php endif; ?>
                <h4 class="mec-event-title"><a class="mec-color-hover" data-event-id="<?php echo $event->data->ID; ?>" href="<?php echo $this->main->get_event_date_permalink($event->data->permalink, $event->date['start']['date']); ?>"><?php echo $event->data->title; ?></a><?php echo $event_color; ?></h4>
                <div class="mec-event-detail"><?php echo (isset($location['name']) ? $location['name'] : ''); ?></div>
            </article>
        <?php endforeach; ?>
    </li>
    <?php elseif(!isset($has_events[$week])): $has_events[$week] = 'printed'; ?>
    <li class="mec-weekly-view-date-events mec-util-hidden mec-calendar-day-events mec-clear mec-weekly-view-week-<?php echo $this->id; ?>-<?php echo date('Ym', strtotime($date)).$week; ?>" id="mec_weekly_view_date_events<?php echo $this->id; ?>_<?php echo date('Ymd', strtotime($date)); ?>" data-week-number="<?php echo $week; ?>">
        <article class="mec-event-article"><h4 class="mec-event-title"><?php _e('No Events', 'mec'); ?></h4><div class="mec-event-detail"></div></article>
    </li>
    <?php endif; ?>
    <?php endforeach; ?>
</ul>
<div class="mec-event-footer"></div>