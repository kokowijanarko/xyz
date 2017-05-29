/**
*	User Management js
*	
*	@author 	Noerman Agustiyan
* 	@version 	0.1
*/
jQuery(document).ready(function($) {



});

	/**
	*	Show Add New User Modal
	*
	*
	*/
	function show_add_new_user () {
		$("#modal_title_user").html("");
		$("#first_name").val("");
		$("#last_name").val("");
		$("#username").val("");
		$("#username_info").html("");
		$("#password").val("");
		$("#photo").val("");
		$("#active").val("yes");
		$("#action").val("add_user");
		$("#modal_dialog_user").modal("show");
	}


	/**
	*	Deactive User
	*
	*
	*/
	function user_change_status (username, full_name, status) {
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
		$("#modal_content").html("<p class='text-center'>User full name : "+full_name+" ( "+username+" )<br>Sure want to "+confirm_info+" this user?</p><input type='hidden' name='username' value='"+username+"'><input type='hidden' name='status' value='"+status+"'><input type='hidden' name='action' value='user_change_status'>");
		$("#modal_footer").html("<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button> <button type='submit' class='btn btn-primary'>Yes</button>");
		$("#modal_dialog").modal("show");
	}



	/**
	*	Show Edit User Modal
	*
	*
	*/
	function show_edit_user () {
		$("#modal_title_user").html("");
		$("#first_name").val("");
		$("#last_name").val("");
		$("#username").val("");
		$("#username_info").html("");
		$("#password").val("");
		$("#photo").val("");
		$("#active").val("yes");
		$("#action").val("add_user");
		$("#modal_dialog_user").modal("show");
	}