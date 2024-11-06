<div class="team-activity" id="team-activity">
    <h3>Historique des matchs</h3>
    <span class="team-activity-wrapper">
        <div class="team-activity-container">
            <h4>Matchs en cours/à venir</h4>
            <ul>
            <?php
            $ID = get_the_ID();
            $upcoming_matches = get_team_upcoming_matches($args['id']);
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

                    if ($args['id'] === $team_1[0]) {
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
                    } else {
                        get_template_part('components/match-card', null, array(
                            'match_id' => $match_id,
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
        <div class="team-activity-container">
            <h4>Matchs terminés</h4>
            <ul>
            <?php
            $upcoming_matches = get_team_finished_matches($args['id']);
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

                    if ($args['id'] === $team_1[0]) {
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
                    } else {
                        get_template_part('components/match-card', null, array(
                            'match_id' => $match_id,
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
        </span>
    </div>