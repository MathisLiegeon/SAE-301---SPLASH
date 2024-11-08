<li class="match-card">
<a href="<?php echo get_permalink($args['match_id']); ?>">
        <span class="match-card-img">
            <?php echo get_the_post_thumbnail($args['to_img']); ?>
        </span>
    <div class="match-card-content">
        <span class="match-card-te">
                <span class="match-card-text"><?php echo esc_html($args['te1_name']); ?></span>
                <span class="match-card-img"><?php echo get_the_post_thumbnail($args['te1_img']); ?></span>
        </span>
        <span class="match-score">
            <span><?php echo esc_html($args['te1_score']); ?> </span>
            <span> : </span>
            <span><?php echo esc_html($args['te2_score']); ?></span>
        </span>
        <span class="match-card-te">
                <span class="match-card-img"><?php echo get_the_post_thumbnail($args['te2_img']); ?></span>
                <span class="match-card-text"><?php echo esc_html($args['te2_name']); ?></span>
        </span>
    </div>
    <span class="match-card-date match-card-date-1">
        <span class="match-card-date match-card-date-2">
            <?php echo esc_html($args['date']); ?>
        </span>
    </span>
</a>
</li>