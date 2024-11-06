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
        if (get_current_user_published_team_id() ){
            foreach ($items as $key => $item) {
                if ($item->title == 'Créer une équipe') {
                    unset($items[$key]);
                  }
            }
        }
      } else {
        foreach ($items as $key => $item) {
            if ($item->title == 'Créer une équipe') {
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
    if ($the_query->posts) {
      $user_id = $the_query->posts[0]->ID;
      console_log('user_id');
      console_log($user_id);
      return $user_id;
    }
    return '';
}

function get_available_users($current_user_id) {
    $users_in_teams = array();
    $teams = get_posts(array('post_type' => 'team', 'numberposts' => -1, 'post_status' => array('publish', 'pending')));

    foreach ($teams as $team) {
        $team_members = get_field('members', $team->ID);
        if (is_array($team_members)) {
            $users_in_teams = array_merge($users_in_teams, array_map(function($member) {
                return is_array($member) ? $member['ID'] : $member;
            }, $team_members));
        }
    }

  $users_in_teams = array_unique($users_in_teams);
  $all_users = get_users();

  $available_users = [];
  foreach ($all_users as $user) {
      if (!in_array($user->data->ID, $users_in_teams) ) {
          if ($user->data->ID == $current_user_id) {
          } else {
              $available_users[] = $user;
          }
      }
  }
  return $available_users;
}

function get_current_user_published_team_id() {
  $current_user_id = get_current_user_id();

  $args = array(
    'post_type' => 'team',
    'posts_per_page' => -1,
    'post_status' => array('publish'),
    'meta_query' => array(
      array(
        'key' => 'members',
        'value' => '"' . $current_user_id . '"',
        'compare' => 'LIKE'
      )
    )
  );

  $user_team = new WP_Query($args);
  $user_team_id = $user_team->posts ? $user_team->posts[0]->ID : null;

  return $user_team_id;
}

function delete_team() {
  if (isset($_POST['delete_team']) && $_POST['delete_team'] == '1') {

    if (!isset($_POST['delete_team_nonce']) || !wp_verify_nonce($_POST['delete_team_nonce'], 'delete_team_action')) {
      wp_die('Nonce verification failed');
    }

    $team_id = intval($_POST['team_id']);

    $deleted = wp_delete_post($team_id, true);
    if ($deleted) {
        wp_redirect(add_query_arg('message', 'team_deleted', home_url()));
        exit;
    } else {
        wp_redirect(add_query_arg('message', 'delete_failed', home_url()));
        exit;
    }
  }
}
add_action('init', 'delete_team');
