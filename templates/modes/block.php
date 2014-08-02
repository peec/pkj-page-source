<div class="<?php echo $block_class ?> page-source-block">

    <?php if ($show_images): ?>
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
            <?php the_post_thumbnail('medium', array('class' => 'img-responsive')) ?>
        </a>
    <?php endif; ?>
    <h5>
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
            <?php the_title() ?>
        </a>
    </h5>
    <?php if ($show_the_excerpt): ?>
        <?php the_excerpt() ?>
    <?php endif ?>

    <a class="readmore" href="<?php the_permalink(); ?>"
       title="<?php the_title_attribute(); ?>"><?php _e('Read more', 'pkj-page-source') ?></a>

</div>