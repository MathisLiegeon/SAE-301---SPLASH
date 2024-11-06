 <!DOCTYPE html>
<html>
  <head <?php language_attributes(); ?>>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPLASH - Tournoi Counter Strike 2</title>
    <link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri();?>/assets/icons/">
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri() . '?ver=' . filemtime(get_stylesheet_directory() . '/style.css'); ?>" type="text/css">

    <?php wp_head();?>
    <script defer src="<?php echo get_template_directory_uri();?>/assets/js/app.js"></script>
  </head>

  <?php
  if (is_user_logged_in()) :
  $current_user= wp_get_current_user();
  console_log('current_user_');
  console_log($current_user);
  $current_user_data = $current_user->data;
  console_log($current_user_data);
  $current_user_email = $current_user_data->user_email;
  console_log($current_user_email);

  $args = array(
    'post_type' => 'user',
    'posts_per_page' => -1,
    'meta_query' => array(
      array(
        'key' => 'email',
        'value' => $current_user_email,
        'compare' => 'LIKE'
      )
    )
  );
  $the_query = new WP_Query($args);
  console_log('the_query');
  console_log($the_query, true);
  $user_profile = $the_query->posts[0];
  console_log($user_profile, true);
  endif;
  ?>
  <body>
    <header class="header" id="header">
      <nav class="header-nav">
        <?php
          wp_nav_menu(array('theme_location' => 'header-menu'));
        ?>
      </nav>
    </header>
    <nav class="header-nav-secondary">
      <a href="<?php echo is_user_logged_in() ? get_permalink($user_profile->ID) : '#'?>">
        <img src="<?php echo get_template_directory_uri();?>/assets/icons/icon_person.svg" alt="Icone">
      </a>
      <a href="<?php echo esc_url(home_url());?>">
        <img src="<?php echo get_template_directory_uri();?>/assets/icons/icon_logo.svg" alt="Icone">
      </a>
      <div class="header-burger" id="burger">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </nav>
