<div class="reveal-modal medium" id="recoverPasswordModal" data-reveal>
	<form id="recoverPasswordModalForm" onsubmit="return false;">
		<fieldset>
		    <legend>Recover Password</legend>
			<div class="row collapse prefix-radius">
				<div class="small-1 medium-2 large-1 columns"><span class="prefix"><i class="fa fa-envelope"></i></span></div>
				<div class="small-11 medium-10 large-11 columns"><input type="text" name="recoverPasswordModalEmail" id="recoverPasswordModalEmail" class="required" placeholder="Enter your email"></div>
			</div>
			<div class="row collapse feedback"></div>
			<div class="row collapse">
				<div class="right">
					<button class="button secondary tiny radius" onclick="$('#recoverPasswordModal').foundation('reveal', 'close');">Cancel</button>
					<button class="button submit tiny radius" id="recoverPasswordModalFormBtn" onclick="query(this.form.id, id, 'recoverPassword');"><span>Recover</span><i class="fa fa-circle-o-notch fa-spin"></i></button>
				</div>
			</div>
		</fieldset>
	</form>
</div>

<div class="reveal-modal medium" id="recoverPasswordModalFeedback" data-reveal>
	<form>
		<fieldset>
		    <legend>Recover Password</legend>
			<div class="row">
			    <div class="columns"></div>
			</div>
		</fieldset>
	</form>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>