<div class="page-source-line post-<?php echo get_post_type() ?>">
    <h2>
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
            <?php the_title() ?>
        </a>
    </h2>

    <?php if ($show_images && has_post_thumbnail()): ?>
        <a class="col-md-4 pull-md-right featured-image" href="<?php the_permalink(); ?>"
           title="<?php the_title_attribute(); ?>">
            <?php the_post_thumbnail('large', array('class' => 'img-responsive featured-image')) ?>
        </a>
    <?php endif; ?>

    <?php if ($show_the_excerpt): ?>
        <?php the_excerpt() ?>
    <?php endif ?>
    <a class="readmore" href="<?php the_permalink(); ?>"
       title="<?php the_title_attribute(); ?>"><?php _e('Read more', 'pkj-page-source') ?></a>
</div>