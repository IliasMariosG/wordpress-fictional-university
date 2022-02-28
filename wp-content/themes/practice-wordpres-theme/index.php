<?php
  get_header();
  pageBanner(
    array(
      'title' => 'Welcome to our blog!',
      'subtitle' => 'Keep up with the latest news.'
    )
  );
?>

<article class="container container--narrow page-section">
  <!-- <h2>All posts</h2> -->
<?php
  while (have_posts()) {    
    the_post(); ?>

    <section class="post-item">  
      <h2 class="headline headline--medium headline--post-title">
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
      </h2>
    

      <section class="metabox">
        <p>Posted by <?php the_author_posts_link(); ?> 
        on <?php the_time('j F, Y'); ?> 
        in <?php echo get_the_category_list(', '); ?> category</p>
      </section>

      <section class="generic-content">
        <?php the_excerpt(); ?>
        <!-- <footer class="generic-content"> -->
          <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading &raquo;</a></p>
        <!-- </footer> -->
      </section>
    </section>
  <?php }
    echo paginate_links();
?>
</article>

<?php
  get_footer();
?>
