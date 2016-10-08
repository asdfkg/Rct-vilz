<?php
require_once '/kunden/homepages/27/d309616710/htdocs/private/config.php';

$_SESSION['RESERVATION']->set('step', 4);

if ($_SESSION['RESERVATION']->get('reservationId'))
{
	if ($_SESSION['USER']->getUserGroupId() == 3)
	{
		$body = '
		<div style="padding:15px; border:solid 1px #DBDBDB;">
		<p style="font-weight:bold;">Villazzo Reservation: '.$row_rs_reservation_property['propertyName'].', '.$row_rs_reservation_property['destName'].'</p>
			<table width="100%" border="0" cellpadding="2" cellspacing="0">
	          <tr>
	            <td style="width:150px;"><strong>Booked by</strong></td>
	            <td>Property Owner</td>
	          </tr>
	          <tr>
	            <td>&nbsp;</td>
	            <td>&nbsp;</td>
	          </tr>
	          <tr>
	            <td style="width:150px;"><strong>Check-in date</strong></td>
	            <td>'.$_SESSION['UTILITY']->dateInvoice($row_rs_reservation_property['reservationStartDt']).'</td>
	          </tr>
	          <tr>
	            <td><strong>Check-out date</strong></td>
	            <td>'.$_SESSION['UTILITY']->dateInvoice($row_rs_reservation_property['reservationEndDt']).'</td>
	          </tr>
	        </table>
			</div>';
	}
	else
	{
		$body = $_SESSION['RESERVATION']->createReceipt($_SESSION['RESERVATION']->get('reservationId'));
	}
	
	// reset reservation
	//$_SESSION['RESERVATION'] = new Reservation();
}
else $body = 'An error occurred, please try again.';
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Confirmation - VILLAZZO</title>
    <link rel="stylesheet" href="/css/custom.css">
    <script src="/js/vendor/modernizr.js"></script>
</head>

<body>
	<?php require_once '../inc-header.php'; ?>
    <!-- Reservations Services Header Image Section Start -->
    <section id="header-section">
        <img src="/img/destination-header_<?php echo str_replace('-', '_', $_SESSION['RESERVATION']->get('destName')); ?>.png">
    </section>
    <!-- Reservations Title and Steps Section Start -->
    <section id="reservations-title-steps-section">
        <div class="row">
            <div class="small-12 columns white-background">
                <div class="row">
                    <div class="medium-5 columns">
                        <h1>RESERVATIONS</h1>
                    </div>
                    <div class="medium-7 columns">
                        <div class="row text-center">
                            <div class="small-12 columns">
                                <ul id="progressbar">
                                    <li class="active">Select Your<br>Villa</li>
                                    <li class="active">Customize Your<br>Service Experience</li>
                                    <li class="active">Contact And<br>Payment Information</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section>
	    <div class="row">
	        <div class="columns">
				<?php echo $body; ?>
	        </div>
	    </div>
    </section>
    
<?php require_once '../inc-footer.php'; ?>

<?php require_once '../inc-js.php'; ?>
		
</body>

</html>
