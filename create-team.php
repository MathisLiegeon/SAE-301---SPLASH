<?php
/* Template Name: Team Creation Page */

if (!is_user_logged_in()) :
    echo '<script> alert("Vous n\'avez pas accès à cette page"); window.location.href = "' . home_url() . '"; </script>';
    exit;
else :
    get_header();
    $error_message = '';
    $current_user_id = get_current_user_id();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_team'])) {
        $team_name = sanitize_text_field($_POST['team_name']);
        $team_coach = sanitize_text_field($_POST['coach']);
        $team_members = array_filter(array(
            $_POST['team_mate_1'],
            $_POST['team_mate_2'],
            $_POST['team_mate_3']
        ));
        $team_members[] = $current_user_id;

        if (count($team_members) < 4 ) {
            $error_message = 'Une équipe doit contenir entre 3 et 4 membres et doit avoir un membre de chaque parcours minimum';
        } else {
            $team_id = wp_insert_post(array(
                'post_title' => $team_name,
                'post_status' => 'publish',
                'post_type' => 'team'
            ));

            if ($team_id) {
                update_field('members', $team_members, $team_id);
                update_field('captain', $current_user_id, $team_id);
                update_field('coach', $team_coach, $team_id);

                // Vérification du type de fichier
                $allowed_types = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');
                if (!empty($_FILES['team_logo']['name'])) {
                    if (!in_array($_FILES['team_logo']['type'], $allowed_types)) {
                        $error_message = 'Type de fichier non autorisé. Veuillez utiliser une image PNG, JPEG ou GIF.';
                    } elseif ($_FILES['team_logo']['size'] > wp_max_upload_size()) {
                        $error_message = 'Le fichier est trop volumineux. Taille maximale autorisée : ' . size_format(wp_max_upload_size());
                    } else {
                        require_once(ABSPATH . 'wp-admin/includes/file.php');
                        require_once(ABSPATH . 'wp-admin/includes/image.php');

                        $upload_overrides = array('test_form' => false);
                        $movefile = wp_handle_upload($_FILES['team_logo'], $upload_overrides);

                        if ($movefile && !isset($movefile['error'])) {
                            $wp_filetype = wp_check_filetype($movefile['file'], null);
                            $attachment = array(
                                'post_mime_type' => $wp_filetype['type'],
                                'post_title' => sanitize_file_name($_FILES['team_logo']['name']),
                                'post_content' => '',
                                'post_status' => 'inherit'
                            );
                            $attach_id = wp_insert_attachment($attachment, $movefile['file'], $team_id);
                            $attach_data = wp_generate_attachment_metadata($attach_id, $movefile['file']);
                            wp_update_attachment_metadata($attach_id, $attach_data);
                            set_post_thumbnail($team_id, $attach_id);

                            // Alternative si set_post_thumbnail ne fonctionne pas
                            update_post_meta($team_id, '_thumbnail_id', $attach_id);

                            error_log('Logo téléchargé avec succès. ID de la pièce jointe : ' . $attach_id);
                        } else {
                            $error_message = 'Erreur lors du téléchargement du logo de l\'équipe.';
                            error_log('Erreur de téléchargement : ' . print_r($movefile['error'], true));
                        }
                    }
                }

                if (empty($error_message)) {
                    echo '<script>alert("L\'équipe a été créée avec succès");</script>';
                }
            } else {
                $error_message = 'Erreur : quelque chose s\'est mal passé.';
            }
        }
    }
?>

<div class="form-main">
    <div class="form-container">
        <h1 class="form-title"><?php the_title(); ?></h1>
        <span class="error-message"><?php echo esc_html($error_message); ?></span>
        <form method="post" class="form-form" id="form-form" enctype="multipart/form-data">
            <div class="form-content">
                <span class="form-element">
                    <label class="form-label" for="team_name">Nom de l'équipe</label>
                    <span class="form-field">
                        <span class="form-input-wrapper">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icon_team.svg" alt="Icone représentant plusieurs personnes">
                            <input class="form-input" type="text" id="team_name" name="team_name" placeholder="Nom de l'équipe" required>
                        </span>
                    </span>
                </span>
            </div>
            <div class="form-content">
                <label class="form-label" for="team-logo">Logo de l'équipe</label>
                <input type="file" id="team-logo" name="team_logo" accept="image/*">
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
                                 <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icon_person-black.svg" alt="Icone représentant une personne">
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
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icon_person-black.svg" alt="Icone représentant une personne">
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
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icon_person-black.svg" alt="Icone représentant une personne">
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
                <span class="form-element">
                    <div class="form-field form-field-search active" id="search-5">
                        <label class="form-label" for="soValue-5">Coéquipier n°4</label>
                        <div class="form-select-option form-input-wrapper">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icon_person-black.svg" alt="Icone représentant une personne">
                            <input type="text" placeholder="Coéquipier n°4" id="soValue-5" readonly name="team_mate_5">
                        </div>
                        <div class="form-search-container form-search-container-pick">
                            <div class="form-search form-search-pick">
                                <input type="text" id="team-search-5" placeholder="Rechercher" name="">
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
                    <div class="form-field form-field-search active" id="search-4">
                        <label class="form-label" for="soValue-4">Coach</label>
                        <div class="form-select-option form-input-wrapper">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icon_person-black.svg" alt="Icone représentant une personne">
                            <input type="text" placeholder="Coach" id="soValue-4" readonly name="coach">
                        </div>
                        <div class="form-search-container form-search-container-pick">
                            <div class="form-search form-search-pick">
                                <input type="text" id="team-search-4" placeholder="Rechercher" name="">
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
                <?php get_template_part('components/submit', null, array(
                    'name' => 'create_team',
                    'id' => 'wp-submit',
                    'text' => 'Créer',
                    'class' => ''
                )); ?>
                <span class="form-text">Seul le créateur de l'équipe sera en mesure de supprimer l'équipe</span>
            </div>
        </form>
    </div>
</div>

<?php
get_footer();
endif;