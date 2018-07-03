<?php
/** no direct access **/
defined('_MECEXEC_') or die();

// MEC Settings
$settings = $this->get_settings();

// The module is disabled
if(!isset($settings['weather_module_status']) or (isset($settings['weather_module_status']) and !$settings['weather_module_status'])) return;

// API Key is empty!
if(!isset($settings['weather_module_api_key']) or (isset($settings['weather_module_api_key']) and !trim($settings['weather_module_api_key']))) return;

// Location is not Set
if(!isset($event->data->meta['mec_location_id']) or (isset($event->data->meta['mec_location_id']) and !$event->data->meta['mec_location_id'])) return;
$location = isset($event->data->locations[$event->data->meta['mec_location_id']]) ? $event->data->locations[$event->data->meta['mec_location_id']] : array();

$lat = isset($location['latitude']) ? $location['latitude'] : 0;
$lng = isset($location['longitude']) ? $location['longitude'] : 0;

// Cannot find the geo point
if(!$lat or !$lng) return;

$occurrence = isset($_GET['occurrence']) ? sanitize_text_field($_GET['occurrence']) : '';
$date = (trim($occurrence) ? $occurrence : $event->date['start']['date']).' '.sprintf("%02d", $event->date['start']['hour']).':'.sprintf("%02d", $event->date['start']['minutes']).' '.$event->date['start']['ampm'];

$weather = $this->get_weather($lat, $lng, $date);

// Weather not found!
if(!is_array($weather) or (is_array($weather) and !count($weather))) return;
?>
<div class="mec-weather-details mec-frontbox" id="mec_weather_details">
    <h3 class="mec-weather mec-frontbox-title"><?php _e('Weather', 'mec'); ?></h3>

    <!-- mec weather start -->
    <div class="mec-weather-box">

        <div class="mec-weather-head">
            <div class="mec-weather-icon-box">
                <span class="mec-weather-icon <?php echo $weather['icon']; ?>"></span>
            </div>
            <div class="mec-weather-summary">
                <div class="mec-weather-summary-report"><?php echo $weather['summary']; ?></div>
                <?php if(isset($weather['temperature'])): ?>
                <div class="mec-weather-summary-temp"><?php  echo round( $weather['temperature']);?> <var><?php _e( ' °C', 'mec' ); ?></var></div>
                <?php endif; ?>
            </div>
            <div class="mec-weather-extras">

                <?php if(isset($weather['windSpeed'])): ?>
                <div class="mec-weather-wind"><span><?php _e('Wind', 'mec'); ?>:</span> <?php echo round($weather['windSpeed']); ?><var><?php _e(' KPH','mec'); ?></var></div>
                <?php endif; ?>

                <?php if(isset($weather['humidity'])): ?>
                    <div class="mec-weather-humidity"><span><?php _e('Humidity', 'mec'); ?>:</span> <?php echo round($weather['humidity']); ?><var><?php _e(' %','mec'); ?></var></div>
                <?php endif; ?>

                <?php if(isset($weather['visibility'])): ?>
                    <div class="mec-weather-visibility"><span><?php _e('Visibility', 'mec'); ?>:</span> <?php echo round($weather['visibility']); ?><var><?php _e(' KM','mec'); ?></var></div>
                <?php endif; ?>
        
            </div>
        </div>

    </div><!--  mec weather end -->

</div>