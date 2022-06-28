<div class="full-width-split group">
      <div class="full-width-split__one">
        <div class="full-width-split__inner">
          <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>

          <?php $today = date('Ymd'); $homepageEventsQuery = new WP_Query(array(
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
              )
            )
          ));

          while($homepageEventsQuery->have_posts()) {
            $homepageEventsQuery->the_post();
            get_template_part('./template-parts/content', 'event');
          }
          ?>

          <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link('event'); ?>" class="btn btn--blue">View All Events</a></p>
        </div>
      </div>
      <div class="full-width-split__two">
        <div class="full-width-split__inner">
          <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>
          <?php
            $homepagePostsQuery = new WP_Query(array(
              'posts_per_page' => 2
            ));
            
            while ($homepagePostsQuery->have_posts()) {
              
              $homepagePostsQuery->the_post(); ?>
              <div class="event-summary">
                <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>">
                  <span class="event-summary__month"><?php the_time('M');?></span>
                  <span class="event-summary__day"><?php the_time('d') ?></span>
                </a>
                <div class="event-summary__content">
                
                  <h5 class="event-summary__title headline headline--tiny"><a href="<?php  the_permalink(); ?>"><?php echo get_the_title(); ?></a></h5>
                  <p><?php
                    if (has_excerpt()) {
                      echo get_the_excerpt();
                    } else {
                      echo wp_trim_words(get_the_content(), 18);
                    }; ?> <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a></p>
                </div>
              </div>
              
          <?php } wp_reset_postdata();
          ?>

          <p class="t-center no-margin"><a href="<?php echo site_url('/blog') ?>" class="btn btn--yellow">View All Blog Posts</a></p>
        </div>
      </div>
    </div>