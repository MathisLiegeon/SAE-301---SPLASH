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
?>

<?php
get_template_part('components/news-card', null, array (
    'url' => get_permalink(),
    'img' => get_the_post_thumbnail_url(),
    'date' => get_the_date(),
    'titre' => get_the_title()
));
?>

<?php
    endwhile;
endif;
get_footer();
