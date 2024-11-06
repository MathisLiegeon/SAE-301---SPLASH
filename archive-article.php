<?php
/*
Template Name: Archive Article
*/

get_header();

$args = array (
    'post_type' => 'article',
    'post_per_page' => -1
);

$the_query = new WP_Query($args);

if ($the_query->have_posts()) :
    while ($the_query->have_posts()) : $the_query->the_post();
    console_log('the_query');
    console_log($the_query->posts);
    $ID = get_the_ID();
    console_log($ID);
    $equipe1 = get_post_meta($ID, 'equipe1', true);
?>
<div class="news-wrapper">
<h2 class="news-title">Dernières actus</h2>
    <?php
    get_template_part('components/news-card', null, array (
        'url' => get_permalink(),
        'img' => $the_query->posts[0]->ID,
        'date' => get_the_date(),
        'titre' => get_the_title()
    ));
    ?>
</div>
<?php
    endwhile;
endif;
get_footer();
