/**
*	Component Management js
*	
*	@author 	Noerman Agustiyan
* 	@version 	0.1
*/
jQuery(document).ready(function($) {



});

	/**
	*	Show Add New Component Modal
	*
	*
	*/
	function show_add_new_component () {
		$("#modal_title_component").html("Add New Component");
		$("#component_id").val("");
		$("#component_name").val("");
		$("#component_page").val("");
		$("#active").val("yes");
		$("#action").val("add_component");
		$("#modal_dialog_component").modal("show");
	}



	/**
	*	Show Edit Component Modal
	*
	*	@param 		component_id
	*
	*/
	function show_edit_component (component_id) {
		$("#modal_title_component").html("Edit Component");
		$("#component_id").val(component_id);
		$("#component_name").val($("#cname_"+component_id).html());
		$("#component_page").val($("#cpage_"+component_id).html());
		$("#active").val($("#cactive_"+component_id).val());
		$("#action").val("edit_component");
		$("#modal_dialog_component").modal("show");
	}



	/**
	*	Deactive Component
	*
	*	@param 		component_id
	*	@param 		component_name
	*	@param 		status
	*
	*/
	function component_change_status (component_id, component_name, status) {
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
		$("#modal_content").html("<p class='text-center'>Component Name : "+component_name+"<br>Sure want to "+confirm_info+" this component?</p><input type='hidden' name='component_id' value='"+component_id+"'><input type='hidden' name='status' value='"+status+"'><input type='hidden' name='action' value='component_change_status'>");
		$("#modal_footer").html("<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button> <button type='submit' class='btn btn-primary'>Yes</button>");
		$("#modal_dialog").modal("show");
	}