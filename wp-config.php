<?php

/*
  Helps with absolute URL muckery that WordPress does to media and stuff in content

  - http://www.lukeschreur.com/posts/configure-wordpress-for-multiple-domains
  - http://roybarber.com/version-controlling-wordpress/
 */

$env_config = array(
  'wp.dev' => array(
    'url' => 'http://wp.dev'
  )
  , 'production.ca' => array(
    'url' => 'http://production.ca'
  )
);

$env = $env_config[$_SERVER['HTTP_HOST']];

define('WP_DEBUG', (bool)getenv('WP_DEBUG'));

define('WP_HOME', $env['url']);
define('WP_SITEURL', $env['url']);

define('DB_NAME', getenv('WP_DB_NAME'));
define('DB_USER', getenv('WP_DB_USER'));
define('DB_PASSWORD', getenv('WP_DB_PASSWORD'));
define('DB_HOST', getenv('WP_DB_HOST'));

// Rest of wp-config.php down here...
