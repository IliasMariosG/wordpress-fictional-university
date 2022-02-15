<?php
  if (!is_user_logged_in()) {
    wp_redirect(esc_url(site_url('/')));
    exit;
  }
  get_header();

  while(have_posts()) {
    the_post();
    pageBanner(array(
      'photo' => 'https://images.unsplash.com/photo-1497200977899-ea39ad7677a1?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&dl=andreas-gucklhorn-VA9lnem0FEc-unsplash.jpg&w=1920'
    ));
    ?>

    <div class="container container--narrow page-section">
      Custom code will go here.
    </div>
    
    <?php }
    get_footer();
?>