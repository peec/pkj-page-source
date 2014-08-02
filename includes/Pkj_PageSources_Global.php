<?php
/**
 * Created by PhpStorm.
 * User: peecdesktop
 * Date: 02.08.14
 * Time: 23:57
 */

class Pkj_PageSources_Global {

    public static function instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new Pkj_PageSources_Global();
        }
        return $inst;
    }
    private function __construct () {
        add_action('plugins_loaded', array($this, 'init_text_domain'));
    }

    public function init_text_domain () {
        $plugin_dir = basename(PKJ_PLUGIN_PAGE_SOURCE_PATH);
        load_plugin_textdomain( 'pkj-page-source', false, $plugin_dir );
    }


} 