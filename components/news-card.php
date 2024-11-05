<li class="news-card">
<a href="<?php echo esc_url($args['url']); ?>">
    <span class="news-card-img">
        <?php echo get_the_post_thumbnail($args['img']); ?>
    </span>
    <div class="news-content">
        <span><?php echo esc_html($args['date']); ?></span>
        <h5><?php echo esc_html($args['titre']); ?></h5>
        <span>READ MORE</span>
    </div>
</a>
</li>
