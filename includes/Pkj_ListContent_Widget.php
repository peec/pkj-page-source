<?php
/**
 * Created by PhpStorm.
 * User: peecdesktop
 * Date: 02.08.14
 * Time: 23:47
 */


class Pkj_ListContent_Widget extends WP_Widget
{

    static public function loadWidget()
    {
        add_action('widgets_init', function () {
            register_widget('pkj_listcontent_widget');
        });
    }

    public function __construct()
    {
        parent::__construct(
            'pkj_listcontent_widget',
            __('PKJ List Posts', 'pkj-page-source'),
            array(
                'description' => __('List any post type in this widget', 'pkj-page-source')
            )
        );
    }

    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];

        // This is where you run the code and display the output
        ?>
        <ul>

            <?php
            $the_query = new WP_Query("post_type={$instance['post_type']}&orderby={$instance['sortby']}");
            while ($the_query->have_posts()) {
                $the_query->the_post();
                ?>
                <li>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php the_title() ?>
                    </a>
                </li>
            <?php
            }
            wp_reset_query();
            ?>
        </ul>
        <?php


        echo $args['after_widget'];
    }

    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('New title', 'pkj-page-source');
        }

        $selectedPostType = isset($instance['post_type']) ? $instance['post_type'] : '';
        $selectedSortOrder = isset($instance['sortby']) ? $instance['sortby'] : '';
// Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>"/>
        </p>
        <?php

        $postTypes = get_post_types(array('_builtin' => false));
        $selector = "<select id='" . $this->get_field_id('post_type') . "' name='" . $this->get_field_name('post_type') . "'><option value=''>None</option>";
        foreach ($postTypes as $postType) {
            $o = get_post_type_object($postType);
            $name = $o->labels->name;
            $selected = $postType == esc_attr($selectedPostType);
            $selector .= '<option ' . ($selected ? "selected='selected'" : "") . ' value="' . $postType . '">' . $name . '</option>';
        }
        $selector .= "</select>";
        ?>
        <label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Post type:'); ?></label>
        <p>
            <?php echo $selector ?>
        </p>

        <label for="<?php echo $this->get_field_id('sortby'); ?>"><?php _e('Sorter etter:'); ?></label>
        <select class="widefat" id="<?php echo $this->get_field_id('sortby'); ?>"
                name="<?php echo $this->get_field_name('sortby'); ?>">
            <?php $sortOrders = array('none' => 'None', 'ID' => 'ID', 'author' => 'Author', 'title' => 'Title', 'type' => 'Type', 'date' => 'Date added', 'modified' => 'Last modified', 'comment_count' => 'Comment amount');
            foreach ($sortOrders as $o => $l) {
                $selected = $o == esc_attr($selectedSortOrder);
                echo "<option value='$o' " . ($selected ? 'selected="selected"' : '') . " >$l</option>";
            }
            ?>
        </select>




    <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['post_type'] = (!empty($new_instance['post_type'])) ? strip_tags($new_instance['post_type']) : '';
        $instance['sortby'] = (!empty($new_instance['sortby'])) ? strip_tags($new_instance['sortby']) : '';
        return $instance;
    }
}
