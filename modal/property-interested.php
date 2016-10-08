<div class="reveal-modal medium" id="propertyInterestedModal" data-reveal>
	<form id="propertyInterestedModalForm" onsubmit="return false;">
		<input type="hidden" id="propertyInterestedModalPropertyName" name="propertyInterestedModalPropertyName" value="<?php echo $propertyArray['property_name']; ?>">
		<fieldset>
		    <legend><?php echo 'Contact us about Villa '.$propertyArray['property_name']; ?></legend>
			<div class="row collapse prefix-radius">
				<div class="large-6 columns"><input type="text" name="propertyInterestedModalFirstName" id="propertyInterestedModalFirstName" class="required" placeholder="Enter your first name"></div>
				<div class="large-6 columns"><input type="text" name="propertyInterestedModalLastName" id="propertyInterestedModalLastName" class="required" placeholder="Enter your last name"></div>
			</div>
			<div class="row collapse prefix-radius">
				<div class="large-6 columns"><input type="text" name="propertyInterestedModalEmail" id="propertyInterestedModalEmail" class="required" placeholder="Enter your email"></div>
				<div class="large-6 columns"><input type="text" name="propertyInterestedModalPhone" id="propertyInterestedModalPhone" class="required" placeholder="Enter your phone number"></div>
			</div>
			<div class="row collapse prefix-radius">
				<div class="columns"><textarea name="propertyInterestedModalMessage" id="propertyInterestedModalMessage" placeholder="Enter your message" style="height: 100px; resize: none;"></textarea></div>
			</div>
			<div class="row collapse feedback"></div>
			<div class="row collapse">
				<div class="right">
					<button class="button secondary tiny" onclick="$('#propertyInterestedModal').foundation('reveal', 'close');">Cancel</button>
					<button class="button submit tiny" id="propertyInterestedModalFormBtn" onclick="query(this.form.id, id, 'propertyInterested');"><span>Submit</span><i class="fa fa-circle-o-notch fa-spin"></i></button>
				</div>
			</div>
		</fieldset>
	</form>
</div>

<div class="reveal-modal medium" id="propertyInterestedModalFeedback" data-reveal>
	<form>
		<fieldset>
		    <legend><?php echo 'Contact us about Villa '.$propertyArray['property_name']; ?></legend>
			<div class="row">
			    <div class="columns"></div>
			</div>
		</fieldset>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>