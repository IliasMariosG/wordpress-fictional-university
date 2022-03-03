<!-- utilise single-program.php -->
<?php
  get_header();

  while(have_posts()) {
    the_post();
    pageBanner(
      array(
        'title' => get_the_title()
      )
    );
?>

    <div class="container container--narrow page-section">
      <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>">
            <i class="fa fa-home" aria-hidden="true"></i> All Campuses
          </a>
            <span class="metabox__main">
              <?php  the_title(); ?>
            </span>
        </p>
      </div>

      <section class="generic-content">
        <?php the_content();
         $mapLocation = get_field('map_location');
        ?>
        <div class="acf-map">
        <!-- no need for the while loop because we are already on the isngle permalink for this campus-->
            <div class=marker" data-lat="<?php echo $mapLocation['lat']; ?>" data-lng="<?php echo $mapLocation['lng']; ?>">
              <h3><?php the_title(); ?></h3>
              <?php echo $mapLocation['address']; ?>
            </div>
          <!-- no need for pagination links here -->  
        </div>
      </section>
      
      <section>
        <?php
          // Displays programs available
          $relatedProgramsQuery = new WP_Query(array(
            'show_in_rest' => true,
            // retrieve all posts
            'posts_per_page' => -1,
            'post_type' => 'program',
            // order by a custom field
            
            'orderby' => 'title',
            // end of order by a custom field
            'order' => 'ASC',
            'meta_query' => array(
              array(
                'key' => 'related_campus',
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID() . '"'
              )
            )
          ));

          if ($relatedProgramsQuery->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Programs available at this campus</h2>';
            
            echo '<ul class="min-list link-list">';
            while($relatedProgramsQuery->have_posts()) {
              $relatedProgramsQuery->the_post(); ?>
              <li>
                <a href="<?php the_permalink() ?>">
                  <?php the_title(); ?> 
                </a>
              </li>
            <?php }
            echo '</ul>';
          }
          wp_reset_postdata();

          
          ?>
      </section>
    </div>
    <?php }

  get_footer();
?>
