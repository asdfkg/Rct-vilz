<?php
require_once '/kunden/homepages/27/d309616710/htdocs/private/config.php';

if ($_SESSION['RESERVATION']->get('step') == 4) die(header('Location: /reservations'));

$_SESSION['RESERVATION']->set('step', 3);

if (isset($_POST['action']) && $_POST['action'] == 'checkout')
{
	$_SESSION['RESERVATION']->set('propertyId', $_POST['propertyId']);
	$_SESSION['RESERVATION']->set('propertyName', $_POST['propertyName']);
	$_SESSION['RESERVATION']->set('destName', $_POST['destName']);
	$_SESSION['RESERVATION']->set('checkInDt', $_POST['checkInDt']);
	$_SESSION['RESERVATION']->set('checkOutDt', $_POST['checkOutDt']);
	$_SESSION['RESERVATION']->set('serviceLevel', $_POST['serviceLevel']);
	$_SESSION['RESERVATION']->set('nightTotal', $_POST['nightTotal']);
	$_SESSION['RESERVATION']->set('destCurrency', $_POST['destCurrency']);
	$_SESSION['RESERVATION']->set('destTax', $_POST['destTax']);
	$_SESSION['RESERVATION']->set('rateNight', $_POST['rateNight']);
	$_SESSION['RESERVATION']->set('rateTotal', $_POST['rateNight'] * $_POST['nightTotal']);
	
	if (isset($_POST['additionalServices']))
	{
		$additionalServices = null;
		$additionalServicesTagsArray = null;
		foreach ($_POST['additionalServices'] as $additionalService)
		{
			$additionalServiceArray = explode('|', $additionalService);
			$additionalServices .= $additionalServiceArray[1].'<br>';
			$additionalServicesTags[] = $additionalServiceArray[0];
		}
		$additionalServices = trim($additionalServices, '<br>');
		$_SESSION['RESERVATION']->set('additionalServices', $additionalServices);
		$_SESSION['RESERVATION']->set('additionalServicesTags', $additionalServicesTags);
	}
	
	header('Location: '.$_SERVER['REQUEST_URI']);
}

if (isset($_POST['discount']))
{
	if ($_POST['discount'] > 0)
	{
		$_SESSION['RESERVATION']->set('rateDiscount', $_POST['discount']);
		$_SESSION['RESERVATION']->set('rateTotal', $_SESSION['RESERVATION']->get('rateTotal') - ($_SESSION['RESERVATION']->get('rateTotal') * $_SESSION['RESERVATION']->get('rateDiscount') / 100));
	}
	header('Location: '.$_SERVER['REQUEST_URI']);
}
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Checkout - VILLAZZO</title>
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
                                            <li class="active" onclick="location.href = './';">Select Your<br>Villa</li>
                                            <li class="active" onclick="location.href = '<?php echo '/reservations/services?property='.$_SESSION['RESERVATION']->get('propertyName').'&check_in='.date('m/d/Y', strtotime($_SESSION['RESERVATION']->get('checkInDt'))).'&check_out='.date('m/d/Y', strtotime($_SESSION['RESERVATION']->get('checkOutDt'))); ?>';">Customize Your<br>Service Experience</li>
                                            <li class="active">Contact And<br>Payment Information</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Reservations Services Header Image Section Start -->
            <section id="reservations-services-section">
	            <div id="rate-details">
	                <div class="row text-center">
	                    <div class="small-12 columns services">
		                    <div class="row service">
	                            <div class="small-4 columns">
	                                <p class="text-left">DESTINATION:</p>
	                            </div>
	                            <div class="small-8 columns">
	                                <p class="text-right"><?php echo 'Villa '.$_SESSION['RESERVATION']->get('propertyName'); ?></p>
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="small-4 columns">
	                                <p class="text-left">ARRIVAL:</p>
	                            </div>
	                            <div class="small-8 columns">
	                                <p class="text-right"><?php echo date('F jS, Y', strtotime($_SESSION['RESERVATION']->get('checkInDt'))); ?></p>
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="small-4 columns">
	                                <p class="text-left">DEPARTURE:</p>
	                            </div>
	                            <div class="small-8 columns">
	                                <p class="text-right"><?php echo date('F jS, Y', strtotime($_SESSION['RESERVATION']->get('checkOutDt'))); ?></p>
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="small-4 columns">
	                                <p class="text-left">LENGTH OF STAY:</p>
	                            </div>
	                            <div class="small-8 columns">
	                                <p class="text-right"><?php echo $_SESSION['RESERVATION']->get('nightTotal'); ?> Nights</p>
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="small-4 columns">
	                                <p class="text-left">LEVEL OF SERVICE:</p>
	                            </div>
	                            <div class="small-8 columns">
	                                <p class="text-right"><?php echo $_SESSION['RESERVATION']->get('serviceLevel'); ?> Stars</p>
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="small-4 columns">
	                                <p class="text-left">NIGHTLY RATE:</p>
	                            </div>
	                            <div class="small-8 columns">
	                                <p class="text-right"><?php echo $_SESSION['RESERVATION']->get('destCurrency').number_format($_SESSION['RESERVATION']->get('rateNight')); ?></p>
	                            </div>
	                        </div>
	                        <?php if ($_SESSION['RESERVATION']->get('additionalServices')) { ?>
	                        <div class="row">
	                            <div class="small-4 columns">
	                                <p class="text-left">ADDITIONAL SERVICES:</p>
	                            </div>
	                            <div class="small-8 columns">
	                                <p class="text-right"><?php echo $_SESSION['RESERVATION']->get('additionalServices'); ?></p>
	                            </div>
	                        </div>
	                        <?php } ?>
			                <div class="row total">
			                    <div class="small-3 columns">
				                    <?php if ($_SESSION['USER']->getUserGroupId() == 1 || $_SESSION['USER']->getUserGroupId() == 2) { ?>
				                    <form method="post">
					                    <input type="text" name="discount" id="discount" placeholder="<?php echo ($_SESSION['RESERVATION']->get('rateDiscount')?'Discounted '.$_SESSION['RESERVATION']->get('rateDiscount').' %':'Discount (%)'); ?>">
				                    </form>
				                    <?php } ?>
			                    </div>
			                    <div class="small-9 columns">
			                        <p class="text-right">TOTAL: <?php echo $_SESSION['RESERVATION']->get('destCurrency').number_format($_SESSION['RESERVATION']->get('rateTotal')); ?></p>
			                    </div>
			                </div>
	                    </div>
	                </div>
	            </div>
            </section>
            <!-- Reservations Title and Steps Section Start -->
            <!-- Checkout Form Start-->
            <section id="checkout-form-section">
                <div class="row">
                    <div class="small-12 columns checkout-form">
		                <form id="checkoutForm" onsubmit="return false;">
	                        <div class="row">
	                            <div class="small-12 columns title">
	                                <h6>CONTACT</h6>
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="small-12 columns">
	                                <div class="row">
	                                    <div class="medium-6 small-12 columns">
	                                        <div class="row">
	                                            <div class="medium-4 small-4 columns">
	                                                <label for="title" class="left inline">Title</label>
	                                            </div>
	                                            <div class="medium-8 small-8 columns">
	                                                <select name="title" id="title">
														<option value="Mr.">Mr.</option>
														<option value="Mrs.">Mrs.</option>
														<option value="Ms.">Ms.</option>
	                                                </select>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="medium-4 small-4 columns">
	                                                <label for="firstName" class="left inline">First Name</label>
	                                            </div>
	                                            <div class="medium-8 small-8 columns">
	                                                <input type="text" name="firstName" id="firstName" class="required" placeholder="">
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="medium-4 small-4 columns">
	                                                <label for="lastName" class="left inline">Last Name</label>
	                                            </div>
	                                            <div class="medium-8 small-8 columns">
	                                                <input type="text" name="lastName" id="lastName" class="required" placeholder="">
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="medium-4 small-4 columns">
	                                                <label for="company" class="left inline">Company</label>
	                                            </div>
	                                            <div class="medium-8 small-8 columns">
	                                                <input type="text" name="company" id="company" placeholder="">
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="medium-4 small-4 columns">
	                                                <label for="email" class="left inline">Email</label>
	                                            </div>
	                                            <div class="medium-8 small-8 columns">
	                                                <input type="text" name="email" id="email" class="required" placeholder="">
	                                            </div>
	                                        </div>
	                                        <?php if ($_SESSION['USER']->getUserGroupId() == 1 || $_SESSION['USER']->getUserGroupId() == 2) { ?>
	                                        <div class="row">
	                                            <div class="columns">
	                                                <label for="email" class="left inline"><input type="checkbox" name="emailConfirmation" id="emailConfirmation" value="1"> Send confirmation to this email</label>
	                                            </div>
	                                        </div>
	                                        <?php } ?>
	                                        <div class="row">
	                                            <div class="medium-4 small-4 columns">
	                                                <label for="phone" class="left inline">Phone</label>
	                                            </div>
	                                            <div class="medium-8 small-8 columns">
	                                                <input type="text" name="phone" id="phone" class="required" placeholder="">
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="small-12 columns title">
	                                <h6>PAYMENT (optional)</h6>
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="small-12 columns">
	                                <p>Your credit card information is only to confirm the reservation; your card will <strong>not</strong> be charged until your booking has been confirmed in writing.</p>
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="medium-6 small-12 columns">
	                                <div class="row">
	                                    <div class="medium-4 small-4 columns">
	                                        <label for="" class="left inline">Credit card type</label>
	                                    </div>
	                                    <div class="medium-8 small-8 columns">
	                                        <?php echo $_SESSION['UTILITY']->createCreditCardDropDown('ccType', 'ccType'); ?>
	                                    </div>
	                                </div>
	                                <div class="row">
	                                    <div class="medium-4 small-4 columns">
	                                        <label for="" class="left inline">Name on card</label>
	                                    </div>
	                                    <div class="medium-8 small-8 columns">
	                                        <input type="text" name="ccName" id="" placeholder="">
	                                    </div>
	                                </div>
	                                <div class="row">
	                                    <div class="medium-4 small-4 columns">
	                                        <label for="" class="left inline">Credit card number</label>
	                                    </div>
	                                    <div class="medium-8 small-8 columns">
	                                        <input type="text" name="ccNumber" id="ccNumber" placeholder="">
	                                    </div>
	                                </div>
	                                <div class="row">
	                                    <div class="medium-4 small-4 columns">
	                                        <label for="" class="left inline">Expiration</label>
	                                    </div>
	                                    <div class="medium-4 small-4 columns">
	                                        <?php echo $_SESSION['UTILITY']->createMonthDropDown('ccExpMonth', 'ccExpMonth'); ?>
	                                    </div>
	                                    <div class="medium-4 small-4 columns">
	                                        <?php echo $_SESSION['UTILITY']->createYearDropDown('ccExpYear', 'ccExpYear'); ?>
	                                    </div>
	                                </div>
	                                <div class="row">
	                                    <div class="medium-4 small-4 columns">
	                                        <label for="" class="left inline">CVV code</label>
	                                    </div>
	                                    <div class="medium-8 small-8 columns">
	                                        <input type="text" name="ccCVV" id="ccCVV" placeholder="">
	                                    </div>
	                                </div>
	                            </div>
	                            <div class="medium-6 small-12 columns">
	                                <div class="row">
	                                    <div class="medium-4 small-4 columns">
	                                        <label for="" class="left inline">Street</label>
	                                    </div>
	                                    <div class="medium-8 small-8 columns">
	                                        <input type="text" name="ccStreet1" id="ccStreet1" placeholder="">
	                                    </div>
	                                </div>
	                                <div class="row">
	                                    <div class="medium-4 small-4 columns">
	                                        <label for="" class="left inline">Street 2</label>
	                                    </div>
	                                    <div class="medium-8 small-8 columns">
	                                        <input type="text" name="ccStreet2" id="ccStreet2" placeholder="">
	                                    </div>
	                                </div>
	                                <div class="row">
	                                    <div class="medium-4 small-4 columns">
	                                        <label for="" class="left inline">City</label>
	                                    </div>
	                                    <div class="medium-8 small-8 columns">
	                                        <input type="text" name="ccCity" id="ccCity" placeholder="">
	                                    </div>
	                                </div>
	                                <div class="row">
	                                    <div class="medium-4 small-4 columns">
	                                        <label for="" class="left inline">State / Zip Code</label>
	                                    </div>
	                                    <div class="medium-4 small-4 columns">
		                                    <input type="text" name="ccStateOther" id="ccStateOther" placeholder="" style="display:none;">
	                                        <?php echo $_SESSION['UTILITY']->createStateDropDown('ccStateUS', 'ccStateUS'); ?>
	                                    </div>
	                                    <div class="medium-4 small-4 columns">
	                                        <input type="text" name="ccZipCode" id="ccZipCode" placeholder="">
	                                    </div>
	                                </div>
	                                <div class="row">
	                                    <div class="medium-4 small-4 columns">
	                                        <label for="" class="left inline">Country</label>
	                                    </div>
	                                    <div class="medium-8 small-8 columns">
	                                        <?php echo $_SESSION['UTILITY']->createCountryDropDown('ccCountry', 'ccCountry'); ?>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="small-12 columns title">
	                                <h6>TERMS & CONDITIONS</h6>
	                            </div>
	                        </div>
	                        <div class="row">
	                            <div class="small-12 columns">
	                                <label id="termsAndContidionsLabel" for="termsAndContidions"><input id="termsAndContidions" type="checkbox" class="required"> I agree to the following General Terms & Conditions</label>
	                            </div>
	                        </div>
		                    <div class="row">
		                        <div class="small-12 columns" id="terms">
									<p><strong>RATES.</strong> Any taxes (sales, occupancy, etc.) that may be required to be paid to governmental authorities are not included in the Rate, but such taxes shall be included in the Invoice to the Guest. <br>
									A charge of $500 per day will apply for each day the maximum number of persons on the Property is exceeded, in addition to the possible loss of the security deposit as specified below.</p>
									<p><strong>PRE-PAYMENT</strong>. For reservations made 70 days or more prior to arrival, 25% of rent is due upon signing this Reservation Form. The remaining balance of 75% must be paid at least 70 days prior to arrival. For reservations made within 70 days of arrival, full payment is required upon signing of this Registration Form. If payment is not received within 48 hours after signature, Villazzo is under no obligation to guarantee the reservation.</a></p>
									<p><strong>CANCELLATIONS AND REFUNDS.</strong> Cancellation of a booking may result in the partial or complete loss of any pre-payments made, as specified below. All cancellations must be in writing. Cancellation charges are as follows:<br>
									70 days or more prior to arrival                                                          No Penalty<br>
									45-70 days prior to arrival                                                                  50% of Pre-Payment<br>
									45 days or less prior to arrival                                                            100% of Pre-Payment<br>
									In case of severe natural causes (force majeure) prohibiting travel or adequate use of the Property during the booking period (such as hurricanes, flooding, earthquakes etc.), the booking may be canceled without penalty.</p>
									<p><strong>AMENDMENTS TO BOOKINGS.</strong> If any changes are made to the booking within 14 days of the originally scheduled arrival date, Villazzo reserves the right to deem the changes as a cancellation and re-booking, in which event certain penalties may apply as provided herein. All requests for changes or amendments must be in writing.<br>
									Should the selected Property not be available because of reasons outside of Villazzo&rsquo;s control, Villazzo reserves the right to relocate the Guest to a Property of equal or better quality (in Villazzo&rsquo;s sole determination) in the same destination.  The Guest agrees to the right of Villazzo to relocate the Guest in such event. </p>
									<p><strong>CREDIT CARDS AND AUTHORIZATION.</strong> Personal checks are not accepted for payment. Signature of the Credit Card Authorization and/or the Guest Registration Form shall constitute confirmation that the Guest has received, read, understood and agreed to all of the Terms and Conditions contained herein. Moreover, verbal authorization from the Guest (or from his/her agent) to use a credit card for the deposit and/or final payment shall constitute ratification of the Terms and Conditions stated herein.</p>
									<p><strong>USE OF PROPERTY.</strong> The Guest and his/her licensees, invitees, family, vendors, employees or others (the &ldquo;Occupants&rdquo;) shall use the Property for residential vacation purposes only, and shall have exclusive use of the Property during their reservation period. In no event shall the Property be utilized, in whole or in part, by the Occupants for any commercial purposes. In the event of such improper use, Villazzo shall have the right to refuse access to the Property by the Occupants, or to immediately terminate the use of the Property by the Occupants, with no return of any deposit, prepayment or full payment.  Moreover, the Occupants may not make any alterations to the Property whatsoever. The Guest may not authorize any other persons to utilize the Property in the Guest&rsquo;s absence; nor may the Guest assign or sublease the Property, in whole or in part.  All Occupants who stay on the Property overnight must be properly registered with Villazzo, in writing.<br>
									The Occupants shall use the Property only in a dignified and quiet manner that is respectful of the Property&rsquo;s neighbors and the neighborhood. Local laws prohibit private or public nuisances; noise violations; parking on the street; parking on the right of way; parking on (or blocking) adjacent private properties; parties that create disturbances of the peace, or any other acts that may be deemed improper or illegal by local regulatory authorities.  Guests having any question as to whether certain conduct is violative of local, county, or state laws, rules, regulations or ordinances should consult Villazzo. Any violation of this paragraph shall be grounds for immediate termination of the stay, and may also constitute a violation of the statutes, ordinances or regulations of the local authorities, which may subject the Guest and/or the Occupants  to civil, criminal or administrative fines, penalties or other sanctions. The Guest shall fully indemnify the Owner and Villazzo (and its officers, directors, managers, owners, employees and agents) in all respects as to any and all costs,  expenses, fines or judgments sustained or incurred in any regard as a result of any breach hereof by the Guest or the Occupants.</p>
									<p><strong>MAINTENANCE.</strong> Villazzo shall provide any routine maintenance and repair to the Property. For all maintenance and repair to the Property that is not covered by a management contract with the Owner, Villazzo will invoice the Guest for repairs and maintenance according to the Villazzo&rsquo;s current Villazzo Living price list. The Guest shall promptly notify Villazzo of any maintenance or repair requirements, or any defects.</p>
									<p><strong>KEYS AND REMOTE CONTROLS</strong>. Villazzo shall furnish to the Guest 2 sets of keys to the Property, including garage door openers if applicable. Upon departure, all keys and garage door openers shall be forthwith returned to Villazzo.  Failure to return such property at the time of departure will result in a charge of $200 to the Guest for each key/garage door opener that is not so returned.</p>
									<p><strong>ACCESS TO PREMISES. </strong>Villazzo and Owner shall have the absolute right to enter the Property at any time for the protection, preservation, maintenance or safety of the Property or the Guest, or for emergency repairs.  Owner/Villazzo shall also have the right to terminate the stay and to immediately discontinue any hospitality services and utilities to the Property in the event of a violation by the Guest or the Occupants of any material prohibitions or covenants.</p>
									<p><strong>LIABILITY OF OWNER / VILLAZZO. </strong>Villazzo will use its best efforts to ensure that the Guest&rsquo;s stay is trouble free during the term of the reservation period. The Guest shall hold Villazzo and the Owner of the Property harmless as to any and all responsibility or liabilities for any claims, losses, damages, expenses arising from (a) personal injury, accidents or death, or (b) loss, damage or delay of baggage or other property, or (c) delays, inconveniences, loss of enjoyment, upset, disappointment, distress or frustration, whether physical or mental while on the premises of the Property or during the term of the reservation period. Owner and Villazzo shall not be held liable for any loss by reason of damage, theft or otherwise to the contents, belongings and personal effects of the Guest or the Occupants. Written notice of any claims asserted against Villazzo or Owner must be received by Villazzo or the Owner within two weeks (14 days) after the conclusion of the actual reservation period.  The Guest shall be responsible for the payment of all sales, use, resort and similar taxes associated with the use of the Property during the reservation period, and the Guest shall hold Villazzo and the Owner of the Property harmless as to liability for the payment of such taxes. The Owner/Villazzo reserve the right to decline any request for bookings at any time and may, within their sole discretion, terminate any stay as a result of unreasonable behavior by the Guest or the Occupants.</p>
									<p><strong>LIABILITY OF GUEST.</strong> The Guest assumes all liability for any loss, damage or injury of any nature to the Guest or the Occupants resulting or arising from or connected with the occupancy and use of the premises and the Property. The Guest will be liable for the repair or replacement costs caused by the willful damage, negligence, or the removal of any property by the Guest or the Occupants. The Guest agrees to be responsible for the actions or inactions of the Occupants on the Property during the reservation period, or any holdover of the reservation period. The Guest shall not be responsible for damage to the Property caused by events outside of the Guest&rsquo;s or Occupants&rsquo; control, such as weather-related damage.</p>
									<p><strong>SUPPLIERS AND LIABILITY.</strong> Although Villazzo uses its best efforts to select the most reputable third party suppliers of products and services, it is not, and shall not be, responsible for their acts or omissions, nor does it guarantee the availability or security of suppliers&rsquo; facilities and services. Services of third party suppliers shall be deemed to be a contract between the Guest and the suppliers, and suppliers&rsquo; terms and conditions apply. The Guest agrees that it will hold Villazzo and the Owner of the Property harmless as to any and all losses sustained or incurred by the Guest or the Occupants due to the acts or omissions of independent suppliers of services.  </p>
									<p><strong>SECURITY/DAMAGE DEPOSIT.</strong> For VillaHotel reservations, the Security/Damage Deposit will be taken as a &ldquo;hold&rdquo; (i.e. not an actual charge that appears on the Guest&rsquo;s credit card statement) on a credit card provided to Villazzo by the Guest. For &ldquo;V&rdquo; Villa reservations, or if there is any problem taking a &ldquo;hold&rdquo; on the Guest&rsquo;s credit card, the Security/Damage Deposit   has to be wired to Villazzo&rsquo;s escrow account prior to arrival, and returned to the Guest within 30 days after departure, provided that the Property and all furniture, fixtures, appliances and equipment are left in the same, good working condition at the time of departure and relinquishment of the Property as existed at the time of the commencement of the booking. <br>
									The Security/Damage Deposit is due and payable at least 14 days prior to the Guest&rsquo;s arrival at the Property.  The Guest shall be fully responsible for any breakages or missing items in the Property during the Term of the Lease, and will be charged for the cost of any necessary repairs or replacements.  If the Property is abused by the Occupants during the term of this Agreement, then the Guest shall be charged supplementally for reasonable and necessary repairs, maintenance or housekeeping. Parties, &ldquo;public&rdquo; gatherings or large events on the Property, consisting of more than the maximum number of Occupants allowed (as stated in the reservation form) are strictly forbidden.  The Property is located in a residential neighborhood, and may not be used as a locale for public events, commercial promotions of products or services, or other large gatherings.  In the event that the Guest knowingly or unknowingly violates this prohibition, or other material prohibitions contained in these Conditions, considerable damage to the Property may be sustained.  Because the amount of the damages may be difficult to ascertain (given the custom nature of the furniture, fixtures and equipment), and because Villazzo desires to provide a strong disincentive to any violation of this or other material prohibitions herein, the Security Damage shall be retained by the Villazzo or Owner, in its entirety, as liquidated damages in the event of such a breach.</p>
									<p><strong>GOVERNING LAW.</strong> This Agreement is governed by the laws of the jurisdiction in which the Property is located. In the event a dispute arises between the parties under this agreement, the prevailing party shall be entitled to recover all costs and reasonable attorney&rsquo;s fees from the non-prevailing party.<br>
									Guest confirms that he has a fully useable primary residence elsewhere and will refrain from making the Property his primary residence.  Furthermore, in the event that these Terms and Conditions fail to address certain areas of potential contention between the Guest, Villazzo and/or the Owner, the Guest agrees that the laws governing lodging establishments and similar hotel operations shall govern the legal relationships between the parties hereto, even though the Property is not a hotel property nor a public lodging establishment.</p>
									The Guest confirms that he has carefully read these Terms and Conditions; has consulted with competent local counsel as to the interpretation of its provisions; and shall be responsible for the acts, or failures to act, of himself/herself and the Occupants coming onto the Property during the stay.
									</p>         
		                        </div>
	                        </div>
			                <div class="row">
			                    <div class="small-12 columns buttons">
		                        <div class="row">
			                        <div class="columns">
				                        <div class="feedback"></div>
			                        </div>
		                        </div>
			                        <div class="row text-center">
			                            <div class="medium-6 columns">
			                                <button class="button submit tiny" id="holdBtn" onclick="query(this.form.id, id, 'reservationHold');"><span style="white-space: nowrap;">HOLD (24 HOURS)</span><i class="fa fa-circle-o-notch fa-spin"></i></button>
			                            </div>
			                            <div class="medium-6 columns">
			                                <button class="button submit tiny" id="checkoutBtn" onclick="query(this.form.id, id, 'reservationBook');"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BOOK NOW&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><i class="fa fa-circle-o-notch fa-spin"></i></button>
			                            </div>
			                        </div>
			                    </div>
			                </div>
						</form>
	                </div>
				</div>
	        </section>
        <!-- Checkout Form End-->
        <?php require_once '../inc-footer.php'; ?>
		
		<?php require_once '../inc-js.php'; ?>
		
		<script type="text/javascript">
		<!--
		$(function()
		{
			$('#ccCountry').change(function() { switchStateField('ccCountry', 'ccStateUS', 'ccStateOther'); });
		});
		-->
		</script>
</body>

</html>