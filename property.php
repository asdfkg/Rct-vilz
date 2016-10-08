<?php
require_once '/kunden/homepages/27/d309616710/htdocs/private/config.php';

// property info
$rs_property = $_SESSION['DB']->querySelect('SELECT propertyId FROM property LEFT JOIN destination ON destination.destId=property.destId WHERE UPPER(propertyName) = ? LIMIT 1', array(str_replace('-', ' ', strtoupper($_GET['prop']))));
$row_rs_property = $_SESSION['DB']->queryResult($rs_property);
$totalRows_rs_property = $_SESSION['DB']->queryCount($rs_property);

if (!isset($row_rs_property['propertyId'])) header('Location: /luxury-rental-property-vacation-destinations');

$checkInDt = (isset($_GET['check_in'])?$_GET['check_in']:NULL);
$checkOutDt = (isset($_GET['check_out'])?$_GET['check_out']:NULL);

$property = $_SESSION['RESERVATION']->getProperty('', $checkInDt, $checkOutDt, 0, 0, 0, 0, $row_rs_property['propertyId']);
$propertyArray = $property[0];

$propertyId = $propertyArray['property_id'];
$propertyName = $propertyArray['property_name'];
$destName = $propertyArray['dest_name'];
if ($destName == 'StTropez') $destName = 'Saint-Tropez';
$destFolder = str_replace(' ', '-', strtolower($destName));
$propertyGallery = $propertyName.($propertyArray['property_gallery_show_all']?'':'/limited');
$propertyTitle = $propertyArray['property_title'];
$propertyDescLong = $propertyArray['property_desc_long'];
$propertyLocationName = $propertyArray['property_location_name'];
$propertyLocationLat = $propertyArray['property_location_lat'];
$propertyLocationLong = $propertyArray['property_location_long'];
$propertyTotalArea = ($propertyArray['property_area_sq']&&$propertyArray['property_area_mt']?number_format($propertyArray['property_area_sq']).' sq ft ('.number_format($propertyArray['property_area_mt']).'m&sup2;)':'');
$propertyLivingArea = ($propertyArray['property_interior_sq']&&$propertyArray['property_interior_mt']?number_format($propertyArray['property_interior_sq']).' sq ft ('.number_format($propertyArray['property_interior_mt']).' m&sup2;)':'');
$propertyYearBuilt = $propertyArray['property_year_built'];
$propertyYearRemodeled = $propertyArray['property_year_remodeled'];
$propertyMaxPeople = $propertyArray['property_max_people'];
$propertyBedrooms = $propertyArray['property_bedrooms'];
$propertyBathrooms = $propertyArray['property_bathrooms'];
$serviceLevelsArray = $propertyArray['service_levels'];
$currency = $propertyArray['dest_currency'];
$checkInDt = $propertyArray['check_in_dt'];
$checkOutDt = $propertyArray['check_out_dt'];
$nightTotal = $propertyArray['night_total'];

// property amenities
$rs_property_feature = $_SESSION['DB']->querySelect('SELECT * FROM propertyFeature LEFT JOIN feature on propertyFeature.featureId = feature.featureId WHERE propertyId = ? AND propFeatActive = 1 ORDER BY propFeatOrder', array($propertyId));
$row_rs_property_feature = $_SESSION['DB']->queryResult($rs_property_feature);
$totalRows_rs_property_feature = $_SESSION['DB']->queryCount($rs_property_feature);

$propertyAmenities = '';
if ($totalRows_rs_property_feature)
{
	$propertyAmenities = '<ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-2">';
	do
	{
		$propertyAmenities .= '<li>';
		if ($row_rs_property_feature['featureName']) $propertyAmenities .= $row_rs_property_feature['featureName'];
		else $propertyAmenities .= $row_rs_property_feature['propFeatName'];
		
		if ($row_rs_property_feature['propFeatValue']) $propertyAmenities .= ': '.$row_rs_property_feature['propFeatValue'];
		$propertyAmenities .= '</li>';
		
	} while ($row_rs_property_feature = $_SESSION['DB']->queryResult($rs_property_feature));
	$propertyAmenities .= '</ul>';
}

// property driving
$rs_property_driving = $_SESSION['DB']->querySelect('SELECT * FROM propertyDriving WHERE propertyId = ? ORDER BY propDrivingLocation', array($propertyId));
$row_rs_property_driving = $_SESSION['DB']->queryResult($rs_property_driving);
$totalRows_rs_property_driving = $_SESSION['DB']->queryCount($rs_property_driving);

$propertydriving = '';
if ($totalRows_rs_property_driving)
{
	$propertydriving = '<ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-2">';
	do {
		$propertydriving .= '<li><span>'.$row_rs_property_driving['propDrivingLocation'].':</span> '.$row_rs_property_driving['propDrivingTime'].' min</li>';
	} while ($row_rs_property_driving = $_SESSION['DB']->queryResult($rs_property_driving));
	$propertydriving .= '</ul>';
}

// property gallery
$propertyGalleryArray = array();
//$path = 'media/destination/'.$destFolder.'/'.$propertyGallery.'/';
$path = 'img/property/'.$propertyGallery.'/';
$propertySlideshowFull = NULL;
$propertySlideshowThumb = NULL;

if (file_exists($path))
{
	$directory = opendir($path);
	while (FALSE !== ($filename = readdir($directory)))
	{
		if (is_dir($path.$filename) || $filename[0] == '.' || $filename[1] == 'jpg' || strpos($filename, '@2x') !== FALSE || strpos($filename, '@3x') !== FALSE) continue; // skip sub directories, hidden files, & non-pngs
		$propertyGalleryArray[] = $filename;
	}
	sort($propertyGalleryArray);
	
	$propertySlideshowCtr = 1;
	foreach ($propertyGalleryArray as $filename)
	{
		$title = NULL;
		$titleArray = explode('_', trim($filename, '.jpg'));
		foreach ($titleArray as $data) if (!is_numeric($data)) $title .= $data.' ';
		$propertySlideshowFull .= '<div data-owlItem="'.$propertySlideshowCtr.'" class="item"><span class="img-property-title">'.$propertyName.'</span><img src="'.$path.''.$filename.'" alt="'.$title.'"></div>';
		$propertySlideshowThumb .= '<div data-owlItem="'.$propertySlideshowCtr.'" class="item"><img src="'.$path.''.$filename.'" alt="'.$title.'"></div>';
		$propertySlideshowCtr ++;
	}
}

// service levels
$propertyServiceLevels = '';
foreach ($serviceLevelsArray as $serviceLevels)
{
	$propertyServiceLevels .= '<div class="medium-'.(12/count($serviceLevelsArray)).' columns data-equalizer-watch">
	    <ul class="pricing-table">
	        <li class="title">';
	        
	        for ($i = 0; $i < $serviceLevels['level']; $i ++) $propertyServiceLevels .= '<i class="fa fa-star"></i> ';
	         $propertyServiceLevels .= strtoupper($serviceLevels['name']).'</li>
	        <li class="description text-left">';
	        
	        if (!empty($serviceLevels['services']))
	        {
		        foreach ($serviceLevels['services'] as $serviceIcon => $serviceLevel)
				{
					if ($serviceLevel['type'] == 'service') $propertyServiceLevels .= '<div class="row"><div class="small-2 medium-3 columns"><img src="/img/reservations/services/icons/'.$serviceIcon.'.png"></div><div class="small-10 medium-9 columns">'.$serviceLevel['desc'].'</div></div>';
				}
			}
			$propertyServiceLevels .= '</li>
	        <li class="price">'.($serviceLevels['night']?$currency.number_format($serviceLevels['night']):$currency.number_format($serviceLevels['min']).' - '.$currency.number_format($serviceLevels['max'])).'<br><span class="text-grey">per night</span></li>';
	        
			if ($serviceLevels['level'] > 0)
			{
				if ($checkInDt && $checkOutDt) $propertyServiceLevels .= '
		        <li class="cta-button"><a class="button tiny" href="/reservations/services?property='.$propertyName.'&level='.$serviceLevels['level'].'&check_in='.date('m/d/Y', strtotime($checkInDt)).'&check_out='.date('m/d/Y', strtotime($checkOutDt)).'">BOOK NOW</a></li>';
		        else $propertyServiceLevels .= '<li class="cta-button"><a class="button tiny" data-reveal-id="propertyAvailabilityModal">CHECK AVAILABILITY</a></li>';
	        }
	        $propertyServiceLevels .= '
	    </ul>
	</div>';
}
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title><?php echo ucwords('Villa '.$propertyName.' - '.$destName.' Villa Rental | VILLAZZO'); ?></title>
    <link rel="stylesheet" href="/css/custom.css">
    <script src="/js/vendor/modernizr.js"></script>
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyAYpd2VEIF_n_fdZkFA3uYKRYKoYkiQIko&sensor=false"></script>
    <script type="text/javascript">
    <!--
	function initialize()
	{
		var map = new google.maps.Map(
			document.getElementById('property-map'), {
			center: new google.maps.LatLng(<?php echo (isset($propertyLocationLat)?$propertyLocationLat:0); ?>, <?php echo (isset($propertyLocationLong)?$propertyLocationLong:0); ?>),
			zoom: 13,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			scrollwheel: false
		});
		
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(<?php echo (isset($propertyLocationLat)?$propertyLocationLat:0); ?>, <?php echo (isset($propertyLocationLong)?$propertyLocationLong:0); ?>),
			map: map
		});
	
	}
    google.maps.event.addDomListener(window, 'load', initialize);
	-->
	</script>
</head>

<body onload="initialize()" onunload="GUnload()">
	<?php require_once 'inc-header.php'; ?>
            <!-- Owl Carousel Desktop Start -->
			<section id="owl-carousel-section">
				<div class="row">
					<div class="columns">
						<div id="sync1" class="owl-carousel"><?php echo $propertySlideshowFull; ?></div>
					</div>
				</div>
    		</section>
			<section id="owl-thumbnails-section" class="visible-for-medium-up">
				<div class="row">
					<div class="columns">
						<div id="sync2" class="owl-carousel"><?php echo $propertySlideshowThumb; ?></div>
					</div>
				</div>
			</section>
            <!-- Owl Carousel Desktop End -->
            <!-- Property Summary Section Start -->
            <section id="property-summary-section">
	            <div class="row text-center" id="property-intro" data-equalizer>
	                <div class="medium-2 columns left-side" data-equalizer-watch>
	                    <h6><?php echo $propertyName.'<br>- '.$destName.' -'; ?></h6>
	                </div>
	                <div class="medium-10 columns right-side" data-equalizer-watch>
	                    <?php echo $propertyTitle; ?>
	                </div>
	            </div>
	            	            
                <div class="row" id="property-desc">
                    <div class="small-12 columns text-justify">
	                    <p><?php echo $propertyDescLong; ?></p>
                    </div>
                </div>
                
                <div class="row text-center visible-for-medium-up">
                    <div class="medium-6 medium-centered columns">
                        <div class="row text-center">
                            <div class="medium-6 columns">
	                            <button class="button small expand" data-reveal-id="propertyInterestedModal">I'M INTERESTED</button>
                            </div>
                            <div class="medium-6 columns">
                                <button class="button small expand" data-reveal-id="propertyShareModal">SHARE</button>
                            </div>
                        </div>
                    </div>
                </div>
                                
                <div class="row full-width text-center" id="property-details-trigger">
                	<p class="flip"><span id="clickMe" class="clickText">click to </span> <i class="fa fa-angle-double-up"></i></p>
                </div>
                
                <!-- View Specification Section Start -->
                <div id="property-specifications">
	                <div class="row" id="property-details">
	                    <div class="columns text-left show-for-small-only">
							<span>DETAILS</span>
	                    </div>
	                    <div class="medium-2 columns text-right show-for-medium-up">
							<span>DETAILS</span>
	                    </div>
	                    <div class="medium-10 columns">
	                        <ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-2">
	                            <li><span>Location:</span>&nbsp;<?php echo $propertyLocationName; ?></li>
		                        <li><span>Bedrooms:</span>&nbsp;<?php echo $propertyBedrooms; ?></li>
	                            <?php if ($propertyLivingArea) echo '<li><span>Interior space:</span>&nbsp;'.$propertyLivingArea.'</li>'; ?>
		                        <?php if ($propertyBathrooms) echo '<li><span>Bathrooms:</span>&nbsp;'.$propertyBathrooms.'</li>'; ?>
	                            <?php if ($propertyTotalArea) echo '<li><span>Total Area:</span>&nbsp;'.$propertyTotalArea.'</li>'; ?>
		                    </ul>
	                    </div>
	                </div>
	                
	                <?php if ($propertydriving) { ?>
	                <div class="row full-width text-center" id="property-amenities-separator"></div>
	                
	                <div class="row" id="property-details">
	                    <div class="columns text-left show-for-small-only">
							<span>DRIVE TIMES</span>
	                    </div>
	                    <div class="medium-2 columns text-right show-for-medium-up">
							<span>DRIVE TIMES</span>
	                    </div>
	                    <div class="medium-10 columns">
							<?php echo $propertydriving; ?>
	                    </div>
	                </div>
	                <?php } ?>
	                
	                <?php if ($propertyAmenities) { ?>
	                <div class="row full-width text-center" id="property-amenities-separator"></div>
	                    
	                <div class="row" id="property-amenities">
	                    <div class="columns text-left show-for-small-only">
	                        <span>AMENITIES</span>
	                    </div>
	                    <div class="medium-2 columns text-right show-for-medium-up">
							<span>AMENITIES</span>
	                    </div>
	                    <div class="medium-10 columns">
							<?php echo $propertyAmenities; ?>
	                    </div>
	                </div>
	                <?php } ?>
	                
                </div>
                <!-- View Specification Section End -->
            </section>
            <!-- Property Summary Section End -->
            
            <!-- Rates Section Start -->
            <section id="rate-section">
	            <div class="row full-width text-center">
		            <div class="columns">
		            	Choose Your Level Of Service
		            	<?php if ($checkInDt && $checkOutDt) echo '<span>Travel Dates: '.date('m/d/Y', strtotime($checkInDt)).' - '.date('m/d/Y', strtotime($checkOutDt)).' <a data-reveal-id="propertyAvailabilityModal">Edit</a></span>'; ?>
		            </div>
	            </div>
	            
                <div class="row data-equalizer">
					<?php echo $propertyServiceLevels ?>
                </div>
            </section>
            <!-- Rates Section End -->
            
            <!-- Property Map Section Start -->
            <section id="property-map-section">
                <div class="text-center">
                    <section>
                        <div id="property-map"></div>
                    </section>
                </div>
            </section>
            <!-- Property Map Section End -->
			<?php require_once 'inc-footer.php'; ?>
			<?php require_once 'modal/property-interested.php'; ?>
			<?php require_once 'modal/property-availability.php'; ?>
			<?php require_once 'modal/property-share.php'; ?>
			<?php require_once 'inc-js.php'; ?>
    <script type="text/javascript">
	    <!--
    $(document).ready(function() {
        var $sync1 = $('#sync1'), // select the main carousel
            $sync2 = $('#sync2'), // select the thumbnail carousel
            flag = true,
            duration = 300;
            
        // gallery carousel main view
        $sync1.owlCarousel({
                items: 1,
                slideSpeed: 1000,
                nav: true,
                navText: ['<img src="img/home/arrow-left.png" style="position: absolute; top: 47%; left: 0;" class="show-for-large-up">', '<img src="img/home/arrow-right.png" style="position: absolute; top: 47%; right: 0;" class="show-for-large-up">'],
                loop: true,
                responsiveRefreshRate: 200,
                dots: false
            })
            .on('change.owl.carousel', function (e) {
                if (e.namespace && e.property.name == 'items' && !flag ) {
                    flag = true;
                    $sync2.trigger('to.owl.carousel', [e.item.index, duration, true]);
                    flag = false;
                }
            })
            .on('click', '.owl-next', function() {
				$sync2.trigger('next.owl.carousel')
		    })
		    .on('click', '.owl-prev', function() {
		        $sync2.trigger('prev.owl.carousel')
		    })
/*
	        .on('dragged.owl.carousel', function(e) {
	            if (e.relatedTarget.state.direction == 'left') {
	                $sync2.trigger('next.owl.carousel')
	            } else {
	                $sync2.trigger('prev.owl.carousel')
	            }
	        }
	    )
*/;
        // gallery thumbnail carousel
        $sync2.owlCarousel({
                items: 5,
                nav: false,
                dots: false,
                dotsEach: false,
                margin: 0,
                responsive: {
                    0: {
                        items: 6,
                        margin: 0
                    },
                    767: {items: 8},
                    1000: {items: 8}
                },
                responsiveRefreshRate: 100,
                margin: 2
            })
            .on('click', '.owl-item', function () {
                $sync1.trigger('to.owl.carousel', [$(this).index(), duration, true]);
            })
            .on('changed.owl.carousel', function (e) {
                if (!flag) {
                    flag = true;
                    $sync1.trigger('to.owl.carousel', [e.item.idex, duration, true]);
                    flag = false;
                }
            })
/*
            .on('click', '.owl-item', function() {
	            var i = $(this).index() - (thumbs + 1);
	            $sync2.trigger('to.owl.carousel', [i, duration, true]);
	            $sync1.trigger('to.owl.carousel', [i, duration, true]);
	        }
	    )
*/;
            
        $('#property-details-trigger .flip').click(function() {
            $('i', this).toggleClass('a fa-angle-double-down fa-2x a fa-angle-double-up fa-2x');
            $('span', this).toggleClass('clickText clickText2');
            $('#property-specifications').slideToggle('slow');
        });
        
        $('#propertyAvailabilityModalCheckInDt').datepicker({
			defaultDate: '+1d',
			minDate: '+1d',
			onClose: function(selectedDate)
			{
				if (selectedDate)
				{
					var nextDayDate = $(this).datepicker('getDate', '+3d');
					nextDayDate.setDate(nextDayDate.getDate() + 3);
					$('#propertyAvailabilityModalCheckOutDt').datepicker('option', 'minDate', nextDayDate);
				}
			}
		});
		
		$('#propertyAvailabilityModalCheckOutDt').datepicker({
			defaultDate: '+1d',
			minDate: '+1d'
		});
    });
    -->
    </script>
</body>

</html>
