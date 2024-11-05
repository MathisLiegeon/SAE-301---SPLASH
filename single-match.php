<?php
/*
Template Name: Match
*/

get_header();

$tournament = get_field('tournament');
$tournament_id = $tournament[0];
$team_1 = get_field('team-1');
$team_2 = get_field('team-2');
$score_te1 = get_field('score_te1');
$score_te2 = get_field('score_te2');
$date = get_field('start');
$live = get_field('live');
$vod_1 = get_field('vod-1');
$vod_2 = get_field('vod-2');
$vod_3 = get_field('vod-3');
?>

<header class="match-header">
    <span class="match-img">
        <?php echo get_the_post_thumbnail($tournament_id); ?>
    </span>
    <h2 class="match-title">
        <?php echo get_the_title($tournament_id); ?>
    </h2>
</header>

<div class="match-match">
    <?php
    get_template_part('components/match-single-card', null, array(
        'to_img' => $tournament_id,
        'te1_name' => get_the_title($team_1[0]),
        'te1_img' => $team_1[0],
        'te2_name' => get_the_title($team_2[0]),
        'te2_img' => $team_2[0],
        'te1_score' => $score_te1,
        'te2_score' => $score_te2,
        'date' => $date
    ));
    ?>
</div>

<div class="match-container">
    <h3>REGARDER</h3>
    <div class="match-content">
        <?php
        if ($live) :
            get_template_part('components/live-card', null, array (
                'title' => $live['title'],
                'link' => $live['url']
            ));

        else :
            echo '<span>Aucun live disponible</span>';
        endif;
        ?>
    </div>
</div>

<div class="match-container">
    <h3>VODS & CLIPS</h3>
    <div class="match-content">
        <?php
        $VODS = [$vod_1, $vod_2, $vod_3];
        console_log($VODS);
        $has_valid_vod = false;

        if (is_array($VODS)) {
            foreach ($VODS as $vod) {
                if ($vod !== null) {
                    $has_valid_vod = true;
                    break;
                }
            }
        }
        if ($has_valid_vod) :
            foreach ($VODS as $VOD) :
            get_template_part('components/live-card', null, array (
                'title' => $VOD['title'],
                'link' => $VOD['url']
            ));

            endforeach;
        else :
            echo '<span>Aucunes VOD disponible</span>';
        endif;
        ?>
    </div>
</div>

<?php
get_footer();
