<?php
/** no direct access **/
defined('_MECEXEC_') or die();

$styling = $this->main->get_styling();
$event = $this->events[0];

// Event is not valid!
if(!isset($event->data)) return;

$event_colorskin = (isset($styling['mec_colorskin']) || isset($styling['color'])) ? 'colorskin-custom' : '';
$event_location = isset($event->data->locations[$event->data->meta['mec_location_id']]) ? $event->data->locations[$event->data->meta['mec_location_id']] : array();
$event_organizer = isset($event->data->organizers[$event->data->meta['mec_organizer_id']]) ? $event->data->organizers[$event->data->meta['mec_organizer_id']] : array();
$event_date = (isset($event->date['start']) ? $event->date['start']['date'] : $event->data->meta['mec_start_date']);
$event_link = (isset($event->data->permalink) and trim($event->data->permalink)) ? $this->main->get_event_date_permalink($event->data->permalink, $event_date) : get_permalink($event->data->ID);
$event_title = $event->data->title;

$start_date = (isset($event->date['start']) and isset($event->date['start']['date'])) ? $event->date['start']['date'] : date('Y-m-d H:i:s');

$event_time = '';
$event_time .= sprintf("%02d", (isset($event->data->meta['mec_date']['start']['hour']) ? $event->data->meta['mec_date']['start']['hour'] : 8)).':';
$event_time .= sprintf("%02d", (isset($event->data->meta['mec_date']['start']['minutes']) ? $event->data->meta['mec_date']['start']['minutes'] : 0));
$event_time .= (isset($event->data->meta['mec_date']['start']['ampm']) ? $event->data->meta['mec_date']['start']['ampm'] : 'AM');

$start_time = date('D M j Y G:i:s', strtotime($start_date.' '.date('H:i:s', strtotime($event_time))));

$d1 = new DateTime($start_time);
$d2 = new DateTime(date("D M j Y G:i:s"));

// Skip if event is expired
if($d1 < $d2) return;

$gmt_offset = $this->main->get_gmt_offset();
if(isset($_SERVER['HTTP_USER_AGENT']) and strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') === false) $gmt_offset = ' : '.$gmt_offset;
if(isset($_SERVER['HTTP_USER_AGENT']) and strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') == true)$gmt_offset = substr(trim($gmt_offset), 0 , 3);
if(isset($_SERVER['HTTP_USER_AGENT']) and strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') == true) $gmt_offset = substr(trim($gmt_offset), 2 , 3);

// Generating javascript code of countdown module
$javascript = '<script type="text/javascript">
jQuery(document).ready(function()
{
    jQuery("#mec_skin_countdown'.$this->id.'").mecCountDown(
    {
        date: "'.$start_time.$gmt_offset.'",
        format: "off"
    },
    function()
    {
    });
});
</script>';

// Include javascript code into the footer
$this->factory->params('footer', $javascript);
?>
<style>
.mec-wrap .mec-event-countdown-style2, .mec-wrap .mec-event-countdown-style1, .mec-event-countdown-style1 .mec-event-countdown-part3 .mec-event-button {background: <?php echo $this->bg_color; ?> ;}
.mec-wrap .mec-event-countdown-style1 .mec-event-countdown-part2:after { border-color: transparent transparent transparent<?php echo $this->bg_color; ?>;}
</style>
<div class="mec-wrap <?php echo $this->html_class; ?>" id="mec_skin_<?php echo $this->id; ?>">
    <?php if($this->style == 'style1'): ?>
    <article class="mec-event-countdown-style1 col-md-12">
        <div class="mec-event-countdown-part1 col-md-4">
            <div class="mec-event-upcoming"><?php echo sprintf(__('%s Upcoming Event', 'mec'), '<span>'.__('Next', 'mec').'</span>'); ?></div>
            <h4 class="mec-event-title"><?php echo $event_title; ?></h4>
        </div>
        <div class="mec-event-countdown-part2 col-md-5">
            <div class="mec-event-date-place">
                <div class="mec-event-date"><?php echo date_i18n($this->date_format_style11, strtotime($event_date)); ?></div>
                <div class="mec-event-place"><?php echo (isset($event_location['name']) ? ' - '.$event_location['name'] : ''); ?></div>
            </div>
            <div class="mec-event-countdown" id="mec_skin_countdown<?php echo $this->id; ?>">
                <ul class="clockdiv" id="countdown">
                    <div class="days-w block-w">
                        <li>
                            <span class="mec-days">00</span>
                            <p class="mec-timeRefDays label-w"><?php _e('days', 'mec'); ?></p>
                        </li>
                    </div>
                    <div class="hours-w block-w">    
                        <li>
                            <span class="mec-hours">00</span>
                            <p class="mec-timeRefHours label-w"><?php _e('hours', 'mec'); ?></p>
                        </li>
                    </div>  
                    <div class="minutes-w block-w">
                        <li>
                            <span class="mec-minutes">00</span>
                            <p class="mec-timeRefMinutes label-w"><?php _e('minutes', 'mec'); ?></p>
                        </li>
                    </div>
                    <div class="seconds-w block-w">
                        <li>
                            <span class="mec-seconds">00</span>
                            <p class="mec-timeRefSeconds label-w"><?php _e('seconds', 'mec'); ?></p>
                        </li>
                    </div>
                </ul>
            </div>
        </div>
        <div class="mec-event-countdown-part3 col-md-3">
            <a class="mec-event-button" href="<?php echo $event_link; ?>"><?php echo $this->main->m('event_detail', __('EVENT DETAIL', 'mec')); ?></a>
        </div>
    </article>
    <?php elseif($this->style == 'style2'): ?>
    <article class="mec-event-countdown-style2">
        <div class="mec-event-countdown-part1 col-md-4">
            <div class="mec-event-upcoming"><?php echo sprintf(__('%s Upcoming Event', 'mec'), '<span>'.__('Next', 'mec').'</span>'); ?></div>
            <h4 class="mec-event-title"><?php echo $event_title; ?></h4>
        </div>
        <div class="mec-event-countdown-part2 col-md-5">
            <div class="mec-event-date-place">
                <div class="mec-event-date"><?php echo date_i18n($this->date_format_style21, strtotime($event_date)); ?></div>
                <div class="mec-event-place"><?php echo (isset($event_location['name']) ? ' - '.$event_location['name'] : ''); ?></div>
            </div>
            <div class="mec-event-countdown" id="mec_skin_countdown<?php echo $this->id; ?>">
                <ul class="clockdiv" id="countdown">
                    <div class="days-w block-w">
                        <li>
                            <span class="mec-days">00</span>
                            <p class="mec-timeRefDays label-w"><?php _e('days', 'mec'); ?></p>
                        </li>
                    </div>
                    <div class="hours-w block-w">    
                        <li>
                            <span class="mec-hours">00</span>
                            <p class="mec-timeRefHours label-w"><?php _e('hours', 'mec'); ?></p>
                        </li>
                    </div>  
                    <div class="minutes-w block-w">
                        <li>
                            <span class="mec-minutes">00</span>
                            <p class="mec-timeRefMinutes label-w"><?php _e('minutes', 'mec'); ?></p>
                        </li>
                    </div>
                    <div class="seconds-w block-w">
                        <li>
                            <span class="mec-seconds">00</span>
                            <p class="mec-timeRefSeconds label-w"><?php _e('seconds', 'mec'); ?></p>
                        </li>
                    </div>
                </ul>
            </div>
        </div>
        <div class="mec-event-countdown-part3 col-md-3">
            <a class="mec-event-button" href="<?php echo $event_link; ?>"><?php echo $this->main->m('event_detail', __('EVENT DETAIL', 'mec')); ?></a>
        </div>
    </article>
    <?php elseif($this->style == 'style3'): ?>
    <article class="mec-event-countdown-style3">
        <div class="mec-event-countdown-part1">
            <div class="mec-event-countdown-part-title">
                <div class="mec-event-upcoming"><?php echo sprintf(__('%s Upcoming Event', 'mec'), '<span>'.__('Next', 'mec').'</span>'); ?></div>
            </div>
            <div class="mec-event-countdown-part-details">
                <div class="mec-event-date">
                    <span class="mec-date1"><?php echo date_i18n($this->date_format_style31, strtotime($event_date)); ?></span>
                    <span class="mec-date2"><?php echo date_i18n($this->date_format_style32, strtotime($event_date)); ?></span>
                    <span class="mec-date3"><?php echo date_i18n($this->date_format_style33, strtotime($event_date)); ?></span>
                </div>
                <div class="mec-event-title-link">
                    <h4 class="mec-event-title"><?php echo $event_title; ?></h4>
                    <a class="mec-event-link" href="<?php echo $event_link; ?>"><?php echo $this->main->m('event_detail', __('Event Detail', 'mec')); ?></a>
                </div>
                <div class="mec-event-countdown" id="mec_skin_countdown<?php echo $this->id; ?>">
                    <ul class="clockdiv" id="countdown">
                        <div class="days-w block-w">
                            <li>
                                <span class="mec-days">00</span>
                                <p class="mec-timeRefDays label-w"><?php _e('days', 'mec'); ?></p>
                            </li>
                        </div>
                        <div class="hours-w block-w">    
                            <li>
                                <span class="mec-hours">00</span>
                                <p class="mec-timeRefHours label-w"><?php _e('hours', 'mec'); ?></p>
                            </li>
                        </div>  
                        <div class="minutes-w block-w">
                            <li>
                                <span class="mec-minutes">00</span>
                                <p class="mec-timeRefMinutes label-w"><?php _e('minutes', 'mec'); ?></p>
                            </li>
                        </div>
                        <div class="seconds-w block-w">
                            <li>
                                <span class="mec-seconds">00</span>
                                <p class="mec-timeRefSeconds label-w"><?php _e('seconds', 'mec'); ?></p>
                            </li>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        <div class="mec-event-countdown-part2">
            <div class="mec-event-image">
                <?php echo $event->data->thumbnails['meccarouselthumb']; ?>
            </div>
        </div>
    </article>
    <?php endif; ?>
</div>