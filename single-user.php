<?php
/*
Template Name: Single User
*/
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url());
    exit;
}

get_header();

$current_user_id = get_current_user_id();

if (get_user_team($current_user_id)) :

$current_user= wp_get_current_user();
$current_user_data = $current_user->data;
$current_user_email = $current_user_data->user_email;

$args = array(
  'post_type' => 'user',
  'posts_per_page' => -1,
  'meta_query' => array(
    array(
      'key' => 'email',
      'value' => $current_user_email,
      'compare' => 'LIKE'
    )
  )
);
$the_query = new WP_Query($args);
console_log('SINGLE : query');
console_log($the_query);
$user_profile = $the_query->posts[0];
$user_author = $user_profile->post_author;


console_log('user_author ---');
console_log($user_author);
$user_team = get_user_team($user_author);
console_log($user_team);

$team_id = $user_team->ID;
$team_name = $user_team->post_title;

endif;
?>
<nav class="user-nav single-nav">
    <a href="#user-overview" class="team-nav-element team-active">Vue d'ensemble</a>
    <a href="#user-historic" class="team-nav-element">Historique des matchs</a>
</nav>

<div class="user-wrapper">
    <header class="user-header">
        <span class="user-img">
            <?php echo get_the_post_thumbnail($team_id); ?>
        </span>
        <span class="user-header-content">
        <h2 class="user-title"><?php the_title();?></h2>
        <span class="user-team">Équipe : <?php echo esc_html($team_name);?></span>
        </span>
    </header>

    <div class="user-container" id="team-stats">
        <h3>Statistiques</h3>
        <span>graph</span>
    </div>
    <div class="user-container" id="team-stats">
        <h3>Equipe actuelle</h3>
        <?php
        get_template_part('components/team-card', null, array (
            'id' => $team_id,
        ));
        ?>
    </div>
</div>
<?php
get_footer();
