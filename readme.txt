=== Kilroy was here ===
Contributors: walterebert
Tags: ascii art, html, source code, demo
Requires at least: 3.1
Tested up to: 6.6
Requires PHP: 5.6
Stable tag: 1.5.4
License: GPL-2.0-or-later
License URI: https://spdx.org/licenses/GPL-2.0-or-later.html

Adds a text tag to the footer of posts & pages

== Installation ==

1. Download the plugin and unzip it. Copy the files to the `/wp-content/plugins/kilroy-was-here` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

After installation, you can change the text in the options page under 'Settings'.

== Screenshots ==

1. Plugin settings page

== Changelog ==

= 1.5.4 =
* Improve accessibility
* Update tested WordPress version

= 1.5.3 =
* Update tested WordPress version

= 1.5.2 =
* Replace PHP `header` function with `http_response_code`.

= 1.5.1 =
* Ignore PHP sniff WordPress.Security.EscapeOutput.OutputNotEscaped
* Remove deprecated @subpackage tag
* Update tested WordPress version

= 1.5 =
* Update code according to WordPress coding standards
* Move class into seperate file

= 1.4 =
* Use short array syntax

= 1.3.3 =
* Use WordPress checked function
* Correct PHP Doc tags

= 1.3.2 =
* Improved code readability
* Do not delete settings in large networks upon uninstall

= 1.3 =
* Renamed class and text domain

= 1.2.2 =
* Replaced text domain constant

= 1.2.1 =
* Improved translation support

= 1.2 =
* Added a priority setting
* Added a HTML comment option
* Added a HTML <head> option
* Improved multisite support

= 1.1 =
* Corrected minimal required WordPress version
* Removed deprecated screen_icon function
* Use plugins_loaded action
* Added text domain for translations
* Follow WordPress coding standards
* Added unit tests
