<?php
require_once '/kunden/homepages/27/d309616710/htdocs/private/config.php';

// get the destination information
$destination = $_GET['dest'];

$rs_destination = $_SESSION['DB']->querySelect('SELECT * FROM destination WHERE UPPER(destName) = ? LIMIT 1', array(strtoupper($destination)));
$row_rs_destination = $_SESSION['DB']->queryResult($rs_destination);
$totalRows_rs_destination = $_SESSION['DB']->queryCount($rs_destination);

if (!$totalRows_rs_destination) header('Location: /luxury-rental-property-vacation-destinations');

if ($destination == 'aspen') $destinationDesc = 'Out of dozens of Aspen vacation homes, Villazzo President Christian Jagodzinski has personally hand-selected only the finest 10 properties between Snowmass and Aspen. His strict selection is based on his own demanding criteria for privacy, amenities, décor, ambience, and design. Most properties simply do not qualify - they are either antiquated, poorly maintained or poorly furnished. Below are the only vacation homes in the Aspen area worthy of the Villazzo label.';
else if ($destination == 'miami') $destinationDesc = 'Out of over 100 rental properties, Villazzo President Christian Jagodzinski has personally hand-selected only the finest 10 properties in Miami and Miami Beach. His strict selection is based on his own demanding criteria for privacy, amenities, décor, ambience, and design. Most properties do not qualify- they are either antiquated, poorly maintained or poorly furnished.  Below are the only luxury rentals in Miami and Miami Beach worthy of the Villazzo label.';
else if ($destination == 'saint-tropez') $destinationDesc = 'Out of over 100 vacation villas, Villazzo President Christian Jagodzinski has personally hand-selected only the finest 10 properties between the beaches of Ramatuelle, Gassin, and the St. Tropez peninsula. His strict selection is based on his own demanding criteria for privacy, amenities, décor, ambience, and design. Most properties simply do not qualify - they are either antiquated, poorly maintained or poorly furnished. Below are the most exclusive luxury villas for rent in St Tropez worthy of the Villazzo label.';

$propertyArray = $_SESSION['RESERVATION']->getProperty($destination=='all'?'':$destination, '', '', 0, 0, 0, 0, 0, '', '', 1);
$villas = NULL;
$villas = $_SESSION['RESERVATION']->formatProperty($propertyArray);
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title><?php echo $row_rs_destination['destMetaTitle']; ?></title>
	<meta name="Description" content="<?php echo $row_rs_destination['destMetaDesc']; ?>" />
	<meta name="Keywords" content="<?php echo $row_rs_destination['destMetaKeywords']; ?>" />
    <link rel="stylesheet" href="/css/custom.css">
    <script src="/js/vendor/modernizr.js"></script>
</head>

<body>
	<?php require_once 'inc-header.php'; ?>
    <!-- Destination Start -->
    <section id="destination-header-image">
        <img alt="Villa Rentals" src="img/destination-header_<?php echo str_replace('-', '_', $destination); ?>.png">
        <div class="row">
            <div class="small-12 columns">
                <h1><?php echo 'LUXURY '.strtoupper($destination).' VILLA & HOME VACATION RENTALS'; ?></h1>
                <p><?php echo $destinationDesc; ?></p>
            </div>
        </div>
    </section>
    <!-- Start Destination Results Start-->
    <section id="destination-results">
        <div class="row text-center"><?php echo $villas; ?></div>
    </section>
    <!-- Start Destination Results End-->
    <!-- Destination End -->
    <!-- More Section Start -->
    <section id="more-section" class="visible-for-small-only">
        <div class="row text-center">
            <div class="small-12 small-centered columns">
                <a href="#"><span class="text-center">MORE</span></a>
            </div>
        </div>
    </section>
    <!-- More Section End -->
	<?php require_once 'inc-footer.php'; ?>
	
	<?php require_once 'inc-js.php'; ?>
	<script>
	// disable equalization for mobile
	$(window).on('load resize', function(e)
	{
		var equalize = true;
		if ($(document).width() <= 640) equalize = false;
		$(document).foundation({ equalizer : { equalize_on_stack: equalize }});  
	});
	</script>
</body>

</html>