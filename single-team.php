<?php
/*
Template Name: Single Team
*/

get_header();

$ID = get_the_ID();
$captain = get_field('captain');
$coach = get_field('coach');
$members = get_field('members');
$social_link = get_field('social_link');
$social_label = get_field('social_label');
?>

<nav class="team-nav">
    <a class="team-nav-element">Présentation</a>
    <a class="team-nav-element">Activité</a>
    <a class="team-nav-element">Statistiques</a>
</nav>

<header class="team-header">
    <span class="team-img">
        <?php the_post_thumbnail('large');?>
    </span>
    <h2 class="team-title">
        <?php the_title();?>
    </h2>
    <a class="team-social" href="<?php echo esc_url($social_link);?>">
        <?php echo esc_html($social_label);?>
    </a>
</header>

<div class="team-roaster">
    <div class="team-roaster-content">
        <h3>Personnel</h3>
        <ul class="team-roaster-list">
            <?php
            get_template_part('components/player-card', null, array (
                'name' => $captain['display_name'],
                'id' => $captain['ID'],
                'type' => 'Capitaine'
            ));
            get_template_part('components/player-card', null, array (
                'name' => $coach['display_name'],
                'id' => $coach['ID'],
                'type' => 'Coach'
            ));
            ?>
        </ul>
    </div>
    <div class="team-roaster-content">
        <h3>Membres</h3>
        <ul class="team-roaster-list">
            <?php
            foreach ($members as $member) {
                get_template_part('components/player-card', null, array (
                    'name' => $member['display_name'],
                    'id' => $member['ID'],
                    'type' => 'Joueur'
                ));
            }
            ?>
        </ul>
    </div>

    <div class="team-activity">
        <h3>Activité</h3>
        <div class="team-activity-container">
            <h4>Matchs en cours/à venir</h4>
            <ul>
            <?php
            $upcoming_matches = get_team_upcoming_matches($ID);
            console_log('upcoming_matches');
            console_log($upcoming_matches);
            if ($upcoming_matches) {
                foreach ($upcoming_matches as $match) :
                    $name = $match->post_title;
                    $match_id = $match->ID;
                    $tournament = get_post_meta($match_id, 'tournament', true);
                    $tournament_id = $tournament[0];
                    $team_1 = get_post_meta($match_id, 'team-1', true);
                    $team_2 = get_post_meta($match_id, 'team-2', true);
                    $score_te1 = get_post_meta($match_id, 'score_te1', true);
                    $score_te2 = get_post_meta($match_id, 'score_te2', true);
                    $date = get_post_meta($match_id, 'start', true);

                    if ($ID === $team_1[0]) {
                        get_template_part('components/match-card', null, array(
                            'to_url' => get_permalink($tournament_id),
                            'to_img' => $tournament_id,
                            'te1_name' => get_the_title($team_1[0]),
                            'te1_img' => $team_1[0],
                            'te1_url' => get_permalink($team_1[0]),
                            'te2_name' => get_the_title($team_2[0]),
                            'te2_img' => $team_2[0],
                            'te2_url' => get_permalink($team_2[0]),
                            'te1_score' => $score_te1,
                            'te2_score' => $score_te2,
                            'date' => $date
                    ));
                    } else {
                        get_template_part('components/match-card', null, array(
                            'to_url' => get_permalink($tournament_id),
                            'to_img' => $tournament_id,
                            'te1_name' => get_the_title($team_2[0]),
                            'te1_img' => $team_2[0],
                            'te1_url' => get_permalink($team_2[0]),
                            'te2_name' => get_the_title($team_1[0]),
                            'te2_img' => $team_1[0],
                            'te1_url' => get_permalink($team_1[0]),
                            'te1_score' => $score_te2,
                            'te2_score' => $score_te1,
                            'date' => $date
                        ));
                    }
                endforeach;
            }
            ?>
            </ul>
        </div>
        <div class="team-activity-container">
            <h4>Matchs terminés</h4>
            <ul>
            <?php
            $upcoming_matches = get_team_finished_matches($ID);
            console_log('upcoming_matches');
            console_log($upcoming_matches);
            if ($upcoming_matches) {
                foreach ($upcoming_matches as $match) :
                    $name = $match->post_title;
                    $match_id = $match->ID;
                    $tournament = get_post_meta($match_id, 'tournament', true);
                    $tournament_id = $tournament[0];
                    $team_1 = get_post_meta($match_id, 'team-1', true);
                    $team_2 = get_post_meta($match_id, 'team-2', true);
                    $score_te1 = get_post_meta($match_id, 'score_te1', true);
                    $score_te2 = get_post_meta($match_id, 'score_te2', true);
                    $date = get_post_meta($match_id, 'start', true);

                    if ($ID === $team_1[0]) {
                        get_template_part('components/match-card', null, array(
                            'to_url' => get_permalink($tournament_id),
                            'to_img' => $tournament_id,
                            'te1_name' => get_the_title($team_1[0]),
                            'te1_img' => $team_1[0],
                            'te2_name' => get_the_title($team_2[0]),
                            'te2_img' => $team_2[0],
                            'te1_score' => $score_te1,
                            'te2_score' => $score_te2,
                            'date' => $date
                    ));
                    } else {
                        get_template_part('components/match-card', null, array(
                            'to_url' => get_permalink($tournament_id),
                            'to_img' => $tournament_id,
                            'te1_name' => get_the_title($team_2[0]),
                            'te1_img' => $team_2[0],
                            'te2_name' => get_the_title($team_1[0]),
                            'te2_img' => $team_1[0],
                            'te1_score' => $score_te2,
                            'te2_score' => $score_te1,
                            'date' => $date
                        ));
                    }
                endforeach;
            }
            ?>
            </ul>
        </div>
    </div>

    <div class="team-roaster-content">
        <h3>Statistiques</h3>
        <span>graph</span>
    </div>
</div>

<?php
get_footer();
