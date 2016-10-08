=== Flowplayer 6 Video Player ===
Contributors: naa986
Donate link: http://wphowto.net/
Tags: video, embed, html5, ipad, iphone, mobile, playlist, flowplayer, player, mp4, webm, responsive, ios, android 
Requires at least: 4.2
Tested up to: 4.5
Stable tag: 1.0.3
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Embed video file in WordPress with Flowplayer 6 style. Embed self-hosted, external, HTML5 compatible responsive video in post/page with flowplayer.

== Description ==

Flowplayer 6 Video Player adds a video shortcode to your WordPress site. This shortcode allows you to embed video files and play theme back using Flowplayer HTML5 player (version 6).

= Features =

* Embed MP4 videos
* Embed webm videos
* Embed videos which can be viewed from a mobile or tablet device
* Video playback support for iOS (ipad, iphone) and android devices
* Embed HTML5 videos which are playable across all major browsers
* Embed videos with poster images
* Embed videos and allow it to loop to the beginning when finished
* Customize the video player using modifier classes
* Automatically play a video when the page is rendered
* Embed videos using three different skins
* Automatically calculate the height of the video based on its width
* Flexible resizing of videos (true responsiveness)
* Embed videos with various aspect ratios (16:9, 4:3)

= Usage =

In order to embed a video, create a new post/page and use the following shortcode:

`[flowplayer src="http://example.com/wp-content/uploads/videos/test.mp4"]`

here, src is the actual source of your mp4 video file.

In addition to the source mp4 video file, you can also specify a webm video file. This step is optional since mp4 video is supported by almost all major browsers.

`[flowplayer src="http://example.com/wp-content/uploads/videos/test.mp4" webm="http://example.com/wp-content/uploads/videos/test.webm"]`

**Autoplay Video**

If you want a particular video to start playing when the page loads you can set the "autoplay" option to "true":

`[flowplayer src="http://example.com/wp-content/uploads/videos/test.mp4" autoplay="true"]`

**Player Size**

By default, the player takes up the full width of the content area. You can easily control the size by specifying a width for it:

`[flowplayer src="http://example.com/wp-content/uploads/videos/test.mp4" width="500"]`

The height will be automatically determined based on the ratio (please see the "Control Player Ratio section" for details).

**Player Ratio**

The player ratio is set to "0.417" by default. But you can override it by specifying a different ratio in the shortcode:

`[flowplayer src="http://example.com/wp-content/uploads/videos/test.mp4" ratio="0.345"]`

**Loop Video**

If you want a particular video to start playing again when it ends you can set the "loop" option to "true":

`[flowplayer src="http://example.com/wp-content/uploads/videos/test.mp4" loop="true"]`

For documentation please visit the [Flowplayer 6 Video Player](http://wphowto.net/flowplayer-6-video-player-for-wordpress-813 "Flowplayer for WordPress") plugin page

= Plugin Language Translation =

If you are a non-English speaker please help [translate Flowplayer 6 Video Player](https://translate.wordpress.org/projects/wp-plugins/flowplayer6-video-player) into your language.

== Installation ==

1. Go to the Add New plugins screen in your WordPress Dashboard
1. Click the upload tab
1. Browse for the plugin file (flowplayer6-video-player.zip) on your computer
1. Click "Install Now" and then hit the activate button
1. Now, go to the settings menu of the plugin and follow the instructions for embedding videos.

== Frequently Asked Questions ==

= Can this plugin be used to embed videos on my WordPress blog? =

Yes.

= Are the videos embedded by this plugin playable on iOS devices? =

Yes.

= Can I autoplay a video? =

Yes.

= Can I embed responsive videos using this plugin? =

Yes.

== Screenshots ==

1. Flowplayer 6 Video Embed Demo

== Upgrade Notice ==
none

== Changelog ==

= 1.0.3 =
* Added translation option so the plugin can take advantage of language packs
* Flowplayer 6 Video Player is now compatible with WordPress 4.4

= 1.0.2 =
* Flowplayer 6 Video Player is now compatible with WordPress 4.3

= 1.0.1 =
* First commit
