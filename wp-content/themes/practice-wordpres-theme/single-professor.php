<?php
  get_header();

  while(have_posts()) {
    the_post();
    pageBanner();
  ?>
    
    

    <div class="container container--narrow page-section">

      <section class="generic-content">
        <section class="row group">
          <aside class="one-third">
              <?php the_post_thumbnail('professorPortrait'); ?>
          </aside>

          <aside class="two-thirds">
          <?php $likeCount = new WP_Query(array(
            'post_type' => 'like',
            'meta_query' => array(
              array(
                'key' => 'liked_professor_id',
                'compare' => '=',
                'value' => get_the_ID()
              )
            )
          ));

          $existStatus = 'no';
          $existQuery = new WP_Query(array(
            'author' => get_current_user_id(),
            'post_type' => 'like',
            'meta_query' => array(
              array(
                'key' => 'liked_professor_id',
                'compare' => '=',
                'value' => get_the_ID()
              )
            )
          ));
          
          if ($existQuery->found_posts) {
            $existStatus = 'yes';
          }

        ?>

            <span class="like-box" data-exists="<?php echo $existStatus; ?>">
              <i class="fa fa-heart-o" aria-hidden="true"></i>
              <i class="fa fa-heart" aria-hidden="true"></i>
              <span class="like-count"><?php echo $likeCount->found_posts; ?></span>
            </span>
            <?php the_content(); ?>
          </aside>
        </section>
      </section>
      <section>
        <?php
          $relatedPrograms = get_field('related_programs');
          
          if ($relatedPrograms) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Subject(s) taught</h2>';
            echo '<ul class="link-list min-list">';
            foreach ($relatedPrograms as $program) { ?>
              <!-- print_r($value->post_title); -->
              <li>
                <a href="<?php echo get_the_permalink($program); ?>">
                  <?php echo get_the_title($program); ?>
                </a>
              </li>
            <?php
            }
            echo '</ul>';
          }
          // print_r($relatedPrograms[0]->post_title);
        ?>
      </section>
    </div>
    <?php }

  get_footer();
?>
