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
  <body>
    <header class="header" id="header">
      <nav class="header-nav">
        <?php
          wp_nav_menu(array('theme_location' => 'header-menu'));
        ?>
      </nav>
    </header>
    <nav class="header-nav-secondary">
      <span>
        <img src="<?php echo get_template_directory_uri();?>/assets/icons/icon_person.svg" alt="Icone">
      </span>
      <span>
        <img src="<?php echo get_template_directory_uri();?>/assets/icons/icon_logo.svg" alt="Icone">
      </span>
      <div class="header-burger" id="burger">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </nav>
