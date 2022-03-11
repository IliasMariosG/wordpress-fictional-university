<?php

/*
  Plugin Name: Our Word Filter Plugin
  Description: A plugin to exercise
  Version: 1.0
  Author: Perforation
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class OurWordFilterPlugin {
  function __construct()
  {
    add_action('admin_menu', array($this, 'ourMenu'));
  }

  function ourMenu() {
    /* 
      add_menu_page params
      1. document title, 2. text showing up in the admin sidebar, 
      3. the permission or capability a user needs to have in order to see the page,
      4. short name or slug variable name foe the new menu we're creating,
      5. a function that outputs the HTML for the actual page itself,
      6. icon that will appear in the admin menu,
      7. a number that we give it, that will control where our menu appears vertically
      7. 100 -> appears down at the bottom
    */
    // add_menu_page('Words to Filter', 'Word Filter', 'manage_options', 'ourwordfilter', array($this, 'wordFilterPageHTML'), plugin_dir_url(__FILE__) . 'custom.svg', 100);
    add_menu_page('Words to Filter', 'Word Filter', 'manage_options', 'ourwordfilter', array($this, 'wordFilterPageHTML'), 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0xMCAyMEMxNS41MjI5IDIwIDIwIDE1LjUyMjkgMjAgMTBDMjAgNC40NzcxNCAxNS41MjI5IDAgMTAgMEM0LjQ3NzE0IDAgMCA0LjQ3NzE0IDAgMTBDMCAxNS41MjI5IDQuNDc3MTQgMjAgMTAgMjBaTTExLjk5IDcuNDQ2NjZMMTAuMDc4MSAxLjU2MjVMOC4xNjYyNiA3LjQ0NjY2SDEuOTc5MjhMNi45ODQ2NSAxMS4wODMzTDUuMDcyNzUgMTYuOTY3NEwxMC4wNzgxIDEzLjMzMDhMMTUuMDgzNSAxNi45Njc0TDEzLjE3MTYgMTEuMDgzM0wxOC4xNzcgNy40NDY2NkgxMS45OVoiIGZpbGw9IiNGRkRGOEQiLz4KPC9zdmc+Cg==', 100);
    add_submenu_page('ourwordfilter', 'Words to Filter', 'Words List', 'manage_options', 'ourwordfilter', array($this, 'wordFilterPageHTML'));
    add_submenu_page('ourwordfilter', 'Word Filter Options', 'Options', 'manage_options', 'word-filter-options', array($this, 'optionsSubMenuHTML'));
   
  }

    function wordFilterPageHTML() { ?>
      Hello World
    <?php
    }

    function optionsSubMenuHTML() { ?>
      Hello World from Options SubPage
    <?php
    }
}

$ourWordFilterPlugin = new OurWordFilterPlugin();