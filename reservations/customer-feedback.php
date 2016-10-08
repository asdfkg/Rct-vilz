<?php
require_once '/kunden/homepages/27/d309616710/htdocs/private/config.php';

// restrict user access
//$_SESSION['USER']->restrict('1,2,4');

$feedback = '';

$rs_reservationProperty = $_SESSION['DB']->querySelect('SELECT *, reservationProperty.reservationId, property.propertyId FROM reservationProperty LEFT JOIN property ON property.propertyId = reservationProperty.propertyId LEFT JOIN reservationFeedback ON reservationFeedback.reservationId = reservationProperty.reservationId WHERE reservationProperty.reservationId = ? LIMIT 1', array(base64_decode(strtr($_GET['reservation'], '-_', '+/').'==')));
$row_rs_reservationProperty = $_SESSION['DB']->queryResult($rs_reservationProperty);
$totalRows_rs_reservationProperty = $_SESSION['DB']->queryCount($rs_reservationProperty);

if (!$totalRows_rs_reservationProperty || $row_rs_reservationProperty['reservationFeedbackId']) header("Location: /");

if (isset($_POST['action']) && $_POST['action'] == 'feedback')
{	
	if ($_SESSION['DB']->queryInsert('INSERT INTO reservationFeedback (reservationId, propertyId, reservationFeedbackRating, reservationFeedbackComment, reservationFeedbackKeepMeInformed) VALUES (?, ?, ?, ?, ?)', array($row_rs_reservationProperty['reservationId'], $row_rs_reservationProperty['propertyId'], $_POST['rating'], $_POST['comment'], ($_POST['keepMeInformed']?1:0))))
	{
		// email feedback
		$from = array($row_rs_reservationProperty['reservationEmail'], $row_rs_reservationProperty['reservationFirstname'].' '.$row_rs_reservationProperty['reservationLastname']);
		$to = array($_SESSION['SETTING']->getCompanyEmail());
		$subject = 'Reservation Feedback: '.$row_rs_reservationProperty['propertyName'];
		$message = '<p>'.$row_rs_reservationProperty['reservationFirstname'].' '.$row_rs_reservationProperty['reservationLastname'].' rated '.$row_rs_reservationProperty['propertyName'].' a rating of '.$_POST['rating'].' and wrote the following feedback:<br><br>'.$_POST['comment'].'<br><br>'.($_POST['keepMeInformed']?$_POST['keepMeInformed']:'').'</p>';
		$body = file_get_contents(EMAILS_PATH.'main.html');
		$body = str_replace('#MESSAGE#', $message, $body);
		
		$_SESSION['UTILITY']->sendEmail($from, $to, $subject, $body);
							
		$feedback = 'Thank you for your rating and feedback.';
	}
}
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Reservations - VILLAZZO</title>
    <link rel="stylesheet" href="/css/custom.css">
    <script src="/js/vendor/modernizr.js"></script>
<script type="text/javascript">
<!--
function validate()
{
	var status = 1;
	if(document.getElementById('rating').value=='') { document.getElementById('ratingLabel').style.color = '#F00'; status = 0; }
	if(status == 1) return true;
	else return false;
}
function rate(target)
{	
	document.getElementById('rating').value = target;
	
	if(target == 1)
	{
		document.getElementById('rating1').src = '/img/reservations/star-on.png';
		document.getElementById('rating2').src = '/img/reservations/star-off.png';
		document.getElementById('rating3').src = '/img/reservations/star-off.png';
		document.getElementById('rating4').src = '/img/reservations/star-off.png';
		document.getElementById('rating5').src = '/img/reservations/star-off.png';
	}
	else if(target == 2)
	{
		document.getElementById('rating1').src = '/img/reservations/star-on.png';
		document.getElementById('rating2').src = '/img/reservations/star-on.png';
		document.getElementById('rating3').src = '/img/reservations/star-off.png';
		document.getElementById('rating4').src = '/img/reservations/star-off.png';
		document.getElementById('rating5').src = '/img/reservations/star-off.png';
	}
	else if(target == 3)
	{
		document.getElementById('rating1').src = '/img/reservations/star-on.png';
		document.getElementById('rating2').src = '/img/reservations/star-on.png';
		document.getElementById('rating3').src = '/img/reservations/star-on.png';
		document.getElementById('rating4').src = '/img/reservations/star-off.png';
		document.getElementById('rating5').src = '/img/reservations/star-off.png';
	}
	else if(target == 4)
	{
		document.getElementById('rating1').src = '/img/reservations/star-on.png';
		document.getElementById('rating2').src = '/img/reservations/star-on.png';
		document.getElementById('rating3').src = '/img/reservations/star-on.png';
		document.getElementById('rating4').src = '/img/reservations/star-on.png';
		document.getElementById('rating5').src = '/img/reservations/star-off.png';
	}
	else if(target == 5)
	{
		document.getElementById('rating1').src = '/img/reservations/star-on.png';
		document.getElementById('rating2').src = '/img/reservations/star-on.png';
		document.getElementById('rating3').src = '/img/reservations/star-on.png';
		document.getElementById('rating4').src = '/img/reservations/star-on.png';
		document.getElementById('rating4').src = '/img/reservations/star-on.png';
		document.getElementById('rating5').src = '/img/reservations/star-on.png';
	}
}
-->
</script>
</head>
<body>
	<?php require_once '../inc-header.php'; ?>

        <section id="header-section">
            <img src="/img/destination-header_all.png">
        </section>


        <section id="reservations-title-steps-section">
            <div class="row">
                <div class="columns">
                    <h1>FEEDBACK REQUEST</h1>
                </div>
            </div>
        </section>

        <section>
            <div class="row">
                <div class="columns">
					<form action="" method="post" name="feedbackForm" id="feedbackForm" onsubmit="return validate();">
						<input type="hidden" name="action" id="action" value="feedback">
						<input type="hidden" name="rating" id="rating">
						<table border="0" cellspacing="0" cellpadding="1">
							<?php if (!isset($_POST['action'])) { ?>
							<tr>
								<td width="51">&nbsp;</td>
								<td width="245" valign="bottom">&nbsp;</td>
							</tr>
							<tr>
								<td><label for="name" id="nameLabel"><strong>Name:</strong></label></td>
								<td valign="bottom"><?php echo $row_rs_reservationProperty['reservationFirstname'].' '.$row_rs_reservationProperty['reservationLastname']; ?></td>
							</tr>
							<tr>
							  <td><label for="email" id="emailLabel"><strong>Dates:</strong></label></td>
							  <td valign="bottom"><?php echo date('m/d/Y', strtotime($row_rs_reservationProperty['reservationStartDt'])).' - '.date('m/d/Y', strtotime($row_rs_reservationProperty['reservationEndDt'])); ?></td>
						  </tr>
							<tr>
							  <td><label for="email" id="emailLabel"><strong>Villa:</strong></label></td>
							  <td valign="bottom"><?php echo $row_rs_reservationProperty['propertyName']; ?></td>
						  </tr>
							<tr>
							  <td><label for="rating" id="ratingLabel"><strong>Rating:</strong></label></td>
							  <td valign="bottom"><img src="/img/reservations/star-off.png" width="15" height="15" alt="rating" id="rating1" onmouseover="rate(1);" style="cursor:pointer; margin-right:5px;" /><img src="/img/reservations/star-off.png" width="15" height="15" alt="rating" id="rating2" onmouseover="rate(2);" style="cursor:pointer; margin-right:5px;" /><img src="/img/reservations/star-off.png" width="15" height="15" alt="rating" id="rating3" onmouseover="rate(3);" style="cursor:pointer; margin-right:5px;" /><img src="/img/reservations/star-off.png" width="15" height="15" alt="rating" id="rating4" onmouseover="rate(4);" style="cursor:pointer; margin-right:5px;" /><img src="/img/reservations/star-off.png" width="15" height="15" alt="rating" id="rating5" onmouseover="rate(5);" style="cursor:pointer;" /></td>
						  </tr>
							<tr>
								<td colspan="2"><label><input type="checkbox" name="keepMeInformed" value="Send me your Top 10 Properties For Sale"> Send me your Top 10 Properties For Sale</label></td>
							</tr>
							<tr>
					        	<td colspan="2"><label for="comment" id="commentLabel"><strong>Comments:</strong></label></td>
					        </tr>
							<tr>
								<td colspan="2"><textarea class="textArea" name="comment" id="comment" onclick="this.value='';" style="width:100%; height:100px; padding:2px; font-size:11px; resize:none;"></textarea></td>
							</tr>
							<tr>
								<td colspan="2"><input type="submit" class="button" name="submitBtn" id="submitBtn" value="Send" /></td>
							</tr>		
							<?php } else { ?>
							<tr>
								<td colspan="2"><?php echo $feedback; ?></td>
							</tr>
							<?php } ?>
						</table>
					</form>
                </div>
            </div>
        </section>

    <?php require_once '../inc-footer.php'; ?>
	
	<?php require_once '../inc-js.php'; ?>
</body>

</html>
