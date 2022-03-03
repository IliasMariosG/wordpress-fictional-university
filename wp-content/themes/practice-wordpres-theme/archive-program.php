<?php
  get_header();
  pageBanner(
    array(
      'title' => 'All Programs',
      'subtitle' => 'There is something for everyone. Have a look around.'
    )
  )
?>

<article class="container container--narrow page-section">
  <!-- <h2>All posts</h2> -->
<ul class="link-list min-list">
<?php
  while (have_posts()) {    
    the_post(); ?>
    <li>
      <a href="<?php the_permalink(); ?>">
      <?php echo get_the_title(); ?>
      </a>
    </li>
    

  <?php }
    echo paginate_links();
?>
</ul>

</article>

<?php
  get_footer();
?>
