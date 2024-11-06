<li class="player-card">
    <a href="<?php get_permalink($args['post_id']);?>">
        <span class="team-name">
            <?php echo esc_html($args['name']); ?>
        </span>
        <span class="team-id">
            #<?php echo esc_html($args['id']); ?>
        </span>
        <span class="team-type">
            <?php echo esc_html($args['type']); ?>
        </span>
    </a>
</li>

<!-- How to use -->
<!-- get_template_part('components/player-card', null, array (
    'name' => '',
    'id' => '',
    'type' => ''
)); -->
