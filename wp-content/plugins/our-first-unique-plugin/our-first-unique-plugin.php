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

    // the name of the option or setting that we want to tie this to, HTML label text, function that's responsible for actually outputting the HTML
    // slug of this page, section you want to add this field to
    add_settings_field('wcp_location', 'Display Location', array($this, 'locationHTML'), 'word-count-settings-page', 'wcp_first_section');
    // group, actual name of setting, array(sanitize text field, default value)
    // sanitize_text_field: sanitize a user's input value
    register_setting('wordcountplugin', 'wcp_location', array('sanitize_callback' => 'sanitize_text_field', 'default' => '0'));

    add_settings_field('wcp_headline', 'Headline Text', array($this, 'headlineHTML'), 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_headline', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Post Statistics'));

    // Word Count
    add_settings_field('wcp_wordcount', 'Word Count', array($this, 'wordcountHTML'), 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_wordcount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));

    // Character Count
    add_settings_field('wcp_charactercount', 'Character Count', array($this, 'charactercountHTML'), 'word-count-settings-page', 'wcp_first_section');
    register_setting('wordcountplugin', 'wcp_wordcount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));
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
}

$wordCountAndTimePlugin = new WordCountAndTimePlugin();

?>