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
            wp_redirect(home_url());
            exit;
        } else {
            $error = "Une erreur s'est produite lors de la création du compte.";
        }
    }
}

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
                    <label class="forms-label" for="user_login">Nom d'utilisateur</label>
                    <span class="form-input-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icon_person-black.svg" alt="Icone représentant une personne">
                        <input type="text" name="username" id="user_login" class="forms-input" value="<?php echo isset($_POST   ['username']) ? esc_attr($_POST['username']) : ''; ?>" size="20" autocapitalize="off" required placeholder="Nom d'utilisateur">
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
                    <label class="forms-label" for="user_rank">Ton parcours en MMI</label>
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
