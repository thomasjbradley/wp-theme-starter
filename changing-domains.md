# Changing WP domains

## Automagically

	Check out the bits inside `wp-config.php` and `themes/functions.php`.

## Manually

- http://codex.wordpress.org/Moving_WordPress
- **http://interconnectit.com/products/search-and-replace-for-wordpress-databases/**
- http://www.mydigitallife.info/how-to-move-wordpress-blog-to-new-domain-or-location/

### Search and replace commands

	UPDATE wp_options SET option_value = replace(option_value, 'http://www.old-domain.com', 'http://www.new-domain.com') WHERE option_name = 'home' OR option_name = 'siteurl';

	UPDATE wp_posts SET guid = replace(guid, 'http://www.old-domain.com','http://www.new-domain.com');

	UPDATE wp_posts SET post_content = replace(post_content, 'http://www.old-domain.com', 'http://www.new-domain.com');
