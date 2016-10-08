<div class="reveal-modal medium" id="propertyShareModal" data-reveal>
	<form id="propertyShareModalForm" onsubmit="return false;">
		<input type="hidden" id="propertyShareModalPropertyName" name="propertyShareModalPropertyName" value="<?php echo $propertyArray['property_name']; ?>">
		<input type="hidden" id="propertyShareModalPropertyUrl" name="propertyShareModalPropertyUrl" value="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/'.str_replace(' ', '-', $propertyArray['dest_name']).'-rental-villas/villa-'.str_replace(' ', '-', $propertyArray['property_name']).(isset($propertyArray['check_in_dt'])&&isset($propertyArray['check_out_dt'])?'?check_in='.date('m/d/Y', strtotime($propertyArray['check_in_dt'])).'&check_out='.date('m/d/Y', strtotime($propertyArray['check_out_dt'])):''); ?>" />
		<fieldset>
		    <legend><?php echo 'Share Villa '.$propertyArray['property_name']; ?></legend>
			<div class="row collapse prefix-radius">
				<div class="columns"><input type="text" name="propertyShareModalEmailFrom" id="propertyShareModalEmailFrom" class="required" placeholder="Enter your email" value="<?php echo ($_SESSION['USER']->getUserId()?$_SESSION['USER']->getEmail():''); ?>"></div>
			</div>
			<div class="row collapse prefix-radius">
				<div class="columns"><input type="text" name="propertyShareModalEmailTo" id="propertyShareModalEmailTo" class="required" placeholder="Enter your friend's email"></div>
			</div>
			<div class="row collapse feedback"></div>
			<div class="row collapse">
				<div class="right">
					<button class="button secondary tiny radius" onclick="$('#propertyShareModal').foundation('reveal', 'close');">Cancel</button>
					<button class="button submit tiny radius" id="propertyShareModalFormBtn" onclick="query(this.form.id, id, 'propertyShare');"><span>Share</span><i class="fa fa-circle-o-notch fa-spin"></i></button>
				</div>
			</div>
		</fieldset>
	</form>
</div>

<div class="reveal-modal medium" id="propertyShareModalFeedback" data-reveal>
	<form>
		<fieldset>
		    <legend><?php echo 'Share Villa '.$propertyArray['property_name']; ?></legend>
			<div class="row">
			    <div class="columns"></div>
			</div>
		</fieldset>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>