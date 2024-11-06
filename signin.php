<?php
/*
Template Name: Sign in Page
*/

if (is_user_logged_in()) {
    echo '<script>
        alert("Vous êtes déjà connecté");
        window.location.href = "' . home_url() . '";
    </script>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_user($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $rank = sanitize_text_field($_POST['rank']);

    $error = null;

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (!is_email($email)) {
        $error = "L'adresse e-mail n'est pas valide.";
    } elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif (strlen($password) < 6) {
        $error = "Le mot de passe doit contenir au moins 6 caractères.";
    } elseif (username_exists($username)) {
        $error = "Ce nom d'utilisateur est déjà pris.";
    } elseif (email_exists($email)) {
        $error = "Cette adresse e-mail est déjà utilisée.";
    }

    if (!$error) {
        $user_id = wp_create_user($username, $password, $email);
        if (!is_wp_error($user_id)) {
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id);
            $user_data = wp_insert_post(array(
                'post_title' => $username,
                'post_status' => 'publish',
                'post_type' => 'user'
            ));

            wp_redirect(home_url());
            if ($user_data) {
                update_field('pseudo', $username, $user_data);
                update_field('email', $email, $user_data);
                update_field('rank', $rank, $user_data);
                update_field('password', $password, $user_data);
                update_field('confirm_password', $confirm_password, $user_data);
            }

            exit;
        } else {
            $error = "Une erreur s'est produite lors de la création du compte.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_text_field($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = sanitize_text_field($_POST['password']);
    $confirm_password = sanitize_text_field($_POST['confirm_password']);
    $rank = sanitize_text_field($_POST['rank']); // Assurez-vous que ce champ est défini dans le formulaire

    if (!is_email($email)) {
        $error = "L'adresse e-mail n'est pas valide.";
    } elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif (strlen($password) < 6) {
        $error = "Le mot de passe doit contenir au moins 6 caractères.";
    } elseif (username_exists($username)) {
        $error = "Ce nom d'utilisateur est déjà pris.";
    } elseif (email_exists($email)) {
        $error = "Cette adresse e-mail est déjà utilisée.";
    }

    if (!$error) {
        $user_id = wp_create_user($username, $password, $email);
        if (!is_wp_error($user_id)) {
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id);

            $allowed_types = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');
            if (!empty($_FILES['profile_picture']['name'])) {
                if (!in_array($_FILES['profile_picture']['type'], $allowed_types)) {
                    $error = 'Type de fichier non autorisé. Veuillez utiliser une image PNG, JPEG ou GIF.';
                } elseif ($_FILES['profile_picture']['size'] > wp_max_upload_size()) {
                    $error = 'Le fichier est trop volumineux. Taille maximale autorisée : ' . size_format(wp_max_upload_size());
                } else {
                    require_once(ABSPATH . 'wp-admin/includes/file.php');
                    require_once(ABSPATH . 'wp-admin/includes/media.php');
                    require_once(ABSPATH . 'wp-admin/includes/image.php');

                    $upload_overrides = array('test_form' => false);
                    $movefile = wp_handle_upload($_FILES['profile_picture'], $upload_overrides);

                    if ($movefile && !isset($movefile['error'])) {
                        $wp_filetype = wp_check_filetype($movefile['file'], null);
                        $attachment = array(
                            'post_mime_type' => $wp_filetype['type'],
                            'post_title' => sanitize_file_name($_FILES['profile_picture']['name']),
                            'post_content' => '',
                            'post_status' => 'inherit'
                        );
                        $attach_id = wp_insert_attachment($attachment, $movefile['file'], 0);
                        $attach_data = wp_generate_attachment_metadata($attach_id, $movefile['file']);
                        wp_update_attachment_metadata($attach_id, $attach_data);
                        update_user_meta($user_id, 'profile_picture', $attach_id);

                        error_log('Image de profil téléchargée avec succès. ID de la pièce jointe : ' . $attach_id);
                    } else {
                        $error = 'Erreur lors du téléchargement de l\'image de profil.';
                        error_log('Erreur de téléchargement : ' . print_r($movefile['error'], true));
                    }
    
                if ($user_data) {
                    update_field('pseudo', $username, $user_data);
                    update_field('email', $email, $user_data);
                    update_field('rank', $rank, $user_data);
                    update_field('password', $password, $user_data);
                    update_field('confirm_password', $confirm_password, $user_data);
                    set_post_thumbnail($user_data, $attachment_id);
                }
            }

            wp_redirect(home_url());
            exit;
        } else {
            $error = "Une erreur s'est produite lors de la création du compte.";
        }
    }
}}

get_header();
?>


<div class="forms-wrap">
    <div class="form-wrap">
        <h1 class="forms-title">Inscription</h1>

        <?php if (isset($error)) : ?>
            <p style="color: red; width:100%; text-align:center;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form class="forms-form forms-form-signin" name="registerform" id="registerform" action="" method="post">
            <span>
                <p class="forms-field">
                    <label class="forms-label" for="user_login">Pseudo</label>
                    <span class="form-input-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icon_person-black.svg" alt="Icone représentant une personne">
                        <input type="text" name="username" id="user_login" class="forms-input" value="<?php echo isset($_POST   ['username']) ? esc_attr($_POST['username']) : ''; ?>" size="20" autocapitalize="off" required placeholder="Pseudo">
                    </span>
                </p>



                <p class="forms-field">
                    <label class="forms-label" for="user_email">Adresse e-mail</label>
                    <span class="form-input-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icon_mail.svg" alt="Icone représentant une lettre">
                        <input type="email" name="email" id="user_email" class="forms-input" value="<?php echo isset($_POST['email']) ?     esc_attr($_POST['email']) : ''; ?>" size="20" autocomplete="email" required placeholder="Adresse e-mail">
                    </span>
                </p>

                <p class="forms-field">
                    <label class="forms-label" for="user_rank">Ton rank</label>
                    <span class="form-input-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icon_rank.svg" alt="Icone représentant un chapeau d'étudiant">
                        <select name="rank" id="user_rank" class="forms-input" required>
                            <?php
                            $tab_rank = ['Argent 1', 'Argent 2', 'Argent 3', 'Argent 4', 'Argent 5', 'Argent 6', 'Nova 1', 'Nova 2', 'Nova 3', 'Nova 4', 'Ak 1', 'Ak 2', 'Double Ak', 'Master', 'Aigle', 'Aigle légendaire', 'Supreme', 'Global Elite'];
                            ?>
                            <option value="">Sélectionnez votre rang</option>
                            <?php
                            foreach ($tab_rank as $rank) {
                                echo '<option value="'. $rank .'" '. (isset($_POST['rank']) && $_POST['rank'] == $rank ? 'selected' : '') .'>'. $rank .'</option>';
                            }
                            ?>
                        </select>
                    </span>
                </p>
            </span>

            <span>
                <p class="forms-field">
                    <label class="forms-label" for="user_pass">Mot de passe</label>
                    <span class="form-input-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icon_weakpsw.svg" alt="Icone représentant un cadenas">
                        <input type="password" name="password" id="user_pass" class="forms-input" value="" size="20"    autocomplete="new-password" required placeholder="Mot de passe">
                    </span>
                </p>

                <p class="forms-field">
                    <label class="forms-label" for="user_pass_confirm">Confirmer le mot de passe</label>
                    <span class="form-input-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icon_psw.svg" alt="Icone représentant un cadenas">
                        <input type="password" name="confirm_password" id="user_pass_confirm" class="forms-input" value="" size="20"    autocomplete="new-password" required placeholder="Confirmer le mot de passe">
                    </span>
                </p>
            </span>

            <p class="forms-field">
                    <label class="forms-label" for="legal_mentions">
                        <input type="checkbox" name="legal_mentions" id="legal_mentions" required>
                        J'accepte les <a href="<?php echo get_permalink(get_page_by_path('mentions-legales')); ?>" target="_blank">mentions légales</a>
                    </label>
                </p>

            <p class="forms-submit">
                <span class="button-signin">
                    <input type="submit" name="wp-submit" id="wp-submit" class="button-primary button-large " value="S'inscrire">
                </span>
                <a class="form-no-account" href="<?php echo esc_url(get_page_link(get_page_by_title('Connexion')->ID)); ?>">Déjà inscrit ? Connecte-toi</a>
            </p>
        </form>
        <p id="nav" class="forms-annexe">
        </p>

    </div>
</div>

<?php
get_footer();
