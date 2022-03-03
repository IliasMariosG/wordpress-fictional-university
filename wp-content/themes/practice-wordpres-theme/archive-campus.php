<?php
  get_header();
  pageBanner(
    array(
      'title' => 'Our Campuses',
      'subtitle' => 'We have several conveniently located campuses.'
    )
  )
?>

<article class="container container--narrow page-section">
  <!-- <h2>All posts</h2> -->
  
  <!-- google maps feature -->
  <div class="acf-map">
  <?php
    while (have_posts()) {
      the_post();
      $mapLocation = get_field('map_location');
    ?>
      <div class=marker" data-lat="<?php echo $mapLocation['lat']; ?>" data-lng="<?php echo $mapLocation['lng']; ?>">
        <h3><a href="<?php the_permalink(); ?>"></a><?php the_title(); ?></h3>
        <?php echo $mapLocation['address']; ?>
      </div>
    <?php }
      echo paginate_links();
    ?>
  </div>
  <!-- end of google maps feature -->
  
  <!-- keep the text-based link because maps is not working -->
  <ul>
  <?php
    while (have_posts()) {    
      the_post();
      $mapLocation = get_field('map_location');
    ?>
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
