=== Improved Include Page ===
Contributors: Marios Alexandrou
Donate link: http://infolific.com/technology/software-worth-using/include-page-plugin-for-wordpress/
Tags: include, include content, include html, include pages, nested content, include other pages, include other content
Requires at least: 4.0
Tested up to: 4.4
License: GPLv2 or later

Improved Include Page plugin allows you to include the content of a page in a template file or a post/page (via a shortcode) with several options.

== Description ==

Improved Include Page (IIP) uses the WordPress Shortcode API to include the content of any page inside any page or post.

= Using a shortcode in a post/page: =

[include-page id="123"] OR [include-page id="/about/resume"]

= Using PHP in a template =

<?php echo iinclude_page(4, null, true); ?>

For more details and examples, see the Installation tab.

Improved Include Page is an enhanced version of the original Include Page developed by Brent Loertscher.

= Key Features =

* Page title can be displayed with optional HTML code
* Content can be displayed with different styles (full, teaser, custom 'more' link)
* WordPress filters are applied to both the content and the title
* Supports the WordPress Shortcode API

== Installation ==

1. Download Improved Include Page
2. Extract the zipped archive
3. Upload the file 'iinclude_page.php' to the 'wp-content/plugins' directory of your WordPress installation
4. Activate the plugin from your WordPress admin 'Plugins' page.
5. Include pages in your templates using 'iinclude_page' function or in your pages/posts using the shortcode syntax.

= How To Use =

Once installed, the plugin adds the function 'iinclude_page':

void **iinclude_page**(int post_id [,string params, boolean return = false])

The function takes three parameters:
1. the id of the page to include ('post_id')
2. an optional string ('params') which contains the display options
3. an optional boolean ('return') tells whether to return the content or display it on screen.

= Example 1: using Shortcode API in posts or pages =

You can include a page's content in a page/post using the syntax:

    [include-page id="123"]

or

    [include-page id="3" displayTitle="true" displayStyle="DT_TEASER_MORE" titleBefore="<h3>" titleAfter="</h3>"  more="continue&raquo;"]

= Example 2: basic usage in templates =

If you wish to include the content of page number '4' insert the following code into your template file (e.g. sidebar.php):

    <?php iinclude_page(4); ?>

or

    <?php echo iinclude_page(4, null, true); ?>

In order to avoid PHP errors if the plugin is disabled, you should use the function with the following syntax:

     <?php if( function_exists( 'iinclude_page' ) ) iinclude_page( 4 ); ?>

= Example 3: using optional parameters in templates =

You can also display the page title using the following code:

    <?php iinclude_page( 4, 'displayTitle=true&titleBefore=<h2 class="sidebar-header">' ); ?>
	
= Parameters =

The current version supports the following parameters:

<dl>
<dt>displayTitle (<em>boolean</em>)</dt>
<dd>toggle title display</dd>

<dt>titleBefore/titleAfter (<em>string</em>)</dt>

<dd>string to display before and after the title</dd>

<dt>displayStyle (<em>integer constant</em>)</dt>
<dd>one of the following:
<ul>
<li><code>DT_TEASER_MORE</code> - Teaser with 'more&' link (default)</li>
<li><code>DT_TEASER_ONLY</code> -Teaser only, without 'more' link</li>
<li><code>DT_FULL_CONTENT</code> - Full content including teaser</li>
<li><code>DT_FULL_CONTENT_NOTEASER</code> - Full content without teaser</li>
</ul>
</dd>

<dt>more (string)</dt>
<dd>text to display for the 'more' link</dd>
</dl>

== Changelog ==

= 1.0 =
* Confirming plugin works with WP 4.4 using both shortcode and template code.
* Bumping WordPress requirement to 4.0.
* Updates to description, documentation and tags.
* PHP code formatting tweaks.
* Support and development transferred from Vito Tardia to Marios Alexandrou.

= 0.5.0 =
* Added the '#more-<id>' in the "read more" link href, to avoid going to the top of the post when clicking (by Matthieu Sarter),
* Added support for the WordPress '<--more [text]-->' tag, so that the more link text can be defined at the post level (it can still be overriden at the 'iinclude_page()/[include]' level) (by Matthieu Sarter).

= 0.4.9 =
* Fixed static method definitions
* Fixed: returns false if a page is not found, without triggering a notice

= 0.4.8 =
* Fixed bug which broke the ID style inclusion on WP 3.0 (thanks to Mike Woods, Brad Lauster and wptk)
* Fixed a bug on the 'more' link which caused too many slashes when using images as 'more tags' (thanks to Nikhil Dabas)

  Note: if you use HTML code in the 'more' link use single quotes for the 'more' parameter, like this: 

  '[include-page id="mypage" more='<img src="my/image.gif" />']'
  
  or you will have a PHP Warning

* Fixed a bug in the displayTitle attribute: using "false" you will get a real boolean false and title is hidden
* Added a new WP action 'include-page' to use inside your PHP code 
  
  '<?php do_action('include-page', $id, $params, $return)?>'

* Edited class attribute for the 'more' link. Now it is 'more-link' and 'iip-more-link'

= 0.4.7 =
* On WP 2.5 or greater allows custom inclusion by post type and status using parameters 'allowType' and 'allowStatus'.
* Bug fix: in shortcode fixed a bug that could crash PHP when including recursive page/posts

= 0.4.6 =
* Bug fixed: since this version you can include only static pages with status of 'published'.

= 0.4.5 =
* Page ID can be a valid page path (WP 2.1 or higher required) with contribution by Guy Leech.

= 0.4.4
* Added parameter $return (default = false) to iinclude_page() function
* Added support for WP 2.5.x shortcode API

= 0.4.3 =
* The code of this version it's been cleaned and optimized using WordPress API.

= 0.4.2 =
* This version fixes a bug that triggers an error when used with some content filter: the '$page' global variable is backed up and then restored before returning.

= 0.4.1 =
* This version contains a bug fix by [Jesse Plank](http://www.funroe.net/): resolves a compatibility problem with the plugin [EventCalendar](http://blog.firetree.net/2005/07/18/eventcalendar-30/).