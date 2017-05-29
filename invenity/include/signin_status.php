<?php
/**
* 	Check if user already logged in
*/
if (!isset($_SESSION['username']) && !isset($_SESSION['level'])) {
	// form filled -> process sign in and refresh if success
	if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['action']) && $_POST['action']=="sign_in") {
		$userclass->sign_in($_POST['username'], $_POST['password']);
	}
	// form didn't fill / illegal request -> redirect to login page
	else {
		header("Location: ./index.php");
		die();
	}
}

?>