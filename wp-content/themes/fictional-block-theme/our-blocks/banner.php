<?php
if (!$attributes['imageURL']) {
  $attributes['imageURL'] = get_theme_file_uri(('/images/library-hero.jpg'));
}
?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="backgroundImage: url('<?php echo get_theme_file_uri('/images/library-hero.jpg') ?>')"></div>
  <div class="page-banner__content container t-center c-white">
    <?php echo $content; ?>
  </div>
</div>
