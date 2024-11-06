<?php
get_header();
?>

<div class="index-hero">
        <img src="<?php echo get_template_directory_uri();?>/assets/img/img_bg.webp" alt="Image de fond d'un personnage de cs2">
    <header>
        <h1>Bienvenue au Tournoi Esport de l'IUT Nord Franche-Comté
        </h1>
        <span>Un événement ouvert à tous, où compétition et convivialité se rencontrent.
        </span>
    </header>
    <footer>
        <p>Rejoignez-nous pour un tournoi unique en son genre, où les étudiants et amateurs d'esport de toute la région s'affrontent dans une ambiance électrique. Que vous soyez joueur ou spectateur, préparez-vous à vivre une expérience inoubliable.</p>
        <a href="#index-section-1"></a>
    </footer>
</div>

<div class="index-section-1" id="index-section-1">
    <p>Notre institution est fière de promouvoir l'esport comme un vecteur de développement personnel et communautaire. Venez découvrir notre tournoi et participez à cette aventure collective.</p>
    <p>Que vous soyez un joueur chevronné ou un simple curieux, notre tournoi est conçu pour être inclusif et accessible à tous. Rejoignez-nous pour célébrer l'esprit du jeu et la compétition saine.</p>
</div>
<div class="index-section-2">
    <h2>Qu'attendez-vous ?
    </h2>
    <div class="section-2-container">
        <span class="section-2-content">
        <?php
        $inscription_page_id = get_page_by_path('Inscription');
        $inscription_url = $inscription_page_id ? get_permalink($inscription_page_id) : '#';
        get_template_part('components/button', null, array(
            'text' => 'S\'inscrire',
            'url' => $inscription_url,
            'class' => ''
        ));
        ?>
        <p class="index-btn-text">Ne manquez pas votre chance de participer. Inscrivez-vous dès maintenant pour garantir votre place dans le tournoi</p>
        </span>
        <span>OU</span>
        <span class="section-2-content">
        <?php
        $tournament_page_id = get_page_by_path('/tournament-page');
        $tournament_url = $tournament_page_id ? get_permalink($tournament_page_id) : home_url('/tournament-page');
        get_template_part('components/button', null, array(
            'text' => 'Détails du tournoi',
            'url' => $tournament_url,
            'class' => ''
        ));
        ?>
        <p class="index-btn-text">Découvrez toutes les informations sur le déroulement du tournoi, les équipes participantes, et bien plus encore.</p>
        </span>
    </div>
</div>

<?php
get_footer();
