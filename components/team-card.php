<a class="team-card" href="<?php echo get_permalink($args['id']); ?>">
    <span class="team-card-img">
        <?php echo get_the_post_thumbnail($args['id']); ?>
    </span>
    <span class="team-card-title">
        <?php echo get_the_title($args['id']); ?>
    </span>
</a>