    <div class="off-canvas-wrap" data-offcanvas>
        <div class="inner-wrap">
            <nav class="tab-bar show-for-small-only">
                <section class="left-small">
                    <a class="left-off-canvas-toggle menu-icon" href="#"><span></span></a>
                </section>
                <section class="middle tab-bar-section">
                    <h1 class="title"><a href="/"><img src="/villazzo_new/img/logo.png" style="height: 35px;"></a></h1>
                </section>
                <section class="right-small">
                    <i class="fa fa-search" onclick="$('.off-canvas-wrap').foundation('offcanvas', 'show', 'move-right'); $('#search').focus();"></i>
                    <i class="fa fa-user" onclick="location.href='/login';"></i>
                </section>
            </nav>
            <aside class="left-off-canvas-menu">
                <ul class="off-canvas-list">
                    <li><label>VILLAZZO</label></li>
    				<li>
						<form action="/search/" method="post">
<!-- 							<input name="destination" type="hidden" value="<?php echo ($_GET['dest']?$_GET['dest']:'all'); ?>" /> -->
							<div class="row collapse">
								<div class="columns" style="padding: 2px 0 0 0 !important;"><input type="search" name="keyword" placeholder="Search"></div>
							</div>
						</form>
					</li>
                    <li class="has-submenu">
               			<a class="title">VILLAS & DESTINATIONS</a>
                        <ul class="left-submenu">
                            <li class="back"><a href="#">Back</a></li>
                            <li class="text-left"><a href="/luxury-rental-property-vacation-destinations">Villas & Destinations</a></li>
                            <li class="text-left"><a href="/rental-villas/aspen">Aspen</a></li>
                            <li class="text-left"><a href="/rental-villas/miami">Miami</a></li>
                            <li class="text-left"><a href="/rental-villas/saint-tropez">Saint-Tropez</a></li>
                        </ul>
                    </li>
                    <li><a href="/about-luxury-villa-rentals/villahotel-concept">SERVICES</a></li>
                    <li><a href="/reservations/">BOOK YOUR VILLA</a></li>
                    <li><a href="/about-luxury-villa-rentals/offers">SPECIAL OFFERS</a></li>
                    <li class="has-submenu">
                    	<a class="title">ABOUT US</a>
                            <ul class="left-submenu">
	                            <li class="back"><a href="#">Back</a></li>
	                            <li class="text-left"><a href="/about-luxury-villa-rentals/founders-vision">Founder's Vision</a></li>
                                <li><a href="/about-luxury-villa-rentals/villahotel-concept">Villazzo VillaHotels</a></li>
                                <li class="text-left"><a href="/about-luxury-villa-rentals/villazzo-realty">Villazzo Realty</a></li>
	                            <li class="text-left"><a href="/about-luxury-villa-rentals/villazzo-investments">Villazzo Investments</a></li>
                                <li class="text-left"><a href="/about-luxury-villa-rentals/press">Press</a></li>
	                            <li class="text-left"><a href="http://www.villazzo.com/blog/">Blog</a></li>
                                <li class="text-left"><a href="/about-luxury-villa-rentals/faq">FAQ</a></li>
                                <li class="text-left"><a href="/about-luxury-villa-rentals/how-to-book">How to Book</a></li>
                                <li class="text-left"><a href="/about-luxury-villa-rentals/testimonials">Testimonials</a></li>
                            </ul>
                    	</li>
                    <li><a href="/about-luxury-villa-rentals/contact-villazzo">CONTACT</a>
                    <?php if ($_SESSION['USER']->getUserId()) { ?>
                    <li class="has-submenu">
                        <a class="title">MY ACCOUNT</a>
                        <ul class="left-submenu">
                        	<li class="back"><a href="#">Back</a></li>
                            <li class="text-left"><a href="/reservations/">New Booking</a></li>
                            <?php if ($_SESSION['USER']->getUserGroupId() == 1) { ?>
                            <li class="text-left"><a href="/reservations/overview">Booking Overview</a></li>
                            <li class="text-left"><a href="/reservations/user">User Management</a></li>
                            <li class="text-left"><a href="/reservations/calendar">Property Calendar</a></li>
                            <?php } else if ($_SESSION['USER']->getUserGroupId() == 2) { ?>
                            <li class="text-left"><a href="/reservations/calendar">Property Calendar</a></li>
                            <li class="text-left"><a href="/reservations/profile">My Profile</a></li>
                            <li class="text-left"><a href="/reservations/overview">My History</a></li>
                            <?php } ?>
                            <li class="text-left"><a href="?logout">Log Out</a></li>
                        </ul>
                    </li>
                    <?php } ?>
                </ul>
            </aside>
            <!-- Top Bar Desktop-->
            <section id="top-bar-section" class="visible-for-medium-up">
                <div class="row full-width">
                    <div class="medium-4 columns"><hr></div>
                    <div class="medium-4 columns">
                        <div id="top-bar-logo" class="text-center">
                            <a href="/"><img src="/villazzo_new/img/logo.png"></a>
                            <a href="/login"><img src="/villazzo_new/img/header-ic-myaccount.png" style="width: 25px; position: absolute; top: 18px; right: -55px; z-index: 1000;"></a>
                            <form action="/search/" method="post">
<!-- 	                            <input name="destination" type="hidden" value="<?php echo ($_GET['dest']?$_GET['dest']:'all'); ?>"> -->
	                            <span class="fa fa-search" onclick="$('#top-bar-section-search').focus();"></span>
	                            <input type="search" name="keyword" id="top-bar-section-search">
	                        </form>
                        </div>
                    </div>
                    <div class="medium-4 columns"><hr></div>
                </div>
            </section>

            <!-- Top Bar Desktop End -->
            <!-- Top Bar Navigation Desktop -->
            <section id="top-bar-navigation" class="top-bar-section visible-for-medium-up">
                <nav class="top-bar" id="header-nav" data-topbar role="navigation">
                    <ul class="button-group">
                        <li class="has-dropdown">
<!--                         	<span onclick="location.href = '/luxury-rental-property-vacation-destinations';">VILLAS & DESTINATIONS</span> -->
                            <span class="hide-for-large-up">VILLAS</span>
                            <span class="show-for-large-up">VILLAS & DESTINATIONS</span>
                            <ul class="dropdown">
                            	<li class="text-left"><a href="/luxury-rental-property-vacation-destinations">All Destinations</a></li>
                                <li class="text-left"><a href="/rental-villas/aspen">Aspen</a></li>
                                <li class="text-left"><a href="/rental-villas/miami">Miami</a></li>
                                <li class="text-left"><a href="/rental-villas/saint-tropez">Saint-Tropez</a></li>
                            </ul>
                        </li>
                        <li><a href="/about-luxury-villa-rentals/villahotel-concept">SERVICES</a></li>                        
                        <li>
                        	<a href="/reservations/">
		                        <span class="hide-for-large-up">BOOK</span>
		                        <span class="show-for-large-up">BOOK YOUR VILLA</span>
	                        </a>
	                    </li>                        
                        <li>
                        	<a href="/about-luxury-villa-rentals/offers">
	                        	<span  class="hide-for-large-up">OFFERS</span>
		                        <span class="show-for-large-up">SPECIAL OFFERS</span>	
                        	</a>
                        </li>
                        <li class="has-dropdown">
<!--                            <span onclick="location.href = '/about-luxury-villa-rentals/founders-vision';"></span>-->
                            <span class="hide-for-large-up">ABOUT</span>
                            <span class="show-for-large-up">ABOUT US</span>
                            <ul class="dropdown">
                                <li class="text-left"><a href="/about-luxury-villa-rentals/founders-vision">Founder's Vision</a></li>
                                <li><a href="/about-luxury-villa-rentals/villahotel-concept">Villazzo VillaHotels</a></li>
                                <li class="text-left"><a href="/about-luxury-villa-rentals/villazzo-realty">Villazzo Realty</a></li>
                                <li class="text-left"><a href="/about-luxury-villa-rentals/villazzo-investments">Villazzo Investments</a></li>
                                <li class="text-left"><a href="/about-luxury-villa-rentals/press">Press</a></li>
                                <li class="text-left"><a href="http://www.villazzo.com/blog/">Blog</a></li>
                                <li class="text-left"><a href="/about-luxury-villa-rentals/faq">FAQ</a></li>
                                <li class="text-left"><a href="/about-luxury-villa-rentals/how-to-book">How to Book</a></li>
                                <li class="text-left"><a href="/about-luxury-villa-rentals/testimonials">Testimonials</a></li>
                            </ul>
                        </li>
                        <li><a href="/about-luxury-villa-rentals/contact-villazzo">CONTACT</a>
                        </li>
                        <?php if ($_SESSION['USER']->getUserId()) { ?>
                        <li class="has-dropdown">
		                        <span class="hide-for-large-up">ACCOUNT</span>
		                        <span class="show-for-large-up">MY ACCOUNT</span>
                            <ul class="dropdown">
	                            <li class="text-left"><a href="/reservations/">New Booking</a></li>
	                            <?php if ($_SESSION['USER']->getUserGroupId() == 1) { ?>
	                            <li class="text-left"><a href="/reservations/overview">Booking Overview</a></li>
	                            <li class="text-left"><a href="/reservations/user">User Management</a></li>
	                            <li class="text-left"><a href="/reservations/calendar">Property Calendar</a></li>
	                            <?php } else if ($_SESSION['USER']->getUserGroupId() == 2) { ?>
								<li class="text-left"><a href="/reservations/calendar">Property Calendar</a></li>
	                            <li class="text-left"><a href="/reservations/profile">My Profile</a></li>
	                            <li class="text-left"><a href="/reservations/overview">My History</a></li>
	                            <?php } ?>
                                <li class="text-left"><a href="?logout">Log Out</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                    </ul>
	            </nav>
            </section>
			<!-- Top Bar Navigation Desktop End -->