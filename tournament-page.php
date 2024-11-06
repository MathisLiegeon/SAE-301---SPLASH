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
	while ($the_query->have_posts()) : $the_query->the_post();

$date = get_field('start');
$ID = get_the_ID();
console_log($ID);

?>

<header class="to-header">
    <span class="to-logo">
        <?php the_post_thumbnail();?>
    </span>
	<span>
    <h2 class="to-title">SPLASH</h2>
    <h2 class="to-title">SPLIT 1</h2>
    <span><?php echo esc_html($date);?></span>
	</span>
</header>

<div class="to-container">
    <h3 class="to-bracket-title">Bracket</h3>
	<div class="to-match-container">
		<span class="to-text">Quart de finale</span>
    	<?php
		$args2 = array (
			'post_type' => 'match',
			'posts_per_page' => '4',
			'meta_query' => array(
				array(
					'key' => 'place',
					'value' => array(1, 2, 3, 4),
					'compare' => 'IN'
				)
			)
		);
		$match_quart = new WP_Query($args2);
		
		if ($match_quart->have_posts()) :
		foreach ($match_quart->posts as $match) :

		console_log($match_quart->posts);
		console_log('match');
		console_log($match);
		$match_id = $match->ID;
		console_log('match_id');
		console_log($match_id);
		$place = get_post_meta($match_id, 'place', true);
		$team_1 = get_post_meta($match_id, 'team-1', true);
		$team_1_id = $team_1[0];
		$team_2 = get_post_meta($match_id, 'team-2', true);
		$team_2_id = $team_2[0];
		$score_te1 = get_post_meta($match_id, 'score_te1', true);
		$score_te2 = get_post_meta($match_id, 'score_te2', true);
		$date = get_post_meta($match_id, 'start', true);

		console_log('team_1_id');
		console_log($team_1_id);

		get_template_part('components/match-card', null, array(
			'match_id' => $match_id,
			'to_img' => $tournament_id,
			'te1_name' => get_the_title($team_1[0]),
			'te1_img' => $team_1[0],
			'te2_name' => get_the_title($team_2[0]),
			'te2_img' => $team_2[0],
			'te1_score' => $score_te1,
			'te2_score' => $score_te2,
			'date' => $date
		));
		endforeach;
		?>
	</div>
</div>
<div class="to-container">
	<div class="to-match-container">
		<span class="to-text">Demi finale</span>
    	<?php
		$demi = array (
			'post_type' => 'match',
			'posts_per_page' => '4',
			'meta_query' => array(
				array(
					'key' => 'place',
					'value' => array(5, 6),
					'compare' => 'IN'
				)
			)
		);
		$match_demi = new WP_Query($demi);

		if ($match_demi->have_posts()) :
		foreach ($match_demi->posts as $match) :

		console_log($match_quart->posts);
		console_log('match');
		console_log($match);
		$match_id = $match->ID;
		console_log('match_id');
		console_log($match_id);
		$place = get_post_meta($match_id, 'place', true);
		$team_1 = get_post_meta($match_id, 'team-1', true);
		$team_1_id = $team_1[0];
		$team_2 = get_post_meta($match_id, 'team-2', true);
		$team_2_id = $team_2[0];
		$score_te1 = get_post_meta($match_id, 'score_te1', true);
		$score_te2 = get_post_meta($match_id, 'score_te2', true);
		$date = get_post_meta($match_id, 'start', true);

		console_log('team_1_id');
		console_log($team_1_id);

		get_template_part('components/match-card', null, array(
			'match_id' => $match_id,
			'to_img' => $tournament_id,
			'te1_name' => get_the_title($team_1[0]),
			'te1_img' => $team_1[0],
			'te2_name' => get_the_title($team_2[0]),
			'te2_img' => $team_2[0],
			'te1_score' => $score_te1,
			'te2_score' => $score_te2,
			'date' => $date
		));
		endforeach;
		endif;
		?>
	</div>
</div>
<div class="to-container">
	<div class="to-match-container">
		<span class="to-text">Finale</span>
    	<?php
		$final = array (
			'post_type' => 'match',
			'posts_per_page' => '4',
			'meta_query' => array(
				array(
					'key' => 'place',
					'value' => array(7),
					'compare' => 'IN'
				)
			)
		);
		$match_final = new WP_Query($final);

		if ($match_final->have_posts()) :
		foreach ($match_final->posts as $match) :

		console_log($match_quart->posts);
		console_log('match');
		console_log($match);
		$match_id = $match->ID;
		console_log('match_id');
		console_log($match_id);
		$place = get_post_meta($match_id, 'place', true);
		$team_1 = get_post_meta($match_id, 'team-1', true);
		$team_1_id = $team_1[0]; 
		$team_2 = get_post_meta($match_id, 'team-2', true);
		$team_2_id = $team_2[0];
		$score_te1 = get_post_meta($match_id, 'score_te1', true);
		$score_te2 = get_post_meta($match_id, 'score_te2', true);
		$date = get_post_meta($match_id, 'start', true);

		console_log('team_1_id');
		console_log($team_1_id);

		get_template_part('components/match-card', null, array(
			'match_id' => $match_id,
			'to_img' => $tournament_id,
			'te1_name' => get_the_title($team_1[0]),
			'te1_img' => $team_1[0],
			'te2_name' => get_the_title($team_2[0]),
			'te2_img' => $team_2[0],
			'te1_score' => $score_te1,
			'te2_score' => $score_te2,
			'date' => $date
		));
		endforeach;
		endif;
		?>
	</div>
</div>



<?php
$tams_list = array (
    'post_type' => 'team',
    'post_per_page' => -1
);

$teams= new WP_Query($tams_list);
echo '<div class="to-news-wrapper to-teams-wrapper">';
echo '<h2 class="news-title">ÉQUIPE PARTICIPANTES</h2>';
echo '<div class="to-news-content">';

if ($teams->have_posts()) :
    foreach ($teams->posts as $team) :

?>
    <?php
    get_template_part('components/team-card', null, array (
        'id' => $team->ID,
    ));
    ?>

<?php
endforeach;
endif;
?>
</div>
</div>

<?php
$post_list = array (
    'post_type' => 'article',
    'post_per_page' => -1
);

$post_query = new WP_Query($post_list);

echo '<div class="to-news-wrapper">';
echo '<h2 class="news-title">Dernières actus</h2>';

if ($post_query->have_posts()) :
    foreach ($post_query->posts as $post) :
    console_log('the_query');
    $ID = get_the_ID();
    console_log($ID);
    $equipe1 = get_post_meta($ID, 'equipe1', true);
?>
    <?php
    get_template_part('components/news-card', null, array (
        'url' => $post->ID,
        'img' => $post->ID,
        'date' => get_the_date(),
        'titre' => get_the_title()
    ));
    ?>
<?php
    endforeach;
echo '</div>';
endif;
endif;
endwhile;
endif;

wp_reset_postdata();
get_footer();
