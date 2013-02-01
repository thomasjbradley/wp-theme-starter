<?php
/**
 *	Fixes Theme My Login's clobbering of page titles
 */
function tml_remove_title_filter ($title) {
	global $theme_my_login;

	remove_filter('the_title', array(&$theme_my_login, 'the_title'), 10, 2);
	remove_filter('single_post_title', array(&$theme_my_login, 'single_post_title'));
	remove_filter('wp_setup_nav_menu_item', array(&$theme_my_login, 'wp_setup_nav_menu_item'));
	remove_action('wp_print_footer_scripts', array(&$theme_my_login, 'print_footer_scripts'));
	remove_action('login_head', 'noindex');
}

add_action('tml_modules_loaded', 'tml_remove_title_filter');
