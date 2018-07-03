<?php
/**
	Plugin Name: Modern Events Calendar
	Plugin URI: http://webnus.net/plugins/modern-events-calendar/
	Description: An awesome plugin for events calendar
	Author: Webnus Team
	Version: 2.8.0
    Text Domain: mec
    Domain Path: /languages
	Author URI: http://webnus.net
**/

/** MEC Execution **/
define('_MECEXEC_', 1);

/** Directory Separator **/
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

/** MEC Absolute Path **/
define('_MEC_ABSPATH_', dirname(__FILE__).DS);

/** Plugin Directory Name **/
define('_MEC_DIRNAME_', basename(_MEC_ABSPATH_));

/** Plugin Base Name **/
define('_MEC_BASENAME_', plugin_basename(__FILE__)); // modern-events-calendar/mec.php

/** Plugin Version **/
define('_MEC_VERSION_', '2.8.0');

/** Include Webnus MEC class if not included before **/
if(!class_exists('MEC')) require_once _MEC_ABSPATH_.'mec-init.php';

/** Initialize Webnus MEC **/
$MEC = MEC::instance();
$MEC->init();