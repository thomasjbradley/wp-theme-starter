<?php

/**
 *	Helper functions to reduce typing
 */
function sd(){ echo rootRelative(get_bloginfo('stylesheet_directory')); }
function ln($id){ echo rootRelative(get_permalink($id)); }

/**
 *	Normalises the bloginfo Url with or without WPML and removes the trailing slash
 */
function url(){ echo rootRelative(preg_replace('@/$@', '', get_bloginfo('url'))); }

/**
 *	Removes server and hostname from the Url and permalinks
 */
function rootRelative($input)
{
	return preg_replace('!http(s)?://' . $_SERVER['SERVER_NAME'] . '/!', '/', $input);
}

add_filter('the_permalink', 'root_relative_permalinks');
function root_relative_permalinks($input)
{
	rootRelative($input);
}

/**
 *	Encoding mime types from attachments into classes
 */
function escape_mime($mime)
{
	$bits = explode('/', $mime);
	return preg_replace('/[^a-z\-1-9_]/', '', $bits[1]);
}

function e_mime($mime){ echo escape_mime($mime); }

/**
 *	Gets file size, converts to KB and echoes it
 */
function e_filesize($id)
{
	$path = explode('wp-content', wp_get_attachment_url($id));
	$path = realpath(dirname(__FILE__) . '/../../' . $path[1]);
	echo round(filesize($path) / 1000);
}

/**
 *	Formats a tel number for links tel: scheme
 */
function format_tel($tel)
{
	return preg_replace('@[^\d]@', '', $tel);
}

/**
 *	Fixes names that are reversed with a comma, e.g.
 *	Bradley, Thomas -> Thomas Bradley
 */
function fix_name($name)
{
	$bits = explode(',', $name);
	return trim($bits[1]) . ' ' . trim($bits[0]);
}

/**
 *	Use to properly sort custom posts by title
 */
function sort_post_title($a, $b)
{
	if($a->post_title == $b->post_title) return 0;
	return ($a->post_title < $b->post_title) ? -1 : 1;
}

/**
 *	Some actions added to wp_head cannot be found
 *	Brute force clearing of stuff put into the head by plugins
 */
function clean_wp_head($head)
{
	$search = array(
		'@\s*<meta\s+name\s*\=\s*["\'][^\'"]*["\']\s+content\s*\=\s*["\'][^\'"]*["\']\s*/?>\s*@i' // meta robots
		,'@\s*<style.*>.*</style>\s*@i' // extraneous styles
		,'@\s*<!--.+-->\s*@i' // stupid comments
		,'@\s*/>@' // extra XML self-closing slashes
		);
		
	$replace = array(
		''
		,''
		,''
		,'>'
		);
		
	$head = preg_replace($search, $replace, $head);
	
	return $head;
}

/**
 *	Remove some stuff that is generated in the wp_head()
 */
// Remove the RSD link
remove_action('wp_head', 'rsd_link');
// Remove the Windows Live Writer manifest file
remove_action('wp_head', 'wlwmanifest_link');
// Remove generator tag
remove_action('wp_head', 'wp_generator');
// Cimy Extra Fields styles
wp_deregister_style('cimy_uef_register');

/**
 *	WPML Theme Integration
 *	http://wpml.org/documentation/support/creating-multilingual-wordpress-themes/
 *	http://wpml.org/2009/05/wordpress-theme-localization/
 *
 *	PO File Generator:
 *	http://www.icanlocalize.com/tools/php_scanner
 *
 *	WPML Coding API:
 *	http://wpml.org/documentation/support/wpml-coding-api/
 */
require_once 'boot/wpml-integration.php';

/**
 *	Disable WPML CSS and JS
 */
define('ICL_DONT_LOAD_NAVIGATION_CSS', true);
define('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true);
define('ICL_DONT_LOAD_LANGUAGES_JS', true);

/**
 *	Remove the WPML generator tag
 */
if(isset($sitepress))
	remove_action('wp_head', array($sitepress, 'meta_generator_tag'));

/**
 *	Clean up usesless stuff from WPML in admin interface
 */
add_action('admin_head', 'hide_wpml_admin_stuff');

function hide_wpml_admin_stuff()
{
	global $current_user;
	get_currentuserinfo();
	
	if($current_user->user_login != 'admin')
	{
		?>
		<style>
			.icl_cyan_box {
				display:none;
			}
		</style>
		<?php
	}
}

/**
 *	Language specific variables
 */
$EN = array('en', 'English');
$FR = array('fr', 'Français');
$DEFAULT_LANG = $EN[0];

/**
 *	Returns WPML language or default
 *
 *	@return	string
 */
function l()
{
	global $DEFAULT_LANG;
	
	if(defined('ICL_LANGUAGE_CODE'))
		return ICL_LANGUAGE_CODE;
	
	return $DEFAULT_LANG;
}

/**
 *	Shortcut for language_attributes function
 */
function la()
{
	language_attributes();
}

/**
 *	For working with basic Canadian English/French web sites
 *	Returns an array with the name of the other language and the url
 *
 *	@return	array
 */
function getOtherLang()
{
	global $DEFAULT_LANG, $EN, $FR;
	
	if(l() == $DEFAULT_LANG)
		return $FR;
	else
		return $EN;
}

/**
 *	Creates a language link to the current item in the other language
 *	Echos the link
 *
 *	@return	void
 */
function langLink()
{
	global $post;
	$otherLang = getOtherLang();
	$url = '';
	
	if($post->ID !== null)
	{
		$otherId = icl_object_id($post->ID, 'post', true, $otherLang[0]);
			
		if($otherId == $post->ID)
			$otherId = icl_object_id($post->ID, 'page', true, $otherLang[0]);
			
		$url = get_permalink($otherId);
	}
	else
	{
		$url = get_blogInfo('url') . '/' . $otherLang[0] . '/';
	}
	
	echo '<a href="' , $url , '">' , $otherLang[1] , '</a>';
}

/**
 *	Gets the permalink for an object, takes into account the languges
 *	Echos the permalink
 *
 *	@param	$id
 *
 *	@return	void
 */
function iln($id)
{
	if(function_exists('icl_object_id'))
	{
		$langId = icl_object_id($id, 'post');
		
		if($langId == null)
			$langId = icl_object_id($id, 'page');
		
		return rootRelative(get_permalink($langId));
	}
	else
	{
		return rootRelative(get_permalink($id));
	}
}

function e_iln($id)
{
	echo iln($id);
}



/**
 *	------------------------------------------------------
 *	Keep theme stuff separate from template functions file
 */
require_once 'theme/functions.php';

/**
 *	Load all the theme widgets
 */
if(is_dir(dirname(__FILE__) . '/theme/widgets'))
{
	$di = new DirectoryIterator(dirname(__FILE__) . '/theme/widgets');
	
	foreach($di as $file)
	{
		if(strpos($file->getFilename(), '.php') !== false)
			include $file->getRealPath();
	}
}
