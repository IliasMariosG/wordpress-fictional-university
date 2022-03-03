<?php

/*
  Plugin Name: Test Plugin
  Description: A plugin to exercise
  Version: 1.0
  Author: Perforation
*/

add_filter('the_content', 'addSentenceToEndOfPost');

function addSentenceToEndOfPost($content) {
  if (is_single() && is_main_query()) {
    return $content . '<p>My name is Love<p>';
  }
  return $content;
}
?>