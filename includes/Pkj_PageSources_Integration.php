<?php

/**
 * Provides integration to list posts based on a Query.
 *
 * @author Petter Kjelkenes
 *
 */
class Pkj_PageSources_Integration
{
    private $postTypes;



    public static function instance($postTypes = array('page'))
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new Pkj_PageSources_Integration($postTypes);
        }
        return $inst;
    }

    private function __construct($postTypes)
    {
        $this->postTypes = $postTypes;
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save'), 100);

        add_filter('the_content', array($this, 'frontend_output'));

        add_filter('pkj-page-source_blocksizemap', array($this, 'filter_blocksizemap_boostrap_grid'));
    }

    /**
     * Comes with a default filter to conform to boostrap grid definition.
     * @param $blocksizemap
     * @return string
     */
    public function filter_blocksizemap_boostrap_grid ($blocksizemap) {
        $class = '';
        foreach($blocksizemap as $context => $perRow) {
            $bit = '';
            switch($context) {
                case 'l': $bit = 'lg'; break;
                case 'm': $bit = 'md'; break;
                case 's': $bit = 'sm'; break;
            }
            $gridSize = 12 / $perRow;
            $class .= "col-$bit-$gridSize ";
        }
        return $class;
    }

    private function getModes ()
    {
        return array(
            'line' => __('Line view', 'pkj-page-source'),
            'block' => __('Block view', 'pkj-page-source')
        );
    }

    public function add_meta_boxes()
    {
        foreach ($this->postTypes as $type) {
            add_meta_box('pkj-sources-box', __('List content from source', 'pkj-page-source'), array($this, 'box_output'), $type, 'normal', 'high');
        }
    }

    public function frontend_output ( $output ) {
        global $post;

        $obj = json_decode(get_post_meta(get_the_ID(), 'pkj_sources', true), true);

        if (in_array(get_post_type(), $this->postTypes) && isset($obj['query']) && $obj['query']) {

            $plugin = $this->render('frontend.php', array(
                'obj' => $obj
            ), true);

            if (isset($obj['params']['placement']) && $obj['params']['placement'] == 'before') {
                $op = $plugin . $output;
            } else {
                $op = $output . $plugin;
            }

        } else {
            $op = $output;
        }
        return $op;
    }

    public function box_output()
    {
        $valuePair = json_decode(get_post_meta(get_the_id(), 'pkj_sources', true), true);
        $value = false;
        if ($valuePair) {
            parse_str($valuePair['query'], $value);
        }
        $postTypes = get_post_types(array('_builtin' => false));

        $this->render('boxoutput.php', array(
            'postTypes' => $postTypes,
            'valuePair' => $valuePair,
            'value' => $value,
            'modes' => $this->getModes()
        ));
    }

    public function render ($view, $args = array(), $return = false) {
        if ($return)ob_start();
        extract($args);
        include PKJ_PLUGIN_PAGE_SOURCE_PATH . '/templates/'.$view;
        if ($return)return ob_get_clean();
    }

    public function save($postid)
    {

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return false;
        if (!current_user_can('edit_page', $postid)) return false;

        if (isset($_POST)) {
            $qArgs = array();
            foreach ($_POST as $k => $v) {
                if (0 === strpos($k, 'pkj_q_')) {
                    $qArgs[substr($k, strlen('pkj_q_'))] = $v;
                }
            }
            $q = array(
                'query' => (string)http_build_query($qArgs), 'params' => isset($_POST['pkj_qa']) ? $_POST['pkj_qa'] : array()
            );
            if (empty($_POST['pkj_q_post_type'])) {
                $q['query'] = '';
            }

            if ($qArgs) {
                update_post_meta((int)$postid, 'pkj_sources', wp_slash(json_encode($q)));
            }
        }

    }
}