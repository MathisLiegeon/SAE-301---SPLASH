<li class="match-card">
    <div class="match-card-content match-single-card-content">
        <a href="<?php echo get_permalink($args['te1_img']); ?>" class="match-card-te">
                <span class="match-card-text"><?php echo esc_html($args['te1_name']); ?></span>
                <span class="match-card-img"><?php echo get_the_post_thumbnail($args['te1_img']); ?></span>
        </a>
        <span class="match-single-score">
            <?php echo esc_html($args['te1_score']); ?> : <?php echo esc_html($args['te2_score']); ?>
            <span class="match-single-score-sm">BO3</span>
        </span>
        <a href="<?php echo get_permalink($args['te2_img']); ?>" class="match-card-te">
            <span class="match-card-img"><?php echo get_the_post_thumbnail($args['te2_img']);?></span>
                    <span class="match-card-text"><?php echo esc_html($args['te2_name']);?></span>
        </a>
    </div>
    <span class="match-card-date match-single-card-date"><?php echo esc_html($args['date']); ?></span>
</li>