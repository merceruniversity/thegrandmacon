<?php
/** no direct access **/
defined('_MECEXEC_') or die();

$styling = $this->main->get_styling();
$event_colorskin = (isset($styling['mec_colorskin']) or isset($styling['color'])) ? 'colorskin-custom' : '';
$settings = $this->main->get_settings();
?>
<div class="mec-wrap <?php echo $event_colorskin; ?>">
    <div class="mec-event-carousel-<?php echo $this->style; ?>">
        <div class='mec-owl-crousel-skin-<?php echo ($this->style == 'type1' ? 'type1' : 'type2'); ?> mec-owl-carousel mec-owl-theme'>
            <?php
                foreach($this->events as $date):
                foreach($date as $event):

                // Skip to next event if there is no image
                if(empty($event->data->thumbnails['meccarouselthumb'])) continue;
                    
                $location = isset($event->data->locations[$event->data->meta['mec_location_id']])? $event->data->locations[$event->data->meta['mec_location_id']] : array();
                $organizer = isset($event->data->organizers[$event->data->meta['mec_organizer_id']])? $event->data->organizers[$event->data->meta['mec_organizer_id']] : array();
                $event_color = isset($event->data->meta['mec_color']) ? '<span class="event-color" style="background: #'.$event->data->meta['mec_color'].'"></span>' : '';
            ?>
            <article class="mec-event-article mec-clear">
                <?php if($this->style == 'type1'):  ?>
                <div class="event-carousel-type1-head clearfix">
                    <div class="mec-event-date mec-color">
                        <div class="mec-event-image">
                            <?php echo $event->data->thumbnails['meccarouselthumb']; ?>
                        </div>
                        <div class="mec-event-date-carousel">
                            <?php echo date_i18n($this->date_format_type1_1, strtotime($event->date['start']['date'])); ?>
                            <div class="mec-event-date-info"><?php echo date_i18n($this->date_format_type1_2, strtotime($event->date['start']['date'])); ?></div>
                            <div class="mec-event-date-info-year"><?php echo date_i18n($this->date_format_type1_3, strtotime($event->date['start']['date'])); ?></div>
                        </div>
                    </div>
                </div>
                <div class="mec-event-carousel-content">
                    <h4 class="mec-event-carousel-title"><a class="mec-color-hover" href="<?php echo $this->main->get_event_date_permalink($event->data->permalink, $event->date['start']['date']); ?>"><?php echo $event->data->title; ?></a></h4>
                    <p><?php echo (isset($location['name']) ? $location['name'] : ''); echo (isset($location['address']) ? '<br>'.$location['address'] : ''); ?></p>
                </div>
                <?php elseif($this->style == 'type2'): ?>
                <div class="event-carousel-type2-head clearfix">
                    <div class="mec-event-image">
                        <?php echo $event->data->thumbnails['meccarouselthumb']; ?>
                    </div>
                    <div class="mec-event-carousel-content-type2">
                        <?php if(isset($settings['multiple_day_show_method']) && $settings['multiple_day_show_method'] == 'all_days') : ?>
                            <span class="mec-event-date-info"><?php echo date_i18n($this->date_format_type2_1, strtotime($event->date['start']['date'])); ?></span>
                        <?php else: ?>
                            <span class="mec-event-date-info"><?php echo $this->main->date_label($event->date['start'], $event->date['end'], $this->date_format_type2_1); ?></span>
                        <?php endif; ?>
                        <h4 class="mec-event-carousel-title"><a class="mec-color-hover" href="<?php echo $this->main->get_event_date_permalink($event->data->permalink, $event->date['start']['date']); ?>"><?php echo $event->data->title; ?></a></h4>
                        <p><?php echo (isset($location['name']) ? $location['name'] : ''); echo (isset($location['address']) ? '<br>'.$location['address'] : ''); ?></p>
                    </div>
                    <div class="mec-event-footer-carousel-type2">
                        <ul class="mec-event-sharing-wrap">
                            <li class="mec-event-share">
                                <a href="#" class="mec-event-share-icon">
                                    <i class="mec-sl-share mec-bg-color-hover mec-border-color-hover"></i>
                                </a>
                            </li>
                            <ul class="mec-event-sharing"><?php echo $this->main->module('links.list', array('event'=>$event)); ?></ul>
                        </ul>
                        <a class="mec-booking-button mec-bg-color-hover mec-border-color-hover" href="<?php echo $this->main->get_event_date_permalink($event->data->permalink, $event->date['start']['date']); ?>" target="_self"><?php echo (is_array($event->data->tickets) and count($event->data->tickets)) ? $this->main->m('register_button', __('REGISTER', 'mec')) : $this->main->m('view_detail', __('View Detail', 'mec')) ; ?></a>
                    </div>
                </div>
                <?php elseif($this->style == 'type3'): ?>
                <div class="event-carousel-type3-head clearfix">
                    <div class="mec-event-image">
                        <?php echo $event->data->thumbnails['meccarouselthumb']; ?>
                    </div>
                    <div class="mec-event-footer-carousel-type3">
                        <?php if(isset($settings['multiple_day_show_method']) && $settings['multiple_day_show_method'] == 'all_days') : ?>
                            <div class="mec-event-date-info"><?php echo date_i18n($this->date_format_type3_1, strtotime($event->date['start']['date'])); ?></div>
                        <?php else: ?>
                            <span class="mec-event-date-info"><?php echo $this->main->date_label($event->date['start'], $event->date['end'], $this->date_format_type3_1); ?></span>
                        <?php endif; ?>
                        <h4 class="mec-event-carousel-title"><a class="mec-color-hover" href="<?php echo $this->main->get_event_date_permalink($event->data->permalink, $event->date['start']['date']); ?>"><?php echo $event->data->title; ?></a></h4>
                        <p><?php echo (isset($location['name']) ? $location['name'] : ''); echo (isset($location['address']) ? '<br>'.$location['address'] : ''); ?></p>
                        <ul class="mec-event-sharing-wrap">
                            <li class="mec-event-share">
                                <a href="#" class="mec-event-share-icon">
                                    <i class="mec-sl-share mec-bg-color-hover mec-border-color-hover"></i>
                                </a>
                            </li>
                            <ul class="mec-event-sharing"><?php echo $this->main->module('links.list', array('event'=>$event)); ?>
                            </ul>
                        </ul>
                        <a class="mec-booking-button mec-bg-color-hover mec-border-color-hover" href="<?php echo $this->main->get_event_date_permalink($event->data->permalink, $event->date['start']['date']); ?>" target="_self"><?php echo (is_array($event->data->tickets) and count($event->data->tickets)) ? $this->main->m('register_button', __('REGISTER', 'mec')) : $this->main->m('view_detail', __('View Detail', 'mec')) ; ?></a>
                    </div>
                </div>
                <?php endif; ?>
            </article>
            <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
	</div>
</div>