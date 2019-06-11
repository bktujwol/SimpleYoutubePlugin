=== Simple Youtube Widget ===
Contributors: ujw0l
Tags: Youtube, channel, playlist , video embed
Requires at least: 2.8	+
Tested up to: 5.2.1
Stable tag: 2.0.1
License: GPLv2

Plugin that provides users option to display Youtube Widget on the Sidebar or Footer	


== Description ==

This plugin lets you to display Youtube widget on sidebar with the themes that supports sidebar and Footer

It displays video and playlist of your choice with video id and playlist id.
It also lets you display all videos from you youtube channel with option to navigate to next nd previous button.
No google API key needed. Uses Youtube rss feed.  

You have choice between single video , playlist and channel.


Note:     


== Installation ==

1. Upload the folder `SimpleYoutubePlugin` and its contents to the `/wp-content/plugins/` directory or use the wordpress plugin installer
2. Activate the plugin through the 'Plugins' menu in WordPress
3. A new "Simple Youtube Widget" will be available under Appearance > Widgets, where you can add it to your sidebar
  


= Uninstall =

1. Deactivate Simple youtube Widget in the 'Plugins' menu in Wordpress.
2. After Deactivation a 'Delete' link appears below the plugin name, follow the link and confim with 'Yes, Delete these files'.
3. This will delete all the plugin files from the server as well as erasing all options the plugin has stored in the database.

== Frequently Asked Questions ==

= Why can't I boardcast Youtube Channel =

Youtube doesn't support channel boardcasting without API, alternate option throws Warning due to bug in SimplePie RSS used by WordPress.

= Why can't I boardcast based on user id =

Youtube doesn't support  boardcasting with userid without API, alternate option throws Warning due to bug in SimplePie RSS used by WordPress.

= Where can I use this plugin? =

You can use this plugin to display videos on sidebar or Footer.

== Screenshots ==

1.	Screenshot of the front end  with one feed
2.  Screenshot of Backend widget area
3.  Screenshot of how to get video id
4.  Screenshot of how to get playlist id



== Changelog ==

= 1.0 =
* This is first stable version 
* More upgrades to follow

= 2.0 =
* It now support boardcasting channel.
* Navigation button added on front end. 
* Instruction on widget area.




