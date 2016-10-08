<?php
require_once '/kunden/homepages/27/d309616710/htdocs/private/config.php';

// restrict user access
$_SESSION['USER']->restrict('1,2,4');

$rs_destination = $_SESSION['DB']->querySelect('SELECT destId, destName FROM destination WHERE destActive = 1');
$row_rs_destination = $_SESSION['DB']->queryResult($rs_destination);
$totalRows_rs_destination = $_SESSION['DB']->queryCount($rs_destination);

function reservationStatus($status)
{
	$rs_reservationStatus = $_SESSION['DB']->querySelect('SELECT * FROM reservationStatus');
	$row_rs_reservationStatus = $_SESSION['DB']->queryResult($rs_reservationStatus);
	$totalRows_rs_reservationStatus = $_SESSION['DB']->queryCount($rs_reservationStatus);
	
	$reservationStatus = '<select name="status" onchange="submit();">';
	do {
		$reservationStatus .= '<option value="'.$row_rs_reservationStatus['reservationStatusId'].'"'. ($row_rs_reservationStatus['reservationStatusId']==$status?'selected="selected"':'').'>'.$row_rs_reservationStatus['reservationStatusName'].'</option>';
	} while ($row_rs_reservationStatus = $_SESSION['DB']->queryResult($rs_reservationStatus));
	$reservationStatus .= '</select>';
	return $reservationStatus;
}

if (isset($_POST['action']) && $_POST['action'] == 'update')
{
	$_SESSION['DB']->queryUpdate('UPDATE reservationProperty SET reservationStatusId = ? WHERE reservationId = ? LIMIT 1', array($_POST['status'], $_POST['reservationId']));
	header('Location: /reservations/overview');
}

if (isset($_GET['action']) && $_GET['action'] == 'delete')
{
	$_SESSION['DB']->queryUpdate('DELETE FROM reservationProperty WHERE reservationId = ? LIMIT 1', array($_GET['reservationId']));
	header('Location: /reservations/overview');
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
</head>

<body>
	<?php require_once '../inc-header.php'; ?>

        <section id="header-section">
            <img src="/img/destination-header_all.png">
        </section>

        <section id="reservations-title-steps-section">
            <div class="row">
                <div class="columns">
                    <h1>RESERVATIONS</h1>
                </div>
            </div>
        </section>

        <section>
            <div class="row">
                <div class="columns">
			<?php do {
					if ($_SESSION['USER']->getUserGroupId() == 1) $rs_reservationProperty = $_SESSION['DB']->querySelect('SELECT *, reservationProperty.reservationId, reservationProperty.reservationStatusId, DATEDIFF(reservationEndDt, reservationStartDt) AS lengthOfStay FROM reservationProperty LEFT JOIN USER ON USER.USER_ID = reservationProperty.user_id LEFT JOIN property ON property.propertyId = reservationProperty.propertyId LEFT JOIN reservationStatus ON reservationStatus.reservationStatusId = reservationProperty.reservationStatusId LEFT JOIN reservationFeedback on reservationFeedback.reservationId = reservationProperty.reservationId WHERE property.destId = '.$row_rs_destination['destId'].(isset($_GET['view'])&&$_GET['view']!='all'?' AND reservationStartDt >= DATE_SUB(NOW(), INTERVAL 12 MONTH)':'').' ORDER BY reservationCreateDt DESC');
					else $rs_reservationProperty = $_SESSION['DB']->querySelect('SELECT *, reservationProperty.reservationId, reservationProperty.reservationStatusId, DATEDIFF(reservationEndDt, reservationStartDt) AS lengthOfStay FROM reservationProperty LEFT JOIN USER ON USER.USER_ID = reservationProperty.user_id LEFT JOIN property ON property.propertyId = reservationProperty.propertyId LEFT JOIN reservationStatus ON reservationStatus.reservationStatusId = reservationProperty.reservationStatusId LEFT JOIN reservationFeedback on reservationFeedback.reservationId = reservationProperty.reservationId WHERE property.destId = '.$row_rs_destination['destId'].' AND reservationProperty.user_id = '.$_SESSION['USER']->getUserId().(isset($_GET['view'])&&$_GET['view']!='all'?' AND reservationStartDt >= DATE_SUB(NOW(), INTERVAL 12 MONTH)':'').' ORDER BY reservationCreateDt DESC');
					$row_rs_reservationProperty = $_SESSION['DB']->queryResult($rs_reservationProperty);
					$totalRows_rs_reservationProperty = $_SESSION['DB']->queryCount($rs_reservationProperty);
					
					if ($totalRows_rs_reservationProperty) { ?>
				<p style="text-transform:uppercase; font-size:18px;"><?php echo $row_rs_destination['destName']; ?></p>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #dac172; margin-bottom:50px;">
					<tr>
						<th valign="top">Reserved</th>
						<th valign="top">Property</th>
						<th valign="top">Full Name</th>
						<th valign="top" style="white-space: nowrap;">Check-in</th>
						<th valign="top">Days</th>
						<th valign="top">Total</th>
						<th valign="top">C/O</th>
						<th valign="top">Comm</th>
						<th valign="top" style="min-width: 180px;">Status</th>
						<th valign="top">&nbsp;</th>
						<th valign="top" >&nbsp;</th>
					</tr>
					<tr>
						<td valign="top" colspan="11" style="background-color:#dac172; height:10px; padding:0px;">&nbsp;</td>
					</tr>
					<?php do {
					$userInfo = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #d7c5a4;"><tr><td valign="top">Name:</td><td valign="top">'.ucwords($row_rs_reservationProperty['reservationFirstname'].' '.$row_rs_reservationProperty['reservationLastname']).'</td></tr><tr><td valign="top">Phone:</td><td valign="top">'.$row_rs_reservationProperty['reservationPhone'].'</td></tr><tr><td valign="top">Email:</td><td valign="top"><a href="mailto:'.$row_rs_reservationProperty['reservationEmail'].'">'.$row_rs_reservationProperty['reservationEmail'].'</a></td></tr>';
					if ($row_rs_reservationProperty['reservationStreet1']) $userInfo .= '<tr><td valign="top">Address:</td><td valign="top">'.$row_rs_reservationProperty['reservationStreet1'].' '.$row_rs_reservationProperty['reservationStreet2'].'<br />'.$row_rs_reservationProperty['reservationCity'].', '.$row_rs_reservationProperty['reservationState'].' '.$row_rs_reservationProperty['reservationPostcode'].'<br />'.$row_rs_reservationProperty['reservationCountry'].'</td></tr>';
					$userInfo .= '</table>';
					$userInfo = htmlentities($userInfo);
					?>
						<tr>
							<td valign="top"><?php echo $_SESSION['UTILITY']->dateInvoice($row_rs_reservationProperty['reservationCreateDt']); ?></td>
							<td valign="top"><?php echo $row_rs_reservationProperty['propertyName']; ?></td>
							<td valign="top"><span class="fakeLink" onclick="modalAlert('userInfo<?php echo $row_rs_reservationProperty['reservationId']; ?>', '<?php echo ucwords($row_rs_reservationProperty['reservationFirstname'].' '.$row_rs_reservationProperty['reservationLastname']); ?>', '<?php echo $userInfo; ?>');"><?php echo ucwords(strtolower($row_rs_reservationProperty['reservationFirstname'].' '.$row_rs_reservationProperty['reservationLastname'])); ?></span></td>
							<td valign="top"><?php echo $_SESSION['UTILITY']->dateInvoice($row_rs_reservationProperty['reservationStartDt']); ?></td>
							<td valign="top"><?php echo $row_rs_reservationProperty['lengthOfStay']; ?></td>
							<td valign="top"><?php echo ($row_rs_reservationProperty['reservationStatusId']==2?$row_rs_reservationProperty['reservationRateCurrency'].number_format($row_rs_reservationProperty['reservationRatePrePayment']):'N/A'); ?></td>
							<td valign="top"><?php echo ($row_rs_reservationProperty['reservationRateCounterOffer']?$row_rs_reservationProperty['reservationRateCurrency'].number_format($row_rs_reservationProperty['reservationRateCounterOffer']):'N/A'); ?></td>
							<td valign="top"><?php echo ($row_rs_reservationProperty['reservationStatusId']==2?$row_rs_reservationProperty['reservationRateCurrency'].number_format(($row_rs_reservationProperty['reservationRateValue']*$row_rs_reservationProperty['USER_COMMISSION_VH']/100)):'N/A'); ?></td>
							<td valign="top"><form action="" method="post" name="statusForm">
									<input name="action" type="hidden" value="update" />
									<input name="reservationId" type="hidden" value="<?php echo $row_rs_reservationProperty['reservationId']; ?>" />
									<?php echo reservationStatus($row_rs_reservationProperty['reservationStatusId']); ?>
								</form></td>
							<td valign="top"><span id="delete<?php echo $row_rs_reservationProperty['reservationId']; ?>" onclick="this.style.display='none'; document.getElementById('deleteConfimation<?php echo $row_rs_reservationProperty['reservationId']; ?>').style.display='block';" class="fakeLink"><i class="fa fa-trash-o" title="Delete Reservation"></i></span><span id="deleteConfimation<?php echo $row_rs_reservationProperty['reservationId']; ?>" style="display:none;">Delete Reservation?<br /><a href="?action=delete&reservationId=<?php echo $row_rs_reservationProperty['reservationId']; ?>">yes</a> | <span onclick="document.getElementById('delete<?php echo $row_rs_reservationProperty['reservationId']; ?>').style.display='block'; document.getElementById('deleteConfimation<?php echo $row_rs_reservationProperty['reservationId']; ?>').style.display='none';" class="fakeLink">no</span></span></td>
							<td valign="top">
							<?php if ($row_rs_reservationProperty['reservationFeedbackCreateDt']) {
							$feedbackInfo = htmlentities('<table width="400" border="0" cellspacing="0" cellpadding="0"><tr><td valign="top">Rating:</td><td valign="top"><img src="media/image/ratings/star-'.($row_rs_reservationProperty['reservationFeedbackRating']>=1?'on':'off').'.png" width="15" height="15" alt="rating" id="rating1" style="margin-right:5px;" /><img src="media/image/ratings/star-'.($row_rs_reservationProperty['reservationFeedbackRating']>=2?'on':'off').'.png" width="15" height="15" alt="rating" id="rating1" style="margin-right:5px;" /><img src="media/image/ratings/star-'.($row_rs_reservationProperty['reservationFeedbackRating']>=3?'on':'off').'.png" width="15" height="15" alt="rating" id="rating1" style="margin-right:5px;" /><img src="media/image/ratings/star-'.($row_rs_reservationProperty['reservationFeedbackRating']>=4?'on':'off').'.png" width="15" height="15" alt="rating" id="rating1" style="margin-right:5px;" /><img src="media/image/ratings/star-'.($row_rs_reservationProperty['reservationFeedbackRating']>=5?'on':'off').'.png" width="15" height="15" alt="rating" id="rating1" style="margin-right:5px;" /></td></tr><tr><td valign="top">Comment:</td><td valign="top">'.$row_rs_reservationProperty['reservationFeedbackComment'].'</td></tr></table>');
							?>
								<span class="fakeLink" onclick="modalAlert('feedbackInfo<?php echo $row_rs_reservationProperty['reservationId']; ?>', '<?php echo ucwords($row_rs_reservationProperty['reservationFirstname'].' '.$row_rs_reservationProperty['reservationLastname']); ?>', '<?php echo $feedbackInfo; ?>');"><?php echo $_SESSION['UTILITY']->dateInvoice($row_rs_reservationProperty['reservationFeedbackCreateDt']); ?></span>
							<?php } else { if (!$row_rs_reservationProperty['reservationFeedback']) {
								
								if (isset($row_rs_reservationProperty['reservationTitle'])) $client = $row_rs_reservationProperty['reservationTitle'].' '.ucwords($row_rs_reservationProperty['reservationLastname']);
								else $client = ucwords($row_rs_reservationProperty['reservationFirstname'].' '.$row_rs_reservationProperty['reservationLastname']);
							?>
							<a href="/reservations/overview/feedback/<?php echo $row_rs_reservationProperty['reservationId']; ?>"><i class="fa fa-comment" title="Request Feedback"></i></a>
						<?php } else echo '<i class="fa fa-check" title="Feedback Requested" style="color:green;"></i>'; } ?>
							</td>
						</tr>
						<?php } while ($row_rs_reservationProperty = $_SESSION['DB']->queryResult($rs_reservationProperty)); ?>
						<tr>
						<td colspan="10"><?php echo ($_GET['view']=='all'?'<a href="'.$_SERVER['PHP_SELF'].'">View Less</a>':'<a href="?view=all">View All</a>'); ?></td>
						</tr>
				</table>
				<?php } } while ($row_rs_destination = $_SESSION['DB']->queryResult($rs_destination)); ?>
                </div>
            </div>
        </section>

    <?php require_once '../inc-footer.php'; ?>
	
	<?php require_once '../inc-js.php'; ?>
</body>

</html>
