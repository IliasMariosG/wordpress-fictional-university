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
          <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>">
            <i class="fa fa-home" aria-hidden="true"></i> All Programs
          </a>
            <span class="metabox__main">
              <?php  the_title(); ?>
            </span>
        </p>
      </div>

      <div class="generic-content">
        <?php the_field('main_body_content'); ?>
      </div>
      
      <section>
        <?php
          // Displays professors
          $relatedProfessorsQuery = new WP_Query(array(
            'show_in_rest' => true,
            // retrieve all posts
            'posts_per_page' => -1,
            'post_type' => 'professor',
            // order by a custom field
            
            'orderby' => 'title',
            // end of order by a custom field
            'order' => 'ASC',
            'meta_query' => array(
              
              array(
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID() . '"'
              )
            )
          ));

          if ($relatedProfessorsQuery->have_posts()) {
            // {Subject name} Professors
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>';
            
            echo '<ul class="professor-cards">';
            while($relatedProfessorsQuery->have_posts()) {
              $relatedProfessorsQuery->the_post(); ?>
              <li class="professor-card__list-item">
                <a class="professor-card" href="<?php the_permalink() ?>">
                  <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>">
                  <span class="professor-card__name"><?php the_title(); ?></span>
                </a>
              </li>
            <?php }
            echo '</ul>';
          }
          wp_reset_postdata();

          $today = date('Ymd');
          $homepageEventsQuery = new WP_Query(array(
            // retrieve all posts
            'posts_per_page' => 2,
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
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
              ),
              array(
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID() . '"'
              )
            )
          ));

          if ($homepageEventsQuery->have_posts()) {
            // Upcoming {Subject Name} Events
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';
            
            while($homepageEventsQuery->have_posts()) {
              $homepageEventsQuery->the_post();
              get_template_part('template-parts/content-event');
            }
          }

          // Campus related to the subject/program
          wp_reset_postdata();
          $relatedCampuses = get_field('related_campus');
          if ($relatedCampuses) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">'.  get_the_title() . ' is Available at These Campuses:<h2>';
            echo '<ul class="min-list link-list">';
              foreach ($relatedCampuses as $campus) { ?>
                <li>
                  <a href="<?php
                    echo get_the_permalink($campus); ?>">
                    <?php echo get_the_title($campus); ?>
                  </a>
                </li>
              <?php }
              echo '</ul>';
          }
        ?>
      </section>
    </div>
    <?php }

  get_footer();
?>
