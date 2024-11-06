<?php
/*
Template Name: Page Mentions legales
*/

get_header();

if (have_posts()) :
    while (have_posts()) : the_post();
?>
<div class="responsive">
<div class="article-wrapper">
    <span class="article-thumbnail">
        <?php echo get_the_post_thumbnail(); ?>
    </span>
    <div class="article-content">
        <?php the_content(); ?>
    </div>
</div>
</div>
<?php
    endwhile;
endif;

get_footer();
?>