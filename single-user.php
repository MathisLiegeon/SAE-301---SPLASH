<?php
/*
Template Name: Single User
*/
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url());
    exit;
}

get_header();

$user = wp_get_current_user();
$user_data = $user->data;
console_log($user_data);

$user_team = get_user_team($user_data->ID);
$user_team_id = $user_team->ID;
console_log($user_team);

?>

<nav class="player-nav single-nav">
    <a href="#player-overview" class="team-nav-element">Vue d'ensemble</a>
    <a href="#player-historic" class="team-nav-element">Historique des matchs</a>
</nav>

<header class="hero">
    <span class="player img">a
        <?php the_post_thumbnail($user_team_id);?>
    </span>
    <h2><?php the_title();?></h2>
</header>

<?php
get_footer();
