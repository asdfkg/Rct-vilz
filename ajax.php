<?php
require_once '/kunden/homepages/27/d309616710/htdocs/private/config.php';

$outputArray = NULL;
$feedback = NULL;
$redirect = NULL;
$status = 1;

switch ($_POST['action'])
{
	// login
	case 'login':
		$redirect = $_SESSION['USER']->login($_POST['email'], $_POST['password'], (isset($_POST['remember'])?$_POST['remember']:''));
		if ($redirect != '')
		{
			$feedback = 'Login success - redirecting';
			if (isset($_POST['redirect']) && $_POST['redirect'] != '') $redirect = $_POST['redirect'];
		}
		else
		{
			$status = 0;
			$feedback = 'Invalid credentials - please try again';
		}
		
		$outputArray = array('result' => $status, 'feedback' => $feedback, 'redirect' => $redirect);
	break;
	
	// recover password
	case 'recoverPassword':
		if (trim($_POST['recoverPasswordModalEmail']) != '')
		{
			$rs_user = $_SESSION['DB']->querySelect('SELECT USER_EMAIL, AES_DECRYPT(USER_PASSWORD, \''.$_SESSION['DB']->getEncryptKey().'\') AS USER_PASSWORD, USER_FIRSTNAME, USER_LASTNAME FROM USER WHERE USER_EMAIL = ? LIMIT 1', array($_POST['recoverPasswordModalEmail']));
			$row_rs_user = $_SESSION['DB']->queryResult($rs_user);
			$totalRows_rs_user = $_SESSION['DB']->queryCount($rs_user);
			
			if ($totalRows_rs_user)
			{
				$from = $_SESSION['SETTING']->getCompanyEmail();
				$to = array(array($row_rs_user['USER_EMAIL'], $row_rs_user['USER_FIRSTNAME'].' '.$row_rs_user['USER_LASTNAME']));
				$subject = 'Login Information';
				$message = 'Hello '.$row_rs_user['USER_FIRSTNAME'].', '.'<br><br>Below is the login information you requested:<br><br>URL: <a href="http://'.$_SERVER['HTTP_HOST'].'">http://'.$_SERVER['HTTP_HOST'].'</a><br>Email: '.$row_rs_user['USER_EMAIL'].'<br>Password: '.$row_rs_user['USER_PASSWORD'];
				$body = file_get_contents(EMAILS_PATH.'main.html');
				$body = str_replace('#MESSAGE#', $message, $body);
				
				if ($_SESSION['UTILITY']->sendEmail($from, $to, $subject, $body)) $feedback = 'Password emailed - please check your inbox';
				else
				{
					$status = 0;
					$feedback = 'Could not send email - please try again';
				}
			}
			else
			{
				$status = 0;
				$feedback = 'Email address not found';
			}
		}
		else $status = 0;
		
		$outputArray = array('result' => $status, 'feedback' => $feedback);
	break;
			
	// contact
	case 'contact':
		if (trim($_POST['firstName']) != '' && trim($_POST['lastName']) != '' && trim($_POST['email']) != '' && trim($_POST['message']) != '')
		{
			if ($_POST['code'] == 4) 
			{
				$from = array($_POST['email'], $_POST['firstName'].' '.$_POST['lastName']);
				$to = array($_SESSION['SETTING']->getCompanyEmail());
				$subject = 'Contact Request';
				$message = '<p><span style="font-weight:bold;">Name</span><br>'.$_POST['firstName'].' '.$_POST['lastName'].'</p>';
				$message .= '<p><span style="font-weight:bold;">Email</span><br>'.$_POST['email'].'</p>';
				$message .= '<p><span style="font-weight:bold;">Message</span><br>'.$_POST['message'].'</p>';
				$message .= '<p><span style="font-weight:bold;">Send me your VillaHotel brochure: </span>'.(isset($_POST['brochure'])?'yes':'no').'</p>';
				$message .= '<p><span style="font-weight:bold;">Email me your monthly newsletter: </span>'.(isset($_POST['newsletter'])?'yes':'no').'</p>';
				$body = file_get_contents(EMAILS_PATH.'main.html');
				$body = str_replace('#MESSAGE#', $message, $body);
				
				if ($_SESSION['UTILITY']->sendEmail($from, $to, $subject, $body)) $outputArray = array('result' => 1, 'feedback' => 'Your message has been sent', 'redirect' => '/');
				else $outputArray = array('result' => 0, 'feedback' => 'An error occurred, please try again');
			}
			else $outputArray = array('result' => 0, 'feedback' => 'The security code is invalid - the answer is 4');
		}
		else $outputArray = array('result' => 0, 'feedback' => 'Please fill in all required fields');
	break;
	
	// property interested
	case 'propertyInterested':
		if (trim($_POST['propertyInterestedModalPropertyName']) != '' && trim($_POST['propertyInterestedModalEmail']) != '')
		{
			$from = array($_POST['propertyInterestedModalEmail'], '');
			$to = array($_SESSION['SETTING']->getCompanyEmail());
			$subject = 'Property Interest: '.$_POST['propertyInterestedModalPropertyName'];
			$message = '<p>First Name: '.$_POST['propertyInterestedModalFirstName'].'</p>';
			$message .= '<p>Last Name: '.$_POST['propertyInterestedModalLastName'].'</p>';
			$message .= '<p>Email: '.$_POST['propertyInterestedModalEmail'].'</p>';
			$message .= '<p>Phone: '.$_POST['propertyInterestedModalPhone'].'</p>';
			$message .= '<p>Message: '.$_POST['propertyInterestedModalMessage'].'</p>';
			$body = file_get_contents(EMAILS_PATH.'main.html');
			$body = str_replace('#MESSAGE#', $message, $body);
			
			if ($_SESSION['UTILITY']->sendEmail($from, $to, $subject, $body)) $feedback = 'Your message has been sent.';
			else
			{
				$status = 0;
				$feedback = 'Please try again';
			}
		}
		else
		{
			$status = 0;
			$feedback = 'Please complete all required fields';
		}
		
		$outputArray = array('result' => $status, 'feedback' => $feedback);
	break;
	
	// property share
	case 'propertyShare':
		if (trim($_POST['propertyShareModalEmailFrom']) != '' && trim($_POST['propertyShareModalEmailTo']) != '')
		{
			$from = array($_POST['propertyShareModalEmailFrom'], '');
			$to = array(array($_POST['propertyShareModalEmailTo'], ''));
			$subject = 'I thought you might like this';
			$message = 'Hi,<br><br>Look at what I stumbled upon: <a href="'.$_POST['propertyShareModalPropertyUrl'].'">Villa '.$_POST['propertyShareModalPropertyName'].'</a>.';
			//$_SESSION['DB']->queryInsert('INSERT INTO SHARE (USER_ID, SHARE_EMAIL_FROM, SHARE_EMAIL_TO, SHARE_URL) VALUES (?, ?, ?, ?)', array(($_SESSION['USER']->getUserId()?$_SESSION['USER']->getUserId():NULL), $_POST['shareModalEmailFrom'], $_POST['shareModalEmailTo'], $_POST['shareModalUrl']));
			$body = file_get_contents(EMAILS_PATH.'main.html');
			$body = str_replace('#MESSAGE#', $message, $body);
			
			if ($_SESSION['UTILITY']->sendEmail($from, $to, $subject, $body)) $outputArray = array('result' => 1, 'feedback' => 'This villa has been shared with '.$_POST['propertyShareModalEmailTo']);
			else $outputArray = array('result' => 0);
		}
		else $outputArray = array('result' => 0, 'feedback' => 'Please fill in all required fields');
	break;
	
	// property availability
	case 'propertyAvailability':
// 		$redirectArray = explode('?', $_POST['redirect']);
// 		$outputArray = array('result' => 1, 'redirect' => $redirectArray[0].'?check_in='.date('m/d/Y', strtotime($_POST['checkInDt'])).'&check_out='.date('m/d/Y', strtotime($_POST['checkOutDt'])));
		$outputArray = array('result' => 1, 'redirect' => $_POST['redirect'].'&check_in='.date('m/d/Y', strtotime($_POST['checkInDt'])).'&check_out='.date('m/d/Y', strtotime($_POST['checkOutDt'])));
	break;
	
	// getPropertyLocations
	case 'getPropertyAltLocations':
		try
		{
            $query = 'SELECT propertyName, propertyMapAltLat, propertyMapAltLong, destName FROM property LEFT JOIN destination ON destination.destId = property.destId WHERE propertyActive = 1';

		    $rs_query = $_SESSION['DB']->querySelect($query, array());
            $result = $rs_query->fetchAll(PDO::FETCH_ASSOC);
			$result = array('success' => 'true', 'value' => $result);
			$outputArray = array('result' => $result);

			/*$rs_query = $_SESSION['DB']->querySelect('SELECT propertyName, propertyMapAltLat, propertyMapAltLong, destName FROM property LEFT JOIN destination ON destination.destId = property.destId WHERE propertyActive = 1');
            $result = $_SESSION['DB']->queryResult($rs_query);
			$result = array('success' => 'true', 'value' => $result);
			$outputArray = array('result' => $result);*/
		}
		catch (Exception $e) {
			$result = array('error' => $e->getMessage());
			$outputArray = array('result' => $result);
		}
	break;
	
	// getDestinationOffsets
	case 'getDestinationOffsets':
		try
		{
            $query = 'SELECT destName, destMapNorthOffset FROM destination';

		    $rs_query = $_SESSION['DB']->querySelect($query, array());
            $result = $rs_query->fetchAll(PDO::FETCH_ASSOC);
			$result = array('success' => 'true', 'value' => $result);
			$outputArray = array('result' => $result);
			echo json_encode($outputArray); exit;
			
			//$offsets = array();
			/*$rs_query = $_SESSION['DB']->querySelect('SELECT destName, destMapNorthOffset FROM destination');
            $result = $_SESSION['DB']->queryResult($rs_query);
			$result = array('success' => 'true', 'value' => $result);
			$outputArray = array('result' => $result);*/
		}
		catch (Exception $e) {
			$result = array('error' => $e->getMessage());
			$outputArray = array('result' => $result);
		}
	break;
	
	case 'reservationHold':
		$destCurrencyRate = $_SESSION['RESERVATION']->getConversionRate();
	
		if ($_SESSION['RESERVATION']->get('destCurrency') == '€')
		{
			$destCurrency = '&euro;';
			$tax = $_SESSION['RESERVATION']->get('destTax');
			$total = ($destCurrencyRate * $_SESSION['RESERVATION']->get('rateTotal')) + (($_SESSION['RESERVATION']->get('rateTotal') * $tax) / 100);
		}
		else
		{
			$destCurrency = '$';
			$tax = $_SESSION['RESERVATION']->get('destTax');
			$total = $_SESSION['RESERVATION']->get('rateTotal') + (($_SESSION['RESERVATION']->get('rateTotal') * $tax)/100);
		}
		
		if ($_SESSION['RESERVATION']->get('nightTotal') > 45) $prePayment = ($total / 2) / .97;
		else $prePayment = $total / .97;
						
		$reservationId = $_SESSION['DB']->queryInsert('INSERT INTO reservationProperty (propertyId, user_id, reservationLevel, reservationStartDt, reservationEndDt, reservationAdditionalServices, reservationTitle, reservationFirstname, reservationLastname, reservationCompany, reservationEmail, reservationPhone, reservationRateCurrency, reservationRateValue, reservationRateDiscount, reservationRateTax, reservationRatePrePayment, reservationRateTotal, reservationStatusId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
		array
		(
			$_SESSION['RESERVATION']->get('propertyId'),
			$_SESSION['USER']->getUserId(),
			$_SESSION['RESERVATION']->get('serviceLevel'),
			$_SESSION['RESERVATION']->get('checkInDt'),
			$_SESSION['RESERVATION']->get('checkOutDt'),
			$_SESSION['RESERVATION']->get('additionalServices'),
			$_POST['title'],
			$_SESSION['UTILITY']->formatName($_POST['firstName']),
			$_SESSION['UTILITY']->formatName($_POST['lastName']),
			$_SESSION['UTILITY']->formatName($_POST['company']),
			$_POST['email'],
			$_SESSION['UTILITY']->formatPhone($_POST['phone']),
			$destCurrency,
			$_SESSION['RESERVATION']->get('rateTotal'),
			$_SESSION['RESERVATION']->get('rateDiscount'),
			$tax,
			$prePayment,
			$total,
			5
		));
		
		if ($reservationId)
		{
			$_SESSION['RESERVATION']->set('reservationId', $reservationId);
			
			// email confirmation
			$from = $_SESSION['SETTING']->getCompanyEmail();
			$to = array(array($_POST['email'], $_POST['firstName'].' '.$_POST['lastName']));
			$subject = 'Villazzo Reservation Confirmation '.$_SESSION['RESERVATION']->formatOrderNbr($reservationId);
			$message = $_SESSION['RESERVATION']->createReceipt($reservationId);
			$body = file_get_contents(EMAILS_PATH.'main.html');
			$body = str_replace('#MESSAGE#', $message, $body);
			
			$file = $_SESSION['RESERVATION']->createPdf($reservationId);
			$_SESSION['UTILITY']->sendEmail($from, $to, $subject, $body, ($file?$file:''));
			
			$feedback = 'Hold placed, generating your receipt...';
			$redirect = '/reservations/confirmation';
		}
		else $status = 0;	
	
		$outputArray = array('result' => $status, 'feedback' => $feedback, 'redirect' => $redirect);
	break;
	
	case 'reservationBook':
		$paymentStatus = 1;
		$paymentResponse = '';
		$authorizationCode = NULL;
		
		$destCurrencyRate = $_SESSION['RESERVATION']->getConversionRate();
	
		if ($_SESSION['RESERVATION']->get('destCurrency') == '€')
		{
			$destCurrency = '&euro;';
			$tax = $_SESSION['RESERVATION']->get('destTax');
			$total = ($destCurrencyRate * $_SESSION['RESERVATION']->get('rateTotal')) + (($_SESSION['RESERVATION']->get('rateTotal') * $tax) / 100);
		}
		else
		{
			$destCurrency = '$';
			$tax = $_SESSION['RESERVATION']->get('destTax');
			$total = $_SESSION['RESERVATION']->get('rateTotal') + (($_SESSION['RESERVATION']->get('rateTotal') * $tax)/100);
		}
		
		if ($_SESSION['RESERVATION']->get('nightTotal') > 45) $prePayment = ($total / 2) / .97;
		else $prePayment = $total / .97;
		
		// validate CC is any
/*
		if (isset($_POST['ccNumber']) && trim($_POST['ccNumber']) != '')
		{
			// test: https://test.authorize.net/gateway/transact.dll
			// live: https://secure.authorize.net/gateway/transact.dll
			$post_url = 'https://test.authorize.net/gateway/transact.dll';
			
			$post_values = array
			(
				'x_login'			=> '7XFV6j7cu6u',
				'x_tran_key'		=> '79U6Wx6ucTr328AJ',
				'x_version'			=> '3.1',
				'x_delim_data'		=> 'TRUE',
				'x_delim_char'		=> '|',
				'x_relay_response'	=> 'FALSE',
				'x_type'			=> 'AUTH_ONLY',
				'x_method'			=> 'CC',
				'x_card_num'		=> $_POST['ccNumber'],
				'x_exp_date'		=> $_POST['ccExpMonth'].$_POST['ccExpYear'],
				'x_amount'			=> $prePayment,
				'x_description'		=> 'Villazzo Booking',
				'x_first_name'		=> $_SESSION['UTILITY']->formatName($_POST['firstName']),
				'x_last_name'		=> $_SESSION['UTILITY']->formatName($_POST['lastName']),
				'x_company'			=> $_POST['company'],
				'x_address'			=> $_POST['ccStreet1'].' '.$_SESSION['ccStreet2'],
				'x_city'			=> $_POST['ccCity'],
				'x_billingState'	=> $_POST['ccState'],
				'x_zip'				=> $_POST['ccZipCode'],
				'x_country'			=> $_POST['ccCountry']
			);
			
			$post_string = '';
			foreach( $post_values as $key => $value ) { $post_string .= $key . '=' . urlencode( $value ) . '&'; }
			$post_string = rtrim( $post_string, '& ' );
			$request = curl_init($post_url);
			curl_setopt($request, CURLOPT_HEADER, 0);
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($request, CURLOPT_POSTFIELDS, $post_string);
			curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);
			$post_response = curl_exec($request);
			curl_close ($request);
			$response_array = explode($post_values['x_delim_char'], $post_response);
			if ($response_array[0] != 1) { $paymentStatus = 0; $authorizationCode = $response_array[37]; $paymentResponse = $response_array[3]; }
		}
*/		

		if ($paymentStatus)
		{
			$reservationId = $_SESSION['DB']->queryInsert('INSERT INTO reservationProperty (propertyId, user_id, reservationLevel, reservationStartDt, reservationEndDt, reservationAdditionalServices, reservationTitle, reservationFirstname, reservationLastname, reservationCompany, reservationEmail, reservationEmailConfirmation, reservationPhone, reservationStreet1, reservationStreet2, reservationCity, reservationState, reservationPostcode, reservationCountry, reservationCreditCardType, reservationCreditCardName, reservationCreditCardNumber, reservationCreditCardExpMonth, reservationCreditCardExpYear, reservationCreditCardCVV, reservationRateCurrency, reservationRateValue, reservationRateDiscount, reservationRateCounterOffer, reservationRateTax, reservationRatePrePayment, reservationRateTotal, reservationPaymentAuthCode, reservationStatusId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, AES_ENCRYPT(?, \''.$_SESSION['DB']->getEncryptKey().'\'), AES_ENCRYPT(?, \''.$_SESSION['DB']->getEncryptKey().'\'), AES_ENCRYPT(?, \''.$_SESSION['DB']->getEncryptKey().'\'), AES_ENCRYPT(?, \''.$_SESSION['DB']->getEncryptKey().'\'), AES_ENCRYPT(?, \''.$_SESSION['DB']->getEncryptKey().'\'), AES_ENCRYPT(?, \''.$_SESSION['DB']->getEncryptKey().'\'), ?, ?, ?, ?, ?, ?, ?, ?, ?)',
			array
			(
				$_SESSION['RESERVATION']->get('propertyId'),
				$_SESSION['USER']->getUserId(),
				$_SESSION['RESERVATION']->get('serviceLevel'),
				$_SESSION['RESERVATION']->get('checkInDt'),
				$_SESSION['RESERVATION']->get('checkOutDt'),
				$_SESSION['RESERVATION']->get('additionalServices'),
				$_POST['title'],
				$_SESSION['UTILITY']->formatName($_POST['firstName']),
				$_SESSION['UTILITY']->formatName($_POST['lastName']),
				$_POST['company'],
				$_POST['email'],
				isset($_POST['emailConfirmation'])?$_POST['emailConfirmation']:null,
				$_SESSION['UTILITY']->formatPhone($_POST['phone']),
				$_POST['ccStreet1'],
				$_POST['ccStreet2'],
				$_POST['ccCity'],
				($_POST['ccCountry']=='US'?$_POST['ccStateUS']:$_POST['ccStateOther']),
				$_POST['ccZipCode'],
				$_POST['ccCountry'],
				$_POST['ccType'],
				$_POST['ccName'],
				$_POST['ccNumber'],
				$_POST['ccExpMonth'],
				$_POST['ccExpYear'],
				$_POST['ccCVV'],
				$destCurrency,
				$_SESSION['RESERVATION']->get('rateTotal'),
				$_SESSION['RESERVATION']->get('rateDiscount'),
				$_SESSION['RESERVATION']->get('rateCounterOffer'),
				$tax,
				$prePayment,
				$total,
				$authorizationCode,
				($_SESSION['USER']->getUserGroupId()==3?3:1) // if owner booking
			));
			
			if ($reservationId)
			{
				$_SESSION['RESERVATION']->set('reservationId', $reservationId);
				
				$file = $_SESSION['RESERVATION']->createPdf($reservationId);
				
				// email confirmation
				if (($_SESSION['USER']->getUserId() && isset($_POST['emailConfirmation']) && $_POST['emailConfirmation']) || !$_SESSION['USER']->getUserId())
				{
					$from = $_SESSION['SETTING']->getCompanyEmail();
					$to = array(array($_POST['email'], $_POST['firstName'].' '.$_POST['lastName']));
					$subject = 'Villazzo Reservation Confirmation '.$_SESSION['RESERVATION']->formatOrderNbr($reservationId);
					$message = $_SESSION['RESERVATION']->createReceipt($reservationId);
					$body = file_get_contents(EMAILS_PATH.'main.html');
					$body = str_replace('#MESSAGE#', $message, $body);
					
					$_SESSION['UTILITY']->sendEmail($from, $to, $subject, $body, ($file?$file:''));
				}
				
				$feedback = 'Booking submitted, generating your receipt...';
				$redirect = '/reservations/confirmation';
			}
			else $status = 0;
		}
		else
		{
			$status = 0;
			$feedback = 'Your credit card failed to authorize ('.$paymentResponse.')';
		}
		
		$outputArray = array('result' => $status, 'feedback' => $feedback, 'redirect' => $redirect);
	break;
	
	case 'feedbackRequest':
		if ($_SESSION['DB']->queryUpdate('UPDATE reservationProperty SET reservationFeedback = 1 WHERE reservationId = ? LIMIT 1', array($_POST['reservationId'])))
		{			
			// email confirmation
			$from = array('christian.jagodzinski@villazzo.com', 'Christian Jagodzinski (Villazzo)');
			$to = array(array($_POST['reservationEmail'], $_POST['reservationName']));
			$subject = 'Reservation Feedback Request';
			$message = $_POST['messageText'];
			$body = file_get_contents(EMAILS_PATH.'main.html');
			$body = str_replace('#MESSAGE#', $message, $body);
			
			$_SESSION['UTILITY']->sendEmail($from, $to, $subject, $body);
			
			$feedback = 'Feedback requested';
		}
		else $status = 0;
		
		$outputArray = array('result' => $status, 'feedback' => $feedback, 'redirect' => '/reservations/overview');
	break;
}

echo json_encode($outputArray);
?>