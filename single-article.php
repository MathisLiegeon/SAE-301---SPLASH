<?php
/*
Template Name: Article
*/

get_header();

if (have_posts()) :
    while (have_posts()) : the_post();
?>
<div class="article-wrapper">
    <span class="article-thumbnail">
        <?php echo get_the_post_thumbnail(); ?>
    </span>
    <h1 class="article-title"><?php the_title(); ?></h1>
    <div class="article-content">
        <?php the_content(); ?>
    </div>
</div>
<?php
    endwhile;
endif;

get_footer();
?>