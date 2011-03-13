<!DOCTYPE html>
<!--[if lt IE 7]><html lang="en-ca" class="no-js ie6"><![endif]-->
<!--[if (IE 7) & !(IEMobile)]><html lang="en-ca" class="no-js ie7"><![endif]-->
<!--[if (IE 7) & (IEMobile)]><html lang="en-ca" class="no-js ie7 ie7mobile"><![endif]-->
<!--[if IE 8]><html lang="en-ca" class="no-js ie8"><![endif]-->
<!--[if IE 9]><html lang="en-ca" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en-ca" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title><?php wp_title(' · '); ?></title>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
	<script src="<?php sd(); ?>/js/modernizr.1.7.custom.min.js"></script>
	<?php wp_head(); ?>
</head>
<body role="document"<?php echo (isset($body_class)) ? ' class="' . $body_class . '"' : ''; ?>>

<ul class="accessibility visuallyhidden focusable">
	<li><a href="#nav"><?php _e('Skip to Navigation', 'tjbdev'); ?></a></li>
	<li><a href="#main-content"><?php _e('Skip to Content', 'tjbdev'); ?></a></li>
	<li><a href="#secondary-content"><?php _e('Skip to Secondary Content', 'tjbdev'); ?></a></li>
</ul>
