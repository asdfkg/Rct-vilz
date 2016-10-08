<div id="propertyRatingModal" title="Property Rating" style="width:400px; display:none;">
	<form id="propertyRatingModalForm" class="modalBody" onsubmit="return false;">
		<input type="hidden" id="propertyId" name="propertyId" value="<?php echo $row_rs_property['propertyId']; ?>" />
		<input type="hidden" id="propertyName" name="propertyName" value="<?php echo $row_rs_property['propertyName']; ?>" />
		<input type="hidden" id="rating" name="rating" value="5" />
		<table class="formTable" style="width:350px;">
			<tr>
				<td>Name</td>
			</tr>
			<tr>
				<td><input type="text" id="name" name="name" class="required" /></td>
			</tr>
			<tr>
				<td>Email (will not be published)</td>
			</tr>
			<tr>
				<td><input type="text" id="email" name="email" class="required" /></td>
			</tr>
			<tr>
				<td>Your Comments</td>
			</tr>
			<tr>
				<td colspan="2"><textarea id="review" name="review" class="required" style="width:100%; height:100px; resize:none;"></textarea></td>
			</tr>
			<tr>
				<td>Rating</td>
			</tr>
			<tr>
				<td>
					<img src="media/image/ratings/star-on.png" width="15" height="15" alt="rating" id="rating1" onmouseover="rate(1);" style="cursor:pointer; margin-right:5px;" />
					<img src="media/image/ratings/star-on.png" width="15" height="15" alt="rating" id="rating2" onmouseover="rate(2);" style="cursor:pointer; margin-right:5px;" />
					<img src="media/image/ratings/star-on.png" width="15" height="15" alt="rating" id="rating3" onmouseover="rate(3);" style="cursor:pointer; margin-right:5px;" />
					<img src="media/image/ratings/star-on.png" width="15" height="15" alt="rating" id="rating4" onmouseover="rate(4);" style="cursor:pointer; margin-right:5px;" />
					<img src="media/image/ratings/star-on.png" width="15" height="15" alt="rating" id="rating5" onmouseover="rate(5);" style="cursor:pointer;" />
				</td>
			</tr>
			<tr>
				<td class="feedback" style="height:36px;"><div class="feedbackBubble feedbackRed" id="propertyRatingModalFormFeedback"></div></td>
			</tr>
		</table>
	</form>
	<div id="propertyRatingModalFeedback" class="modalFeedback"></div>
	<div class="modalFooter">
		<button type="button" id="propertyRatingModalOkBtn" class="normal" onclick="modalQuery('propertyRatingModal', 'propertyRating');">Submit</button>
		<button type="button" id="propertyRatingModalCancelBtn" class="cancel" onclick="$('#propertyRatingModal').dialog('close');">Cancel</button>
	</div>
</div>