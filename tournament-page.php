<?php
/*
Template name: Tournament Page
*/

get_header();

$args = array (
    'post_type' => 'tournament',
    'posts_per_page' => '1'
);

$the_query = new WP_Query($args);

if ($the_query->have_posts()) :
$date = get_field('start');
$ID = get_the_ID();
console_log($ID);

$args2 = array (
    'post_type' => 'match',
    'posts_per_page' => '-1',
);
$match = new WP_Query($args2);

if ($match->have_posts()) : $match->the_post();
console_log($match->posts);
$match_id = $match->ID;
console_log('match_id');
console_log($match_id);

$place = get_post_meta($match_id, 'place', true);
$team_1 = get_post_meta($match_id, 'team-1', true);
$team_1_id = $team_1[0];
$team_2 = get_post_meta($match_id, 'team-2', true);
$team_2_id = $team_0[0];
$score_te1 = get_post_meta($match_id, 'score_te1', true);
$score_te2 = get_post_meta($match_id, 'score_te2', true);
$date = get_post_meta($match_id, 'start', true);
$live = get_post_meta($match_id, 'live', true);
$vod_1 = get_post_meta($match_id, 'vod-1', true);
$vod_2 = get_post_meta($match_id, 'vod-2', true);
$vod_3 = get_post_meta($match_id, 'vod-3', true);

console_log('team_1_id');
console_log($team_1_id);
?>

<header class="to_header">
    <span class="to-logo">
        <?php the_post_thumbnail();?>
    </span>
    <h2 class="to-title">SPLASH</h2>
    <h2 class="to-title">SPLIT 1</h2>
    <span><?php echo esc_html($date);?></span>
</header>

<div class="to-container">
    <h3>Bracket</h3>
    <div class="bracket-container">
        <div class="braket-col mod-1">
            <div class="bracket-col-label">Upper Quarterfinals</div>
            <div class="bracket-row mod-1">
			<a class="bracket-item"  href="">
				<div class="bracket-item-team mod-first">
					<div class="bracket-item-team-name ">
						<span class="bracket_img">
							<?php echo $place == 0 ? get_the_post_thumbnail($team_1_id) : ''; ?>
                        </span>
						<span><?php echo esc_html($place == 0 ? get_the_title($team_1_id) : ''); ?></span>
					</div>
					<div class="bracket-item-team-score">
						<?php echo esc_html($place == 0 ? get_the_title($score_te1) : ''); ?>
					</div>
				</div>
				<div class="bracket-item-team mod-winner">
					<div class="bracket-item-team-name">
						<span class="bracket_img">
							<?php echo $place == 0 ? get_the_post_thumbnail($team_2_id) : ''; ?>
                        </span>
						<span><?php echo esc_html($place == 0 ? get_the_title($team_2_id) : ''); ?></span>
					</div>
					<div class="bracket-item-team-score">
						<?php echo esc_html($place == 0 ? get_the_title($score_te2) : ''); ?>
					</div>
				</div>
				<div class="bracket-item-status moment-tz-convert">
                    <span><?php echo esc_html($place == 0 ? $date : ''); ?></span>
                </div>
				<div class="bracket-item-line mod-down"></div>
			</a>
			</div>
        </div>

        <div class="braket-col mod-2"></div>
        <div class="braket-col mod-3"></div>
    </div>
</div>

<?php
endif;
endif;

wp_reset_postdata();
get_footer();
