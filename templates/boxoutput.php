<h3><?php _e('Generic settings', 'pkj-page-source') ?></h3>
<div class="inside">
    <?php
    $selector = "<select name='pkj_q_post_type'><option value=''>None</option>";
    foreach ($postTypes as $postType) {
        $o = get_post_type_object($postType);
        $name = $o->labels->name;
        $selected = $value && $postType == $value['post_type'];
        $selector .= '<option ' . ($selected ? "selected='selected'" : "") . ' value="' . $postType . '">' . $name . '</option>';
    }
    $selector .= "</select>";

    ?>
    <p><strong><?php _e('Get post type', 'pkj-page-source') ?></strong></p>
    <?php echo $selector ?>



    <?php $val = $value && isset($value['posts_per_page']) ? $value['posts_per_page'] : '10'; ?>
    <p><strong><?php _e('Amount of items', 'pkj-page-source') ?></strong></p>
    <input type="text" value="<?php echo $val ?>" name="pkj_q_posts_per_page" />


    <?php
    $show_images = $value && isset($valuePair['params']['show_images']) && $valuePair['params']['show_images'];
    ?>

    <p><strong><?php _e('Show featured image', 'pkj-page-source') ?></strong></p>
    <input type="checkbox" value="1"
           name="pkj_qa[show_images]" <?php echo($show_images ? 'checked="checked"' : '') ?> />

    <?php
    $val = $value && isset($valuePair['params']['show_excerpt']) && $valuePair['params']['show_excerpt'];
    ?>
    <p><strong><?php _e('Show excerpt', 'pkj-page-source') ?></strong></p>
    <input type="checkbox" value="1"
           name="pkj_qa[show_excerpt]" <?php echo($val ? 'checked="checked"' : '') ?> />


    <p><strong><?php _e('Where to place the content', 'pkj-page-source') ?></strong></p>
    <?php
    $placements = array(
        'after' => __('After the content', 'pkj-page-source'),
        'before' => __('Before the content', 'pkj-page-source')
    );
    ?>
    <?php $selectedPlacement = $value && isset($valuePair['params']['placement']) ? $valuePair['params']['placement'] : 'after'; ?>
    <select name="pkj_qa[placement]">
        <?php foreach ($placements as $mode => $name): ?>
            <option
                value="<?php echo $mode ?>" <?php echo $selectedPlacement == $mode ? 'selected="selected"' : '' ?>><?php echo $name ?></option>
        <?php endforeach ?>
    </select>


    <p><strong><?php _e('View mode', 'pkj-page-source') ?></strong></p>
    <?php $selectedViewMode = $value && isset($valuePair['params']['view_mode']) ? $valuePair['params']['view_mode'] : false; ?>
    <select name="pkj_qa[view_mode]" id="pkj-view-mode">
        <?php foreach ($modes as $mode => $name): ?>
            <option
                value="<?php echo $mode ?>" <?php echo $selectedViewMode == $mode ? 'selected="selected"' : '' ?>><?php echo $name ?></option>
        <?php endforeach ?>
    </select>


</div>


<div class="pkj-view-mode-panel" data-mode="block">
    <h3><?php _e('Block settings', 'pkj-page-source') ?></h3>
    <div class="inside">

        <?php
        $sizes = array (
            's' => __('Small devices', 'pkj-page-source'),
            'm' => __('Medium devices', 'pkj-page-source'),
            'l' => __('Large devices', 'pkj-page-source'),
        );
        $defaultSize = array(
            's' => 1,
            'm' => 3,
            'l' => 3
        );
        ?>
        <p><strong><?php _e('Amount of columns per row', 'pkj-page-source') ?></strong></p>
        <?php foreach($sizes as $id => $name): ?>
            <?php $selSize = $value && isset($valuePair['params']['blocksize']) ? $valuePair['params']['blocksize'][$id] : $defaultSize[$id]; ?>
            <?php echo $name ?> <input name="pkj_qa[blocksize][<?php echo $id ?>]" value="<?php echo $selSize?>" size="2" />
        <?php endforeach?>

        <?php $selectedBlockClass = $value && isset($valuePair['params']['block_class']) ? $valuePair['params']['block_class'] : 'col-md-4'; ?>
        <p><strong><?php _e('Blocks custom classes', 'pkj-page-source') ?></strong></p>
        <input type="text" value="<?php echo $selectedBlockClass ?>" name="pkj_qa[block_class]" />
    </div>

</div>



<script>
    (function ($) {
        var PkjPageSource = {
            ViewMode: {
                pkjViewModeSet: function (mode) {
                    $('.pkj-view-mode-panel').hide();
                    if (mode) {
                        $('.pkj-view-mode-panel[data-mode="' + mode + '"]').show();
                    }
                }
            }
        }

        $(function () {
            var vm = PkjPageSource.ViewMode;

            $('#pkj-view-mode').change(function () {
                vm.pkjViewModeSet($(this).val());
            });

            vm.pkjViewModeSet('<?php echo $selectedViewMode ?>');
        })
    })(jQuery);

</script>


