/**
*	System Setting js
*	
*	@author 	Noerman Agustiyan
* 	@version 	0.1
*/
jQuery(document).ready(function($) {
	
	/**
	*	System Settings Confirmation
	*
	*	@location 	system_settings.php
	*/
	$("#confirm_save_system_settings").click(function(event) {
		// Set modal value and show it!
		$("#modal_form").attr('action', '');
		$("#modal_title").html("Confirmation");
		$("#modal_content").html("<p class='text-center'>Save system settings?</p>");
		$("#modal_footer").html("<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button><button type='button' id='process_save' class='btn btn-primary'><i class='glyphicon glyphicon-save'></i> Yes, Save now</button>");
		$("#modal_dialog").modal("show");

		// Submit Form
		$("#process_save").click(function(event) {
			$("#save_system_settings").click();
		});
	});

	

});


	/**
	* 	Set Body Background Value
	*
	*	@location 	system_settings.php
	*/
	function set_body_background(image) {
		// Set Hidden Value
		$("#body_background").val(image);
		
		// Remove Old Border
		$(".img-thumbnail.bg-image").css({
			height: '100px',
			cursor: 'pointer',
			border: ''
		});

		// Set Active Border
		new_image = image.split(".");
		$("img[name^="+new_image[0]+"]").css({
			height: '100px',
			cursor: 'pointer',
			border: 'solid #4A89DC'
		});
	}



	/**
	* 	Set Color Scheme Value
	*
	*	@location 	system_settings.php
	*/
	function set_color_scheme(color_scheme) {
		// Set Hidden Value
		$("#color_scheme").val(color_scheme);

		// Remove Old Border
		$("div.color-swatches").css({
			cursor: 'pointer',
			border: ''
		});

		// Set Active Border
		color_scheme_name = color_scheme.split(".");
		$("div[id^="+color_scheme_name[0]+"]").css({
			cursor: 'pointer',
			border: 'solid #4A89DC'
		});
	}

