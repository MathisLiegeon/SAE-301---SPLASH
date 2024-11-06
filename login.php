<?php
/*
Template Name: Login Page
*/


// if (is_user_logged_in()) {
//     echo '<script>
//         alert("Vous êtes déjà connecté");
//         window.location.href = "' . home_url() . '";
//     </script>';
//     exit;
// }

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    console_log('POST request received');
    $username = sanitize_text_field($_POST['username']);
    $password = sanitize_text_field($_POST['password']);
    $remember = isset($_POST['rememberme']);
    console_log($username);
    console_log($password);
    console_log($remember);

    $user = wp_signon(array(
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => $remember
    ));
    console_log('User result:');
    console_log($user);

    if (is_wp_error($user)) {
        $error_message = 'Identifiant ou mot de passe incorrect.';
    } else {
        wp_redirect(home_url());
        exit;
    }
}
ini_set('display_errors', 1);
error_reporting(E_ALL);

get_header();

?>

<div class="forms-wrap login-wrapper">
    <div class="form-wrap">
        <h1 class="forms-title">Connexion</h1>
        <?php if (!empty($error_message)) : ?>
            <p class="form-error-message" style="color: red; width:100%; text-align:center;"><?php echo esc_html($error_message); ?></p>
        <?php endif; ?>

        <form class="forms-form" name="loginform" id="loginform" action="" method="post">
            <p class="forms-field">
                <label class="forms-label" for="user_login">Identifiant ou adresse e-mail</label>
                <span class="form-input-wrapper">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icon_person-black.svg" alt="Icone représentant une personne">
                    <input type="text" name="username" id="user_login" class="forms-input" value="" size="20" autocapitalize="off"  autocomplete="username" required placeholder="Identifiant ou adresse e-mail">
                </span>
            </p>
            <span>
                <p class="forms-field">
                    <label class="forms-label" for="user_pass">Mot de passe</label>
                    <span class="form-input-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icon_psw.svg" alt="Icone représentant un cadenas">
                        <input type="password" name="password" id="user_pass" class="forms-input" value="" size="20" autocomplete="current-password"    required placeholder="Mot de passe">
                    </span>
                </p>

                <a class="form-psw-forgot" href="<?php echo wp_lostpassword_url(); ?>">Mot de passe oublié ?</a>

                <p class="forms-field forgetmenot">
                    <label class="forms-label" for="rememberme">
                        <input name="rememberme" type="checkbox" id="rememberme" value="forever"> Se souvenir de moi
                    </label>
                </p>
            </span>

            <p class="forms-submit">
                <?php
                get_template_part('components/submit', null, array(
                    'name' => 'wp-submit',
                    'id' => 'wp-submit',
                    'text' => 'Se connecter',
                    'class' => 'login-form-submit'
                ));
                ?>
            <a class="form-no-account" href="<?php echo esc_url(get_page_link(get_page_by_title('Inscription')->ID)); ?>">Pas de compte ? inscrit-toi</a>
            </p>
        </form>
    </div>

</div>

<?php
get_footer();
