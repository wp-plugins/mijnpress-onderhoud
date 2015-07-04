=== MijnPress onderhoud ===
Contributors: Ramon Fincken
Donate link: http://donate.ramonfincken.com
Tags: mijnpress,maintenance,onderhoud,security,administration,permissions
Requires at least: 4.0
Tested up to: 4.2.2
Stable tag: 0.0.2

Plugin used for maintenance clients, prevents clients from breaking sites

== Description ==

Plugin used for maintenance clients, prevents clients from breaking sites<br>

Requires: 'Limit-Login-Attempts', 'Sucuri-scanner', 'WP-security-audit-log'<br>
* this (array of plugins) is filterable: mijnpress_onderhoud_user_has_cap<br>
Disables: Online file editor<br>
Revokes permissions for non-main admins: 'activate_plugins', 'edit_plugins', 'install_plugins', 'update_plugins', 'delete_plugins', 'delete_themes', 'switch_themes', 'edit_themes'<br>
* this (array of permissions to revoke) is filterable: mijnpress_onderhoud_user_has_cap<br>
* this (main admin array) is filterable: mijnpress_onderhoud_main_admins<br>

<br><br>Uses TGM-Plugin-Activation to force plugin installs, thanks Thomas Griffin, Gary Jones, Juliette Reinders Folmer!

<br>
<br>Coding by: <a href="http://www.mijnpress.nl">MijnPress.nl</a> <a href="http://twitter.com/#!/ramonfincken">Twitter profile</a> <a href="http://wordpress.org/extend/plugins/profile/ramon-fincken">More plugins</a>

== Installation ==

1. Upload directory `mijnpress_onderhoud` to the `/wp-content/plugins/` directory
2. Add this define to your wp-config and adjust the YOUR_SITE_MAIN_ADMIN_USER_ID HERE<br>
define('MP_MIJNPRESS_ONDERHOUD', YOUR_SITE_MAIN_ADMIN_USER_ID HERE);
3. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= I have a lot of questions and I want support where can I go? =

<a href="http://pluginsupport.mijnpress.nl/">http://pluginsupport.mijnpress.nl/</a> or drop me a tweet to notify me of your support topic over here.<br>
I always check my tweets, so mention my name with @ramonfincken and your problem.


== Changelog ==
= 0.0.2 =
Added: revoke permissions<br>
Added: required plugins<br>
Added: filters

= 0.0.1 =
Init

== Screenshots ==

None yet
