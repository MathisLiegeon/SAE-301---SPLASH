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

// Show current template if needed
function show_template() {
    if (is_user_logged_in()) {
        global $template;
        echo '<div style="background: #f1f1f1; padding: 10px; margin-top: 20px;">';
        echo 'Template utilisé : ' . $template;
        echo '</div>';
    }
}
add_action('wp_footer', 'show_template');

// Add thumbnail support for some custom post types
add_theme_support('post-thumbnails');

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

// Modify the menus
function modify_menu($items, $args) {
    if ($args->theme_location == 'header-menu'  || $args->theme_location == 'footer-menu') {
      if (is_user_logged_in()) {
        foreach ($items as $key => $item) {
          if ($item->title == 'Connexion') {
            $items[$key]->title = 'Deconnexion';
            $items[$key]->url = wp_logout_url(home_url());
          }
          if ($item->title == 'Inscription') {
            unset($items[$key]);
          }
        }
      }
    }
    return $items;
}
add_filter('wp_nav_menu_objects', 'modify_menu', 10, 2);

// --------------------- UTILITY FUNCTIONS ---------------------
function get_team_upcoming_matches($team_id) {
  $args = array(
      'post_type' => 'match',
      'posts_per_page' => -1,
      'meta_query' => array(
          'relation' => 'AND',
          array(
              'key' => 'status',
              'value' => array(-1, 0),
              'compare' => 'IN'
          ),
          array(
              'relation' => 'OR',
              array(
                  'key' => 'team-1',
                  'value' => $team_id,
                  'compare' => 'LIKE'
              ),
              array(
                  'key' => 'team-2',
                  'value' => $team_id,
                  'compare' => 'LIKE'
              ),
          )
      )
  );
  $query = new WP_Query($args);
  return $query->posts;
}

function get_team_finished_matches($team_id) {
    $args = array(
        'post_type' => 'match',
        'posts_per_page' => -1,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'status',
                'value' => 1,
                'compare' => '='
            ),
            array(
                'relation' => 'OR',
                array(
                    'key' => 'team-1',
                    'value' => $team_id,
                    'compare' => 'LIKE'
                ),
                array(
                    'key' => 'team-2',
                    'value' => $team_id,
                    'compare' => 'LIKE'
                ),
            )
        )
    );

    $query = new WP_Query($args);
    return $query->posts;
}

function get_user_team($user_id) {
    $args = array(
        'post_type' => 'team',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => 'members',
                'value' => '"' . $user_id . '"',
                'compare' => 'LIKE'
            ),
        )
    );

    $query = new WP_Query($args);
    return $query->posts[0];
}

function get_user_post($id) {
    $args = array(
        'post_type' => 'user',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => 'user',
                'value' => $id,
                'compare' => 'LIKE'
            )
        )
    );

    $the_query = new WP_Query($args);
    console_log('the_query');
    console_log($the_query->posts);
    $user_id = $the_query->posts[0]->ID;
    console_log('user_id');
    console_log($user_id);
    return $user_id;
}