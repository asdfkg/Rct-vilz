<?php
// utility class
class Utility
{	
	// format password
	public function formatPassword($password)
	{
		return str_pad(substr($password, strlen($password)), strlen($password), '*', STR_PAD_LEFT);
	}
	
	// format credit card
	public function formatCreditCard($creditCard)
	{
		return str_pad(substr($creditCard, -4), strlen($creditCard), '*', STR_PAD_LEFT);
	}	
	
	// format currency
	public function formatCurrency($currency)
	{
		return '$'.number_format($currency, 2);
	}
	
	// format to URL
	public function formatToUrl($data)
	{
		return strtolower(trim(preg_replace('/\s/', '-', preg_replace(array('/[^A-Za-z0-9]/', '/\s\s+/'), ' ', $data)), '-'));
	}
	
	// format name
	public function formatName($data)
	{
		return strtoupper(trim(preg_replace(array('/[^A-Za-z]/', '/\s\s+/'), ' ', $data)));
	}	
	// format phone
	function formatPhone($phone)
	{
		$phone = preg_replace('/[^0-9]/', '', $phone);
		if (strlen($phone) == 7) return preg_replace('/([0-9]{3})([0-9]{4})/', '$1-$2', $phone);
		else if (strlen($phone) == 10) return preg_replace('/([0-9]{3})([0-9]{3})([0-9]{4})/', '($1) $2-$3', $phone);
		else return $phone;
	}
	
	// format date user
	function dateReservation($date)
	{
		return date('F j, Y', strtotime($date));
	}
	
	// format date pdf
	function datePdf($start, $end)
	{
		return date('Y m d', strtotime($start)) . ' - ' . date('m d', strtotime($end));
	}
	
	// format date user
	function dateInvoice($dateInvoice)
	{
		return date('m/d/y', strtotime($dateInvoice));
	}
	
	// send email
	public function sendEmail($from, $to, $subject, $message, $file = '', $cc = '', $bcc = '', $template = '')
	{
		$mail = new PHPMailer;
		
/*
		$mail->IsSMTP(); // Set mailer to use SMTP
		$mail->Host = 'mail.maddev.com'; // Specify main and backup server
		$mail->SMTPAuth = true; // Enable SMTP authentication
		$mail->Username = 'olivier@maddev.com'; // SMTP username
		$mail->Password = 'maQ6CUpd'; // SMTP password
		$mail->SMTPSecure = 'tls'; // Enable encryption, 'ssl' also accepted
*/
				
		$mail->SetFrom($from[0], $from[1]);
		$mail->AddReplyTo($from[0], $from[1]);
		foreach ($to as $data) $mail->AddAddress(trim($data[0]), trim($data[1]));
		if ($cc) foreach ($cc as $data) $mail->AddCC(trim($data[0]), trim($data[1]));
		if ($bcc) foreach ($bcc as $data) $mail->AddBCC(trim($data[0]), trim($data[1]));
		if ($file) $mail->AddAttachment($file);
		
		// add default BCC
		$mail->AddBCC('olivier@maddev.com', 'Olivier Beuzelin');
		
		// default images
		$mail->AddEmbeddedImage(EMAILS_PATH.'img/logo.png', 'logo');
		//$mail->AddEmbeddedImage(EMAILS_PATH.'img/banner.png', 'banner');
		//$mail->AddEmbeddedImage(EMAILS_PATH.'img/ico-social-facebook.png', 'facebook');
		//$mail->AddEmbeddedImage(EMAILS_PATH.'img/ico-social-twitter.png', 'twitter');
				
		$mail->IsHTML(true);
		
		// insert footer date
		$message = str_replace('#FOOTER_DATE#', date('Y'), $message);
				
		$mail->Subject = $subject;
		$mail->Body = $message;
		$mail->AltBody = $message;
		
		if ($mail->Send()) return 1;
		else return 0;
	}
	
	// create toggle button
	public function createToggleButton($name, $table, $id, $state, $style = 'icon')
	{
		if ($style == 'btn') { $tag = 'button'; $class = 'button submit tiny radius'; }
		else { $tag = 'span'; $class = 'toggleBtn'; }
		
		return '<'.$tag.' id="'.$name.$id.'Btn" title="Turn '.($state?'Off':'On').'" class="'.$class.'" onclick="toggleState(\''.$table.'\', '.$id.', '.($state?0:1).', \''.$name.$id.'Btn\');"><i class="'.($state?'fa fa-power-off':'fa fa-ban').'"></i></'.$tag.'>';
	}
	
	// create credit card drop down
	public function createCreditCardDropDown($name, $id, $selected = '', $class = '')
	{
		$output = '
		<select name="'.$name.'" id="'.$id.'"'.($class?' class="'.$class.'"':'').'>
            <option value="AMEX"'.($selected=='AMEX'?' selected="selected"':'').'>Amex</option>
            <option value="MASTERCARD"'.($selected=='MASTERCARD'?' selected="selected"':'').'>Master Card</option>
            <option value="VISA"'.($selected=='VISA'?' selected="selected"':'').'>Visa</option>
        </select>';
		return $output;
	}
	
	// create month drop down
	public function createMonthDropDown($name, $id, $selected = '', $class = '')
	{
		$output = '
		<select name="'.$name.'" id="'.$id.'"'.($class?' class="'.$class.'"':'').'>
			<option value="">Exp Month</option>';
			for ($i = 0; $i < 12; $i ++) $output .= '<option '.($selected==''.date('m', strtotime('January + '.$i.' months'.(date('d')>28?' - 4 days':''))).''?'selected="selected"':'').' value="'.date('m', strtotime('January + '.$i.' months'.(date('d')>28?' - 4 days':''))).'">'.date('F', strtotime('January + '.$i.' months'.(date('d')>28?' - 4 days':''))).'</option>';
            $output .= '
        </select>';
		return $output;
	}
	
	// create year drop down
	public function createYearDropDown($name, $id, $selected = '', $class = '')
	{
		$output = '
		<select name="'.$name.'" id="'.$id.'"'.($class?' class="'.$class.'"':'').'>
			<option value="">Exp Year</option>';
			for ($i = 0; $i <= 10; $i ++) $output .= '<option '.($selected==''.date('Y', strtotime(' + '.$i.' years')).''?'selected="selected"':'').' value="'.date('Y', strtotime(' + '.$i.' years')).'">'.date('Y', strtotime(' + '.$i.' years')).'</option>';
            $output .= '
        </select>';
		return $output;
	}
	
	// create state drop down
	public function createStateDropDown($name, $id, $selected = '', $class = '')
	{
		$output = '
		<select name="'.$name.'" id="'.$id.'"'.($class?' class="'.$class.'"':'').'>
			<option value="">State</option>
            <option value="AL"'.($selected=='AL'?' selected="selected"':'').'>Alabama</option>
            <option value="AK"'.($selected=='AK'?' selected="selected"':'').'>Alaska</option>
            <option value="AZ"'.($selected=='AZ'?' selected="selected"':'').'>Arizona</option>
            <option value="AR"'.($selected=='AR'?' selected="selected"':'').'>Arkansas</option>
            <option value="CA"'.($selected=='CA'?' selected="selected"':'').'>California</option>
            <option value="CO"'.($selected=='CO'?' selected="selected"':'').'>Colorado</option>
            <option value="CT"'.($selected=='CT'?' selected="selected"':'').'>Connecticut</option>
            <option value="DE"'.($selected=='DE'?' selected="selected"':'').'>Delaware</option>
            <option value="DC"'.($selected=='DC'?' selected="selected"':'').'>District Of Columbia</option>
            <option value="FL"'.($selected=='FL'?' selected="selected"':'').'>Florida</option>
            <option value="GA"'.($selected=='GA'?' selected="selected"':'').'>Georgia</option>
            <option value="HI"'.($selected=='HI'?' selected="selected"':'').'>Hawaii</option>
            <option value="ID"'.($selected=='ID'?' selected="selected"':'').'>Idaho</option>
            <option value="IL"'.($selected=='IL'?' selected="selected"':'').'>Illinois</option>
            <option value="IN"'.($selected=='IN'?' selected="selected"':'').'>Indiana</option>
            <option value="IA"'.($selected=='IA'?' selected="selected"':'').'>Iowa</option>
            <option value="KS"'.($selected=='KS'?' selected="selected"':'').'>Kansas</option>
            <option value="KY"'.($selected=='KY'?' selected="selected"':'').'>Kentucky</option>
            <option value="LA"'.($selected=='LA'?' selected="selected"':'').'>Louisiana</option>
            <option value="ME"'.($selected=='ME'?' selected="selected"':'').'>Maine</option>
            <option value="MD"'.($selected=='MD'?' selected="selected"':'').'>Maryland</option>
            <option value="MA"'.($selected=='MA'?' selected="selected"':'').'>Massachusetts</option>
            <option value="MI"'.($selected=='MI'?' selected="selected"':'').'>Michigan</option>
            <option value="MN"'.($selected=='MN'?' selected="selected"':'').'>Minnesota</option>
            <option value="MS"'.($selected=='MS'?' selected="selected"':'').'>Mississippi</option>
            <option value="MO"'.($selected=='MO'?' selected="selected"':'').'>Missouri</option>
            <option value="MT"'.($selected=='MT'?' selected="selected"':'').'>Montana</option>
            <option value="NE"'.($selected=='NE'?' selected="selected"':'').'>Nebraska</option>
            <option value="NV"'.($selected=='NV'?' selected="selected"':'').'>Nevada</option>
            <option value="NH"'.($selected=='NH'?' selected="selected"':'').'>New Hampshire</option>
            <option value="NJ"'.($selected=='NJ'?' selected="selected"':'').'>New Jersey</option>
            <option value="NM"'.($selected=='NM'?' selected="selected"':'').'>New Mexico</option>
            <option value="NY"'.($selected=='NY'?' selected="selected"':'').'>New York</option>
            <option value="NC"'.($selected=='NC'?' selected="selected"':'').'>North Carolina</option>
            <option value="ND"'.($selected=='ND'?' selected="selected"':'').'>North Dakota</option>
            <option value="OH"'.($selected=='OH'?' selected="selected"':'').'>Ohio</option>
            <option value="OK"'.($selected=='OK'?' selected="selected"':'').'>Oklahoma</option>
            <option value="OR"'.($selected=='OR'?' selected="selected"':'').'>Oregon</option>
            <option value="PA"'.($selected=='PA'?' selected="selected"':'').'>Pennsylvania</option>
            <option value="PR"'.($selected=='PR'?' selected="selected"':'').'>Puerto Rico</option>
            <option value="RI"'.($selected=='RI'?' selected="selected"':'').'>Rhode Island</option>
            <option value="SC"'.($selected=='SC'?' selected="selected"':'').'>South Carolina</option>
            <option value="SD"'.($selected=='SD'?' selected="selected"':'').'>South Dakota</option>
            <option value="TN"'.($selected=='TN'?' selected="selected"':'').'>Tennessee</option>
            <option value="TX"'.($selected=='TX'?' selected="selected"':'').'>Texas</option>
            <option value="UT"'.($selected=='UT'?' selected="selected"':'').'>Utah</option>
            <option value="VT"'.($selected=='VT'?' selected="selected"':'').'>Vermont</option>
            <option value="VI"'.($selected=='VI'?' selected="selected"':'').'>Virgin Islands</option>
            <option value="VA"'.($selected=='VA'?' selected="selected"':'').'>Virginia</option>
            <option value="WA"'.($selected=='WA'?' selected="selected"':'').'>Washington</option>
            <option value="WV"'.($selected=='WV'?' selected="selected"':'').'>West Virginia</option>
            <option value="WI"'.($selected=='WI'?' selected="selected"':'').'>Wisconsin</option>
            <option value="WY"'.($selected=='WY'?' selected="selected"':'').'>Wyoming</option>
		</select>';
		return $output;
	}
	
	// create country drop down
	public function createCountryDropDown($name, $id, $selected = '', $class = '')
	{
		$output = '
		<select name="'.$name.'" id="'.$id.'"'.($class?' class="'.$class.'"':'').'">
			<option value="US"'.($selected=='US'?' selected="selected"':'').'>United States</option>
			<option value="AF"'.($selected=='AF'?' selected="selected"':'').'>Afghanistan</option>
			<option value="AX"'.($selected=='AX'?' selected="selected"':'').'>Aland Islands</option>
			<option value="AL"'.($selected=='AL'?' selected="selected"':'').'>Albania</option>
			<option value="DZ"'.($selected=='DZ'?' selected="selected"':'').'>Algeria</option>
			<option value="AS"'.($selected=='AS'?' selected="selected"':'').'>American Samoa</option>
			<option value="AD"'.($selected=='AD'?' selected="selected"':'').'>Andorra</option>
			<option value="AO"'.($selected=='AO'?' selected="selected"':'').'>Angola</option>
			<option value="AI"'.($selected=='AI'?' selected="selected"':'').'>Anguilla</option>
			<option value="AQ"'.($selected=='AQ'?' selected="selected"':'').'>Antarctica</option>
			<option value="AG"'.($selected=='AG'?' selected="selected"':'').'>Antigua &amp; Barbuda</option>
			<option value="AR"'.($selected=='AR'?' selected="selected"':'').'>Argentina</option>
			<option value="AM"'.($selected=='AM'?' selected="selected"':'').'>Armenia</option>
			<option value="AW"'.($selected=='AW'?' selected="selected"':'').'>Aruba</option>
			<option value="AU"'.($selected=='AU'?' selected="selected"':'').'>Australia</option>
			<option value="AT"'.($selected=='AT'?' selected="selected"':'').'>Austria</option>
			<option value="AZ"'.($selected=='AZ'?' selected="selected"':'').'>Azerbaijan</option>
			<option value="BS"'.($selected=='BS'?' selected="selected"':'').'>Bahamas</option>
			<option value="BH"'.($selected=='BH'?' selected="selected"':'').'>Bahrain</option>
			<option value="BD"'.($selected=='BD'?' selected="selected"':'').'>Bangladesh</option>
			<option value="BB"'.($selected=='BB'?' selected="selected"':'').'>Barbados</option>
			<option value="BY"'.($selected=='BY'?' selected="selected"':'').'>Belarus</option>
			<option value="BE"'.($selected=='BE'?' selected="selected"':'').'>Belgium</option>
			<option value="BZ"'.($selected=='BZ'?' selected="selected"':'').'>Belize</option>
			<option value="BJ"'.($selected=='BJ'?' selected="selected"':'').'>Benin</option>
			<option value="BM"'.($selected=='BM'?' selected="selected"':'').'>Bermuda</option>
			<option value="BT"'.($selected=='BT'?' selected="selected"':'').'>Bhutan</option>
			<option value="BO"'.($selected=='BO'?' selected="selected"':'').'>Bolivia</option>
			<option value="BA"'.($selected=='BA'?' selected="selected"':'').'>Bosnia &amp; Herzegovina</option>
			<option value="BW"'.($selected=='BW'?' selected="selected"':'').'>Botswana</option>
			<option value="BV"'.($selected=='BV'?' selected="selected"':'').'>Bouvet Island</option>
			<option value="BR"'.($selected=='BR'?' selected="selected"':'').'>Brazil</option>
			<option value="IO"'.($selected=='IO'?' selected="selected"':'').'>British Indian Ocean Territory</option>
			<option value="BN"'.($selected=='BN'?' selected="selected"':'').'>Brunei Darussalam</option>
			<option value="BG"'.($selected=='BG'?' selected="selected"':'').'>Bulgaria</option>
			<option value="BF"'.($selected=='BF'?' selected="selected"':'').'>Burkina Faso</option>
			<option value="BI"'.($selected=='BI'?' selected="selected"':'').'>Burundi</option>
			<option value="KH"'.($selected=='KH'?' selected="selected"':'').'>Cambodia</option>
			<option value="CM"'.($selected=='CM'?' selected="selected"':'').'>Cameroon</option>
			<option value="CA"'.($selected=='CA'?' selected="selected"':'').'>Canada</option>
			<option value="CV"'.($selected=='CV'?' selected="selected"':'').'>Cape Verde</option>
			<option value="KY"'.($selected=='KY'?' selected="selected"':'').'>Cayman Islands</option>
			<option value="CF"'.($selected=='CF'?' selected="selected"':'').'>Central African Rep</option>
			<option value="TD"'.($selected=='TD'?' selected="selected"':'').'>Chad</option>
			<option value="CL"'.($selected=='CL'?' selected="selected"':'').'>Chile</option>
			<option value="CN"'.($selected=='CN'?' selected="selected"':'').'>China</option>
			<option value="CX"'.($selected=='CX'?' selected="selected"':'').'>Christmas Island</option>
			<option value="CC"'.($selected=='CC'?' selected="selected"':'').'>Cocos (Keeling) Islands</option>
			<option value="CO"'.($selected=='CO'?' selected="selected"':'').'>Colombia</option>
			<option value="KM"'.($selected=='KM'?' selected="selected"':'').'>Comoros</option>
			<option value="CG"'.($selected=='CG'?' selected="selected"':'').'>Congo</option>
			<option value="CK"'.($selected=='CK'?' selected="selected"':'').'>Cook Islands</option>
			<option value="CR"'.($selected=='CR'?' selected="selected"':'').'>Costa Rica</option>
			<option value="CI"'.($selected=='CI'?' selected="selected"':'').'>Côte d\'Ivoire</option>
			<option value="HR"'.($selected=='HR'?' selected="selected"':'').'>Croatia</option>
			<option value="CU"'.($selected=='CU'?' selected="selected"':'').'>Cuba</option>
			<option value="CY"'.($selected=='CY'?' selected="selected"':'').'>Cyprus</option>
			<option value="CZ"'.($selected=='CZ'?' selected="selected"':'').'>Czech Republic</option>
			<option value="CD"'.($selected=='CD'?' selected="selected"':'').'>Dem Rep of Congo (Zaire)</option>
			<option value="DK"'.($selected=='DK'?' selected="selected"':'').'>Denmark</option>
			<option value="DJ"'.($selected=='DJ'?' selected="selected"':'').'>Djibouti</option>
			<option value="DM"'.($selected=='DM'?' selected="selected"':'').'>Dominica</option>
			<option value="DO"'.($selected=='DO'?' selected="selected"':'').'>Dominican Republic</option>
			<option value="EC"'.($selected=='EC'?' selected="selected"':'').'>Ecuador</option>
			<option value="EG"'.($selected=='EG'?' selected="selected"':'').'>Egypt</option>
			<option value="SV"'.($selected=='SV'?' selected="selected"':'').'>El Salvador</option>
			<option value="GQ"'.($selected=='GQ'?' selected="selected"':'').'>Equatorial Guinea</option>
			<option value="ER"'.($selected=='ER'?' selected="selected"':'').'>Eritrea</option>
			<option value="EE"'.($selected=='EE'?' selected="selected"':'').'>Estonia</option>
			<option value="ET"'.($selected=='ET'?' selected="selected"':'').'>Ethiopia</option>
			<option value="FK"'.($selected=='FK'?' selected="selected"':'').'>Falkland Islands (Malvinas)</option>
			<option value="FO"'.($selected=='FO'?' selected="selected"':'').'>Faeroe Islands</option>
			<option value="FJ"'.($selected=='FJ'?' selected="selected"':'').'>Fiji</option>
			<option value="FI"'.($selected=='FI'?' selected="selected"':'').'>Finland</option>
			<option value="FR"'.($selected=='FR'?' selected="selected"':'').'>France</option>
			<option value="GF"'.($selected=='GF'?' selected="selected"':'').'>French Guiana</option>
			<option value="PF"'.($selected=='PF'?' selected="selected"':'').'>French Polynesia/Tahiti</option>
			<option value="TF"'.($selected=='TF'?' selected="selected"':'').'>French Southern Territories</option>
			<option value="GA"'.($selected=='GA'?' selected="selected"':'').'>Gabon</option>
			<option value="GM"'.($selected=='GM'?' selected="selected"':'').'>Gambia</option>
			<option value="GE"'.($selected=='GE'?' selected="selected"':'').'>Georgia</option>
			<option value="DE"'.($selected=='DE'?' selected="selected"':'').'>Germany</option>
			<option value="GH"'.($selected=='GH'?' selected="selected"':'').'>Ghana</option>
			<option value="GI"'.($selected=='GI'?' selected="selected"':'').'>Gibraltar</option>
			<option value="GR"'.($selected=='GR'?' selected="selected"':'').'>Greece</option>
			<option value="GL"'.($selected=='GL'?' selected="selected"':'').'>Greenland</option>
			<option value="GD"'.($selected=='GD'?' selected="selected"':'').'>Grenada</option>
			<option value="GP"'.($selected=='GP'?' selected="selected"':'').'>Guadeloupe</option>
			<option value="GU"'.($selected=='GU'?' selected="selected"':'').'>Guam</option>
			<option value="GT"'.($selected=='GT'?' selected="selected"':'').'>Guatemala</option>
			<option value="GG"'.($selected=='GG'?' selected="selected"':'').'>Guernsey</option>
			<option value="GN"'.($selected=='GN'?' selected="selected"':'').'>Guinea</option>
			<option value="GW"'.($selected=='GW'?' selected="selected"':'').'>Guinea-Bissau</option>
			<option value="GY"'.($selected=='GY'?' selected="selected"':'').'>Guyana</option>
			<option value="HT"'.($selected=='HT'?' selected="selected"':'').'>Haiti</option>
			<option value="HM"'.($selected=='HM'?' selected="selected"':'').'>Heard Island &amp; McDonald Islands</option>
			<option value="VA"'.($selected=='VA'?' selected="selected"':'').'>Holy See (Vatican City State)</option>
			<option value="HN"'.($selected=='HN'?' selected="selected"':'').'>Honduras</option>
			<option value="HK"'.($selected=='HK'?' selected="selected"':'').'>Hong Kong</option>
			<option value="HU"'.($selected=='HU'?' selected="selected"':'').'>Hungary</option>
			<option value="IS"'.($selected=='IS'?' selected="selected"':'').'>Iceland</option>
			<option value="IN"'.($selected=='IN'?' selected="selected"':'').'>India</option>
			<option value="ID"'.($selected=='ID'?' selected="selected"':'').'>Indonesia</option>
			<option value="IR"'.($selected=='IR'?' selected="selected"':'').'>Iran</option>
			<option value="IQ"'.($selected=='IQ'?' selected="selected"':'').'>Iraq</option>
			<option value="IE"'.($selected=='IE'?' selected="selected"':'').'>Ireland</option>
			<option value="IM"'.($selected=='IM'?' selected="selected"':'').'>Isle of Man</option>
			<option value="IL"'.($selected=='IL'?' selected="selected"':'').'>Israel</option>
			<option value="IT"'.($selected=='IT'?' selected="selected"':'').'>Italy</option>
			<option value="CI"'.($selected=='CI'?' selected="selected"':'').'>Ivory Coast</option>
			<option value="JM"'.($selected=='JM'?' selected="selected"':'').'>Jamaica</option>
			<option value="JP"'.($selected=='JP'?' selected="selected"':'').'>Japan</option>
			<option value="JE"'.($selected=='JE'?' selected="selected"':'').'>Jersey</option>
			<option value="JO"'.($selected=='JO'?' selected="selected"':'').'>Jordan</option>
			<option value="KZ"'.($selected=='KZ'?' selected="selected"':'').'>Kazakhstan</option>
			<option value="KE"'.($selected=='KE'?' selected="selected"':'').'>Kenya</option>
			<option value="KI"'.($selected=='KI'?' selected="selected"':'').'>Kiribati</option>
			<option value="KP"'.($selected=='KP'?' selected="selected"':'').'>Korea, Democratic Republic of</option>
			<option value="KR"'.($selected=='KR'?' selected="selected"':'').'>Korea, Republic of</option>
			<option value="KW"'.($selected=='KW'?' selected="selected"':'').'>Kuwait</option>
			<option value="KG"'.($selected=='KG'?' selected="selected"':'').'>Kyrgyzstan</option>
			<option value="LA"'.($selected=='LA'?' selected="selected"':'').'>Laos</option>
			<option value="LV"'.($selected=='LV'?' selected="selected"':'').'>Latvia</option>
			<option value="LB"'.($selected=='LB'?' selected="selected"':'').'>Lebanon</option>
			<option value="LS"'.($selected=='LS'?' selected="selected"':'').'>Lesotho</option>
			<option value="LR"'.($selected=='LR'?' selected="selected"':'').'>Liberia</option>
			<option value="LY"'.($selected=='LY'?' selected="selected"':'').'>Libya</option>
			<option value="LI"'.($selected=='LI'?' selected="selected"':'').'>Liechtenstein</option>
			<option value="LT"'.($selected=='LT'?' selected="selected"':'').'>Lithuania</option>
			<option value="LU"'.($selected=='LU'?' selected="selected"':'').'>Luxembourg</option>
			<option value="MO"'.($selected=='MO'?' selected="selected"':'').'>Macau</option>
			<option value="MK"'.($selected=='MK'?' selected="selected"':'').'>Macedonia</option>
			<option value="MG"'.($selected=='MG'?' selected="selected"':'').'>Madagascar</option>
			<option value="MW"'.($selected=='MW'?' selected="selected"':'').'>Malawi</option>
			<option value="MY"'.($selected=='MY'?' selected="selected"':'').'>Malaysia</option>
			<option value="MV"'.($selected=='MV'?' selected="selected"':'').'>Maldives</option>
			<option value="ML"'.($selected=='ML'?' selected="selected"':'').'>Mali</option>
			<option value="MT"'.($selected=='MT'?' selected="selected"':'').'>Malta</option>
			<option value="MH"'.($selected=='MH'?' selected="selected"':'').'>Marshall Islands</option>
			<option value="MQ"'.($selected=='MQ'?' selected="selected"':'').'>Martinique</option>
			<option value="MR"'.($selected=='MR'?' selected="selected"':'').'>Mauritania</option>
			<option value="MU"'.($selected=='MU'?' selected="selected"':'').'>Mauritius</option>
			<option value="MX"'.($selected=='MX'?' selected="selected"':'').'>Mexico</option>
			<option value="FM"'.($selected=='FM'?' selected="selected"':'').'>Micronesia</option>
			<option value="MD"'.($selected=='MD'?' selected="selected"':'').'>Moldova</option>
			<option value="MC"'.($selected=='MC'?' selected="selected"':'').'>Monaco</option>
			<option value="MN"'.($selected=='MN'?' selected="selected"':'').'>Mongolia</option>
			<option value="MS"'.($selected=='MS'?' selected="selected"':'').'>Montserrat</option>
			<option value="MA"'.($selected=='MA'?' selected="selected"':'').'>Morocco</option>
			<option value="MZ"'.($selected=='MZ'?' selected="selected"':'').'>Mozambique</option>
			<option value="MM"'.($selected=='MM'?' selected="selected"':'').'>Myanmar</option>
			<option value="NA"'.($selected=='NA'?' selected="selected"':'').'>Namibia</option>
			<option value="NR"'.($selected=='NR'?' selected="selected"':'').'>Nauru</option>
			<option value="NP"'.($selected=='NP'?' selected="selected"':'').'>Nepal</option>
			<option value="NL"'.($selected=='NL'?' selected="selected"':'').'>Netherlands</option>
			<option value="AN"'.($selected=='AN'?' selected="selected"':'').'>Netherlands Antilles</option>
			<option value="NC"'.($selected=='NC'?' selected="selected"':'').'>New Caledonia</option>
			<option value="NZ"'.($selected=='NZ'?' selected="selected"':'').'>New Zealand</option>
			<option value="NI"'.($selected=='NI'?' selected="selected"':'').'>Nicaragua</option>
			<option value="NE"'.($selected=='NE'?' selected="selected"':'').'>Niger</option>
			<option value="NG"'.($selected=='NG'?' selected="selected"':'').'>Nigeria</option>
			<option value="NU"'.($selected=='NU'?' selected="selected"':'').'>Niue</option>
			<option value="NF"'.($selected=='NF'?' selected="selected"':'').'>Norfolk Island</option>
			<option value="MP"'.($selected=='MP'?' selected="selected"':'').'>Northern Mariana Islands</option>
			<option value="NO"'.($selected=='NO'?' selected="selected"':'').'>Norway</option>
			<option value="OM"'.($selected=='OM'?' selected="selected"':'').'>Oman</option>
			<option value="PK"'.($selected=='PK'?' selected="selected"':'').'>Pakistan</option>
			<option value="PW"'.($selected=='PW'?' selected="selected"':'').'>Palau</option>
			<option value="PS"'.($selected=='PS'?' selected="selected"':'').'>Palestinian Territory</option>
			<option value="PA"'.($selected=='PA'?' selected="selected"':'').'>Panama</option>
			<option value="PG"'.($selected=='PG'?' selected="selected"':'').'>Papua New Guinea</option>
			<option value="PY"'.($selected=='PY'?' selected="selected"':'').'>Paraguay</option>
			<option value="PE"'.($selected=='PE'?' selected="selected"':'').'>Peru</option>
			<option value="PH"'.($selected=='PH'?' selected="selected"':'').'>Philippines</option>
			<option value="PN"'.($selected=='PN'?' selected="selected"':'').'>Pitcairn</option>
			<option value="PL"'.($selected=='PL'?' selected="selected"':'').'>Poland</option>
			<option value="PT"'.($selected=='PT'?' selected="selected"':'').'>Portugal</option>
			<option value="PR"'.($selected=='PR'?' selected="selected"':'').'>Puerto Rico</option>
			<option value="QA"'.($selected=='QA'?' selected="selected"':'').'>Qatar</option>
			<option value="RE"'.($selected=='RE'?' selected="selected"':'').'>Reunion Is.</option>
			<option value="RO"'.($selected=='RO'?' selected="selected"':'').'>Romania</option>
			<option value="RU"'.($selected=='RU'?' selected="selected"':'').'>Russia</option>
			<option value="RW"'.($selected=='RW'?' selected="selected"':'').'>Rwanda</option>
			<option value="SH"'.($selected=='SH'?' selected="selected"':'').'>Saint Helena</option>
			<option value="KN"'.($selected=='KN'?' selected="selected"':'').'>Saint Kitts &amp; Nevis</option>
			<option value="LC"'.($selected=='LC'?' selected="selected"':'').'>Saint Lucia</option>
			<option value="PM"'.($selected=='PM'?' selected="selected"':'').'>Saint Pierre &amp; Miquelon</option>
			<option value="VC"'.($selected=='VC'?' selected="selected"':'').'>Saint Vincent &amp; Grenadines</option>
			<option value="AS"'.($selected=='AS'?' selected="selected"':'').'>Samoa (Amer.)</option>
			<option value="WS"'.($selected=='WS'?' selected="selected"':'').'>Samoa (Western)</option>
			<option value="SM"'.($selected=='SM'?' selected="selected"':'').'>San Marino</option>
			<option value="KN"'.($selected=='KN'?' selected="selected"':'').'>Sao Tome &amp; Principe</option>
			<option value="SA"'.($selected=='SA'?' selected="selected"':'').'>Saudi Arabia</option>
			<option value="SN"'.($selected=='SN'?' selected="selected"':'').'>Senegal</option>
			<option value="CS"'.($selected=='CS'?' selected="selected"':'').'>Serbia &amp; Montenegro</option>
			<option value="SC"'.($selected=='SC'?' selected="selected"':'').'>Seychelles</option>
			<option value="SL"'.($selected=='SL'?' selected="selected"':'').'>Sierra Leone</option>
			<option value="SG"'.($selected=='SG'?' selected="selected"':'').'>Singapore</option>
			<option value="SK"'.($selected=='SK'?' selected="selected"':'').'>Slovakia</option>
			<option value="SI"'.($selected=='SI'?' selected="selected"':'').'>Slovenia</option>
			<option value="SB"'.($selected=='SB'?' selected="selected"':'').'>Solomon Islands</option>
			<option value="ZA"'.($selected=='ZA'?' selected="selected"':'').'>South Africa</option>
			<option value="GS"'.($selected=='GS'?' selected="selected"':'').'>South Georgia &amp; S. Sandwich Islands</option>
			<option value="ES"'.($selected=='ES'?' selected="selected"':'').'>Spain</option>
			<option value="LK"'.($selected=='LK'?' selected="selected"':'').'>Sri Lanka</option>
			<option value="SD"'.($selected=='SD'?' selected="selected"':'').'>Sudan</option>
			<option value="SR"'.($selected=='SR'?' selected="selected"':'').'>Suriname</option>
			<option value="SJ"'.($selected=='SJ'?' selected="selected"':'').'>Svalbard &amp; Jan Mayen</option>
			<option value="SZ"'.($selected=='SZ'?' selected="selected"':'').'>Swaziland</option>
			<option value="SE"'.($selected=='SE'?' selected="selected"':'').'>Sweden</option>
			<option value="CH"'.($selected=='CH'?' selected="selected"':'').'>Switzerland</option>
			<option value="SY"'.($selected=='SY'?' selected="selected"':'').'>Syria</option>
			<option value="TW"'.($selected=='TW'?' selected="selected"':'').'>Taiwan</option>
			<option value="TJ"'.($selected=='TJ'?' selected="selected"':'').'>Tajikistan</option>
			<option value="TZ"'.($selected=='TZ'?' selected="selected"':'').'>Tanzania</option>
			<option value="TH"'.($selected=='TH'?' selected="selected"':'').'>Thailand</option>
			<option value="TL"'.($selected=='TL'?' selected="selected"':'').'>Timor-Leste</option>
			<option value="TG"'.($selected=='TG'?' selected="selected"':'').'>Togo</option>
			<option value="TK"'.($selected=='TK'?' selected="selected"':'').'>Tokelau</option>
			<option value="TO"'.($selected=='TO'?' selected="selected"':'').'>Tonga</option>
			<option value="TT"'.($selected=='TT'?' selected="selected"':'').'>Trinidad &amp; Tobago</option>
			<option value="TN"'.($selected=='TN'?' selected="selected"':'').'>Tunisia</option>
			<option value="TR"'.($selected=='TR'?' selected="selected"':'').'>Turkey</option>
			<option value="TM"'.($selected=='TM'?' selected="selected"':'').'>Turkmenistan</option>
			<option value="TC"'.($selected=='TC'?' selected="selected"':'').'>Turks &amp; Caicos Islands</option>
			<option value="TV"'.($selected=='TV'?' selected="selected"':'').'>Tuvalu</option>
			<option value="UG"'.($selected=='UG'?' selected="selected"':'').'>Uganda</option>
			<option value="UA"'.($selected=='UA'?' selected="selected"':'').'>Ukraine</option>
			<option value="AE"'.($selected=='AE'?' selected="selected"':'').'>United Arab Emirates</option>
			<option value="GB"'.($selected=='GB'?' selected="selected"':'').'>United Kingdom</option>
			<option value="UM"'.($selected=='UM'?' selected="selected"':'').'>United States Minor Outlying Islands</option>
			<option value="UY"'.($selected=='UY'?' selected="selected"':'').'>Uruguay</option>
			<option value="UZ"'.($selected=='UZ'?' selected="selected"':'').'>Uzbekistan</option>
			<option value="VU"'.($selected=='VU'?' selected="selected"':'').'>Vanuatu</option>
			<option value="VE"'.($selected=='VE'?' selected="selected"':'').'>Venezuela</option>
			<option value="VN"'.($selected=='VN'?' selected="selected"':'').'>Vietnam</option>
			<option value="VG"'.($selected=='VG'?' selected="selected"':'').'>Virgin Islands, British</option>
			<option value="VI"'.($selected=='VI'?' selected="selected"':'').'>Virgin Islands, US</option>
			<option value="WF"'.($selected=='WF'?' selected="selected"':'').'>Wallis &amp; Futuna Isle</option>
			<option value="EH"'.($selected=='EH'?' selected="selected"':'').'>Western Sahara</option>
			<option value="YE"'.($selected=='YE'?' selected="selected"':'').'>Yemen</option>
			<option value="ZM"'.($selected=='ZM'?' selected="selected"':'').'>Zambia</option>
			<option value="ZW"'.($selected=='ZW'?' selected="selected"':'').'>Zimbabwe</option>
        </select>';
		return $output;
	}
}
?>