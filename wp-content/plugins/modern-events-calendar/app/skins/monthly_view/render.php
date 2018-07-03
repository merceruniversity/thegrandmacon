<?php
/** no direct access **/
defined('_MECEXEC_') or die();

$calendar_type = 'calendar';
if(in_array($this->style, array('clean', 'modern'))) $calendar_type = 'calendar_clean';

echo $this->draw_monthly_calendar($this->year, $this->month, $this->events, $calendar_type);