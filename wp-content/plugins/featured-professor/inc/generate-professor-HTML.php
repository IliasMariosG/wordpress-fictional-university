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
        <div class="professor-callout__photo">
        <div class="professor-callout__text">
          <h5><?php the_title()?></h5>
        </div>
        </div>
      </div>
      <?php
      wp_reset_postdata();
      return ob_get_clean();
    }

  }

?>