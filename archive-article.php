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

echo '<div class="news-wrapper">';
echo '<h2 class="news-title">Dernières actus</h2>';

if ($the_query->have_posts()) :
    foreach ($the_query->posts as $post) :
    console_log('the_query');
    $ID = get_the_ID();
    console_log($ID);
    $equipe1 = get_post_meta($ID, 'equipe1', true);
?>
    <?php
    get_template_part('components/news-card', null, array (
        'url' => $post->ID,
        'img' => $post->ID,
        'date' => get_the_date(),
        'titre' => get_the_title()
    ));
    ?>
<?php
    endforeach;
echo '</div>';
endif;
get_footer();
