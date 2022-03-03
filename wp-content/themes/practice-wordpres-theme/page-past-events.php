<?php
  get_header();
  pageBanner(
    array(
      'title' => 'Past Events',
      'subtitle' => 'A recap of our past events.'
    )
  );
?>

<article class="container container--narrow page-section">
  <!-- <h2>All posts</h2> -->
<?php
   $today = date('Ymd');
   $pastEventsQuery = new WP_Query(array(
     'paged' => get_query_var('paged', 1),
    // retrieve all posts
    'post_type' => 'event',
    // order by a custom field
    'meta_key' => 'event_date',
    'orderby' => 'meta_value_num',
    // end of order by a custom field
    'order' => 'ASC',
    'meta_query' => array(
      // filter out events from the past
      array(
        'key' => 'event_date',
        'compare' => '<',
        'value' => $today,
        'type' => 'numeric'
      )
    )
  ));
  while ($pastEventsQuery->have_posts()) {    
    $pastEventsQuery->the_post();
    get_template_part('./template-parts/content-event');
  }
  echo paginate_links(array(
    'total' => $pastEventsQuery->max_num_pages
  ));
?>
</article>

<?php
  get_footer();
?>
