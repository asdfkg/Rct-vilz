<?php
require_once '../private/config.php';

if ($_SESSION['RESERVATION']->get('reservationId')) $_SESSION['RESERVATION'] = new Reservation();

$_SESSION['RESERVATION']->set('step', 1);

if (isset($_POST['action']) && $_POST['action'] == 'reservation') die(header('Location: ?dest='.$_POST['dest'].'&check_in='.date('m/d/Y', strtotime($_POST['checkInDt'])).'&check_out='.date('m/d/Y', strtotime($_POST['checkOutDt'])).'&bed_min='.$_POST['bedMin'].'&bed_max='.$_POST['bedMax'].'&budget_min='.$_POST['budgetMin'].'&budget_max='.$_POST['budgetMax'].'&amenities='.$_POST['amenities']));

//if (!isset($_GET['dest'])) header('Location: ?dest='.($_SESSION['RESERVATION']->get('destName')?$_SESSION['RESERVATION']->get('destName'):'all').'&check_in='.($_SESSION['RESERVATION']->get('checkInDt')?date('m/d/Y', strtotime($_SESSION['RESERVATION']->get('checkInDt'))):date('m/d/Y')).'&check_out='.($_SESSION['RESERVATION']->get('checkOutDt')?date('m/d/Y', strtotime($_SESSION['RESERVATION']->get('checkOutDt'))):date('m/d/Y', strtotime('+3 days'))));

if (!isset($_GET['dest'])) die(header('Location: ?dest=all&check_in='.date('m/d/Y',strtotime('+7 days')).'&check_out='.date('m/d/Y', strtotime('+14 days'))));

$destination = $_GET['dest']=='all'?NULL:$_GET['dest'];
$checkInDt = $_GET['check_in'];
$checkOutDt = $_GET['check_out'];
$bedMin = isset($_GET['bed_min'])?$_GET['bed_min']:NULL;
$bedMax = isset($_GET['bed_max'])?$_GET['bed_max']:NULL;
$budgetMin = isset($_GET['budget_min'])?$_GET['budget_min']:NULL;
$budgetMax = isset($_GET['budget_max'])?$_GET['budget_max']:NULL;
$amenities = isset($_GET['amenities'])?$_GET['amenities']:NULL;

/*
$_SESSION['RESERVATION']->set('destName', $destination);
$_SESSION['RESERVATION']->set('checkInDt', date('Y-m-d', strtotime($checkInDt)));
$_SESSION['RESERVATION']->set('checkOutDt', date('Y-m-d', strtotime($checkOutDt)));
$_SESSION['RESERVATION']->set('bedroomMin', $bed);
*/

if ($destination == 'all') $rs_destination = $_SESSION['DB']->querySelect('SELECT * FROM destination LIMIT 1');
else $rs_destination = $_SESSION['DB']->querySelect('SELECT * FROM destination WHERE UPPER(destName) = ? LIMIT 1', array(strtoupper($destination)));
$row_rs_destination = $_SESSION['DB']->queryResult($rs_destination);
$totalRows_rs_destination = $_SESSION['DB']->queryCount($rs_destination);

$propertyArray = $_SESSION['RESERVATION']->getProperty($destination, $checkInDt, $checkOutDt, $bedMin, $bedMax, $budgetMin, $budgetMax, '', '', $amenities, 1);
$villaCtr = 0;
$villaCtr = count($propertyArray);
$villas = NULL;
$villas = $_SESSION['RESERVATION']->formatProperty($propertyArray);
print_r($villas);exit;
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Reservations - VILLAZZO</title>
    <link rel="stylesheet" href="/villazzo_new/css/custom.css">
    <link rel="stylesheet" href="/villazzo_new/css/reservations.css">
    <script src="/villazzo_new/js/vendor/modernizr.js"></script>
</head>

<body>
	<?php require_once '../inc-header.php'; ?>
        <!-- Contact Us Header Image Section Start -->
        <section id="header-section">
            <img src="/villazzo_new/img/destination-header_<?php echo str_replace('-', '_', $_GET['dest']); ?>.png">
        </section>
        <!-- Contact Us Header Image Section End -->
        <?php require_once 'inc-reservation.php'; ?>
        <!-- Reservations Title and Steps Section Start -->
        <section id="reservations-title-steps-section">
            <div class="row">
                <div class="medium-5 columns">
                    <h1>RESERVATIONS</h1>
                </div>
                <div class="medium-7 columns">
                    <div class="row text-center">
                        <div class="small-12 columns">
                            <ul id="progressbar">
                                <li class="active">Select Your<br>Villa</li>
                                <li>Customize Your<br>Service Experience</li>
                                <li>Contact And<br>Payment Information</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Reservations Title and Steps Section End -->
        <!-- Start Destination Results Start-->
        <section id="destination-results">
            <div class="row">
                <div class="columns">
                    <p class="property-results-top-titles"><?php echo number_format($villaCtr); ?> VILLAS</p>
                </div>
            </div>
            <div class="row text-center">
                <?php echo $villas; ?>
            </div>
        </section>
        <!-- Start Destination Results End-->
        <!-- SubFooter Section End -->
    <?php require_once '../inc-footer.php'; ?>
	
	<?php require_once '../inc-js.php'; ?>
    <script type="text/javascript">
    $(function() {
        $('.filtersBtn').click(function() {
            $('.filtersPanel').slideToggle('slow');
        });
		$('#bedroomsSlider').slider({
			range: true,
			min: 4,
			max: 8,
			step: 1,
			<?php if ($bedMin && $bedMax) echo 'values: ['.$bedMin.', '.$bedMax.'],'; else echo 'values: [4, 8],'; ?>
			animate: 'fast'
		});
        $('#budgetSlider').slider({
			range: true,
	        min: 0,
	        max: 10000,
	        step: 2500,
	        <?php if ($budgetMin && $budgetMax) echo 'values: ['.$budgetMin.', '.$budgetMax.'],'; else echo 'values: [0, 10000],'; ?>
	        animate: 'fast'
		});
		$('.rangeSlider').slider({
			change: function(event, ui)
			{
				var bedroomRange = $('#bedroomsSlider').slider('values');
				var budgetRange = $('#budgetSlider').slider('values');
				$('#bedMin').val(bedroomRange[0]);
				$('#bedMax').val(bedroomRange[1]);
				$('#budgetMin').val(budgetRange[0]);
				$('#budgetMax').val(budgetRange[1]);
			}
		});
		
		var amenitiesArray = [<?php echo (isset($_GET['amenities'])?$_GET['amenities']:''); ?>];
		$('.amenities').click(function() {
			if ($(this).is(':checked')) amenitiesArray.push($(this).val());
			else amenitiesArray.pop($(this).val());
			$('#amenities').val(amenitiesArray.join(','));
		});
    });
    
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