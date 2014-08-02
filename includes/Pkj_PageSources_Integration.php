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
    }

    public function add_meta_boxes()
    {
        foreach ($this->postTypes as $type) {
            add_meta_box('pkj-sources-box', __('Kilder', 'pkj'), array($this, 'box_output'), $type, 'normal', 'high');
        }
    }

    public function box_output()
    {
        $valuePair = json_decode(get_post_meta(get_the_id(), 'pkj_sources', true), true);
        $value = false;
        if ($valuePair) {
            parse_str($valuePair['query'], $value);
        }
        $postTypes = get_post_types(array('_builtin' => false));


        $selector = "<select name='pkj_q_post_type'><option value=''>None</option>";
        foreach ($postTypes as $postType) {
            $o = get_post_type_object($postType);
            $name = $o->labels->name;
            $selected = $value && $postType == $value['post_type'];
            $selector .= '<option ' . ($selected ? "selected='selected'" : "") . ' value="' . $postType . '">' . $name . '</option>';
        }
        $selector .= "</select>";

        echo '<p><strong>List følgende type</strong></p>' . $selector;


        $show_images = $value && isset($valuePair['params']['show_images']) && $valuePair['params']['show_images'];
        echo '<p><strong>Vis bilder</strong></p><input type="checkbox" value="1" name="pkj_qa[show_images]" ' . ($show_images ? 'checked="checked"' : '') . ' />';
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
            $q = array('query' => (string)http_build_query($qArgs), 'params' => isset($_POST['pkj_qa']) ? $_POST['pkj_qa'] : array());

            if ($qArgs) {
                update_post_meta((int)$postid, 'pkj_sources', wp_slash(json_encode($q)));
            }
        }

    }
}