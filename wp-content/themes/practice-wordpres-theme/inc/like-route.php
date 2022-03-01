<?php

  add_action('rest_api_init', 'universityLikeRoutes');

  function universityLikeRoutes() {
    // We're going to register two new routes
    register_rest_route('university/v1', 'manageLike', array(
      'methods' => 'POST',
      'callback' => 'createLike'
    ));

    register_rest_route('university/v1', 'manageLike', array(
      'methods' => 'DELETE',
      'callback' => 'deleteLike'
    ));
  }

  function createLike($data) {
    if (is_user_logged_in()) {
      $professorID = sanitize_text_field($data['professorId']);

      $existQuery = new WP_Query(array(
        'author' => get_current_user_id(),
        'post_type' => 'like',
        'meta_query' => array(
          array(
            'key' => 'liked_professor_id',
            'compare' => '=',
            'value' => $professorID
          )
        )
      ));

      if ($existQuery->found_posts == 0) {
        return wp_insert_post(array(
          'post_type' => 'like',
          'post_status' => 'publish',
          'post_title' => '2nd PHP Test',
          'meta_input' => array(
            'liked_professor_id' => $professorID
          )
        )); 
      } else {
        die('Invalid professor id.');
      }
      
    } else {
      die('Only logeed in users can create a like.');
    }
  }

  function deleteLike() {
    return 'Thanks for trying to delete a like.';
  }