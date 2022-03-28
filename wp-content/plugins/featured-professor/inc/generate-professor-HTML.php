<?php
  function generateProfessorHTML($professorID) {
    $professorPostQuery = new WP_Query(array(
      'post_type' => 'professor',
      'p' => $professorID
    ));

    while ($professorPostQuery->have_posts()) {
      $professorPostQuery->the_post();

      ob_start(); ?>
      <!-- HTML here -->
      <div class="professor-callout">
        <div class="professor-callout__photo" style="background-image: url(<?php the_post_thumbnail_url('professorPortrait') ?>)">
        <div class="professor-callout__text">
          <h5><?php the_title()?></h5>
          <p><?php echo wp_trim_words(get_the_content(), 30); ?></p>

          <?php
          $relatedPrograms = get_field('related_programs');
          if ($relatedPrograms) { ?>
            <p>(Professor name) teaches:
              <?php
              foreach ($relatedPrograms as $key => $program) {
                echo get_the_title($program);
              }
              // php is aware of the whitespace, that is why we don't put the full-stop just before the closing `p` tag
              ?>.
            </p>
          <?php
          }
          ?>
        </div>
        </div>
      </div>
      <?php
      wp_reset_postdata();
      return ob_get_clean();
    }

  }

?>