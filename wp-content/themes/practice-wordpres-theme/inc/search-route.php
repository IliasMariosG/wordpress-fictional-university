<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch() {
  register_rest_route('university/v1', 'search', array(
    'methods' => WP_REST_Server::READABLE,
    'callback' => 'universitySearchResults'
  ));
}

function universitySearchResults($data) {
  $mainQuery = new WP_Query(array(
    'post_type' => array('post', 'page', 'professor', 'program', 'campus', 'event'),
    's' => sanitize_text_field($data['term'])
  ));
  $mainResults = array(
    'blogsPages' => array(),
    'professors'=> array(),
    'programs' => array(),
    'events' => array(),
    'campuses' => array()
  );
  while($mainQuery->have_posts()) {
    $mainQuery->the_post();
    if (get_post_type() == 'post' OR get_post_type() == 'page') { 
      array_push($mainResults['blogsPages'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'postType' => get_post_type(),
        'authorName' => get_the_author()
      ));
    }
    if (get_post_type() == 'professor') { 
      array_push($mainResults['professors'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        // first argument value (0): current post
        'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
      ));
    }
    if (get_post_type() == 'program') { 
      array_push($mainResults['programs'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'id' => get_the_ID()
      ));
    }
    if (get_post_type() == 'event') {
      $eventDate = new DateTime(get_field('event_date'));
      $description = null;
      if (has_excerpt()) {
        $description = get_the_excerpt();
      } else {
        $description = wp_trim_words(get_the_content(), 18);
      };
      array_push($mainResults['events'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'month' => $eventDate->format('M'),
        'day' => $eventDate->format('d'),
        'description' => $description
      ));
    }
    if (get_post_type() == 'campus') { 
      array_push($mainResults['campuses'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink()
      ));
    }
  }
  $programRelationshipsQuery = new WP_Query(array(
    'post_type' => 'professor',
    'meta_query' => array(
      array(
        // name of the advanced custom field we want to look within
        'key' => 'related_programs',
        'compare' => 'LIKE',
        'value' => '"' . $mainResults['programs'][0]['id'] . '"'
      )
    )
  ));
  while($programRelationshipsQuery->have_posts()) {
    $programRelationshipsQuery->the_post();
    if (get_post_type() == 'professor') { 
      array_push($mainResults['professors'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        // first argument value (0): current post
        'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
      ));
    };
  }
  // remove duplicates
  $mainResults['professors'] = array_unique($mainResults['professors'], SORT_REGULAR);
  return $mainResults;
}
