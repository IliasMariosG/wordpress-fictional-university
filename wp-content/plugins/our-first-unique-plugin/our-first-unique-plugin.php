<?php

/*
  Plugin Name: Test Plugin
  Description: A plugin to exercise
  Version: 1.0
  Author: Perforation
*/

class WordCountAndTimePlugin {
  function __construct()
  {
    add_action('admin_menu', array($this, 'pluginSettingsLink'));
    add_action('admin_init', array($this, 'settings'));
    add_filter('the_content', array($this, 'ifWrap'));
  }

  function pluginSettingsLink() {
    add_options_page('Word Count Settings', 'Word Count', 'manage_options', 'word-count-settings-page', array($this, 'settingsPageHTML'));
  }
  
  function settingsPageHTML() { ?>
    <article class="wrap">
      <h1>Word Count Settings</h1>
      <form action="options.php" method="POST">
        <?php
          settings_fields('wordcountplugin');
          do_settings_sections('word-count-settings-page');
          submit_button();
        ?>
      </form>
    </article>
  <?php }

  function settings() {
    // name of the section, title of the section, content, page slug we want to add this section to
    add_settings_section('wcp_first_section', null, null, 'word-count-settings-page');

    /*
      Parameters: 
      The name of the option or setting that we want to tie this to, HTML label text, function that's responsible for actually outputting the HTML
      slug of this page, section you want to add this field to
    */
    add_settings_field('wcp_location', 'Display Location', array($this, 'locationHTML'), 'word-count-settings-page', 'wcp_first_section');
    /*
      Parameters:
      Group, actual name of setting, array(sanitize text field, default value)
    */
    /* 
      Note:
      sanitize_text_field: sanitize a user's input value */
    register_setting('wordcountplugin', 'wcp_location', array('sanitize_callback' => 'sanitize_text_field', 'default' => '0'));

    add_settings_field('wcp_headline', 'Headline Text', array($this, 'headlineHTML'), 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_headline', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Post Statistics'));

    // Word Count
    add_settings_field('wcp_wordcount', 'Word Count', array($this, 'wordcountHTML'), 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_wordcount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));

    // Character Count
    add_settings_field('wcp_charactercount', 'Character Count', array($this, 'charactercountHTML'), 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_charactercount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));

    // Read Time
    add_settings_field('wcp_readtime', 'Read Time', array($this, 'readtimeHTML'), 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_readtime', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));
  }

  function locationHTML() { ?>
  <!--  we do want the `select` element to have a name that matches the setting that we've registered. -->
    <select name="wcp_location">
      <option value="0" <?php selected(get_option('wcp_location'), '0'); ?>>Beginning of Post</option>
      <option value="1" <?php selected(get_option('wcp_location'), '1'); ?>>End of Post</option>
    </select>
  <?php
  }

  function headlineHTML() { ?>
    <input type="text" name="wcp_headline" value="<?php echo esc_attr(get_option('wcp_headline')); ?>">
  <?php
  }

  function wordcountHTML() { ?>
    <input type="checkbox" name="wcp_wordcount" value="1" <?php checked(get_option('wcp_wordcount'), '1'); ?>>
  <?php
  }

  function charactercountHTML() { ?>
    <input type="checkbox" name="wcp_charactercount" value="1" <?php checked(get_option('wcp_charactercount'), '1'); ?>>
  <?php
  }

  function readtimeHTML() { ?>
    <input type="checkbox" name="wcp_readtime" value="1" <?php checked(get_option('wcp_readtime', '1')); ?>>
  <?php
  }

  function ifWrap($content) {
    if (is_main_query() AND is_single() AND 
    (get_option('wcp_wordcount', '1') OR 
    get_option('wcp_charactercount', '1') OR 
    get_option('wcp_readtime', '1')
    )) {
      return $this->createHTML($content);
    }
    return $content;
  }

  function createHTML($content) {
    $html = '<h3>' .  esc_html(get_option('wcp_headline', 'Post Statistics')) . '</h3><p>';
    // get word count once because both wordcount and readtime will need it
    $wordCount = str_word_count(strip_tags($content));

    if (get_option('wcp_wordcount', '1')) {
      $html .= 'This post has ' . $wordCount . ' words.<br>';
    }

    if (get_option('wcp_charactercount', '1')) {
      $html .= 'This post has ' . strlen(strip_tags($content)) . ' characters.<br>';
    }

    if (get_option('wcp_readtime', '1')) {
      $html .= 'THis post will take about ' . round($wordCount/225) . ' minute(s) to read.<br>';
    }

    $html .= '</p>';

    if (get_option('wcp_location', '0') == '0') {
      return $html . $content;
    }
    return $content . $html;
  }
}

$wordCountAndTimePlugin = new WordCountAndTimePlugin();

?>