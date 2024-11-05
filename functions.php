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

