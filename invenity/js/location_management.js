/**
*	Location Management js
*	
*	@author 	Noerman Agustiyan
* 	@version 	0.1
*/
jQuery(document).ready(function($) {



});

	/**
	*	Show Add New Location Modal
	*
	*
	*/
	function show_add_new_location () {
		$("#modal_title_location").html("Add New Location");
		$("#location_id").val("");
		$("#location_name").val("");
		$("#location_place").val("");
		$("#location_building").val("");
		$("#location_floor").val("");
		$("#location_info").html("");
		$("#photo").val("");
		$("#active").val("yes");
		$("#action").val("add_location");
		$("select").trigger("chosen:updated");
		$("#modal_dialog_location").modal("show");
	}


	/**
	*	Change Location Status
	*	
	*	@param 	location_id
	*	@param 	location_name
	*	@param 	status
	*
	*/
	function location_change_status (location_id, location_name, status) {
		// If status yes, activate. If status no, deactivate
		if (status=="yes") {
			confirm_info = "<strong>activate</strong>";
		}
		else if (status=="no") {
			confirm_info = "<strong>deactive</strong>";
		}
		// Set modal value and show it!
		$("#modal_form").attr('action', './process.php');
		$("#modal_title").html("Confirmation");
		$("#modal_content").html("<p class='text-center'>Location name : "+location_name+" <br>Sure want to "+confirm_info+" this location?</p><input type='hidden' name='location_id' value='"+location_id+"'><input type='hidden' name='status' value='"+status+"'><input type='hidden' name='action' value='location_change_status'>");
		$("#modal_footer").html("<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button> <button type='submit' class='btn btn-primary'>Yes</button>");
		$("#modal_dialog").modal("show");
	}



	/**
	*	Show Edit Location Modal
	*
	*	@param 		location_id
	*
	*/
	function show_edit_location (location_id) {
		$("#modal_title_location").html("Edit location");
		$("#location_id").val(location_id);
		$("#location_name").val($("#location_name_"+location_id).html());
		$("#location_place").val($("#location_place_"+location_id).val());
		$("#location_building").val($("#location_building_"+location_id).val());
		$("#location_floor").val($("#location_floor_"+location_id).val());
		$("#active").val($("#lactive_"+location_id).val());
		$("#action").val("edit_location");
		$("select").trigger("chosen:updated");
		$("#modal_dialog_location").modal("show");
	}



	/**
	*	Show Add New Location Details Modal
	*	
	*	@param 		detail_type
	*	
	*/
	function show_add_new_location_details (detail_type) {
		$("#modal_title_location_details").html("Add new " + detail_type);
		$("#location_detail_name_label").html( "Location " + detail_type + " name");
		$("#location_detail_type").val(detail_type);
		$("#location_detail_id").val("");
		$("#location_detail_name").val("");
		$("#active_ld").val("yes");
		$("#action_ld").val("add_location_details");
		$("select").trigger("chosen:updated");
		$("#modal_dialog_location_details").modal("show");
	}


	/**
	*	Change location location_detail status
	*	
	*	@param 	location_detail_type
	*	@param 	location_detail_id
	*	@param 	location_detail_name
	*	@param 	status
	*
	*/
	function location_detail_change_status (location_detail_type, location_detail_id, location_detail_name, status) {
		// If status yes, activate. If status no, deactivate
		if (status=="yes") {
			confirm_info = "<strong>activate</strong>";
		}
		else if (status=="no") {
			confirm_info = "<strong>deactive</strong>";
		}
		// Set modal value and show it!
		$("#modal_form").attr('action', './process.php');
		$("#modal_title").html("Confirmation");
		$("#modal_content").html("<p class='text-center'>location_detail name : "+location_detail_name+" <br>Sure want to "+confirm_info+" this location detail?</p><input type='hidden' name='location_detail_id' value='"+location_detail_id+"'><input type='hidden' name='location_detail_type' value='"+location_detail_type+"'><input type='hidden' name='status' value='"+status+"'><input type='hidden' name='action' value='location_detail_change_status'>");
		$("#modal_footer").html("<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button> <button type='submit' class='btn btn-primary'>Yes</button>");
		$("#modal_dialog").modal("show");
	}



	/**
	*	Show Edit Location Detail Modal
	*
	*	@param 		detail_type
	*	@param 		detail_id
	*
	*/
	function show_edit_location_details (detail_type, detail_id) {
		$("#modal_title_location_details").html("Edit " + detail_type);
		$("#location_detail_name_label").html( "Location " + detail_type + " name");
		$("#location_detail_type").val(detail_type);
		$("#location_detail_id").val(detail_id);
		$("#location_detail_name").val($("#" + detail_type + "_name_" + detail_id).html());
		$("#active_ld").val($("#" + detail_type + "_active_" + detail_id).val());
		$("#action_ld").val("edit_location_details");
		$("select").trigger("chosen:updated");
		$("#modal_dialog_location_details").modal("show");
	}