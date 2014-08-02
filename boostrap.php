<?php
/*
Plugin Name: PKJ Page Source
Plugin URI: https://github.com/peec/pkj-page-source
Description: Wordpress plugin that lets you add a source to pages, to list automatic generated content.
Version: 0.0.1
Author: Petter Kjelkenes
Author URI: http://pkj.no
License: MIT
*/

include dirname(__FILE__) . '/includes/Pkj_PageSources_Integration.php';

Pkj_PageSources_Integration::instance();
