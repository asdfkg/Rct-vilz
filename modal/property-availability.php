<div class="reveal-modal medium" id="propertyAvailabilityModal" data-reveal>
	<form id="propertyAvailabilityModalForm" onsubmit="return false;">
		<input type="hidden" id="propertyAvailabilityModalPropertyId" name="propertyAvailabilityModalPropertyId" value="<?php echo $propertyArray['property_id']; ?>">
		<input type="hidden" name="redirect" value="/reservations/services?property=<?php echo $propertyArray['property_name']; ?>">
		<fieldset>
		    <legend><?php echo 'Check Villa '.$propertyArray['property_name'].'\'s Availability'; ?></legend>
			<div class="row collapse prefix-radius">
                <div class="large-6 columns"><input type="text" name="checkInDt" id="checkInDt" class="required" placeholder="Enter your arrival date" value="<?php echo (isset($_GET['check_in'])?$_GET['check_in']:NULL); ?>"></div>
				<div class="large-6 columns"><input type="text" name="checkOutDt" id="checkOutDt" class="required" placeholder="Enter your departure date" value="<?php echo (isset($_GET['check_out'])?$_GET['check_out']:NULL); ?>"></div>
			</div>
<!--
			<div class="row collapse prefix-radius">
				<div class="columns"><input type="text" name="propertyAvailabilityModalEmailFrom" id="propertyAvailabilityModalEmailFrom" class="required" placeholder="Enter your email"></div>
			</div>
-->
			<div class="row collapse feedback"></div>
			<div class="row collapse">
				<div class="right">
					<button class="button secondary tiny" onclick="$('#propertyAvailabilityModal').foundation('reveal', 'close');">Cancel</button>
					<button class="button submit tiny" id="propertyAvailabilityModalFormBtn" onclick="query(this.form.id, id, 'propertyAvailability');"><span>Check</span><i class="fa fa-circle-o-notch fa-spin"></i></button>
				</div>
			</div>
		</fieldset>
	</form>
</div>

<div class="reveal-modal medium" id="propertyAvailabilityModalFeedback" data-reveal>
	<form>
		<fieldset>
		    <legend><?php echo 'Check Villa '.$propertyArray['property_name'].'\'s Availability'; ?></legend>
			<div class="row">
			    <div class="columns"></div>
			</div>
		</fieldset>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>