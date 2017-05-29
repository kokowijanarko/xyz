<?php
session_start();

/**
*	Required Class
*/
require_once(__DIR__ . '/lib/db.class.php');
$db        = new DB();
require_once(__DIR__ . '/class/user.class.php');
$userClass = new UserClass();
require_once(__DIR__ . '/class/inventory.class.php');
$invClass  = new Inventory();
require_once(__DIR__ . '/class/system.class.php');
$sysClass  = new SystemClass();
require_once(__DIR__ . '/class/component.class.php');
$comClass  = new ComponentClass();
require_once(__DIR__ . '/class/device.class.php');
$devClass  = new DeviceClass();
require_once(__DIR__ . '/class/location.class.php');
$locClass  = new LocationClass();



/**
*	If Exist Action
* 	Set per action process based on if functions
*
*/
if (isset($_POST["action"])) {
	$action = $_POST["action"];

	/**
	*	Sign Out
	*
	*/
	if ($action=="sign_out") {
		$userclass->sign_out();
	}


	/**
	*	Component Block
	*
	*	=============== START ===============
	*/

	// Add Component 
	elseif ($action=="add_component") {
		$add_component = $comClass->add_component($_POST);
		if ($add_component>0) {
			$_SESSION['save_status'] = "Successfully saved!";
		}
		else {
			$_SESSION['save_status'] = "Error, failed to save data!";
		}
		header("Location: ./component_management.php");
		die();
	}


	// Edit Component 
	elseif ($action=="edit_component") {
		$edit_component = $comClass->edit_component($_POST);
		if ($edit_component>0) {
			$_SESSION['save_status'] = "Successfully saved!";
		}
		else {
			$_SESSION['save_status'] = "Error, failed to save data!";
		}
		header("Location: ./component_management.php");
		die();
	}


	// Component Status Change 
	elseif ($action=="component_change_status") {
		$component_change_status = $comClass->component_change_status($_POST);
		if ($component_change_status>0) {
			$_SESSION['save_status'] = "Successfully saved!";
		}
		else {
			$_SESSION['save_status'] = "Error, failed to change status!";
		}
		header("Location: ./component_management.php");
		die();
	}

	/**
	*	=============== END ===============
	*
	*/



	/**
	*	User Block
	*
	*	=============== START ===============
	*/

	// User Status Change 
	elseif ($action=="user_change_status") {
		$user_change_status = $userClass->user_change_status($_POST);
		if ($user_change_status>0) {
			$_SESSION['save_status'] = "Successfully saved!";
		}
		else {
			$_SESSION['save_status'] = "Error, failed to change status!";
		}
		header("Location: ./user_management.php");
		die();
	}


	// Add User 
	elseif ($action=="add_user") {
		$add_user = $userClass->add_user($_POST, $_FILES);
		if ($add_user>0) {
			$_SESSION['save_status'] = "Successfully saved!";
		}
		else {
			$_SESSION['save_status'] = "Error, failed to save data!";
		}
		header("Location: ./user_management.php");
		die();
	}

	
	// Edit User
	elseif ($action=="edit_user") {
		$edit_user        = $userClass->edit_user($_POST, $_FILES);
		$edit_user_break  = explode("|", $edit_user);
		$edit_user_status = $edit_user_break[0];
		$edit_user_notif  = $edit_user_break[1];
		if ($edit_user>0) {
			$_SESSION['save_status'] = "Successfully saved! ".$edit_user_notif;
		}
		else {
			$_SESSION['save_status'] = "Error, failed to save data! ".$edit_user_notif;
		}
		if ($_POST['action2']=="my_profile") {
			header("Location: ./my_profile.php");
			die();
		}
		else {
			header("Location: ./user_management.php");
			die();
		}
	}

	/**
	*	=============== END ===============
	*
	*/



	/**
	*	Device Block
	*
	*	=============== START ===============
	*/

	// Add device type
	elseif ($action=="add_device_type") {
		$add_device_type = $devClass->add_device_type($_POST);
		// break
		$adt_break   = explode("|", $add_device_type);
		$adt_process = $adt_break[0];
		$adt_notif   = $adt_break[1];
		if ($adt_process>0) {
			$_SESSION['save_status'] = "Successfully saved! $adt_notif";
		}
		else {
			$_SESSION['save_status'] = "Error, failed to save data! $adt_notif";
		}
		header("Location: ./device_management.php");
		die();
	}


	// Device type change status
	elseif ($action=="device_type_change_status") {
		$device_type_change_status = $devClass->device_type_change_status($_POST);
		if ($device_type_change_status>0) {
			$_SESSION['save_status'] = "Successfully saved!";
		}
		else {
			$_SESSION['save_status'] = "Error, failed to change status!";
		}
		header("Location: ./device_management.php");
		die();
	}


	// Add device
	elseif ($action=="add_device") {
		$add_device = $devClass->add_device($_POST, $_FILES);
		// break
		$adv_break   = explode("|", $add_device);
		$adv_process = $adv_break[0];
		$adv_notif   = $adv_break[1];
		if ($adv_process>0) {
			$_SESSION['save_status'] = "Successfully saved! $adv_notif";
		}
		else {
			$_SESSION['save_status'] = "Error, failed to save data! $adv_notif";
		}
		header("Location: ./device_management.php");
		die();
	}


	// Edit device
	elseif ($action=="edit_device") {
		$edit_device = $devClass->edit_device($_POST, $_FILES);
		// break
		$edv_break   = explode("|", $edit_device);
		$edv_process = $edv_break[0];
		$edv_notif   = $edv_break[1];
		if ($edv_process>0) {
			$_SESSION['save_status'] = "Successfully saved! $edv_notif";
		}
		else {
			$_SESSION['save_status'] = "Error, failed to save data! $edv_notif";
		}
		header("Location: ./device_management.php");
		die();
	}

	/**
	*	=============== END ===============
	*
	*/



	/**
	*	Location Block
	*
	*	=============== START ===============
	*/

	// Add Location
	elseif ($action=="add_location") {
		$add_location = $locClass->add_location($_POST);
		// break
		$al_break   = explode("|", $add_location);
		$al_process = $al_break[0];
		$al_notif   = $al_break[1];
		if ($al_process>0) {
			$_SESSION['save_status'] = "Successfully saved! $al_notif";
		}
		else {
			$_SESSION['save_status'] = "Error, failed to save data! $al_notif";
		}
		header("Location: ./location_management.php");
		die();
	}


	// Edit Location 
	elseif ($action=="edit_location") {
		$edit_location = $locClass->edit_location($_POST);
		if ($edit_location>0) {
			$_SESSION['save_status'] = "Successfully saved!";
		}
		else {
			$_SESSION['save_status'] = "Error, failed to save data!";
		}
		header("Location: ./location_management.php");
		die();
	}


	// Location change status
	elseif ($action=="location_change_status") {
		$location_change_status = $locClass->location_change_status($_POST);
		if ($location_change_status>0) {
			$_SESSION['save_status'] = "Successfully saved!";
		}
		else {
			$_SESSION['save_status'] = "Error, failed to change status!";
		}
		header("Location: ./location_management.php");
		die();
	}


	// ==== Location Detail ==== //
	// Add Location
	elseif ($action=="add_location_details") {
		$add_location_details = $locClass->add_location_details($_POST);
		// break
		$ald_break   = explode("|", $add_location_details);
		$ald_process = $ald_break[0];
		$ald_notif   = $ald_break[1];
		if ($ald_process>0) {
			$_SESSION['save_status'] = "Successfully saved! $ald_notif";
		}
		else {
			$_SESSION['save_status'] = "Error, failed to save data! $ald_notif";
		}
		header("Location: ./location_management.php");
		die();
	}

	// Edit location detail
	elseif ($action=="edit_location_details") {
		$edit_location_details = $locClass->edit_location_details($_POST);
		if ($edit_location_details>0) {
			$_SESSION['save_status'] = "Successfully saved!";
		}
		else {
			$_SESSION['save_status'] = "Error, failed to save data!";
		}
		header("Location: ./location_management.php");
		die();
	}


	// Location detail change status
	elseif ($action=="location_detail_change_status") {
		$location_detail_change_status = $locClass->location_detail_change_status($_POST);
		if ($location_detail_change_status>0) {
			$_SESSION['save_status'] = "Successfully saved!";
		}
		else {
			$_SESSION['save_status'] = "Error, failed to change status!";
		}
		header("Location: ./location_management.php");
		die();
	}

	/**
	*	=============== END ===============
	*
	*/



	/**
	*	Report Block
	*
	*	=============== START ===============
	*/

	// Report by Location
	elseif ($action=="report_by_locations") {
		// Get locations (based on checkbox)
		$location_array = $_POST["locations"];
		$result         = implode(",", $location_array);

		// $_SESSION['save_status'] = "result : '$result'";
		header("Location: ./report.php?report_type=location_id&criteria=$result");
		die();
	}


	// Report by Device Type
	elseif ($action=="report_by_types") {
		// Get device_type (based on checkbox)
		$device_type_array = $_POST["device_types"];
		$result            = implode(",", $device_type_array);

		// $_SESSION['save_status'] = "result : '$result'";
		header("Location: ./report.php?report_type=type_id&criteria=$result");
		die();
	}

	/**
	*	=============== END ===============
	*
	*/



}
else {
	header("Location: ./index.php");
	die();
}
?>