<?php
/*
Template Name: Team Creation Page
*/
if (!is_user_logged_in()) :
    echo '<script>
        alert("Vous n\'avez pas accès à cette page");
        window.location.href = "' . home_url() . '";
    </script>';
    exit;
else :
get_header();

$error_message = '';

$current_user_id = get_current_user_id();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_team'])) {
    $team_name = sanitize_text_field($_POST['team_name']);
    $team_members = array_filter(array(
        $_POST['team_mate_1'],
        $_POST['team_mate_2'],
        $_POST['team_mate_3']
    ));



    $team_members[] = $current_user_id;

    if ((count($team_members) < 3 || count($team_members) > 4) ) {
        $error_message = 'Une équipe doit contenir entre 3 et 4 membres et doit avoir un membre de chaque parcours minimum';
    } else {
        $team_id = wp_insert_post(array(
            'post_title' => $team_name,
            'post_status' => 'publish',
            'post_type' => 'team'
        ));

        if ($team_id) {
            update_field('members', $team_members, $team_id);
            update_field('creator', $current_user_id, $team_id);
            echo '<script>alert("L\'equipe a été créé avec succès");</script>';
        } else {
            $error_message = 'Erreur : quelque chose s\'est mal passé.';
        }
    }
}
?>

<div class="form-main">
    <div class="form-container">
        <h1 class="form-title">
            <?php the_title();?>
        </h1>
        <span class="error-message">
            <?php echo esc_html($error_message);?>
        </span>
        <form method="post" class="form-form" id="form-form">
            <div class="form-content">
                <span class="form-element">
                    <label class="form-label" for="team_name">Nom de l'équipe</label>
                    <span class="form-field">
                        <span class="form-input-wrapper">
                            <img src="<?php echo get_template_directory_uri();?>/assets/icons/icon_team.svg" alt="Icone représentant plusieurs personnes">
                            <input class="form-input" type="text" id="team_name" name="team_name" placeholder="Nom de l'équipe" required>
                        </span>
                    </span>
                </span>
            </div>

            <div class="form-content">
                <span  class="form-info">
                    <span>
                        <p class="form-label">Choisi tes coéquipiers</p>
                        <span class="form-text">(Minimum 2 de chaque parcours et maximum 3)</span>
                    </span>

                    <span class="form-element">
                        <div class="form-field form-field-search active" id="search-1">
                            <label class="form-label" for="soValue-1">Coéquipier n°1</label>
                            <div class="form-select-option form-input-wrapper">
                                 <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icon_person.svg" alt="Icone représentant une personne">
                                <input type="text" placeholder="Coéquipier n°1" id="soValue-1" readonly     name="team_mate_1">
                            </div>
                            <div class="form-search-container form-search-container-pick">
                                <div class="form-search form-search-pick">
                                    <input type="text" id="team-search-1" placeholder="Rechercher"  name="">
                                </div>
                                <ul class="form-search-option form-search-option-pick">
                                    <li class="search-element" data-id="">Aucun</li>
                                    <?php
                                    $available_users = get_available_users($current_user_id);
                                    foreach ($available_users as $user) :
                                        echo '<li class="search-element" data-id="' . esc_attr($user->ID) . '">' . esc_html    ($user->data->display_name) . ' ' . esc_html(get_user_meta  ($user->ID, 'spe', true)) . '</li>';
                                    endforeach;
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </span>
                </span>
                <span class="form-element">
                    <div class="form-field form-field-search active" id="search-2">
                        <label class="form-label" for="soValue-2">Coéquipier n°2</label>
                        <div class="form-select-option form-input-wrapper">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icon_person.svg" alt="Icone représentant une personne">
                            <input type="text" placeholder="Coéquipier n°2" id="soValue-2" readonly name="team_mate_2">
                        </div>
                        <div class="form-search-container form-search-container-pick">
                            <div class="form-search form-search-pick">
                                <input type="text" id="team-search-2" placeholder="Rechercher" name="">
                            </div>
                            <ul class="form-search-option form-search-option-pick">
                                <li class="search-element" data-id="">Aucun</li>
                                <?php
                                $available_users = get_available_users($current_user_id);
                                foreach ($available_users as $user) :
                                    echo '<li class="search-element" data-id="' . esc_attr($user->ID) . '">' . esc_html($user->data->display_name) . ' ' . esc_html(get_user_meta($user->ID, 'spe', true)) . '</li>';
                                endforeach;
                                ?>
                            </ul>
                        </div>
                    </div>
                </span>
                <span class="form-element">
                    <div class="form-field form-field-search active" id="search-3">
                        <label class="form-label" for="soValue-3">Coéquipier n°3</label>
                        <div class="form-select-option form-input-wrapper">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icon_person.svg" alt="Icone représentant une personne">
                            <input type="text" placeholder="Coéquipier n°3" id="soValue-3" readonly name="team_mate_3">
                        </div>
                        <div class="form-search-container form-search-container-pick">
                            <div class="form-search form-search-pick">
                                <input type="text" id="team-search-3" placeholder="Rechercher" name="">
                            </div>
                                <ul class="form-search-option form-search-option-pick">
                                <li class="search-element" data-id="">Aucun</li>
                                <?php
                                $available_users = get_available_users($current_user_id);
                                foreach ($available_users as $user) :
                                    echo '<li class="search-element" data-id="' . esc_attr($user->ID) . '">' . esc_html($user->data->display_name) . ' ' . esc_html(get_user_meta($user->ID, 'spe', true)) . '</li>';
                                endforeach;
                                ?>
                            </ul>
                        </div>
                    </div>
                </span>
            </div>

            <div class="form-content">
                <?php
                get_template_part('components/submit', null, array(
                    'name' => 'create_team',
                    'id' => 'wp-submit',
                    'text' => 'Créer',
                    'class' => ''
                ));
                ?>
                <span class="form-text">Seul le créateur de l’équipe sera en mesure de supprimer l'équipe</span>
            </div>
        </form>
    </div>
</div>

<?php
get_footer();
endif;