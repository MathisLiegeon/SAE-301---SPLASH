<?php
$captain = get_field('captain');
$coach = get_field('coach');
$members = get_field('members');
?>

<div class="team-roaster" id="team-roaster">
    <div class="team-roaster-content">
        <h3>Personnel</h3>
        <ul class="team-roaster-list">
            <?php
            $cuser_post_id = get_user_post($captain['ID']);
            console_log('captain[ID]');
            console_log($captain['ID']);
            get_template_part('components/player-card', null, array (
                'name' => $captain['display_name'],
                'id' => $captain['ID'],
                'type' => 'Capitaine'
            ));
            $couser_post_id = get_user_post($coach['ID']);
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
                $muser_post_id = get_user_post($member['ID']);
                if ($captain['ID'] != $member['ID']) {
                    get_template_part('components/player-card', null, array (
                        'name' => $member['display_name'],
                        'id' => $member['ID'],
                        'type' => 'Joueur'
                    ));
                }
            }
            ?>
        </ul>
    </div>
</div>