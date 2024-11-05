<?php
/*
Template Name: Single Team
*/

get_header();

$ID = get_the_ID();
$captain = get_field('captain');
$coach = get_field('coach');
$members = get_field('members');
$social = get_field('social');
console_log($social);
console_log($social['url']);
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
    <a class="team-social" href="<?php echo esc_url($social['url']);?>">
       @<?php echo esc_html($social['title']);?>
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

    <?php get_template_part('archive-match'); ?>

    <div class="team-roaster-content">
        <h3>Statistiques</h3>
        <span>graph</span>
    </div>
</div>

<?php
get_footer();
