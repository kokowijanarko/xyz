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
require_once(__DIR__ . '/class/location.class.php');
$locClass = new LocationClass();
require_once(__DIR__ . '/class/device.class.php');
$devClass = new DeviceClass();

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
    	<?php 
		if (isset($_SESSION['save_status']) && $_SESSION['save_status']!=""){
			// show info
			echo "<div class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>$_SESSION[save_status]</div>";
			// clear save_status session value
			$_SESSION["save_status"] = "";
		}
		?>
			<div class="panel panel-primary">
    			<div class="panel-heading">
    				<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> &nbsp; Report</h3>
    				<br>
    			</div>
    			<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<legend class="text-center">Summary Report</legend>
						</div>
						<?php if ($invClass->setting_data("location_details")=="enable"): ?>
						<div class="col-md-6">
							<div class="panel panel-default">
								<div class="panel-heading"><i class="glyphicon glyphicon-map-marker"></i> Report Per Locations</div>
								<div class="panel-body">
									<a href="report_summary.php?by=a.location_id&name=per_location" target="_blank" class="btn btn-large btn-block btn-primary">Complete Summary Report</a>
									<hr>
									<p>Specific Location :</p>
									<div class="input-group">
										<select class="form-control chosen-select" name="report_specific_location" onchange="set_url('a.location_id', 'per_location', this.value)">
											<option value="">- Select Location -</option>
											<?php 
											// Get location
											$locations     = "";
											$location_list = $locClass->show_location();
											$total_row     = count($location_list);
											foreach ($location_list as $location_data) {
												$location_id   = $location_data["location_id"];
												$location_name = $location_data["location_name"];
												$locations    .= "<option value='$location_id'>$location_name</option>";
											}
											echo $locations;
											?>
										</select>
										<span class="input-group-btn">
											<a href="#" class="btn btn-primary per_location" target="">Show</a>
										</span>
									</div>
								</div>
							</div>
						</div>
						<!-- Place -->
						<div class="col-md-6">
							<div class="panel panel-default">
								<div class="panel-heading"><i class="glyphicon glyphicon-globe"></i> Report Per Place</div>
								<div class="panel-body">
									<a href="report_summary.php?by=d.place_id&name=per_place" target="_blank" class="btn btn-large btn-block btn-primary">Complete Summary Report</a>
									<hr>
									<p>Specific Place :</p>
									<div class="input-group">
										<select class="form-control chosen-select" name="report_specific_place" onchange="set_url('d.place_id', 'per_place', this.value)">
											<option value="">- Select Place -</option>
											<?php 
											// Get location
											$places     = "";
											$location_list = $locClass->show_location_detail_by_type("place");
											$total_row     = count($location_list);
											foreach ($location_list as $location_data) {
												$place_id   = $location_data["place_id"];
												$place_name = $location_data["place_name"];
												$places    .= "<option value='$place_id'>$place_name</option>";
											}
											echo $places;
											?>
										</select>
										<span class="input-group-btn">
											<a href="#" class="btn btn-primary per_place" target="">Show</a>
										</span>
									</div>
								</div>
							</div>
						</div>
						<!-- building -->
						<div class="col-md-6">
							<div class="panel panel-default">
								<div class="panel-heading"><i class="glyphicon glyphicon-home"></i> Report Per Building</div>
								<div class="panel-body">
									<a href="report_summary.php?by=d.building_id&name=per_building" target="_blank" class="btn btn-large btn-block btn-primary">Complete Summary Report</a>
									<hr>
									<p>Specific Building :</p>
									<div class="input-group">
										<select class="form-control chosen-select" name="report_specific_building" onchange="set_url('d.building_id', 'per_building', this.value)">
											<option value="">- Select Building -</option>
											<?php 
											// Get location
											$buildings     = "";
											$location_list = $locClass->show_location_detail_by_type("building");
											$total_row     = count($location_list);
											foreach ($location_list as $location_data) {
												$building_id   = $location_data["building_id"];
												$building_name = $location_data["building_name"];
												$buildings    .= "<option value='$building_id'>$building_name</option>";
											}
											echo $buildings;
											?>
										</select>
										<span class="input-group-btn">
											<a href="#" class="btn btn-primary per_building" target="">Show</a>
										</span>
									</div>
								</div>
							</div>
						</div>
						<?php else: ?>
						<div class="col-md-6">
							<div class="panel panel-default">
								<div class="panel-heading"><i class="glyphicon glyphicon-globe"></i> Report Per Locations</div>
								<div class="panel-body">
									<a href="report_summary.php?by=a.location_id&name=per_location" target="_blank" class="btn btn-large btn-block btn-primary">Complete Summary Report</a>
									<hr>
									<p>Specific Location :</p>
									<div class="input-group">
										<select class="form-control chosen-select" name="report_specific_location" onchange="set_url('a.location_id', 'per_location', this.value)">
											<option value="">- Select Location -</option>
											<?php 
											// Get location
											$locations     = "";
											$location_list = $locClass->show_location();
											$total_row     = count($location_list);
											foreach ($location_list as $location_data) {
												$location_id   = $location_data["location_id"];
												$location_name = $location_data["location_name"];
												$locations    .= "<option value='$location_id'>$location_name</option>";
											}
											echo $locations;
											?>
										</select>
										<span class="input-group-btn">
											<a href="#" class="btn btn-primary per_location" target="_blank">Show</a>
										</span>
									</div>
								</div>
							</div>
						</div>
						<?php endif ?>
						<div class="col-md-6">
							<div class="panel panel-default">
								<div class="panel-heading"><i class="glyphicon glyphicon-pushpin"></i> Report Per Device Type</div>
								<div class="panel-body">
									<a href="report_summary.php?by=a.type_id&name=per_device_type" target="_blank" class="btn btn-large btn-block btn-primary">Complete Summary Report</a>
									<hr>
									<p>Specific Device Type :</p>
									<div class="input-group">
										<select class="form-control chosen-select" name="report_specific_device_type" onchange="set_url('a.type_id', 'per_device_type', this.value)">
											<option value="">- Select Device Type -</option>
											<?php 
											// Get location
											$device_types     = "";
											$device_type_list = $devClass->show_device_type();
											foreach ($device_type_list as $device_type_data) {
												$device_type_id   = $device_type_data["type_id"];
												$device_type_name = $device_type_data["type_name"];
												$device_types    .= "<option value='$device_type_id'>$device_type_name</option>";
											}
											echo $device_types;
											?>
										</select>
										<span class="input-group-btn">
											<a href="#" class="btn btn-primary per_device_type" target="">Show</a>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<hr>
							<legend class="text-center">Detailed Report</legend>
						</div>
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-6">
											<p>A detailed report containing all inventory data registered in the database. Each item is printed per page, so you can easily perform evaluation.</p>
										</div>
										<div class="col-md-6">
											<a href="report_detailed.php" target="_blank" class="btn btn-large btn-block btn-primary"><i class="glyphicon glyphicon-print"></i><br>Complete Detailed Report</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
    			</div>
    		</div>
		</div>
		<?php

		// get footer
		include("./include/include_footer.php");
		include("./include/init_datatables.php");
		include("./include/init_chosen.php");
		?>
		<script type="text/javascript">
			function set_url (by, nama, kriteria) {
				if (kriteria!="") {
					$("."+nama).attr('href', 'report_summary.php?by='+by+'&name='+nama+'&criteria='+kriteria);
					$("."+nama).attr('target', '_blank');
				}
				else {
					$("."+nama).attr('href', '#');
					$("."+nama).attr('target', '');	
				}
			}
		</script>
		<?php
	}
}

?>