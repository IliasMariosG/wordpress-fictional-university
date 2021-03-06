<?php

/*
  Plugin Name: Featured Professor Block Type
  Description: Create a drop-down menu with featured professors
  Version: 1.0
  Author: Perforation
  TextDomain: featured-professor
  Domain Path: /languages
*/  

if (!defined('ABSPATH')) exit; // Exit if accessed directly

require_once plugin_dir_path(__FILE__) . './inc/generate-professor-HTML.php';
require_once plugin_dir_path(__FILE__) . './inc/related-posts-HTML.php';

class FeaturedProfessor {
  function __construct()
  {
    add_action('init', array($this, 'onInit'));
    add_action('rest_api_init', [$this, 'professorHTML']);
    add_filter('the_content', [$this, 'addRelatedPosts']);
  }

  function addRelatedPosts($defaultContent) {
    if (is_singular('professor') && in_the_loop() && is_main_query()) {
      return $defaultContent . relatedPostsHTML(get_the_id());
    }
    return $defaultContent;
  }

  function professorHTML() {
    register_rest_route('/featuredProfessor/v1', 'getHTML', array(
      'methods' => WP_REST_Server::READABLE,
      'callback' => [$this, 'getProfessorHTML']
    ));
  }

  function getProfessorHTML($data) {
    // We look inside $data for any url variable (on the address bar)
    return generateProfessorHTML(($data['professorFeaturedID']));
  }

  function onInit() {
    load_plugin_textdomain('featured-professor', false, dirname(plugin_basename(__FILE__)) . '/languages');

    register_meta('post', 'featuredProfessor', array(
      'show_in_rest' => true,
      'type' => 'number',
      'single' => false
    ));
    wp_register_script('featuredProfessorScript', plugin_dir_url(__FILE__) . 'build/index.js' , array('wp-blocks', 'wp-i18n', 'wp-editor'));
    wp_register_style('featuredProfessorStyle', plugin_dir_url(__FILE__) . 'build/index.css');

    wp_set_script_translations('featuredProfessorScript', 'featured-professor', plugin_dir_path(__FILE__) . '/languages');
    register_block_type('ourplugin/featured-professor', array(
      'editor_script' => 'featuredProfessorScript',
      'editor_style' => 'featuredProfessorStyle',
      'render_callback' => array($this, 'renderCallback')
    ));
  }

  function renderCallback($attributes) {
    if ($attributes['professorFeaturedID']) {
      wp_enqueue_style('featuredProfessorStyle');
      return generateProfessorHTML($attributes['professorFeaturedID']);
    } else {
      NULL;
    }
  }
}

$featuredProfessor = new FeaturedProfessor();
