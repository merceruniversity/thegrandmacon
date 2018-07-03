<?php
/** no direct access **/
defined('_MECEXEC_') or die();
?>
<div class="mec-wrap <?php echo $event_colorskin; ?> clearfix <?php echo $this->html_class; ?>" id="mec_skin_<?php echo $this->uniqueid; ?>">
    <article class="mec-single-event">
        <div class="col-md-8">
            <div class="mec-events-event-image"><?php echo $event->data->thumbnails['full']; ?></div>
            <div class="mec-event-content">
                <h1 class="mec-single-title"><?php the_title(); ?></h1>
                <div class="mec-single-event-description mec-events-content"><?php the_content(); ?></div>
            </div>

            <!-- Export Module -->
            <?php echo $this->main->module('export.details', array('event'=>$event)); ?>

            <!-- Countdown module -->
            <?php if($this->main->can_show_countdown_module($event)): ?>
            <div class="mec-events-meta-group mec-events-meta-group-countdown">
                <?php echo $this->main->module('countdown.details', array('event'=>$this->events)); ?>
            </div> 
            <?php endif; ?>

            <!-- Hourly Schedule -->
            <?php if(isset($event->data->meta['mec_hourly_schedules']) and is_array($event->data->meta['mec_hourly_schedules']) and count($event->data->meta['mec_hourly_schedules'])): ?>
            <div class="mec-event-schedule mec-frontbox">
                <h3 class="mec-schedule-head mec-frontbox-title"><?php _e('Hourly Schedule','mec'); ?></h3>
                <div class="mec-event-schedule-content">
                    <?php foreach($event->data->meta['mec_hourly_schedules'] as $schedule): ?>
                    <dl>
                        <dt class="mec-schedule-time"><span class="mec-schedule-start-time mec-color"><?php echo $schedule['from']; ?></span> - <span class="mec-schedule-end-time mec-color"><?php echo $schedule['to']; ?></span> </dt>
                        <dt class="mec-schedule-title"><?php echo $schedule['title']; ?></dt>
                        <dt class="mec-schedule-description"><?php echo $schedule['description']; ?></dt>
                    </dl>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Booking Module -->
            <?php if($this->main->is_sold($event, (trim($occurrence) ? $occurrence : $event->date['start']['date'])) and count($event->dates) <= 1): ?>
            <div class="mec-sold-tickets warning-msg"><?php _e('Sold out!', 'wpl'); ?></div>
            <?php elseif($this->main->can_show_booking_module($event)): ?>
            <div id="mec-events-meta-group-booking-<?php echo $this->uniqueid; ?>" class="mec-events-meta-group mec-events-meta-group-booking">
                <?php echo $this->main->module('booking.default', array('event'=>$this->events)); ?>
            </div>
            <?php endif ?>

            <!-- Tags -->
            <div class="mec-events-meta-group mec-events-meta-group-tags">
                <?php the_tags(__('Tags: ', 'mec'), ', ', '<br />'); ?>
            </div>

        </div>
        <?php if(!is_active_sidebar('mec-single-sidebar')): ?>
        <div class="col-md-4">

            <div class="mec-event-meta mec-color-before mec-frontbox">
                <?php
                    // Event Date and Time
                    if(isset($event->data->meta['mec_date']['start']) and !empty($event->data->meta['mec_date']['start']))
                    {
                    ?>
                        <div class="mec-single-event-date">
                            <i class="mec-sl-calendar"></i>
                            <h3 class="mec-date"><?php _e('Date', 'mec'); ?></h3>
                            <dd><abbr class="mec-events-abbr"><?php echo $this->main->date_label((trim($occurrence) ? array('date'=>$occurrence) : $event->date['start']), (trim($occurrence_end_date) ? array('date'=>$occurrence_end_date) : (isset($event->date['end']) ? $event->date['end'] : NULL)), $this->date_format1); ?></abbr></dd>
                        </div>

                        <?php  
                        if(isset($event->data->meta['mec_hide_time']) and $event->data->meta['mec_hide_time'] == '0')
                        {
                            $time_comment = isset($event->data->meta['mec_comment']) ? $event->data->meta['mec_comment'] : '';
                            $allday = isset($event->data->meta['mec_allday']) ? $event->data->meta['mec_allday'] : 0;
                            ?>
                            <div class="mec-single-event-time">
                                <i class="mec-sl-clock " style=""></i>
                                <h3 class="mec-time"><?php _e('Time', 'mec'); ?></h3>
                                <i class="mec-time-comment"><?php echo (isset($time_comment) ? $time_comment : ''); ?></i>
                                
                                <?php if($allday == '0' and isset($event->data->time) and trim($event->data->time['start'])): ?>
                                <dd><abbr class="mec-events-abbr"><?php echo $event->data->time['start']; ?><?php echo (trim($event->data->time['end']) ? ' - '.$event->data->time['end'] : ''); ?></abbr></dd>
                                <?php else: ?>
                                <dd><abbr class="mec-events-abbr"><?php _e('All of the day', 'mec'); ?></abbr></dd>
                                <?php endif; ?>
                            </div>
                        <?php
                        }
                    }
                ?>

                <!-- Local Time Module -->
                <?php echo $this->main->module('local-time.details', array('event'=>$event)); ?>

                <?php
                    // Event Cost
                    if(isset($event->data->meta['mec_cost']) and $event->data->meta['mec_cost'] != '')
                    {
                        ?>
                        <div class="mec-event-cost">
                            <i class="mec-sl-wallet"></i>
                            <h3 class="mec-cost"><?php echo $this->main->m('cost', __('Cost', 'mec')); ?></h3>
                            <dd class="mec-events-event-cost"><?php echo (is_numeric($event->data->meta['mec_cost']) ? $this->main->render_price($event->data->meta['mec_cost']) : $event->data->meta['mec_cost']); ?></dd>
                        </div>
                        <?php
                    }
                ?>
                
                <?php
                    // More Info
                    if(isset($event->data->meta['mec_more_info']) and trim($event->data->meta['mec_more_info']) and $event->data->meta['mec_more_info'] != 'http://')
                    {
                        ?>
                        <div class="mec-event-more-info">
                            <i class="mec-sl-info"></i>
                            <h3 class="mec-cost"><?php echo $this->main->m('more_info_link', __('More Info', 'mec')); ?></h3>
                            <dd class="mec-events-event-more-info"><a class="mec-more-info-button mec-color-hover" target="<?php echo (isset($event->data->meta['mec_more_info_target']) ? $event->data->meta['mec_more_info_target'] : '_self'); ?>" href="<?php echo $event->data->meta['mec_more_info']; ?>"><?php echo ((isset($event->data->meta['mec_more_info_title']) and trim($event->data->meta['mec_more_info_title'])) ? $event->data->meta['mec_more_info_title'] : __('Read More', 'mec')); ?></a></dd>
                        </div>
                        <?php
                    }
                ?>
                
                <?php
                    // Event labels
                    if(isset($event->data->labels) && !empty($event->data->labels))
                    {
                        $mec_items = count($event->data->labels);
                        $mec_i = 0; ?>
                        <div class="mec-single-event-label">
                            <i class="mec-fa-bookmark-o"></i>
                            <h3 class="mec-cost"><?php echo $this->main->m('taxonomy_labels', __('Labels', 'mec')); ?></h3>
                            <?php foreach($event->data->labels as $labels=>$label) :
                                $seperator = (++$mec_i === $mec_items ) ? '' : ',';
                                echo '<dd style="color:' . $label['color'] . '">' . $label["name"] . $seperator . '</dd>';
                            endforeach; ?>
                        </div>
                        <?php
                    }
                ?>

                <?php
                    // Event Location
                    if(isset($event->data->locations[$event->data->meta['mec_location_id']]) and !empty($event->data->locations[$event->data->meta['mec_location_id']]))
                    {
                        $location = $event->data->locations[$event->data->meta['mec_location_id']];
                        ?>
                        <div class="mec-single-event-location">
                            <?php if($location['thumbnail']): ?>
                            <img class="mec-img-location" src="<?php echo esc_url($location['thumbnail'] ); ?>" alt="<?php echo (isset($location['name']) ? $location['name'] : ''); ?>">
                            <?php endif; ?>
                            <i class="mec-sl-location-pin"></i>
                            <h3 class="mec-events-single-section-title mec-location"><?php echo $this->main->m('taxonomy_location', __('Location', 'mec')); ?></h3>
                            <dd class="author fn org"><?php echo (isset($location['name']) ? $location['name'] : ''); ?></dd>
                            <dd class="location"><address class="mec-events-address"><span class="mec-address"><?php echo (isset($location['address']) ? $location['address'] : ''); ?></span></address></dd>
                        </div>
                        <?php
                    }
                ?>

                <?php
                    // Event Categories
                    if(isset($event->data->categories) and !empty($event->data->categories))
                    {
                        ?>
                        <div class="mec-single-event-category">
                            <i class="mec-sl-folder"></i>
                            <dt><?php echo $this->main->m('taxonomy_categories', __('Category', 'mec')); ?></dt>
                            <?php
                            $cats = array();
                            foreach($event->data->categories as $category)
                            {
                                $icon = get_metadata('term', $category['id'], 'mec_cat_icon', true);
                                $icon = isset($icon) && $icon != '' ? '<i class="'.$icon.' mec-color"></i>' : '<i class="mec-fa-angle-right"></i>';
                                echo '<dd class="mec-events-event-categories">
                                <a href="'.get_term_link($category['id'], 'mec_category').'" class="mec-color-hover" rel="tag">'.$icon . $category['name'] .'</a></dd>';
                            }
                            ?>
                        </div>
                        <?php
                    }
                ?>

                <?php
                    // Event Organizer
                    if(isset($event->data->organizers[$event->data->meta['mec_organizer_id']]) && !empty($event->data->organizers[$event->data->meta['mec_organizer_id']]))
                    {
                        $organizer = $event->data->organizers[$event->data->meta['mec_organizer_id']];
                        ?>
                        <div class="mec-single-event-organizer">
                            <?php if(isset($organizer['thumbnail']) and trim($organizer['thumbnail'])): ?>
                                <img class="mec-img-organizer" src="<?php echo esc_url($organizer['thumbnail']); ?>" alt="<?php echo (isset($organizer['name']) ? $organizer['name'] : ''); ?>">
                            <?php endif; ?>
                            <h3 class="mec-events-single-section-title"><?php echo $this->main->m('taxonomy_organizer', __('Organizer', 'mec')); ?></h3>
                            <?php if(isset($organizer['thumbnail'])): ?>
                            <dd class="mec-organizer">
                                <i class="mec-sl-home"></i>
                                <h6><?php echo (isset($organizer['name']) ? $organizer['name'] : ''); ?></h6>
                            </dd>
                            <?php endif;
                            if(isset($organizer['tel']) && !empty($organizer['tel'])): ?>
                            <dd class="mec-organizer-tel">
                                <i class="mec-sl-phone"></i>
                                <h6><?php _e('Phone', 'mec'); ?></h6>
                                <a href="tel:<?php echo $organizer['tel']; ?>"><?php echo $organizer['tel']; ?></a>
                            </dd>
                            <?php endif;
                            if(isset($organizer['email']) && !empty($organizer['email'])): ?>
                            <dd class="mec-organizer-email">
                                <i class="mec-sl-envelope"></i>
                                <h6><?php _e('Email', 'mec'); ?></h6>
                                <a href="mailto:<?php echo $organizer['email']; ?>"><?php echo $organizer['email']; ?></a>
                            </dd>
                            <?php endif;
                            if(isset($organizer['url']) && !empty($organizer['url']) and $organizer['url'] != 'http://'): ?>
                            <dd class="mec-organizer-url">
                                <i class="mec-sl-sitemap"></i>
                                <h6><?php _e('Website', 'mec'); ?></h6>
                                <span><a href="<?php echo (strpos($organizer['url'], 'http') === false ? 'http://'.$organizer['url'] : $organizer['url']); ?>" class="mec-color-hover" target="_blank"><?php echo $organizer['url']; ?></a></span>
                            </dd>
                            <?php endif; ?>
                        </div>
                    <?php
                        $this->show_other_organizers($event); // Show Additional Organizers
                    }
                ?>

                <!-- Register Booking Button -->
                <?php if($this->main->can_show_booking_module($event)): ?>
                <a class="mec-booking-button mec-bg-color" href="#mec-events-meta-group-booking-<?php echo $this->uniqueid; ?>"><?php echo esc_html($this->main->m('register_button', __('REGISTER', 'mec'))); ?></a>
                <?php endif ?>
                
            </div>      
            
            <!-- Attendees List Module -->
            <?php echo $this->main->module('attendees-list.details', array('event'=>$event)); ?>
            
            <!-- Next Previous Module -->
            <?php echo $this->main->module('next-event.details', array('event'=>$event)); ?>
            
            <!-- Links Module -->
            <?php echo $this->main->module('links.details', array('event'=>$event)); ?>

            <!-- Weather Module -->
            <?php echo $this->main->module('weather.details', array('event'=>$event)); ?>
            
            <!-- Google Maps Module -->
            <div class="mec-events-meta-group mec-events-meta-group-gmap">
                <?php echo $this->main->module('googlemap.details', array('event'=>$this->events)); ?>
            </div>

            <!-- QRCode Module -->
            <?php echo $this->main->module('qrcode.details', array('event'=>$event)); ?>


        </div>
        <?php else: ?>
        <div class="col-md-4">
            <div class="mec-event-meta mec-color-before mec-frontbox">
                <?php
                $single = new MEC_skin_single();

                // Event Date and Time
                if(isset($event->data->meta['mec_date']['start']) and !empty($event->data->meta['mec_date']['start']) and $single->found_value('data_time', $settings) == 'on')
                {
                    ?>
                    <div class="mec-single-event-date">
                        <i class="mec-sl-calendar"></i>
                        <h3 class="mec-date"><?php _e('Date', 'mec'); ?></h3>
                        <dd><abbr class="mec-events-abbr"><?php echo $this->main->date_label((trim($occurrence) ? array('date'=>$occurrence) : $event->date['start']), (trim($occurrence_end_date) ? array('date'=>$occurrence_end_date) : (isset($event->date['end']) ? $event->date['end'] : NULL)), $this->date_format1); ?></abbr></dd>
                    </div>

                    <?php  
                    if(isset($event->data->meta['mec_hide_time']) and $event->data->meta['mec_hide_time'] == '0')
                    {
                        $time_comment = isset($event->data->meta['mec_comment']) ? $event->data->meta['mec_comment'] : '';
                        $allday = isset($event->data->meta['mec_allday']) ? $event->data->meta['mec_allday'] : 0;
                        ?>
                        <div class="mec-single-event-time">
                            <i class="mec-sl-clock " style=""></i>
                            <h3 class="mec-time"><?php _e('Time', 'mec'); ?></h3>
                            <i class="mec-time-comment"><?php echo (isset($time_comment) ? $time_comment : ''); ?></i>
                            
                            <?php if($allday == '0' and isset($event->data->time) and trim($event->data->time['start'])): ?>
                                <dd><abbr class="mec-events-abbr"><?php echo $event->data->time['start']; ?><?php echo (trim($event->data->time['end']) ? ' - '.$event->data->time['end'] : ''); ?></abbr></dd>
                            <?php else: ?>
                                <dd><abbr class="mec-events-abbr"><?php _e('All of the day', 'mec'); ?></abbr></dd>
                            <?php endif; ?>
                        </div>
                        <?php
                    }
                }

                // Local Time Module
                if($single->found_value('local_time', $settings) == 'on') echo $this->main->module('local-time.details', array('event'=>$event));
                ?>

                <?php
                // Event Cost
                if(isset($event->data->meta['mec_cost']) and $event->data->meta['mec_cost'] != '' and $single->found_value('event_cost', $settings) == 'on')
                {
                    ?>
                    <div class="mec-event-cost">
                        <i class="mec-sl-wallet"></i>
                        <h3 class="mec-cost"><?php echo $this->main->m('cost', __('Cost', 'mec')); ?></h3>
                        <dd class="mec-events-event-cost"><?php echo (is_numeric($event->data->meta['mec_cost']) ? $this->main->render_price($event->data->meta['mec_cost']) : $event->data->meta['mec_cost']); ?></dd>
                    </div>
                    <?php
                }
                ?>

                <?php
                // More Info
                if(isset($event->data->meta['mec_more_info']) and trim($event->data->meta['mec_more_info']) and $event->data->meta['mec_more_info'] != 'http://' and $single->found_value('more_info', $settings) == 'on')
                {
                    ?>
                    <div class="mec-event-more-info">
                        <i class="mec-sl-info"></i>
                        <h3 class="mec-cost"><?php echo $this->main->m('more_info_link', __('More Info', 'mec')); ?></h3>
                        <dd class="mec-events-event-more-info"><a class="mec-more-info-button mec-color-hover" target="<?php echo (isset($event->data->meta['mec_more_info_target']) ? $event->data->meta['mec_more_info_target'] : '_self'); ?>" href="<?php echo $event->data->meta['mec_more_info']; ?>"><?php echo ((isset($event->data->meta['mec_more_info_title']) and trim($event->data->meta['mec_more_info_title'])) ? $event->data->meta['mec_more_info_title'] : __('Read More', 'mec')); ?></a></dd>
                    </div>
                    <?php
                }
                ?>

                <?php
                // Event labels
                if(isset($event->data->labels) and !empty($event->data->labels) and $single->found_value('event_label', $settings) == 'on')
                {
                    $mec_items = count($event->data->labels);
                    $mec_i = 0; ?>
                    <div class="mec-single-event-label">
                        <i class="mec-fa-bookmark-o"></i>
                        <h3 class="mec-cost"><?php echo $this->main->m('taxonomy_labels', __('Labels', 'mec')); ?></h3>
                        <?php foreach($event->data->labels as $labels=>$label) : 
                        $seperator = (++$mec_i === $mec_items ) ? '' : ',';
                        echo '<dd style="color:' . $label['color'] . '">' . $label["name"] . $seperator . '</dd>';
                        endforeach; ?>
                    </div>
                    <?php
                }
                ?>

                <?php
                // Event Location
                if(isset($event->data->locations[$event->data->meta['mec_location_id']]) and !empty($event->data->locations[$event->data->meta['mec_location_id']]) and $single->found_value('event_location', $settings) == 'on')
                {
                    $location = $event->data->locations[$event->data->meta['mec_location_id']];
                    ?>
                    <div class="mec-single-event-location">
                        <?php if($location['thumbnail']): ?>
                            <img class="mec-img-location" src="<?php echo esc_url($location['thumbnail'] ); ?>" alt="<?php echo (isset($location['name']) ? $location['name'] : ''); ?>">
                        <?php endif; ?>
                        <i class="mec-sl-location-pin"></i>
                        <h3 class="mec-events-single-section-title mec-location"><?php echo $this->main->m('taxonomy_location', __('Location', 'mec')); ?></h3>
                        <dd class="author fn org"><?php echo (isset($location['name']) ? $location['name'] : ''); ?></dd>
                        <dd class="location"><address class="mec-events-address"><span class="mec-address"><?php echo (isset($location['address']) ? $location['address'] : ''); ?></span></address></dd>
                    </div>
                    <?php
                }
                ?>

                <?php
                // Event Categories
                if(isset($event->data->categories) and !empty($event->data->categories) and $single->found_value('event_categories', $settings) == 'on')
                {
                    ?>
                    <div class="mec-single-event-category">
                        <i class="mec-sl-folder"></i>
                        <dt><?php echo $this->main->m('taxonomy_categories', __('Category', 'mec')); ?></dt>
                        <?php
                        $cats = array();
                        foreach($event->data->categories as $category)
                        {
                            $icon = get_metadata('term', $category['id'], 'mec_cat_icon', true);
                            $icon = isset($icon) && $icon != '' ? '<i class="'.$icon.' mec-color"></i>' : '<i class="mec-fa-angle-right"></i>';
                            echo '<dd class="mec-events-event-categories">
                            <a href="'.get_term_link($category['id'], 'mec_category').'" class="mec-color-hover" rel="tag">'.$icon . $category['name'] .'</a></dd>';
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>

                <?php
                // Event Organizer
                if(isset($event->data->organizers[$event->data->meta['mec_organizer_id']]) && !empty($event->data->organizers[$event->data->meta['mec_organizer_id']]) and $single->found_value('event_orgnizer', $settings) == 'on')
                { 
                    $organizer = $event->data->organizers[$event->data->meta['mec_organizer_id']];
                    ?>
                    <div class="mec-single-event-organizer">
                        <?php if(isset($organizer['thumbnail']) and trim($organizer['thumbnail'])): ?>
                            <img class="mec-img-organizer" src="<?php echo esc_url($organizer['thumbnail']); ?>" alt="<?php echo (isset($organizer['name']) ? $organizer['name'] : ''); ?>">
                        <?php endif; ?>
                        <h3 class="mec-events-single-section-title"><?php echo $this->main->m('taxonomy_organizer', __('Organizer', 'mec')); ?></h3>
                        <?php if(isset($organizer['thumbnail'])): ?>
                            <dd class="mec-organizer">
                                <i class="mec-sl-home"></i>
                                <h6><?php echo (isset($organizer['name']) ? $organizer['name'] : ''); ?></h6>
                            </dd>
                        <?php endif;
                        if(isset($organizer['tel']) && !empty($organizer['tel'])): ?>
                        <dd class="mec-organizer-tel">
                            <i class="mec-sl-phone"></i>
                            <h6><?php _e('Phone', 'mec'); ?></h6>
                            <a href="tel:<?php echo $organizer['tel']; ?>"><?php echo $organizer['tel']; ?></a>
                        </dd>
                        <?php endif; 
                        if(isset($organizer['email']) && !empty($organizer['email'])): ?>
                        <dd class="mec-organizer-email">
                            <i class="mec-sl-envelope"></i>
                            <h6><?php _e('Email', 'mec'); ?></h6>
                            <a href="mailto:<?php echo $organizer['email']; ?>"><?php echo $organizer['email']; ?></a>
                        </dd>
                        <?php endif;
                        if(isset($organizer['url']) && !empty($organizer['url']) and $organizer['url'] != 'http://'): ?>
                        <dd class="mec-organizer-url">
                            <i class="mec-sl-sitemap"></i>
                            <h6><?php _e('Website', 'mec'); ?></h6>
                            <span><a href="<?php echo (strpos($organizer['url'], 'http') === false ? 'http://'.$organizer['url'] : $organizer['url']); ?>" class="mec-color-hover" target="_blank"><?php echo $organizer['url']; ?></a></span>
                        </dd>
                        <?php endif; ?>
                    </div>
                    <?php
                    $this->show_other_organizers($event); // Show Additional Organizers
                }
                ?>

                <!-- Register Booking Button -->
                <?php if($this->main->can_show_booking_module($event) and $single->found_value('register_btn', $settings) == 'on'): ?>
                    <a class="mec-booking-button mec-bg-color" href="#mec-events-meta-group-booking-<?php echo $this->uniqueid; ?>"><?php echo esc_html($this->main->m('register_button', __('REGISTER', 'mec'))); ?></a>
                <?php endif ?>
            </div>

            <!-- Attendees List Module -->
            <?php if($single->found_value('attende_module', $settings) == 'on') echo $this->main->module('attendees-list.details', array('event'=>$event)); ?>

            <!-- Next Previous Module -->
            <?php if($single->found_value('next_module', $settings) == 'on') echo $this->main->module('next-event.details', array('event'=>$event)); ?>

            <!-- Links Module -->
            <?php if($single->found_value('links_module', $settings) == 'on') echo $this->main->module('links.details', array('event'=>$event)); ?>

            <!-- Weather Module -->
            <?php if($single->found_value('weather_module', $settings) == 'on') echo $this->main->module('weather.details', array('event'=>$event)); ?>

            <!-- Google Maps Module -->
            <?php if ($single->found_value('google_map', $settings) == 'on'): ?>
                <div class="mec-events-meta-group mec-events-meta-group-gmap">
                    <?php echo $this->main->module('googlemap.details', array('event'=>$this->events)); ?>
                </div>
            <?php endif; ?>

            <!-- QRCode Module -->
            <?php if($single->found_value('qrcode_module', $settings) == 'on') echo $this->main->module('qrcode.details', array('event'=>$event)); ?>

        </div>
        <?php dynamic_sidebar('mec-single-sidebar'); ?>

        <?php endif; ?>
    </article>
</div>