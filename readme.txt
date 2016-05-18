=== Default Term ===
Contributors: allanchristiancarlos
Donate link: https://github.com/allanchristiancarlos/default-term
Tags: terms, taxonomy, default taxonomy
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WordPress Plugin that allows you to set a default term of a taxonomy

== Description ==

WordPress Plugin that allows you to set a default term of a taxonomy


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->Plugin Name screen to configure the plugin
4. (Make your instructions match the desired user flow for activating and installing your plugin. Include any steps that might be needed for explanatory purposes)

```
register_taxonomy( 'custom-tax', ['post'], [
		'label'              => 'Custom Tag',
		'public'             => true,
		'show_ui'            => true,
		'default_term'       => 'Uncategorized',
	]);
```

(!IMPORTANT) Add a **default_term** key in your registration of taxonomy. 
Then deactivate and activate plugin to save the default term into the database.


== Changelog ==

= 0.0.1 =
* initial release
