/**
*	Inventory js
*	
*	@author 	Noerman Agustiyan
* 	@version 	0.1
*/
jQuery(document).ready(function($) {

	/**
	*	Sign Out!
	*	
	*	@location 	include_header.php
	*/
	$("#sign_out").click(function(event) {
		// Set modal value and show it!
		$("#modal_form").attr('action', './dashboard.php');
		$("#modal_title").html("Confirmation");
		$("#modal_content").html("<p class='text-center'>Do you want to sign out from inventory system?</p>");
		$("#modal_footer").html("<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button> <input type='hidden' name='action' value='sign_out'> <button type='submit' class='btn btn-primary'>Yes, Sign me out</button>");
		$("#modal_dialog").modal("show");
	});

	
});

	