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
          <a class="metabox__blog-home-link" href="<?php echo site_url('/blog'); ?>">
            <i class="fa fa-home" aria-hidden="true"></i> Blog Home
          </a>
            <span class="metabox__main">
              Posted by <?php the_author_posts_link(); ?> 
              on <?php the_time('j F, Y'); ?> 
              in <?php echo get_the_category_list(', '); ?> category
            </span>
        </p>
      </div>

      <section class="generic-content">
        <?php the_content() ?>
      </section>
    </div>
    <?php }

  get_footer();
?>
