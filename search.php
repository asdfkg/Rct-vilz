<?php
require_once '/kunden/homepages/27/d309616710/htdocs/private/config.php';

//if ($_SERVER['REQUEST_METHOD'] == 'POST') header('Location: /search/'.$_POST['destination'].'/'.strtolower(trim(preg_replace('/\s/', '-', preg_replace(array('/[^A-Za-z0-9]/', '/\s\s+/'), ' ', $_POST['keyword'])), '-')).'/');
if ($_SERVER['REQUEST_METHOD'] == 'POST') header('Location: /search/'.strtolower(trim(preg_replace('/\s/', '-', preg_replace(array('/[^A-Za-z0-9]/', '/\s\s+/'), ' ', $_POST['keyword'])), '-')).'/');

//$destination = $_GET['dest'];
$destination = 'all';

$rs_destination = $_SESSION['DB']->querySelect('SELECT * FROM destination WHERE UPPER(destName) = ? LIMIT 1', array(strtoupper($destination)));
$row_rs_destination = $_SESSION['DB']->queryResult($rs_destination);
$totalRows_rs_destination = $_SESSION['DB']->queryCount($rs_destination);

//if (!$totalRows_rs_destination) header('Location: /luxury-rental-property-vacation-destinations');

$propertyArray = $_SESSION['RESERVATION']->getProperty($destination=='all'?'':$destination, '', '', 0, 0, 0, 0, 0, $_GET['keyword'], '', 1);
$villaCtr = 0;
$villaCtr = count($propertyArray);
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
                <img src="img/destination-header_<?php echo str_replace('-', '_', $destination); ?>.png">
                <div class="row">
                    <div class="small-12 columns">
                        <h1><?php echo 'LUXURY '.strtoupper($destination).' RENTALS | '.strtoupper($destination).' VILLA & LUXURY HOME VACATION RENTALS'; ?></h1>
                        <p>Out of over 100 vacation villas, Villazzo President Christian Jagodzinkski has personally hand-selected only the finest 10 properties between the beaches of Ramatuelle, Gassin, and the St. Tropez peninsula.</p>
                    </div>
                </div>
            </section>
            <!-- Start Destination Results Start-->
            <section id="destination-results">
	            <div class="row">
	                <div class="columns">
	                    <p class="property-results-top-titles"><?php echo number_format($villaCtr); ?> VILLAS MATCH YOUR SEARCH FOR '<?php echo strtoupper(str_replace('-', ' ', $_GET['keyword'])); ?>'.</p>
	                </div>
	            </div>
                <div class="row text-center"><?php echo $villas; ?></div>
            </section>
            <!-- Start Destination Results End-->
            <!-- Destination End -->
        <?php require_once 'inc-footer.php'; ?>
		
		<?php require_once 'inc-js.php'; ?>
</body>

</html>