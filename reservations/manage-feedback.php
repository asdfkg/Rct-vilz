<?php
require_once '/kunden/homepages/27/d309616710/htdocs/private/config.php';

// restrict user access
$_SESSION['USER']->restrict('1,2,4');

$rs_reservationProperty = $_SESSION['DB']->querySelect('SELECT reservationId, reservationTitle, reservationFirstname, reservationLastname, reservationEmail FROM reservationProperty WHERE reservationId = ? LIMIT 1', array($_GET['id']));
$row_rs_reservationProperty = $_SESSION['DB']->queryResult($rs_reservationProperty);
$totalRows_rs_reservationProperty = $_SESSION['DB']->queryCount($rs_reservationProperty);
if (!$totalRows_rs_reservationProperty) header('Location: /reservations/overview');

if (isset($row_rs_reservationProperty['reservationTitle'])) $client = $row_rs_reservationProperty['reservationTitle'].' '.ucwords($row_rs_reservationProperty['reservationLastname']);
else $client = ucwords($row_rs_reservationProperty['reservationFirstname'].' '.$row_rs_reservationProperty['reservationLastname']);
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Reservations - VILLAZZO</title>
    <link rel="stylesheet" href="/css/custom.css">
    <script src="/js/vendor/modernizr.js"></script>
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
	<script type="text/javascript">
	<!--
	tinymce.init({
		selector: 'textarea',
		height: 500,
		plugins: [
		'advlist autolink lists link image charmap print preview anchor',
		'searchreplace visualblocks code fullscreen',
		'insertdatetime media table contextmenu paste code'
		],
		toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
		content_css: [
		'//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
		'//www.tinymce.com/css/codepen.min.css'
		]
	});
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
	                
					<form id="feedbackRequestForm" onsubmit="return false;">
						
						<input type="hidden" name="reservationId" id="reservationId" value="<?php echo $row_rs_reservationProperty['reservationId']; ?>" />
						<input type="hidden" name="reservationName" id="reservationName" value="<?php echo $row_rs_reservationProperty['reservationFirstname'].' '.$row_rs_reservationProperty['reservationLastname']; ?>" />
						<input type="hidden" name="reservationEmail" id="reservationEmail" value="<?php echo $row_rs_reservationProperty['reservationEmail']; ?>" />
						<input type="hidden" name="messageText" id="messageText" />
						
						<textarea name="messageHtml" id="messageHtml" style="width:100%; height:400px;">
						<?php
						
						$body = '<p style="font-family:\'Palatino Linotype\', \'Book Antiqua\', Palatino, serif; font-size:12px;">
						Dear '.$client.',<br /><br />
					
						On behalf of the entire Villazzo team, I wish to thank you for choosing to stay with us during your most recent vacation. Villazzo prides itself on crafting an exquisite hotel experience for all of its guests; providing the same attention to detail, personalized service, and luxury amenities in the midst of your own private luxury villa, far away from the hustle and bustle of tourists and sightseers. We hope that your stay with Villazzo exceeded your expectations for what a luxury villa rental can be.<br /><br />
						
						We would appreciate your rating (and feedback) - it only takes 5 seconds - please <a style="color:#ae843b;" href="http://www.villazzo.com/reservations/feedback/'.str_replace('=', '', strtr(base64_encode($row_rs_reservationProperty['reservationId']), '+/', '-_')).'/">click here</a>.<br /><br />
						
						Thank you again, and I look forward to checking you in to yet another Villazzo VillaHotel soon.<br /><br /><br />
						
						Christian Jagodzinski<br /><br />
						
						President<br />
						<span style="color:#ae843b; font-size:18px;"><span style="color:#ae843b; font-size:30px;">V</span>ILLA<span style="color:#ae843b; font-size:24px;">ZZ</span>O</span><br />
						<span style="color:#ae843b;">Miami Beach - Saint-Tropez - Aspen</span><br />
						81 Washington Ave, Miami Beach, FL 33139<br />
						+1-877-VILLAZZO<br />
						cell US +1 (305) 491-9221<br />
						cell EU +33 (6) 82 67 53 85<br />
						Skype: villazzo.christian.jagodzinski<br />
						<a href="mailto:christian.jagodzinski@villazzo.com" style="color:#ae843b;">christian.jagodzinski@villazzo.com</a><br />
						<a href="http://www.villazzo.com" style="color:#ae843b;">www.villazzo.com</a>
						</p>';
						echo $body;
						?>
						</textarea>
						
						<button class="button" id="feedbackRequestBtn" onclick="$('#messageText').val(tinymce.get('messageHtml').getContent()); query(form.id, id, 'feedbackRequest');"><span id="feedbackRequestBtnHtml">Send</span></button>
						
						<div class="feedback"></div>
						
					</form>




                </div>
            </div>
        </section>

    <?php require_once '../inc-footer.php'; ?>
	
	<?php require_once '../inc-js.php'; ?>
</body>

</html>
