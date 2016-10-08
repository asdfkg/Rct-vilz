<?php
require_once("../config.php");

function mail_attachment($filename, $path, $mailto, $bcc, $mailfrom, $replyto, $subject, $message)
{	
    $file = $path.$filename;
    $file_size = filesize($file);
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));
    $name = basename($file);
    $header = "From: ".$mailfrom."\r\n";
    $header .= "Cc: "."\r\n";
    $header .= "Bcc: ".$bcc."\r\n";
    $header .= "Reply-To: ".$replyto."\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-Type:text/html; charset=iso-8859-1\r\n";
    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $header .= $message."\r\n\r\n";
	$header .= "--".$uid."\r\n";
	$header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use diff. tyoes here
	$header .= "Content-Transfer-Encoding: base64\r\n";
	$header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
	$header .= $content."\r\n\r\n";
	$header .= "--".$uid."--";
    mail($mailto, $subject, "", $header);
}

	$rs_reservation_property = $_SESSION['VILLAZO_DB']->querySelect(sprintf("SELECT *, DATEDIFF(reservationEndDt, reservationStartDt) AS numberOfNights, AES_DECRYPT(reservationCreditCardName, '".$_SESSION['RESERVATION_USER']->getPasswordKey()."') AS creditCardName, AES_DECRYPT(reservationCreditCardType, '".$_SESSION['RESERVATION_USER']->getPasswordKey()."') AS creditCardType, AES_DECRYPT(reservationCreditCardNumber, '".$_SESSION['RESERVATION_USER']->getPasswordKey()."') AS creditCardNumber, AES_DECRYPT(reservationCreditCardExpMonth, '".$_SESSION['RESERVATION_USER']->getPasswordKey()."') AS creditCardExpMonth, AES_DECRYPT(reservationCreditCardExpYear, '".$_SESSION['RESERVATION_USER']->getPasswordKey()."') AS creditCardExpYear, AES_DECRYPT(reservationCreditCardCVV, '".$_SESSION['RESERVATION_USER']->getPasswordKey()."') AS creditCardCVV FROM reservationProperty LEFT JOIN property ON property.propertyId=reservationProperty.propertyId LEFT JOIN destination ON destination.destId = property.destId LEFT JOIN propertyType ON propertyType.propertyTypeId = property.propertyTypeId WHERE reservationId=%s", GetSQLValueString($_SESSION['RESERVATION']->get('reservationId'), "int")));
	$row_rs_reservation_property = mysql_fetch_assoc($rs_reservation_property);
					
	$rs_property_type = $_SESSION['VILLAZO_DB']->querySelect(sprintf("SELECT propertyTypeName FROM property LEFT JOIN propertyType ON propertyType.propertyTypeId = property.propertyTypeId WHERE propertyId = %s", GetSQLValueString($row_rs_reservation_property['propertyId'], "int")));
	$row_rs_property_type = mysql_fetch_assoc($rs_property_type);
					
	$rs_property_sleeps = $_SESSION['VILLAZO_DB']->querySelect(sprintf("SELECT propFeatValue FROM propertyFeature WHERE propertyId = %s AND featureId = 59", GetSQLValueString($row_rs_reservation_property['propertyId'], "int")));
	$row_rs_property_sleeps = mysql_fetch_assoc($rs_property_sleeps);
	
	$rs_property_smoking = $_SESSION['VILLAZO_DB']->querySelect(sprintf("SELECT propFeatValue FROM propertyFeature WHERE propertyId = %s AND featureId = 58", GetSQLValueString($row_rs_reservation_property['propertyId'], "int")));
	$row_rs_property_smoking = mysql_fetch_assoc($rs_property_smoking);
	
	$rs_property_pets = $_SESSION['VILLAZO_DB']->querySelect(sprintf("SELECT propFeatValue FROM propertyFeature WHERE propertyId = %s AND featureId = 57", GetSQLValueString($row_rs_reservation_property['propertyId'], "int")));
	$row_rs_property_pets = mysql_fetch_assoc($rs_property_pets);
	
	$rs_property_bedrooms = $_SESSION['VILLAZO_DB']->querySelect(sprintf("SELECT propBedrId FROM propertyBedroom WHERE propertyId = %s", GetSQLValueString($row_rs_reservation_property['propertyId'], "int")));
	$row_rs_property_bedrooms = mysql_fetch_assoc($rs_property_bedrooms);
	$totalRows_rs_property_bedrooms = mysql_num_rows($rs_property_bedrooms);
	
	$destCurrency = ($row_rs_reservation_property['reservationRateCurrency']=='&euro;'?'E':'$');
	$nightlyRate = ($row_rs_reservation_property['reservationRateValue'] - $row_rs_reservation_property['reservationRateDiscount']) / $row_rs_reservation_property['numberOfNights'];
	$nightlyTotal = $row_rs_reservation_property['reservationRateValue'] - $row_rs_reservation_property['reservationRateDiscount'];
	$taxRate = $row_rs_reservation_property['reservationRateTax'];
	$taxTotal = $nightlyTotal * $taxRate / 100;
	$cleaningRate = 0;
	$checkoutTotal = $nightlyTotal + $cleaningRate + $taxTotal;
	
	
	
		$body = '
		<div style="padding:15px; border:solid 1px #DBDBDB;">
			<table width="100%" border="0" cellpadding="2" cellspacing="0">
	          <tr>
	            <td colspan="2" style="padding-bottom:20px;">';
	            $body .= 'Dear '.$row_rs_reservation_property['reservationFirstname'].' '.$row_rs_reservation_property['reservationLastname'].'<br /><br />';
	            if ($row_rs_reservation_property['reservationStatusId'] == 4) $body .= 'We are pleased to hold your selection for 24 hours. To complete your reservation please contact us directly to speak to a sales representative at +1 (305) 777 0146.<br /><br />Thank you for choosing Villazzo for your upcoming trip!<br /><br />Below is your booking confirmation with the details of your selection. You can print this page for future reference.';
	            else $body .= 'Your reservation has been received. Thank you for choosing Villazzo for your upcoming trip!<br /><br />
	Below is your booking confirmation, which has also been emailed to you. You can print this page for future reference.<br /><br /> 
	Please note: We still require a signed registration form - it has been pre-filled with all your information and emailed to you as attachment of your confirmation. Please sign it and fax back to us at +1-305-777-0147. If we do not receive the signed registration form within 24 hours, your reservation will be automatically deleted.';
	$body .= '</td>
	          </tr>
			  <tr>
			  <td valign="top" width="320">
				  <div style="padding:10px; height:220px; margin-right:20px; border:solid 1px #DBDBDB;">
				  <div style="font-size:14px;"><strong>Contact</strong></div>
				  <table width="100%" border="0" cellpadding="2" cellspacing="0" style="margin-left:10px;">
				  <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td><strong>First Name</strong></td>
					<td>'.$row_rs_reservation_property['reservationFirstname'].'</td>
				  </tr>
				  <tr>
					<td><strong>Last Name</strong></td>
					<td>'.$row_rs_reservation_property['reservationLastname'].'</td>
				  </tr>
				  <tr>
					<td><strong>Company</strong></td>
					<td>'.(isset($row_rs_reservation_property['reservationCompany'])?$row_rs_reservation_property['reservationCompany']:'n/a').'</td>
				  </tr>
				  <tr>
					<td><strong>Email</strong></td>
					<td>'.$row_rs_reservation_property['reservationEmail'].'</td>
				  </tr>
				  <tr>
					<td><strong>Phone</strong></td>
					<td>'.$row_rs_reservation_property['reservationPhone'].'</td>
				  </tr>
				  <tr>
					<td><strong>Street</strong></td>
					<td>'.$row_rs_reservation_property['reservationStreet1']." ".$row_rs_reservation_property['reservationStreet2'].'</td>
				  </tr>
				  <tr>
					<td><strong>City</strong></td>
					<td>'.$row_rs_reservation_property['reservationCity'].'</td>
				  </tr>
				  <tr>
					<td><strong>State</strong></td>
					<td>'.$row_rs_reservation_property['reservationState'].'</td>
				  </tr>
				  <tr>
					<td><strong>Zip Code</strong></td>
					<td>'.$row_rs_reservation_property['reservationPostcode'].'</td>
				  </tr>
				  <tr>
					<td><strong>Country</strong></td>
					<td>'.$row_rs_reservation_property['reservationCountry'].'</td>
				  </tr>
				  </table>
				  </div>
			  </td>
			  <td valign="top">
				  <div style="padding:10px; height:220px; border:solid 1px #DBDBDB;">
				  <div style="font-size:14px;"><strong>Payment</strong></div>';
				  if ($row_rs_reservation_property['creditCardNumber']) $body .= '				  
				  <table width="100%" border="0" cellpadding="2" cellspacing="0" style="margin-left:10px;">
				  <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td><strong>Credit card type</strong></td>
					<td>'.($row_rs_reservation_property['creditCardNumber']?$row_rs_reservation_property['creditCardType']:'').'</td>
				  </tr>
				  <tr>
					<td><strong>Credit card number</strong></td>
					<td>'.$_SESSION['VILLAZZO_FORMAT']->creditCard($row_rs_reservation_property['creditCardNumber']).'</td>
				  </tr>
				  <tr>
					<td><strong>Expiration date</strong></td>
					<td>'.$row_rs_reservation_property['creditCardExpMonth'].($row_rs_reservation_property['creditCardNumber']?"/":'').$row_rs_reservation_property['creditCardExpYear'].'</td>
				  </tr>
				  </table>';
				  else $body .= '<p>N/A</p>';
				  $body .= '				  
				  </div>
			  </td>
			  </tr>
	          <tr>
	            <td colspan="2">
				  <table width="100%" border="0" cellpadding="2" cellspacing="0" style="margin-top:30px;">
				  <tr>
					<td align="center" style="font-size:14px; padding:10px 0px 10px 0px; border-top:solid 1px #DBDBDB; border-bottom:solid 1px #DBDBDB; border-right:solid 1px #DBDBDB; border-left:solid 1px #DBDBDB;"><strong>Date</strong></td>
					<td align="center" style="font-size:14px; padding:10px 0px 10px 0px; border-top:solid 1px #DBDBDB; border-bottom:solid 1px #DBDBDB; border-right:solid 1px #DBDBDB;"><strong>Qty.</strong></td>
					<td align="center" style="font-size:14px; padding:10px 0px 10px 0px; border-top:solid 1px #DBDBDB; border-bottom:solid 1px #DBDBDB; border-right:solid 1px #DBDBDB;"><strong>Description</strong></td>
					<td align="center" style="font-size:14px; padding:10px 0px 10px 0px; border-top:solid 1px #DBDBDB; border-bottom:solid 1px #DBDBDB; border-right:solid 1px #DBDBDB;"><strong>Price</strong></td>
					<td align="center" style="font-size:14px; padding:10px 0px 10px 0px; border-top:solid 1px #DBDBDB; border-bottom:solid 1px #DBDBDB; border-right:solid 1px #DBDBDB;"><strong>Total</strong></td>
				  </tr>
				  <tr>
					<td valign="top" align="center" style="height:80px; border-bottom:solid 1px #DBDBDB; border-right:solid 1px #DBDBDB; border-left:solid 1px #DBDBDB;">'.$_SESSION['VILLAZZO_FORMAT']->dateInvoice($row_rs_reservation_property['reservationStartDt']).'</td>
					<td valign="top" align="center" style="height:80px; border-bottom:solid 1px #DBDBDB; border-right:solid 1px #DBDBDB;">'.$_SESSION['RESERVATION']->get('numberOfNights').'</td>
					<td valign="top" align="center" style="height:80px; border-bottom:solid 1px #DBDBDB; border-right:solid 1px #DBDBDB;">Nightly Rate '.$row_rs_property_type['propertyTypeName'].' '.$row_rs_reservation_property['propertyName'].', '.$row_rs_reservation_property['destName'].'</td>
					<td valign="top" align="center" style="height:80px; border-bottom:solid 1px #DBDBDB; border-right:solid 1px #DBDBDB;">'.$row_rs_reservation_property['reservationRateCurrency'].number_format($row_rs_reservation_property['reservationRateValue']/$_SESSION['RESERVATION']->get('numberOfNights')).'</td>
					<td valign="top" align="center" style="height:80px; border-bottom:solid 1px #DBDBDB; border-right:solid 1px #DBDBDB;">'.$row_rs_reservation_property['reservationRateCurrency'].number_format($row_rs_reservation_property['reservationRateValue']).'</td>
				  </tr>
				  <tr>
					<td colspan="4" align="right" style="font-size:14px; border-right:solid 1px #DBDBDB; padding:5px;"><strong>Subtotal:</strong></td>
					<td align="center" style="border-bottom:solid 1px #DBDBDB; border-right:solid 1px #DBDBDB; padding:5px;">'.$row_rs_reservation_property['reservationRateCurrency'].number_format($row_rs_reservation_property['reservationRateValue']).'</td>
				  </tr>
				  <tr>
					<td colspan="4" align="right" style="font-size:14px; border-right:solid 1px #DBDBDB; padding:5px;"><strong>Tax:</strong></td>
					<td align="center" style="border-bottom:solid 1px #DBDBDB; border-right:solid 1px #DBDBDB; padding:5px;">'.$row_rs_reservation_property['reservationRateCurrency'].number_format($row_rs_reservation_property['reservationRateTax']*$row_rs_reservation_property['reservationRateValue']/100).'</td>
				  </tr>
				  <tr>
					<td colspan="4" align="right" style="font-size:14px; border-right:solid 1px #DBDBDB; padding:5px;"><strong>Total:</strong></td>
					<td align="center" style="border-bottom:solid 1px #DBDBDB; border-right:solid 1px #DBDBDB; padding:5px;">'.$row_rs_reservation_property['reservationRateCurrency'].number_format($row_rs_reservation_property['reservationRateTax']*$row_rs_reservation_property['reservationRateValue']/100+$row_rs_reservation_property['reservationRateValue']).'</td>
				  </tr>
				  </table>
			  </td>
			  </tr>
			  <tr>
			  <td colspan="2">
				  <table width="100%" border="0" cellpadding="2" cellspacing="0" style="margin-top:20px;">
				  <tr>
					<td valign="top" width="150"><strong>Additional Services<br />(Will be billed<br />separately on<br />check-out)</strong></td>
					<td valign="top" align="left">'.$row_rs_reservation_property['reservationAdditionalServices'].'</td>
				  </tr>
				  </table>
			  </td>
			  </tr>
	        </table>
			</div>
	      <table width="650" border="0" cellspacing="0" cellpadding="0" style="margin-top:20px;">
	        <tr>
	          <td rowspan="2" align="right" valign="top"><a href="http://www.villazzo.com/'.strtolower($row_rs_reservation_property['destName']).'-rental-villas/'.($row_rs_reservation_property['propertyTypeId']==1?'villa-hotel':'v-villa').'-'.strtolower($row_rs_reservation_property['propertyName']).'"><img src="http://www.villazzo.com/media/image/reservation/bt_invoice.png" /></a></td>
	        </tr>
	      </table>';


	    if ($_SESSION['RESERVATION_USER']->getUserId()) $from = $_SESSION['RESERVATION_USER']->getFirstName().' '.$_SESSION['RESERVATION_USER']->getLastName().' <'.$_SESSION['RESERVATION_USER']->getUserEmail().'>';
		else $from = $_SESSION['VILLAZZO_SETTING']->getGlobalEmailFrom();
	    $to = $row_rs_reservation_property['reservationFirstname']." ".$row_rs_reservation_property['reservationLastname']." <".$row_rs_reservation_property['reservationEmail'].">";
	    if ($row_rs_reservation_property['reservationStatusId'] == 4) $subject = "Villazzo Courtesy Hold: ".$row_rs_reservation_property['propertyName'].", ".$row_rs_reservation_property['destName'];
	    else $subject = "Villazzo Reservation: ".$row_rs_reservation_property['propertyName'].", ".$row_rs_reservation_property['destName'];
	    $my_path = '../media/document/pdf/guest-registration-forms/';	
		
	    if ($row_rs_reservation_property['reservationEmailConfirmation'] == 1) mail_attachment($pdfName, $my_path, $to, $_SESSION['VILLAZZO_SETTING']->getGlobalEmailTo(), $from, $from, $subject, $_SESSION['VILLAZZO_FORMAT']->emailTemplate($body));
	    else mail_attachment($pdfName, $my_path, $_SESSION['VILLAZZO_SETTING']->getGlobalEmailTo(), '', $from, $from, $subject, $_SESSION['VILLAZZO_FORMAT']->emailTemplate($body));
