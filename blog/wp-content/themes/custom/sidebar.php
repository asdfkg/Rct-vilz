</div>
<div class="large-4 columns">
	<div id="sidebar" role="complementary">
		<ul>
			<?php 	/* Widgetized sidebar, if you have the plugin installed. */
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
			<!--li>
				<?php //get_search_form(); ?>
			</li-->

			<!-- Author information is disabled per default. Uncomment and fill in your details if you want to use it.
			<li><h2>Author</h2>
			<p>A little something about you, the author. Nothing lengthy, just an overview.</p>
			</li>
			-->

			<?php if ( is_404() || is_category() || is_day() || is_month() ||
						is_year() || is_search() || is_paged() ) {
			?> <li>

			<?php /* If this is a 404 page */ if (is_404()) { ?>
			<?php /* If this is a category archive */ } elseif (is_category()) { ?>
			<!--p>You are currently browsing the archives for the <?php //single_cat_title(''); ?> category.</p-->

			<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
			<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a> blog archives
			for the day <?php the_time('l, F jS, Y'); ?>.</p>

			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a> blog archives
			for <?php the_time('F, Y'); ?>.</p>

			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a> blog archives
			for the year <?php the_time('Y'); ?>.</p>

			<?php /* If this is a search result */ } elseif (is_search()) { ?>
			<p>You have searched the <a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a> blog archives
			for <strong>'<?php the_search_query(); ?>'</strong>. If you are unable to find anything in these search results, you can try one of these links.</p>

			<?php /* If this set is paginated */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a> blog archives.</p>

			<?php } ?>

			</li>
		<?php }?>
		</ul>
		<ul role="navigation">
			<?php wp_list_pages('title_li=<div class="sidebarTitle">Pages</div>' ); ?>
			<div id="searchWidget">
				<?php get_search_form(); ?>
			</div>
			<?php wp_list_categories('show_count=0&title_li=<div class="sidebarTitle">Categories</div>'); ?>
            
            <div class="sidebarTitle">Connect with Us</div>
            <a href="http://www.twitter.com/villazzo" title="Follow us on Twitter" target="_blank"><img src="/img/blog/twitter.png" width="25" height="25" alt="twitter" /></a>
            <a href="http://www.facebook.com/villazzo" title="Visit us on Facebook" target="_blank"><img src="/img/blog/facebook.png" width="25" height="25" alt="facebook" style="margin-left:0px;" /></a>
            <a href="#" title="" target="_blank"><img src="/img/blog/linkedin.png" width="25" height="25" alt="linkedin" style="margin-left:0px;" /></a>
            <a href="#" title="" target="_blank"><img src="/img/blog/technorati.png" width="25" height="25" alt="technorati" style="margin-left:0px;" /></a>
            <a href="http://digg.com/users/Villazzo" title="Follow us on Digg" target="_blank"><img src="/img/blog/digg.png" width="25" height="25" alt="digg" style="margin-left:0px;" /></a>
            <a href="http://delicious.com/villazzo" title="Follow us on Delicious" target="_blank"><img src="/img/blog/delicious.png" width="25" height="25" alt="delicious" style="margin-left:0px;" /></a>
            <a href="http://www.flickr.com/photos/villazzo/" title="View our Flickr photos" target="_blank"><img src="/img/blog/flickr.png" width="25" height="25" alt="flickr" style="margin-left:0px;" /></a>
            <a href="https://www.youtube.com/user/VillazzoVideos" title="View our YouTube videos" target="_blank"><img src="/img/blog/youtube.png" width="25" height="25" alt="youtube" style="margin-left:0px;" /></a>
            <a href="feed/rss/" title="Subscribe to our RSS" target="_blank"><img src="/img/blog/rss.png" width="25" height="25" alt="rss" style="margin-left:0px;" /></a>
            
            <div class="sidebarTitle">Twitter Updates</div>
            <div style="margin-top:20px;"><?php aktt_sidebar_tweets(); ?></div>
            
            <div class="sidebarTitle">Flickr Photostream</div>
            <div style="margin-top:20px; width:280px;"><?php get_flickrRSS(array('num_items' => 6, 'type' => 'user', 'id' => '48875966@N07', 'html' => '<a href="%flickr_page%" style="float:left; margin:0px 16px 16px 0px;" target="_blank" title="%title%"><img src="%image_square%" alt="%title%"></a>')); ?></div>
            
            <div style="float:left; margin:30px 0px 10px 0px; width:100%;"><script type="text/javascript" src="http://static.ak.connect.facebook.com/connect.php/en_US"></script><script type="text/javascript">FB.init("7e74fb6f1c08f59f6891641decb350d8");</script><fb:fan profile_id="408998975872" stream="0" connections="8" logobar="1" width="260"></fb:fan><div style="font-size:8px; padding-left:10px"><a href="http://www.facebook.com/Villazzo" target="_blank" title="Visit Villazzo on Facebook">Villazzo</a> on Facebook</div></div>

			<li>
			<div class="sidebarTitle">Archives</div>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>
			<?php if (wp_register()) { ?>
			<li>
			<div class="sidebarTitle">Register</div>
				<ul>
				<?php wp_register(); ?>
				</ul>
			</li>
			<?php } ?>
		</ul>
		<!--ul>
			<?php /* If this is the frontpage */ //if ( is_home() || is_page() ) { ?>
				<?php //wp_list_bookmarks(); ?>

				<li><h2>Meta</h2>
				<ul>
					<?php //wp_register(); ?>
					<li><?php //wp_loginout(); ?></li>
					<li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
					<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
					<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
					<?php //wp_meta(); ?>
				</ul>
				</li>
			<?php //} ?>

			<?php endif; ?>
		</ul-->
	</div>
</div>