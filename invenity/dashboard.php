<?php
session_start();

/**
*	Required Class
*/
require_once(__DIR__ . '/lib/db.class.php');
$db        = new DB();
require_once(__DIR__ . '/class/user.class.php');
$userclass = new UserClass();
require_once(__DIR__ . '/class/inventory.class.php');
$invClass  = new Inventory();
require_once(__DIR__ . '/class/device.class.php');
$devClass  = new DeviceClass();

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
else if (isset($_SESSION['username']) && isset($_SESSION['level']) && $_SESSION['username']!="" && $_SESSION['level']!="") {
	// already logged in 
	// sign out
	if (isset($_POST['action']) && $_POST['action']=="sign_out") {
		$userclass->sign_out();
	}
	else {
		// get header
		include("./include/include_header.php");

		?>
    	<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
    		<div class="panel panel-primary">
    			<div class="panel-heading">
    				<h3 class="panel-title"><i class="glyphicon glyphicon-dashboard"></i> &nbsp; Status Monitor</h3>
    				<br>
    			</div>
    			<div class="panel-body">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<canvas id="canvas" class="img-thumbnail"></canvas>
					</div>
    			</div>
    		</div>
    	</div>
		<?php

		// get footer
		include("./include/include_footer.php");

		// get dashboard chart
		include("./include/include_dashboard_chart.php");
	}
}

?>