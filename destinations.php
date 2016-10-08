<?php require_once '/kunden/homepages/27/d309616710/htdocs/private/config.php'; ?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <?php getMeta('destinations'); ?>
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="/css/map.css">
    <script src="/js/vendor/modernizr.js"></script>
</head>

<body>
	<?php require_once 'inc-header.php'; ?>
            <!-- Choose Your Destination Start -->
            <section id="choose-your-destination">
                <div class="row text-center hide-for-medium-up">
                    <h1>CHOOSE YOUR DESTINATION</h1>
                </div>
                <div class="row large-collapse">
                    <div class="medium-4 columns extend-it-all">
                        <a href="/rental-villas/saint-tropez"><img src="img/destination-header_saint_tropez_all.png"></a>
                    </div>
                    <div class="medium-4 columns extend-it-all">
                        <a href="/rental-villas/miami"><img src="img/destination-header_miami_all.png"></a>
                    </div>
                    <div class="medium-4 columns extend-it-all">
                        <a href="/rental-villas/aspen"><img src="img/destination-header_aspen_all.png"></a>
                    </div>
            </section>
            <!-- Choose Your Destination Map Start-->
            <section id="choose-your-destination-map">
                <div class="row">
                    <div class="small-12 columns">
                         <div id="destinations-map-container">
                        	  <div id="destinations-map" class="map"></div>
                        	  <a href="" class="btn-refresh"><img src="img/destinations/back.png" /></a>
                        	  <a href="" class="btn-dest-properties">View All %destination% Properties</a>
                          </div>
                    </div>
                </div>
                <div class="row visible-for-medium-up">
                    <div class="small-12 columns">
                        <h4>LUXURY VACATION VILLA RENTALS IN MIAMI, ASPEN & ST. TROPEZ</h4>
                        <p>Unlike a traditional villa rental agent, Villazzo functions as a true hotel operator. All Villazzo villas are within 15 minutes driving distance from our local operations offices in the heart of Saint-Tropez, Miami Beach, and Aspen. Out of the dozens of luxury homes we inspect, we only select the "Top 10". Most homes which you would find through other agents would not qualify for Villazzo's strict standards of design, quality, and maintenance.</p>
                        <p>If you book such a hand-selected vacation rental home as "VillaHotel", this amazing property is then converted into your own "Private Hotel" - with our signature hotel products, staff, and services. The result is a completely new experience in luxury travel.</p>
                        <p>We invite you to explore our destinations above and choose a luxury villa rental that suits your specific taste and needs. Since we understand that our guests want to customize their service packages, we have created three levels for you to choose from:  5-star VillaHotel, 4-star VillaHotel, and 3-star VillaHotel.</p>
                    </div>
                </div>
            </section>
            <!-- Choose Your Destination Map End-->
        <?php require_once 'inc-footer.php'; ?>
		
		<?php require_once 'inc-js.php'; ?>
		
        <script src="https://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
    	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>-->
    	<script src="/js/vendor/jquery.ui.map.full.min.js" type="text/javascript"></script>
        <script src="/js/map/markerclusterer_plus.js"></script>
        <script src="/js/map/infobox_packed.js"></script>
    	<script src="/js/map/map.js"></script>

</body>

</html>
