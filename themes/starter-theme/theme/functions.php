<?php

/**
 * Sets up the theme's localisation
 */
load_theme_textdomain('tjbdev', TEMPLATEPATH . '/locale');

include 'menus.php';
include 'sidebars.php';

/**
 * Deal with some stuff generated with wp_head();
 */
// Automatically adds feed links to wp_head()
add_theme_support('automatic-feed-links');
// Remove extra feed links for categories
remove_action('wp_head', 'feed_links_extra', 3);
// Remove general feeds for posts and comments
remove_action('wp_head', 'feed_links', 2);
// Remove stupid cforms crap
remove_action('wp_head', 'cforms_style');
remove_action('init', 'cforms_runtime_scripts');

/**
 * Allows hiding of specific widgets from the admin interface
 */
add_action('widgets_init', 'theme_unregister_widgets');

function theme_unregister_widgets () {
  unregister_widget('WP_Widget_Archives');
  unregister_widget('WP_Widget_Calendar');
  unregister_widget('WP_Widget_Categories');
  unregister_widget('WP_Widget_Links');
  unregister_widget('WP_Widget_Meta');
  unregister_widget('WP_Nav_Menu_Widget');
  unregister_widget('WP_Widget_Pages');
  unregister_widget('WP_Widget_Recent_Comments');
  unregister_widget('WP_Widget_Recent_Posts');
  unregister_widget('WP_Widget_RSS');
  unregister_widget('WP_Widget_Search');
  unregister_widget('WP_Widget_Tag_Cloud');
  unregister_widget('WP_Widget_Text');
}

/**
 * Creates CSS to hide specific items from the admin screens
 * http://www.strangework.com/2010/03/24/how-to-hide-an-admin-menu-in-wordpress/
 */
add_action('admin_head', 'theme_hide_admin_stuff');

function theme_hide_admin_stuff () {
  global $current_user;
  get_currentuserinfo();

  if($current_user->user_login != 'admin') {
    ?>
    <style>
      #menu-comments,
      #authordiv,
      #commentstatusdiv,
      #commentsdiv,
      #trackbacksdiv,
      #postcustom,
      /*#categorydiv,*/
      #tagsdiv-post_tag,
      /* Shiba Media Library */
      #menu-posts-gallery,
      #find-posts-gallery,
      label[for="find-posts-gallery"] {
        display:none;
      }
    </style>
    <?php
  }
}

include 'admin-fields.php';
