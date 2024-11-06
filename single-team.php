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
<nav class="team-nav single-nav">
    <a href="#team-header" class="team-nav-element team-active"
    if urlpage = url#team-header style:borderbottom:solid
    >Présentation</a>
    <a href="#team-activity" class="team-nav-element">Activité</a>
    <a href="#team-stats" class="team-nav-element">Statistiques</a>
</nav>

<div class="responsive">
<header class="team-header" id="team-header">
    <span class="team-img">
        <?php the_post_thumbnail('large');?>
    </span>
    <span>
        <h2 class="team-title">
            <?php the_title();?>
        </h2>
        <a class="team-social" href="<?php echo esc_url($social['url']);?>">
           @<?php echo esc_html($social['title']);?>
        </a>
    </span>
</header>
<div class="team-wrapper">
    <?php get_template_part('archive-user'); ?>

    <?php get_template_part('archive-match'); ?>

    <div class="team-stats" id="team-stats">
        <h3>Statistiques</h3>
        <span>graph</span>
    </div>
</div>
</div>
<?php
get_footer();
