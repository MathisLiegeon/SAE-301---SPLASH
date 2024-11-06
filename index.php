<?php
get_header();
?>

<div class="index-hero">
    <img src="<?php echo get_template_directory_uri();?>/assets/img/img_bg.webp" alt="Image de fond d'un personnage de cs2">
    <header>
        <h1><?php the_title();?></h1>
        <span>Subtitle</span>
    </header>
    <footer>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent placerat nulla eu posuere mattis. Maecenas non finibus nulla, eu lobortis dolor</p>
        <a href="#index-section-1"></a>
    </footer>
</div>

<div class="index-section-1" id="index-section-1">
    <p>IUT Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent placerat nulla eu posuere mattis. Maecenas non finibus nulla, eu lobortis dolor. Phasellus cursus dictum velit, ac gravida felis lobortis sit amet. Cras rhoncus maximus fermentum. Nam vitae pulvinar ante. Aenean mattis vitae risus eget hendrerit.</p>
    <p>OUVERT A TOUS Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent placerat nulla eu posuere mattis. Maecenas non </p>
</div>
<div class="index-section-2">
    <h2>Qu'attend tu ?</h2>
    <div class="section-2-container">
        <?php
        get_template_part('components/button', null, array(
            'text' => 'S\'inscrire',
            'url' => 'wp_login_url()',
            'class' => ''
        ));
        ?>
        <span>OU</span>
        <?php
        get_template_part('components/button', null, array(
            'text' => 'Détails du tournoi',
            'url' => 'home_url(/)',
            'class' => ''
        ));
        ?>
    </div>
</div>

<?php
get_footer();
