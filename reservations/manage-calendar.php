<?php
require_once '/kunden/homepages/27/d309616710/htdocs/private/config.php';

// restrict user access
$_SESSION['USER']->restrict('1,2,4');

$destId = (isset($_GET['destId'])?$_GET['destId']:1);
$today = (isset($_GET['date'])?$_GET['date']:date('Y-m-15'));
$calendarStartDt = '- 1 year';
$propertyName = (isset($_GET['property'])?$_GET['property']:NULL);
$checkInDt = NULL;
$checkOutDt = NULL;
$totalNights = 0;
$propertyQuery = NULL;

$rs_destination = $_SESSION['DB']->querySelect('SELECT destId, destName FROM destination WHERE destActive = 1');
$row_rs_destination = $_SESSION['DB']->queryResult($rs_destination);
$totalRows_rs_destination = $_SESSION['DB']->queryCount($rs_destination);

if ($propertyName)
{
	$rs_property = $_SESSION['DB']->querySelect('SELECT propertyId FROM property LEFT JOIN destination ON destination.destId=property.destId WHERE UPPER(propertyName) = ? LIMIT 1', array(str_replace('-', ' ', strtoupper($propertyName))));
	$row_rs_property = $_SESSION['DB']->queryResult($rs_property);
	$totalRows_rs_property = $_SESSION['DB']->queryCount($rs_property);
	
	$checkInDt = isset($_GET['check_in'])?$_GET['check_in']:'';
	$checkOutDt = isset($_GET['check_out'])?$_GET['check_out']:'';
	$calendarStartDt = $_GET['check_in'].' '.$calendarStartDt;
	$totalNights = ceil((strtotime($checkOutDt) - strtotime($checkInDt)) / 86400);
	$propertyQuery = ' AND property.propertyId = '.$row_rs_property['propertyId'];
}

$rs_reservationProperty = $_SESSION['DB']->querySelect('SELECT reservationProperty.propertyId, propertyName, destName FROM property LEFT JOIN reservationProperty ON reservationProperty.propertyId = property.propertyId LEFT JOIN destination on destination.destId = property.destId WHERE propertyActive = 1 AND property.destId = '.$destId.$propertyQuery.' GROUP BY property.propertyId ORDER BY propertyValue DESC');
$row_rs_reservationProperty = $_SESSION['DB']->queryResult($rs_reservationProperty);
$totalRows_rs_reservationProperty = $_SESSION['DB']->queryCount($rs_reservationProperty);

// draw calendar
function drawCalendar($destId, $propertyId, $date, $nav = '', $propertyName = '', $checkInDt = '', $checkOutDt = '')
{	
	$year = date('Y', strtotime($date));
	$month = date('m', strtotime($date));
	
	$calendar = '';
	
	if ($nav == 'prev') $calendar = '<div style="float:left; margin:127px 10px 0px 0px;"><a href="?destId='.$destId.'&date='.date('Y-m-d', strtotime($date.' - 1 month')).'"><img src="media/image/reservation/calendar/arrow_left.png" width="25" height="39" alt="Previous" /></a></div>';
	
	$calendar .= '<div class="calendarHolder">';
	
	$calendar .= '<table cellpadding="0" cellspacing="0" class="calendar">';
	
	$calendar .= '<tr class="calendar-row"><td class="calendar-day-head" colspan="7">';
	$calendar .= date('F Y', strtotime($date));
	$calendar .= '</td></tr>';

	$headings = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-subhead">'.implode('</td><td class="calendar-day-subhead">', $headings).'</td></tr>';

	$runningDay = date('w',mktime(0,0,0,$month,1,$year));
	$daysInMonth = date('t',mktime(0,0,0,$month,1,$year));
	$daysInThisWeek = 1;
	$dayCounter = 0;
	$datesArray = array();

	$calendar.= '<tr class="calendar-row">';

	for($x = 0; $x < $runningDay; $x++):
		$calendar .= '<td class="calendar-day-np">&nbsp;</td>';
		$daysInThisWeek++;
	endfor;

	for ($listDay = 1; $listDay <= $daysInMonth; $listDay++):
			
		$rs_property = $_SESSION['DB']->querySelect('SELECT reservationStatusId FROM reservationProperty LEFT JOIN property ON property.propertyId=reservationProperty.propertyId LEFT JOIN destination ON destination.destId=property.destId WHERE reservationStatusId != 4 AND property.propertyId = ? AND reservationStartDt <= DATE_ADD(?, INTERVAL +1 DAY) AND reservationEndDt >= ?', array($propertyId, $year.'-'.$month.'-'.$listDay, $year.'-'.$month.'-'.$listDay));
		$row_rs_property = $_SESSION['DB']->queryResult($rs_property);	
		$totalRows_rs_property = $_SESSION['DB']->queryCount($rs_property);
		
		if ($totalRows_rs_property)
		{
			do
			{						
				if ($row_rs_property['reservationStatusId'])
				{ 
					// reserved
					if ($row_rs_property['reservationStatusId']==1)
					{
						//$calendar .= '<td class="calendar-day" style="background:url(media/image/reservation/calendar/calendar_orange.jpg) no-repeat center;">';
						$calendar .= '<td class="calendar-day reserved">';
						$calendar .= '<div class="day-number">'.$listDay.'</div>';
						$calendar .= '</td>';
					}
					// booked
					else if ($row_rs_property['reservationStatusId']==2)
					{
						//$calendar .= '<td class="calendar-day" style="background:url(media/image/reservation/calendar/calendar_red.jpg) no-repeat center;">';
						$calendar .= '<td class="calendar-day booked">';
						$calendar .= '<div class="day-number">'.$listDay.'</div>';
						$calendar .= '</td>';
					}
					// owner
					else if ($row_rs_property['reservationStatusId']==3)
					{
						//$calendar .= '<td class="calendar-day" style="background:url(media/image/reservation/calendar/calendar_blue.jpg) no-repeat center;">';
						$calendar .= '<td class="calendar-day owner">';
						$calendar .= '<div class="day-number">'.$listDay.'</div>';
						$calendar .= '</td>';
					}
					// courtesy hold
					else if ($row_rs_property['reservationStatusId']==5)
					{
						//$calendar .= '<td class="calendar-day" style="background:url(media/image/reservation/calendar/calendar_orange.jpg) no-repeat center;">';
						$calendar .= '<td class="calendar-day hold">';
						$calendar .= '<div class="day-number">'.$listDay.'</div>';
						$calendar .= '</td>';
					}
				}
			}
			while ($row_rs_property = $_SESSION['DB']->queryResult($rs_property));
		}
		else
		{
			$calendar .= '<td class="calendar-day" style="background:#7cbd25;">';
			
			$selectedDate = $month.'/'.$listDay.'/'.$year;
			
			if (strtotime($checkInDt) == strtotime($selectedDate) || strtotime($checkOutDt) == strtotime($selectedDate)) $color = '#000 !important';
			else $color = '#fff !important';
			
			if (isset($_GET['property']))
			{
				$calendar .= '<div class="day-number"><a href="?property='.$propertyName;
				
				if ((!$checkInDt && !$checkOutDt) || ($checkInDt && $checkOutDt)) $calendar .= '&check_in='.$selectedDate;
				if ($checkInDt && !$checkOutDt) $calendar .= '&check_in='.$checkInDt.'&check_out='.$selectedDate;
				
				$calendar.= '" style="color:'.$color.'; text-decoration:underline;">'.$listDay.'</a></div>';
			}
			else
			{
				$calendar .= '<div class="day-number">'.$listDay.'</div>';
			}
			
			$calendar.= '</td>';
		}					
		//$calendar.= '</td>';
		
		if ($runningDay == 6):
			$calendar.= '</tr>';
			if (($dayCounter+1) != $daysInMonth):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$runningDay = -1;
			$daysInThisWeek = 0;
		endif;
		$daysInThisWeek++; $runningDay++; $dayCounter++;
	endfor;

	if ($daysInThisWeek < 8):
		for($x = 1; $x <= (8 - $daysInThisWeek); $x++):
			$calendar .= '<td class="calendar-day-np">&nbsp;</td>';
		endfor;
	endif;

	$calendar.= '</tr>';
	
	$calendar.= '</table>';
	
	$calendar.= '</div>';
	
	if ($nav == 'next') $calendar .= '<span style="float:left; margin:127px 0px 0px 10px;"><a href="?destId='.$destId.'&date='.date('Y-m-d', strtotime($date.' + 1 month')).'"><img src="media/image/reservation/calendar/arrow_right.png" width="25" height="39" alt="Next" /></a></span>';
	
	return $calendar;
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
    <style type="text/css">
<!--
/* calendar */
.calendarHolder {
	width: 293px;
	height: 277px;
	background: #dac172;
	float:left;
}
table.calendar {
	width: 290px;
}
tr.calendar-row {
}
td.calendar-day {
	min-height:37px;
	font-size:11px;
	position:relative;
	border:solid 1px #FFF;
}
* html div.calendar-day {
	height:37px;
}
td.calendar-day:hover {
}
td.calendar-day-np {
	min-height:37px;
	background: #dac172;
	border:solid 1px #FFF;
}
* html div.calendar-day-np {
	height:37px;
}
td.calendar-day-head {
	color:#FFF;
	text-transform:uppercase;
	font-weight:bold;
	text-align:center;
	padding:5px;
	background: #DAC172;
}
td.calendar-day-subhead {
	color:#000;
	text-transform:uppercase;
	font-weight:bold;
	text-align:center;
	padding:0px;
	width:37px;
	height:30px;
}
div.day-number {
	padding:0px 8px 0px 0px;
	color:#fff;
	font-weight:bold;
	float:right;
	margin:0px;
	width:20px;
	text-align:center;
}
td.calendar-day, td.calendar-day-np {
	width:37px;
	height:37px;
}
.reserved {
	border: 1px solid rgba(255, 255, 255, 0.5);
	background: #f2ca59; /* Old browsers */
	background: -moz-linear-gradient(top, #f2ca59 0%, #f0c552 50%, #efbb46 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #f2ca59), color-stop(50%, #f0c552), color-stop(100%, #efbb46)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, #f2ca59 0%, #f0c552 50%, #efbb46 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, #f2ca59 0%, #f0c552 50%, #ffa300 #efbb46 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, #f2ca59 0%, #f0c552 50%, #efbb46 100%); /* IE10+ */
	background: linear-gradient(to bottom, #f2ca59 0%, #f0c552 50%, #efbb46 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f2ca59', endColorstr='#efbb46', GradientType=0 ); /* IE6-9 */
}
.booked {
	border: 1px solid rgba(255, 255, 255, 0.5);
	background: #cb3925; /* Old browsers */
	background: -moz-linear-gradient(top, #cb3925 0%, #c53620 50%, #bb301c 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #cb3925), color-stop(50%, #c53620), color-stop(100%, #bb301c)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, #cb3925 0%, #c53620 50%, #bb301c 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, #cb3925 0%, #c53620 50%, #bb301c #ffa300%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, #cb3925 0%, #c53620 50%, #bb301c 100%); /* IE10+ */
	background: linear-gradient(to bottom, #cb3925 0%, #c53620 50%, #bb301c 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cb3925', endColorstr='#bb301c', GradientType=0 ); /* IE6-9 */
}
.owner {
	border: 1px solid rgba(255, 255, 255, 0.5);
	background: #2dbfcc; /* Old browsers */
	background: -moz-linear-gradient(top, #2dbfcc 0%, #29b8c6 50%, #22aec0 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #2dbfcc), color-stop(50%, #29b8c6), color-stop(100%, #22aec0)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, #2dbfcc 0%, #29b8c6 50%, #22aec0 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, #2dbfcc 0%, #29b8c6 50%, #22aec0 #ffa300%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, #2dbfcc 0%, #29b8c6 50%, #22aec0 100%); /* IE10+ */
	background: linear-gradient(to bottom, #2dbfcc 0%, #29b8c6 50%, #22aec0 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2dbfcc', endColorstr='#22aec0', GradientType=0 ); /* IE6-9 */
}
.hold {
	border: 1px solid rgba(255, 255, 255, 0.5);
	background: #cb8d25; /* Old browsers */
	background: -moz-linear-gradient(top, #dba03c 0%, #d8982b 50%, #cb8d25 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #dba03c), color-stop(50%, #d8982b), color-stop(100%, #cb8d25)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, #dba03c 0%, #d8982b 50%, #cb8d25 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, #dba03c 0%, #d8982b 50%, #ffa300 #cb8d25 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, #dba03c 0%, #d8982b 50%, #cb8d25 100%); /* IE10+ */
	background: linear-gradient(to bottom, #dba03c 0%, #d8982b 50%, #cb8d25 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#dba03c', endColorstr='#cb8d25', GradientType=0 ); /* IE6-9 */
}
.calendar-legend {
	float: left;
	padding: 15px;
	color: white;
}
-->
</style>

</head>

<body>
	<?php require_once '../inc-header.php'; ?>

        <section id="header-section">
            <img src="/img/destination-header_all.png">
        </section>


        <section id="reservations-title-steps-section">
            <div class="row">
                <div class="columns">
                    <h1>CALENDAR</h1>
                </div>
            </div>
        </section>

        <section>
            <div class="row">
                <div class="columns">
	                
	                
					<?php if ($propertyName == NULL) do { echo '<a href="?destId='.$row_rs_destination['destId'].'" style="float:left; width:300px; margin-right:20px;"><img src="/img/destination-header_'.strtolower(str_replace('-', '_', $row_rs_destination['destName'])).'.png" alt="'.$row_rs_destination['destName'].' villa hotels" /></a>'; } while ($row_rs_destination = $_SESSION['DB']->queryResult($rs_destination)); ?>
					
					<?php if ($totalRows_rs_reservationProperty) {
						do { ?>                   
					
						<div style="float:left; width:1005px; margin:0px 0px 20px 0px;">
							<?php
							if ($_SESSION['USER']->getUserGroupId() == 1 || $_SESSION['USER']->getUserGroupId() == 2)
							{
								$rs_reservationPropertyDetails = $_SESSION['DB']->querySelect('SELECT (SELECT SUM(DATEDIFF(reservationEndDt, reservationStartDt)) AS reservationPropertyNightTotal FROM reservationProperty WHERE propertyId = ? AND reservationStatusId = 2 AND YEAR(reservationEndDt) = YEAR(CURDATE())) AS reservationPropertyNightBookedTotal, 
								reservationRateCurrency, (SELECT SUM(reservationRateValue) AS reservationRateValueTotal FROM reservationProperty WHERE propertyId = ? AND reservationStatusId = 2 AND YEAR(reservationEndDt) = YEAR(CURDATE())) AS reservationRateValueTotal 
								FROM reservationProperty WHERE propertyId = ? LIMIT 1', array($row_rs_reservationProperty['propertyId'], $row_rs_reservationProperty['propertyId'], $row_rs_reservationProperty['propertyId']));
								$row_rs_reservationPropertyDetails = $_SESSION['DB']->queryResult($rs_reservationPropertyDetails);
								$totalRows_rs_reservationPropertyDetails = $_SESSION['DB']->queryCount($rs_reservationPropertyDetails);
								?>
								<div style="float:left; width:1005px; margin:20px 0px 10px 0px;">
									<h3><?php echo $row_rs_reservationProperty['propertyName']; ?></h3>
									
									<input type="hidden" id="slide<?php echo $row_rs_reservationProperty['propertyId']; ?>" value="<?php echo 17-date('m'); ?>" />
									<span style="float:left; margin:127px 10px 0px 0px; cursor:pointer; font-size:1.5rem;"><i class="fa fa-chevron-circle-left" onclick="if ($('#slide<?php echo $row_rs_reservationProperty['propertyId']; ?>').val() > 1) { $('#property<?php echo $row_rs_reservationProperty['propertyId']; ?>').animate({marginLeft: '+=306px'}, 1000); $('#slide<?php echo $row_rs_reservationProperty['propertyId']; ?>').val(parseInt($('#slide<?php echo $row_rs_reservationProperty['propertyId']; ?>').val()) - 1); }"></i></span>
									
									<div style="float:left; width:920px; height:277px; margin:0px 0px 10px 10px; overflow:hidden;">
										<div id="property<?php echo $row_rs_reservationProperty['propertyId']; ?>" style="margin-left: -<?php echo (14-date('m'))*306; ?>px;">
											<span style="float:left; margin-left:12px;"><?php echo drawCalendar($destId, $row_rs_reservationProperty['propertyId'], date('m/d/Y', strtotime($calendarStartDt)), '', $propertyName, $checkInDt, $checkOutDt); ?></span>
											<?php for ($i = 1; $i < 36; $i ++) { ?>
											<span style="float:left; margin-left:12px;"><?php echo drawCalendar($destId, $row_rs_reservationProperty['propertyId'], date('m/d/Y', strtotime($calendarStartDt.(date('d')>28?' - 4 days':'').' + '.$i.' month')), '', $propertyName, $checkInDt, $checkOutDt); ?></span>
											<?php } ?>
										</div>
									</div>
									
									<span style="float:right; margin:127px 20px 0px 0px; cursor:pointer; font-size:1.5rem;"><i class="fa fa-chevron-circle-right" onclick="if ($('#slide<?php echo $row_rs_reservationProperty['propertyId']; ?>').val() < <?php echo ceil(36 - 2); ?>) { $('#property<?php echo $row_rs_reservationProperty['propertyId']; ?>').animate({marginLeft: '-=306px'}, 1000); $('#slide<?php echo $row_rs_reservationProperty['propertyId']; ?>').val(parseInt($('#slide<?php echo $row_rs_reservationProperty['propertyId']; ?>').val()) + 1); }"></i></span>
									
								</div>
								
								
								<?php if ($propertyName) { ?>
								<table style="text-align:left; margin-left:45px;">
							      <tr><td>Check-In Date:</td><td style="font-weight:bold;"><?php echo ($checkInDt?date('m/d/Y', strtotime($checkInDt)):'TBD'); ?></td></tr>
							      <tr><td>Check-Out Date:</td><td style="font-weight:bold;"><?php echo ($checkOutDt?date('m/d/Y', strtotime($checkOutDt)):'TBD'); ?></td></tr>
							      <tr><td>Number of Nights:</td><td style="font-weight:bold;"><?php echo ($totalNights>0?$totalNights:'TBD'); ?></td></tr>
							      <tr><td><?php echo '<a class="button tiny expand" href="/reservations/services?property='.$propertyName.'&check_in='.date('m/d/Y', strtotime($checkInDt)).'&check_out='.date('m/d/Y', strtotime($checkOutDt)).'">CONTINUE</a>'; ?></td></tr>
								  </table>
								  <?php } else { ?>
								<table style="text-align:left; margin-left:45px;">
									<tr>
										<th>Total Booked Nights <?php echo date('Y'); ?>:</th>
										<td><?php echo ($row_rs_reservationPropertyDetails['reservationPropertyNightBookedTotal']?$row_rs_reservationPropertyDetails['reservationPropertyNightBookedTotal']:0); ?></td>
									</tr>
									<?php if ($_SESSION['USER']->getUserGroupId() == 1) { ?>
									<tr>
										<th>Total Villa Revenue <?php echo date('Y'); ?>:</th>
										<td><?php echo $row_rs_reservationPropertyDetails['reservationRateCurrency'].number_format($row_rs_reservationPropertyDetails['reservationRateValueTotal']); ?></td>
									</tr>
									<?php } ?>
								</table>
								<?php } ?>
								
								<div style="float:right; margin:-40px 47px 0px 0px; font-size:12px;">
									<span class="calendar-legend reserved">Reserved</span>
									<span class="calendar-legend booked">Booked</span>
									<span class="calendar-legend owner">Owner</span>
									<span class="calendar-legend hold">Hold</span>
								</div>
								
								
								  
								  
							<?php } ?>
						</div>
					
					<?php } while ($row_rs_reservationProperty = $_SESSION['DB']->queryResult($rs_reservationProperty)); } ?>


				</div>
			</div>
        </section>

    <?php require_once '../inc-footer.php'; ?>
	
	<?php require_once '../inc-js.php'; ?>
</body>

</html>
