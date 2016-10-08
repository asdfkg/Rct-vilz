<?php
require_once '../private/config.php';

if ($_SESSION['RESERVATION']->get('step') == 4) die(header('Location: /reservations'));

//if (!isset($_SESSION['RESERVATION']) || $_SESSION['RESERVATION']->get('reservationId')) $_SESSION['RESERVATION'] = new Reservation();

$_SESSION['RESERVATION']->set('step', 2);

if (!isset($_GET['property'])) header('Location: /reservations');

$rs_property = $_SESSION['DB']->querySelect('SELECT propertyId FROM property LEFT JOIN destination ON destination.destId=property.destId WHERE UPPER(propertyName) = ? LIMIT 1', array(str_replace('-', ' ', strtoupper($_GET['property']))));
$row_rs_property = $_SESSION['DB']->queryResult($rs_property);

$totalRows_rs_property = $_SESSION['DB']->queryCount($rs_property);

$level = (isset($_GET['level'])?$_GET['level']:($_SESSION['RESERVATION']->get('serviceLevel')?$_SESSION['RESERVATION']->get('serviceLevel'):NULL));
$checkInDt = (isset($_GET['check_in'])?$_GET['check_in']:NULL);
$checkOutDt = (isset($_GET['check_out'])?$_GET['check_out']:NULL);

$property = $_SESSION['RESERVATION']->getProperty('', $checkInDt, $checkOutDt, 0, 0, 0, 0, $row_rs_property['propertyId']);
// echo "<pre>"; print_r($property[0]);die;
$propertyArray = $property[0];
if ($propertyArray['night_total'] < 3) header('Location: /reservations');

$additionalServiceTags = array();
if ($_SESSION['RESERVATION']->get('additionalServicesTags')) $additionalServiceTags = $_SESSION['RESERVATION']->get('additionalServicesTags');

$serviceLevelsArray = $propertyArray['service_levels'];

// service levels
$propertyServiceLevelsTab = '
<div class="row">
	<div class="columns">
		<ul class="tabs" data-tab>';
		
$propertyServiceLevelsContent = '
<div class="row">
	<div class="columns">
		<div class="tabs-content">';
		
$propertyServiceLevelsOptions = '';

foreach ($serviceLevelsArray as $serviceLevels)
{
	//echo "<pre>"; print_r($serviceLevels);die;
	if($serviceLevels['level']!=0 || $propertyArray['night_total'] >= 30){
	$propertyServiceLevelsTab .= '<li class="tab-title'.($serviceLevels['level']==($level?$level:3)?' active':'').($serviceLevels['level']==0?' hide-for-small':'').'"><a href="#service-level-'.$serviceLevels['level'].'">';

    for ($i = 0; $i < $serviceLevels['level']; $i ++) $propertyServiceLevelsTab .= '<i class="fa fa-star hide-for-small"></i>';
	$propertyServiceLevelsTab .= strtoupper($serviceLevels['name']).'</a></li>';
	        
    if (!empty($serviceLevels['services']))
    {
        $propertyServiceLevelsContent .= '
        <div class="content'.($serviceLevels['level']==($level?$level:3)?' active':'').'" id="service-level-'.$serviceLevels['level'].'">
			<div class="services">';
		
        foreach ($serviceLevels['services'] as $servicelevel)
		{
			$propertyServiceLevelsContent .= '
						<div class="row service">
		                    <div class="small-6 columns">
		                        <p class="text-left">'.$servicelevel['desc'].'</p>
		                    </div>
		                    <div class="small-6 columns">
		                        <p class="text-right">'.$propertyArray['dest_currency'].number_format($servicelevel['rate']).'</p>
		                    </div>
		                </div>';
		}
		$propertyServiceLevelsContent .= '
				<div class="row total">
	                <div class="columns">
	                    <p class="text-right">'.($serviceLevels['level']>0?'As '.$serviceLevels['level'].' Star VillaHotel<br>':'').'Nightly Rate: '.$propertyArray['dest_currency'].number_format($serviceLevels['night']).'</p>
	                </div>
	            </div>
	        </div>';
		
		if ($serviceLevels['level'] > 0) $propertyServiceLevelsContent .= '
		<div class="options">
			<form method="post" action="/reservations/checkout" onsubmit="return false;">
				<input type="hidden" name="action" value="checkout">
				<input type="hidden" name="propertyId" value="'.$propertyArray['property_id'].'">
				<input type="hidden" name="propertyName" value="'.$propertyArray['property_name'].'">
				<input type="hidden" name="destName" value="'.$propertyArray['dest_name'].'">
				<input type="hidden" name="checkInDt" value="'.$propertyArray['check_in_dt'].'">
				<input type="hidden" name="checkOutDt" value="'.$propertyArray['check_out_dt'].'">
				<input type="hidden" name="nightTotal" value="'.$propertyArray['night_total'].'">
				<input type="hidden" name="serviceLevel" value="'.$serviceLevels['level'].'">
				<input type="hidden" name="destCurrency" value="'.$propertyArray['dest_currency'].'">
				<input type="hidden" name="destTax" value="'.$propertyArray['dest_tax'].'">
				<input type="hidden" name="rateNight" value="'.$serviceLevels['night'].'">
				<div class="row text-center header">
		            <div class="columns">
		                <h5>Customize Your Experience</h5>
		            </div>
		        </div>
		        
		        <div class="row option">
		            <div class="columns">
		                <div class="row collapse" data-equalizer>
		                    <div class="medium-1 columns hide-for-small" data-equalizer-watch>
		                        <img src="/img/reservations/services/icons/babysitting.png">
		                    </div>
		                    <div class="small-12 medium-3 columns" data-equalizer-watch>
		                        <h5>Babysitting</h5>
		                    </div>
		                    <div class="medium-8 columns right-side" data-equalizer-watch>
		                        <div class="row text-left">
		                            <div class="columns">
		                                <p>Knowing your children are in expert hands will assure you make the most out of your vacation. All our babysitters are certified experts.</p>
		                            </div>
		                        </div>
		                        <div class="row text-left">
		                            <div class="small-1 columns">
		                                <input name="additionalServices[]" id="additionalServicesBabysitting1" value="baby_sitting|Licensed Babysitter during your stay ['.$propertyArray['dest_currency'].'39 per hour]" type="checkbox" '.(in_array('baby_sitting', $additionalServiceTags)?'checked':'').'>
		                            </div>
		                            <div class="small-11 columns">
		                                <label for="additionalServicesBabysitting1">Licensed Babysitter during your stay ['.$propertyArray['dest_currency'].'39 per hour]</label>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
				
				
				
		        <div class="row option">
		            <div class="columns">
		                <div class="row collapse" data-equalizer>
		                    <div class="medium-1 columns hide-for-small" data-equalizer-watch>
		                        <img src="/img/reservations/services/icons/shopper.png">
		                    </div>
		                    <div class="small-12 medium-3 columns" data-equalizer-watch>
		                        <h5>Pre-arrival Shopping</h5>
		                    </div>
		                    <div class="medium-8 columns right-side" data-equalizer-watch>
		                        <div class="row text-left">
		                            <div class="columns">
		                                <p>Your Butler will pre-purchase items for you such as groceries prior to your arrival. This service is included in 4 star and 5 star rates.</p>
		                            </div>
		                        </div>
		                        <div class="row text-left">
		                            <div class="small-1 columns">
		                                <input name="additionalServices[]" id="additionalServicesShopper1" value="Personal_Shopping|I would like to learn more about pre-arrival shopping." type="checkbox" '.(in_array('personal_shopping', $additionalServiceTags)?'checked':'').'>
		                            </div>
		                            <div class="small-11 columns">
		                                <label for="additionalServicesShopper1">I would like to learn more about pre-arrival shopping.</label>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
				
				
		        <div class="row option">
		            <div class="columns">
		                <div class="row collapse" data-equalizer>
		                    <div class="medium-1 columns hide-for-small" data-equalizer-watch>
		                        <img src="/img/reservations/services/icons/security.png">
		                    </div>
		                    <div class="small-10 medium-3 columns" data-equalizer-watch>
		                        <h5>Security</h5>
		                    </div>
		                    <div class="medium-8 columns right-side" data-equalizer-watch>
		                        <div class="row text-left">
		                            <div class="columns">
		                                <p>Specially trained and licensed security staff protect you against theft, offensive crowd, or paparazzi.</p>
		                            </div>
		                        </div>
		                        <div class="row text-left">
		                            <div class="small-1 columns">
		                                <input name="additionalServices[]" id="additionalServicesSecurity1" value="unarmed_security|Unarmed Security ['.$propertyArray['dest_currency'].'59 per hr]" type="checkbox" '.(in_array('unarmed_security', $additionalServiceTags)?'checked':'').'>
		                            </div>
		                            <div class="small-11 columns">
		                                <label for="additionalServicesSecurity1">Unarmed Security ['.$propertyArray['dest_currency'].'59 per hr]</label>
		                            </div>
		                        </div>
								<div class="row text-left">
		                            <div class="small-1 columns">
		                                <input name="additionalServices[]" id="additionalServicesSecurity2" value="armed_security|Armed Security ['.$propertyArray['dest_currency'].'99 per hr]" type="checkbox" '.(in_array('armed_security', $additionalServiceTags)?'checked':'').'>
		                            </div>
		                            <div class="small-11 columns">
		                                <label for="additionalServicesSecurity2">Armed Security ['.$propertyArray['dest_currency'].'99 per hr]</label>
		                            </div>
		                        </div>
								<div class="row text-left">
		                            <div class="small-1 columns">
		                                <input name="additionalServices[]" id="additionalServicesSecurity3" value="armed_security_canine|Armed Security with canine protection (charged at a premium cost)" type="checkbox" '.(in_array('armed_security_canine', $additionalServiceTags)?'checked':'').'>
		                            </div>
		                            <div class="small-11 columns">
		                                <label for="additionalServicesSecurity3">Armed Security with canine protection (charged at a premium cost)</label>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		        
		        <div class="row option">
		            <div class="columns">
		                <div class="row collapse" data-equalizer>
		                    <div class="medium-1 columns hide-for-small" data-equalizer-watch>
		                        <img src="/img/reservations/services/icons/transportation.png">
		                    </div>
		                    <div class="small-10 medium-3 columns" data-equalizer-watch>
		                        <h5>Transportation</h5>
		                    </div>
		                    <div class="medium-8 columns right-side" data-equalizer-watch>
		                        <div class="row text-left">
		                            <div class="columns">
		                                <p>Villazzo can take care of all of your transportation needs, ranging from airport transfers to licensed limousine drivers that will shuttle you around town.  We offer Cadillac Escalades or Mercedes S Class – or any other car of your preference upon request.</p>
		                            </div>
		                        </div>
		                        <div class="row text-left">
		                            <div class="small-1 columns">
		                                <input name="additionalServices[]" id="additionalServicesTransportation1" value="airport_transfer|Please provide me Airport Transfer options." type="checkbox" '.(in_array('airport_transfer', $additionalServiceTags)?'checked':'').'>
		                            </div>
		                            <div class="small-11 columns">
		                                <label for="additionalServicesTransportation1">Please provide me Airport Transfer options.</label>
		                            </div>
		                        </div>
		                        <div class="row text-left">
		                            <div class="small-1 columns">
		                                <input name="additionalServices[]" id="additionalServicesTransportation2" value="chauffeured_limo|Please provide me Chauffeured Limousine/Driver options." type="checkbox" '.(in_array('chauffeured_limo', $additionalServiceTags)?'checked':'').'>
		                            </div>
		                            <div class="small-11 columns">
		                                <label for="additionalServicesTransportation2">Please provide me Chauffeured Limousine/Driver options.</label>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		        
		        <div class="row option">
		            <div class="columns">
		                <div class="row collapse" data-equalizer>
		                    <div class="medium-1 columns hide-for-small" data-equalizer-watch>
		                        <img src="/img/reservations/services/icons/charter.png">
		                    </div>
		                    <div class="small-10 medium-3 columns" data-equalizer-watch>
		                        <h5>Luxury Car Rental / Yacht Charter</h5>
		                    </div>
		                    <div class="medium-8 columns right-side" data-equalizer-watch>
		                        <div class="row text-left">
		                            <div class="columns">
		                                <p>Your butler will gladly arrange any car rentals or yacht charters for you before arrival or during your stay.</p>
		                            </div>
		                        </div>
		                        <div class="row text-left">
		                            <div class="small-1 columns">
		                                <input name="additionalServices[]" id="additionalServicesCharter1" value="car_rental|Please provide me car rental options." type="checkbox" '.(in_array('car_rental', $additionalServiceTags)?'checked':'').'>
		                            </div>
		                            <div class="small-11 columns">
		                                <label for="additionalServicesCharter1">Please provide me car rental options.</label>
		                            </div>
		                        </div>
								<div class="row text-left">
		                            <div class="small-1 columns">
		                                <input name="additionalServices[]" id="additionalServicesCharter2" value="yacht_charter|Please provide me yacht charter options." type="checkbox" '.(in_array('yacht_charter', $additionalServiceTags)?'checked':'').'>
		                            </div>
		                            <div class="small-11 columns">
		                                <label for="additionalServicesCharter2">Please provide me yacht charter options.</label>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		        
		        <div class="row option">
		            <div class="columns">
		                <div class="row collapse" data-equalizer>
		                    <div class="medium-1 columns hide-for-small" data-equalizer-watch>
		                        <img src="/img/reservations/services/icons/spa.png">
		                    </div>
		                    <div class="small-10 medium-3 columns" data-equalizer-watch>
		                        <h5>Spa at Home</h5>
		                    </div>
		                    <div class="medium-8 columns right-side" data-equalizer-watch>
		                        <div class="row text-left">
		                            <div class="columns">
		                                <p>Relieve any arrival stress with a massage upon arrival or at any other time during your stay.</p>
		                            </div>
		                        </div>
		                        <div class="row text-left">
		                            <div class="small-1 columns">
		                                <input name="additionalServices[]" id="additionalServicesSpa1" value="massage_swedish|Relaxing Swedish Massage ['.$propertyArray['dest_currency'].'200]" type="checkbox" '.(in_array('massage_swedish', $additionalServiceTags)?'checked':'').'>
		                            </div>
		                            <div class="small-11 columns">
		                                <label for="additionalServicesSpa1">Relaxing Swedish Massage ['.$propertyArray['dest_currency'].'200]</label>
		                            </div>
		                        </div>
								<div class="row text-left">
		                            <div class="small-1 columns">
		                                <input name="additionalServices[]" id="additionalServicesSpa2" value="massage_tissue|Deep Tissue Massage ['.$propertyArray['dest_currency'].'200]" type="checkbox" '.(in_array('massage_tissue', $additionalServiceTags)?'checked':'').'>
		                            </div>
		                            <div class="small-11 columns">
		                                <label for="additionalServicesSpa2">Deep Tissue Massage ['.$propertyArray['dest_currency'].'200]</label>
		                            </div>
		                        </div>
								<div class="row text-left">
		                            <div class="small-1 columns">
		                                <input name="additionalServices[]" id="additionalServicesSpa3" value="massage_aroma|Aromatherapy Massage ['.$propertyArray['dest_currency'].'200]" type="checkbox" '.(in_array('massage_aroma', $additionalServiceTags)?'checked':'').'>
		                            </div>
		                            <div class="small-11 columns">
		                                <label for="additionalServicesSpa3">Aromatherapy Massage ['.$propertyArray['dest_currency'].'200]</label>
		                            </div>
		                        </div>
		                        <div class="row text-left">
		                            <div class="small-1 columns">
		                                <input name="additionalServices[]" id="additionalServicesSpa4" value="mani_pedi|Manicure / Pedicure ['.$propertyArray['dest_currency'].'120]" type="checkbox" '.(in_array('mani_pedi', $additionalServiceTags)?'checked':'').'>
		                            </div>
		                            <div class="small-11 columns">
		                                <label for="additionalServicesSpa4">Manicure / Pedicure ['.$propertyArray['dest_currency'].'120]</label>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		        
		        <div class="row option">
		            <div class="columns">
		                <div class="row collapse" data-equalizer>
		                    <div class="medium-1 columns hide-for-small" data-equalizer-watch>
		                        <img src="/img/reservations/services/icons/cleaning.png">
		                    </div>
		                    <div class="medium-3 columns" data-equalizer-watch>
		                        <h5>Check Out Cleaning</h5>
		                    </div>
		                    <div class="medium-8 columns right-side" data-equalizer-watch>
		                        <div class="row text-left">
		                            <div class="columns">
		                                <p>A check-out cleaning fee of $750 will be charged for 3 star VillaHotel stays, the check out cleaning fee is included in 4 star and 5 star VillaHotel rate.</p>
		                            </div>
		                        </div>
		                        
		                        
		                    </div>
		                </div>
		            </div>
		        </div>
				
				<div class="row total">
		            <div class="columns">
		                <p class="text-right">'.($serviceLevels['level']>0?'As '.$serviceLevels['level'].' Star VillaHotel<br>':'').'Nightly Rate: '.$propertyArray['dest_currency'].number_format($serviceLevels['night']).'
						<br><br><button class="tiny" onclick="this.form.submit();">CHECKOUT</button></p>
		        	</div>
		    	</div>
		    </form>
	    </div>';
    	
    	$propertyServiceLevelsContent .= '</div>';
	}
}}

$propertyServiceLevelsContent .= '
					</div>
				</div>
			</div>';

$propertyServiceLevelsTab .= '
		</ul>
	</div>
</div>';
/*
if (isset($_POST['action']) && $_POST['action'] == 'book')
{
	$_SESSION['RESERVATION']->set('destName', $_POST['destName']);
	$_SESSION['RESERVATION']->set('checkInDt', date('Y-m-d', strtotime($_POST['checkInDt'])));
	$_SESSION['RESERVATION']->set('checkOutDt', date('Y-m-d', strtotime($_POST['checkOutDt'])));
	$_SESSION['RESERVATION']->set('totalNights', $_POST['totalNights']);
	$_SESSION['RESERVATION']->set('destCurrency', $_POST['destCurrency']);
	$_SESSION['RESERVATION']->set('rateNight', $_POST['rateNight']);
	$_SESSION['RESERVATION']->set('rateTotal', $_POST['rateTotal']);
	
	header('Location: services');
}
*/
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Services - VILLAZZO</title>
    <link rel="stylesheet" href="../css/custom.css">
    <script src="../js/vendor/modernizr.js"></script>
</head>

<body>
	<?php require_once '../inc-header.php'; ?>
    <!-- Reservations Services Header Image Section Start -->
    <section id="header-section">
        <img src="/img/destination-header_<?php echo str_replace('-', '_', $propertyArray['dest_name']); ?>.png">
    </section>
    <!-- Reservations Title and Steps Section Start -->
    <section id="reservations-title-steps-section">
        <div class="row" id="steps">
            <div class="columns">
                <div class="row">
                    <div class="medium-5 columns">
                        <h1>RESERVATIONS</h1>
                    </div>
                    <div class="medium-7 columns">
                        <div class="row text-center">
                            <div class="columns">
                                <ul id="progressbar">
                                	<li class="active" onclick="location.href = './';">Select Your<br>Villa</li>
                                    <li class="active">Customize Your<br>Service Experience</li>
                                    <li>Contact And<br>Payment Information</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Reservations Title and Steps Section End -->
        
    <!-- Reservations Services Header Image Section Start -->
    <section id="reservations-services-section">
        <div class="row" id="your-selection" data-equalizer>
            <div class="large-2 columns left-side show-for-large-up text-center" data-equalizer-watch>
                <h6>Your<br>Selection</h6>
            </div>
            <div class="medium-10 columns right-side text-center" data-equalizer-watch>
                <div class="row">
                    <div class="medium-3 columns">
                        Destination
                        <br><span><?php echo $propertyArray['property_name']; ?></span>
                    </div>
                    <div class="medium-3 columns">
                        Check-In Date
                        <br><span><?php echo date('F jS, Y', strtotime($propertyArray['check_in_dt'])); ?></span>
                    </div>
                    <div class="medium-3 columns">
                        Check-Out Date
                        <br><span><?php echo date('F jS, Y', strtotime($propertyArray['check_out_dt'])); ?></span>
                    </div>
                    <div class="medium-3 columns">
                        Length Of Stay
                        <br><span><?php echo $propertyArray['night_total']; ?> Nights</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Show Rate Details Start -->
        <div id="service-levels">
			<?php echo $propertyServiceLevelsTab; ?>
        </div>	
        <div id="rate-details">
            <?php echo $propertyServiceLevelsContent; ?>
        </div>
        <!-- Show Rate Details End -->
    </section>
    <?php require_once '../inc-footer.php'; ?>
	
	<?php require_once '../inc-js.php'; ?>
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