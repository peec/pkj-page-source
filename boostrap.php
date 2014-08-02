<?php
/*
Plugin Name: PKJ Page Source
Text Domain: pkj-page-source
Plugin URI: https://github.com/peec/pkj-page-source
Description: Wordpress plugin that lets you add a source to pages, to list automatic generated content.
Version: 0.0.1
Author: Petter Kjelkenes
Author URI: http://pkj.no
License: MIT
*/

define('PKJ_PLUGIN_PAGE_SOURCE_PATH', dirname(__FILE__));



include PKJ_PLUGIN_PAGE_SOURCE_PATH. '/includes/Pkj_PageSources_Global.php';
include PKJ_PLUGIN_PAGE_SOURCE_PATH. '/includes/Pkj_PageSources_Integration.php';
include PKJ_PLUGIN_PAGE_SOURCE_PATH. '/includes/Pkj_ListContent_Widget.php';

Pkj_PageSources_Global::instance();
Pkj_PageSources_Integration::instance();
Pkj_ListContent_Widget::loadWidget();