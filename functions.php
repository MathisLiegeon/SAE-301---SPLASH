<?php
// Implement a way to log things to the console in php
function console_log($data) {
  echo '<script>';
  echo 'console.log('. json_encode($data) .')';
  echo '</script>';
}

// Hide the admin bar
function hide_admin_bar() {
  return false;
}
add_filter('show_admin_bar', 'hide_admin_bar');

// Add thumbnail support for some custom post types
add_theme_support('post-thumbnails', array('project'));

// Register the menus
function register_my_menus() {
    register_nav_menus(
      array(
        'header-menu' => __('Header Menu'),
        'footer-menu' => __('Footer Menu')
      )
    );
  }
add_action('init', 'register_my_menus', 0);
