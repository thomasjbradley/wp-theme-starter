<!DOCTYPE html>
<html lang="en-ca" class="no-js">
<head>
  <meta charset="utf-8">
  <title><?php wp_title(''); ?></title>
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
  <script src="<?php sd(); ?>/js/modernizr.1.7.custom.min.js"></script>
  <?php
    ob_start();
    wp_head();
    echo clean_wp_head(ob_get_clean());
  ?>
</head>
<body role="document"<?php echo (isset($body_class)) ? ' class="' . $body_class . '"' : ''; ?>>

<ul class="accessibility visuallyhidden focusable">
  <li><a href="#nav"><?php _e('Skip to Navigation', 'tjbdev'); ?></a></li>
  <li><a href="#main-content"><?php _e('Skip to Content', 'tjbdev'); ?></a></li>
  <li><a href="#secondary-content"><?php _e('Skip to Secondary Content', 'tjbdev'); ?></a></li>
</ul>
