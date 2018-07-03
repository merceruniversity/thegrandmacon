<?php
/** no direct access **/
defined('_MECEXEC_') or die();

$styling = $this->main->get_styling();
$event_colorskin = (isset($styling['mec_colorskin'] ) || isset($styling['color'])) ? 'colorskin-custom' : '';
$settings = $this->main->get_settings();
?>
<div class="mec-wrap <?php echo $event_colorskin; ?>">
    <div class="mec-event-masonry">
        <?php
        foreach($this->events as $date):
        foreach($date as $event):

        $location = isset($event->data->locations[$event->data->meta['mec_location_id']])? $event->data->locations[$event->data->meta['mec_location_id']] : array();
        $organizer = isset($event->data->organizers[$event->data->meta['mec_organizer_id']])? $event->data->organizers[$event->data->meta['mec_organizer_id']] : array();
        $event_color = isset($event->data->meta['mec_color']) ? '<span class="event-color" style="background: #'.$event->data->meta['mec_color'].'"></span>' : '';

        $start_time = (isset($event->data->time) ? $event->data->time['start'] : '');
        $end_time = (isset($event->data->time) ? $event->data->time['end'] : '');
        ?>
            <div class="mec-masonry-item-wrap <?php echo $this->filter_by_classes($event->data->ID); ?>">
                <div class="mec-masonry">

                    <article class="mec-event-article mec-clear">

                        <?php if(isset($event->data->featured_image) and isset($event->data->featured_image['full']) and trim($event->data->featured_image['full'])): ?>
                        <div class="mec-masonry-img" ><img src="<?php echo $event->data->featured_image['full']; ?>"></div>
                        <?php endif; ?>

                        <div class="mec-masonry-content mec-event-grid-modern">
                            <div class="event-grid-modern-head clearfix">

                                <div class="mec-masonry-col<?php echo (isset($location['name']) and trim($location['name'])) ? '6' : '12'; ?>">
                                    <?php if(isset($settings['multiple_day_show_method']) and $settings['multiple_day_show_method'] == 'all_days') : ?>
                                        <div class="mec-event-date mec-color"><?php echo date_i18n($this->date_format_1, strtotime($event->date['start']['date'])); ?></div>
                                        <div class="mec-event-month"><?php echo date_i18n($this->date_format_2, strtotime($event->date['start']['date'])); ?></div>
                                    <?php else: ?>
                                        <div class="mec-event-date mec-color"><?php echo $this->main->date_label($event->date['start'], $event->date['end'], $this->date_format_1); ?></div>
                                        <div class="mec-event-month"><?php echo $this->main->date_label($event->date['start'], $event->date['end'], $this->date_format_2); ?></div>
                                    <?php endif; ?>
                                    <div class="mec-event-detail"><?php echo $start_time.(trim($end_time) ? ' - '.$end_time : ''); ?></div>
                                </div>

                                <?php if(isset($location['name']) and trim($location['name'])): ?>
                                <div class="mec-masonry-col6">
                                    <div class="mec-event-location">
                                        <i class="mec-sl-location-pin mec-color"></i>
                                        <div class="mec-event-location-det">
                                            <h6 class="mec-location"><?php echo (isset($location['name']) ? $location['name'] : ''); ?></h6>
                                            <address class="mec-events-address"><span class="mec-address"><?php echo (isset($location['address']) ? $location['address'] : ''); ?></span></address>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>

                            </div>
                            <?php
                                $excerpt = trim($event->data->post->post_excerpt) ? $event->data->post->post_excerpt : '';

                                // Safe Excerpt for UTF-8 Strings
                                if(!trim($excerpt))
                                {
                                    $ex = explode(' ', strip_tags($event->data->post->post_content));
                                    $words = array_slice($ex, 0, 25);

                                    $excerpt = implode(' ', $words);
                                }
                            ?>
                            <div class="mec-event-content">
                                <h4 class="mec-event-title"><a class="mec-color-hover" data-event-id="<?php echo $event->data->ID; ?>" href="<?php echo $this->main->get_event_date_permalink($event->data->permalink, $event->date['start']['date']); ?>"><?php echo $event->data->title; ?></a><?php echo $event_color; ?></h4>
                                <div class="mec-event-description mec-events-content">
                                    <p><?php echo $excerpt.(trim($excerpt) ? ' ...' : ''); ?></p>
                                </div>
                            </div>
                            <div class="mec-event-footer">
                                <a class="mec-booking-button" data-event-id="<?php echo $event->data->ID; ?>" href="<?php echo $this->main->get_event_date_permalink($event->data->permalink, $event->date['start']['date']); ?>" target="_self"><?php echo (is_array($event->data->tickets) and count($event->data->tickets)) ? $this->main->m('register_button', __('REGISTER', 'mec')) : $this->main->m('view_detail', __('View Detail', 'mec')) ; ?></a>
                            </div>
                        </div>
                    </article>

                </div>
            </div>
        <?php endforeach; ?>
        <?php endforeach; ?>
	</div>
</div>