<?php

/*
  Plugin Name: Featured Professor Block Type
  Description: Create a drop-down menu with featured professors
  Version: 1.0
  Author: Perforation
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class FeaturedProfessor {
  function __construct()
  {
    add_action('init', array($this, 'onInit'));
  }

  function onInit() {
    wp_register_script('featuredProfessorScript', plugin_dir_url(__FILE__) . 'build/index.js' , array('wp-blocks', 'wp-i18n', 'wp-editor'));
    wp_register_style('featuredProfessorStyle', plugin_dir_url(__FILE__) . 'build/index.css');
    register_block_type('ourplugin/featured-professor', array(
      'editor_script' => 'featuredProfessorScript',
      'editor_style' => 'featuredProfessorStyle',
      'render_callback' => array($this, 'renderCallback')
    ));
  }

  function renderCallback($attributes) {
    if ($attributes['professorFeaturedID']) {
      wp_enqueue_style('featuredProfessorStyle');
      return '<div class="professor-callout">Hello</div>';
    } else {
      NULL;
    }
  }
}

$featuredProfessor = new FeaturedProfessor();
