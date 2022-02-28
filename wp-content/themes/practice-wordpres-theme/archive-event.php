<?php
  get_header();
  pageBanner(array(
    'title' => 'All Events',
    'subtitle' => 'See what is going on in our world.'
  ));
?>

<article class="container container--narrow page-section">
  <!-- <h2>All posts</h2> -->
<?php
  while (have_posts()) {    
    the_post();
    get_template_part('./template-parts/content-event');
  }
    echo paginate_links();
?>
  <hr class="section-break">
  <p>Looking for a recap of past events? <a href="/past-events">Check out our past events archive</a>.</p>
</article>

<?php
  get_footer();
?>
