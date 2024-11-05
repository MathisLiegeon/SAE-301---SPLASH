<li class="match-card">
    <a href="<?php echo esc_url($args['to_url']); ?>" class="match-card-to">
        <span class="match-card-img">
            <?php echo get_the_post_thumbnail($args['to_img']); ?>
        </span>
    </a>
    <div class="match-card-content">
        <span class="match-card-te">
            <a href="<?php echo esc_url($args['te1_url']); ?>">
                <span class="match-card-text"><?php echo esc_html($args['te1_name']); ?></span>
                <span class="match-card-img"><?php echo get_the_post_thumbnail($args['te1_img']); ?></span>
            </a>
        </span>
        <span>
            <?php echo esc_html($args['te1_score']); ?> : <?php echo esc_html($args['te2_score']); ?>
        </span>
        <span class="match-card-te">
            <a href="<?php echo esc_url($args['te2_url']); ?>">
                <span class="match-card-text"><?php echo esc_html($args['te2_name']); ?></span>
                <span class="match-card-img"><?php echo get_the_post_thumbnail($args['te2_img']); ?></span>
            </a>
        </span>
    </div>
    <span class="match-card-date"><?php echo esc_html($args['date']); ?></span>
</li>