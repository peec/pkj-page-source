<?php
$show_images = isset($obj['params']['show_images']) ? $obj['params']['show_images'] : false;
$show_the_excerpt = isset($obj['params']['show_excerpt']) ? $obj['params']['show_excerpt'] : false;
$the_query = new WP_Query($obj['query']);
$mode = isset($obj['params']['view_mode']) ? $obj['params']['view_mode'] : 'block';
$block_class = isset($obj['params']['block_class']) ? $obj['params']['block_class'] : '';

$blocksizemap = isset($obj['params']['blocksize']) ? $obj['params']['blocksize'] : array('s' => 1, 'm' => 3, 'l' => 3);

$gridClasses = apply_filters('pkj-page-source_blocksizemap', $blocksizemap);

$block_class = $block_class . $gridClasses;
?>
<div class="page-source <?php echo $mode=='block' ? apply_filters('pkj-page-source_rowclass', 'row') : '' ?> <?php echo $mode?>s"> <?php /* the s is supposed to be added. */ ?>
    <?php
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
        Pkj_PageSources_Integration::instance()->render("modes/$mode.php", array(
            'show_images' => $show_images,
            'show_the_excerpt' => $show_the_excerpt,
            'mode' => $mode,
            'block_class' => $block_class
        ));
    }
    wp_reset_query();
    ?>
</div>