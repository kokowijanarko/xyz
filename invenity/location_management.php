<?php
session_start();

/**
*	Required Class
*/
require_once(__DIR__ . '/lib/db.class.php');
$db        = new DB();
require_once(__DIR__ . '/class/location.class.php');
$locationclass = new LocationClass();
require_once(__DIR__ . '/class/inventory.class.php');
$invClass  = new Inventory();

// Check if user already logged in
include("./include/signin_status.php");

// get header
include("./include/include_header.php");

// Location details settings 
$setting_location_details = $invClass->setting_data("location_details");

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
			<h3 class="panel-title">
				<i class="glyphicon glyphicon-globe"></i> &nbsp; <?php echo $current_page_name; ?>
				<span class="pull-right">
					<button type="button" class="btn btn-default btn-sm" onclick="show_add_new_location()"><i class="glyphicon glyphicon-plus"></i> New Location</button>
					<?php // If location details settings enabled, show add new button. else hide it
					if ($setting_location_details == "enable") : ?>
					<button type="button" class="btn btn-default btn-sm" onclick="show_add_new_location_details('place')"><i class="glyphicon glyphicon-plus"></i> New Place</button>
					<button type="button" class="btn btn-default btn-sm" onclick="show_add_new_location_details('building')"><i class="glyphicon glyphicon-plus"></i> New Building</button>
					<button type="button" class="btn btn-default btn-sm" onclick="show_add_new_location_details('floor')"><i class="glyphicon glyphicon-plus"></i> New Floor</button>
					<?php endif; ?>
				</span>
			</h3>
			<br>
		</div>
		<div class='panel-body'>
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
					<a href="#loc_list" id="loc_list_tab" role="tab" data-toggle="tab" aria-controls="loc_list" aria-expanded="true"><i class="glyphicon glyphicon-map-marker"></i> Locations</a>
				</li>
				<?php // If location details settings enabled, show add new button. else hide it
				if ($setting_location_details == "enable") : ?>
				<li role="presentation">
					<a href="#loc_place_list" id="loc_place_list_tab" role="tab" data-toggle="tab" aria-controls="loc_place_list" aria-expanded="true"><i class="glyphicon glyphicon-globe"></i> Location Places</a>
				</li>
				<li role="presentation">
					<a href="#loc_building_list" id="loc_building_list_tab" role="tab" data-toggle="tab" aria-controls="loc_building_list" aria-expanded="true"><i class="glyphicon glyphicon-home"></i> Location Buildings</a>
				</li>
				<li role="presentation">
					<a href="#loc_floor_list" id="loc_floor_list_tab" role="tab" data-toggle="tab" aria-controls="loc_floor_list" aria-expanded="true"><i class="glyphicon glyphicon-sort"></i> Location Floors</a>
				</li>
				<?php endif; ?>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade active in" id="loc_list" aria-labelledby="loc_list_tab">
					<legend>Locations</legend>
					<?php if (count($locationclass->show_location())!=0) : ?>
						<table class='table table-bordered table-striped' id='datatable'>
						<thead>
							<tr>
								<th>Name (Room)</th>
								<!--<th>Photo</th>-->
								<?php if ($setting_location_details=="enable"): ?>
								<th>Place</th>
								<th>Building</th>
								<th>Floor</th>
								<?php endif ?>
								<th>Active</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$data = $locationclass->show_location();
						foreach ($data as $location_data) {
							$location_id    = $location_data["location_id"];
							$location_name  = $location_data["location_name"];
							$location_photo = $location_data["location_photo"];
							$active         = $location_data["active"];
							
							if ($active=="yes") {
								$active_status = "<span class='label label-success'>Yes</span><input type='hidden' id='lactive_$location_id' value='yes'>";
								$button_status = "<button type='button' title='Deactive' class='btn btn-danger btn-sm' onclick=\"location_change_status('$location_id', '$location_name', 'no')\"><i class='glyphicon glyphicon-remove'></i></button>";
							}
							elseif ($active=="no") {
								$active_status = "<span class='label label-danger'>No</span><input type='hidden' id='lactive_$location_id' value='no'>";
								$button_status = "<button type='button' title='Activate' class='btn btn-success btn-sm' onclick=\"location_change_status('$location_id', '$location_name', 'yes')\"><i class='glyphicon glyphicon-ok'></i></button>";
							}
							?>
							<tr>
								<input type='hidden' name='location_id_<?php echo $location_id; ?>' id='location_id_<?php echo $location_id; ?>' value='<?php echo $location_id; ?>' >
								<td id='location_name_<?php echo $location_id; ?>'><?php echo $location_name; ?></td>
								<!-- <td><img src='<?php echo $location_photo; ?>' width='100'></td> -->
								<?php if ($setting_location_details=="enable"): ?>
								<td><?php echo $location_data["place_name"]; ?><input type="hidden" id='location_place_<?php echo $location_id; ?>' value="<?php echo $location_data["place_id"]; ?>"></td>
								<td><?php echo $location_data["building_name"]; ?><input type="hidden"  id='location_building_<?php echo $location_id; ?>' value="<?php echo $location_data["building_id"]; ?>"></td>
								<td><?php echo $location_data["floor_name"]; ?><input type="hidden" id='location_floor_<?php echo $location_id; ?>' value="<?php echo $location_data["floor_id"]; ?>"></td>
								<?php endif ?>
								<td><?php echo $active_status; ?></td>
								<td><?php echo $button_status; ?> <button class='btn btn-default btn-sm' onclick="show_edit_location('<?php echo $location_id; ?>')"><i class='glyphicon glyphicon-pencil'></i></button></td>
							</tr>
							<?php
						}
						?>
						</tbody>
						</table>
					<?php else: ?>
						<p>No Location Data Found!</p>
					<?php endif; ?>
				</div>
				
				<?php // If location details settings enabled, show add new button. else hide it
				if ($setting_location_details == "enable") : ?>
				<div role="tabpanel" class="tab-pane fade" id="loc_place_list" aria-labelledby="loc_place_list_tab">
					<legend>Location Places</legend>
					<?php if (count($locationclass->show_location_detail_by_type('place'))!=0) : ?>
						<table class='table table-bordered table-striped datatables' width="100%">
						<thead>
							<tr>
								<th>Place Name</th>
								<th>Active</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$place_datas = $locationclass->show_location_detail_by_type('place');
						foreach ($place_datas as $place_data) {
							$place_id   = $place_data["place_id"];
							$place_name = $place_data["place_name"];
							$active     = $place_data["active"];
							
							if ($active=="yes") {
								$active_status = "<span class='label label-success'>Yes</span><input type='hidden' id='place_active_$place_id' value='yes'>";
								$button_status = "<button type='button' title='Deactive' class='btn btn-danger btn-sm' onclick=\"location_detail_change_status('place', '$place_id', '$place_name', 'no')\"><i class='glyphicon glyphicon-remove'></i></button>";
							}
							elseif ($active=="no") {
								$active_status = "<span class='label label-danger'>No</span><input type='hidden' id='place_active_$place_id' value='no'>";
								$button_status = "<button type='button' title='Activate' class='btn btn-success btn-sm' onclick=\"location_detail_change_status('place', '$place_id', '$place_name', 'yes')\"><i class='glyphicon glyphicon-ok'></i></button>";
							}
							?>
							<tr>
								<input type='hidden' name='place_id_<?php echo $place_id; ?>' id='place_id_<?php echo $place_id; ?>' value='<?php echo $place_id; ?>' >
								<td id='place_name_<?php echo $place_id; ?>'><?php echo $place_name; ?></td>
								<td><?php echo $active_status; ?></td>
								<td><?php echo $button_status; ?> <button class='btn btn-default btn-sm' onclick="show_edit_location_details('place', '<?php echo $place_id; ?>')"><i class='glyphicon glyphicon-pencil'></i></button></td>
							</tr>
							<?php
						}
						?>
						</tbody>
						</table>
					<?php else: ?>
						<p>No Location Place Data Found!</p>
					<?php endif; ?>
				</div>
				
				
				<div role="tabpanel" class="tab-pane fade" id="loc_building_list" aria-labelledby="loc_building_list_tab">
					<legend>Location Buildings</legend>
					<?php if (count($locationclass->show_location_detail_by_type('building'))!=0) : ?>
						<table class='table table-bordered table-striped datatables' width="100%">
						<thead>
							<tr>
								<th>Building Name</th>
								<th>Active</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$building_datas = $locationclass->show_location_detail_by_type('building');
						foreach ($building_datas as $building_data) {
							$building_id   = $building_data["building_id"];
							$building_name = $building_data["building_name"];
							$active        = $building_data["active"];
							
							if ($active=="yes") {
								$active_status = "<span class='label label-success'>Yes</span><input type='hidden' id='building_active_$building_id' value='yes'>";
								$button_status = "<button type='button' title='Deactive' class='btn btn-danger btn-sm' onclick=\"location_detail_change_status('building', '$building_id', '$building_name', 'no')\"><i class='glyphicon glyphicon-remove'></i></button>";
							}
							elseif ($active=="no") {
								$active_status = "<span class='label label-danger'>No</span><input type='hidden' id='building_active_$building_id' value='no'>";
								$button_status = "<button type='button' title='Activate' class='btn btn-success btn-sm' onclick=\"location_detail_change_status('building', '$building_id', '$building_name', 'yes')\"><i class='glyphicon glyphicon-ok'></i></button>";
							}
							?>
							<tr>
								<input type='hidden' name='building_id_<?php echo $building_id; ?>' id='building_id_<?php echo $building_id; ?>' value='<?php echo $building_id; ?>' >
								<td id='building_name_<?php echo $building_id; ?>'><?php echo $building_name; ?></td>
								<td><?php echo $active_status; ?></td>
								<td><?php echo $button_status; ?> <button class='btn btn-default btn-sm' onclick="show_edit_location_details('building', '<?php echo $building_id; ?>')"><i class='glyphicon glyphicon-pencil'></i></button></td>
							</tr>
							<?php
						}
						?>
						</tbody>
						</table>
					<?php else: ?>
						<p>No Location Building Data Found!</p>
					<?php endif; ?>
				</div>
				
				
				<div role="tabpanel" class="tab-pane fade" id="loc_floor_list" aria-labelledby="loc_floor_list_tab">
					<legend>Location Floors</legend>
					<?php if (count($locationclass->show_location_detail_by_type('floor'))!=0) : ?>
						<table class='table table-bordered table-striped datatables' width="100%">
						<thead>
							<tr>
								<th>Floor Name</th>
								<th>Active</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$floor_datas = $locationclass->show_location_detail_by_type('floor');
						foreach ($floor_datas as $floor_data) {
							$floor_id   = $floor_data["floor_id"];
							$floor_name = $floor_data["floor_name"];
							$active     = $floor_data["active"];
							
							if ($active=="yes") {
								$active_status = "<span class='label label-success'>Yes</span><input type='hidden' id='floor_active_$floor_id' value='yes'>";
								$button_status = "<button type='button' title='Deactive' class='btn btn-danger btn-sm' onclick=\"location_detail_change_status('floor', '$floor_id', '$floor_name', 'no')\"><i class='glyphicon glyphicon-remove'></i></button>";
							}
							elseif ($active=="no") {
								$active_status = "<span class='label label-danger'>No</span><input type='hidden' id='floor_active_$floor_id' value='no'>";
								$button_status = "<button type='button' title='Activate' class='btn btn-success btn-sm' onclick=\"location_detail_change_status('floor', '$floor_id', '$floor_name', 'yes')\"><i class='glyphicon glyphicon-ok'></i></button>";
							}
							?>
							<tr>
								<input type='hidden' name='floor_id_<?php echo $floor_id; ?>' id='floor_id_<?php echo $floor_id; ?>' value='<?php echo $floor_id; ?>' >
								<td id='floor_name_<?php echo $floor_id; ?>'><?php echo $floor_name; ?></td>
								<td><?php echo $active_status; ?></td>
								<td><?php echo $button_status; ?> <button class='btn btn-default btn-sm' onclick="show_edit_location_details('floor', '<?php echo $floor_id; ?>')"><i class='glyphicon glyphicon-pencil'></i></button></td>
							</tr>
							<?php
						}
						?>
						</tbody>
						</table>
					<?php else: ?>
						<p>No Location Floor Data Found!</p>
					<?php endif; ?>
				</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
</div>
<?php
// MODAL

// If form error, show error
if (isset($_SESSION["new_location_name"])) { 
    echo "<script type='text/javascript'>
        jQuery(document).ready(function($) {
            $('#modal_dialog_location').modal('show');
        });
    </script>";
    $location_info = "<span class='text-danger' id='location_info'>Location '$_SESSION[new_location_name]' is already exists!</span>";
    unset($_SESSION["new_location_name"]);
}

?>
<!-- location modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_dialog_location">
    <form name="form_location" class="form-horizontal validetta" enctype="multipart/form-data" id="form_location" method="post" action="process.php">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modal_title_location"></h4>
                </div>
                <div class="modal-body" id="modal_content_location">
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="location_name">Location Room</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="location_id" id="location_id" value=""> 
                            <input type="text" class="form-control" name="location_name" id="location_name" placeholder="Location Name" data-validetta="required">
                            <?php if (isset($location_info)) { echo $location_info; } ?>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label class="control-label col-sm-3" for="location_photo">Location Photo</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" name="location_photo" id="location_photo" placeholder="Location Photo">
                            <span class="help-block">Max file size 2 Mb. Jpg, png and gif. (Optional)</span>
                        </div>
                    </div> -->

					<?php // If location details settings enabled, show input. else hide it
					if ($setting_location_details == "enable") : ?>

					<div class="form-group">
                        <label class="control-label col-sm-3" for="location_place">Location Place</label>
                        <div class="col-sm-9">
                            <select class="form-control chosen-select" name="location_place" id="location_place">
                            	<option value="">Select Place</option>
                            	<?php
                            	$ld_place_res = ""; 
                            	foreach ($locationclass->show_location_detail_by_type('place') as $ld_place) {
                            		$ld_place_res .= "<option value='$ld_place[place_id]'>$ld_place[place_name]</option>";
                            	}
                            	echo $ld_place_res;
                            	?>
                            </select>
                        </div>
                    </div>
                    
					<div class="form-group">
                        <label class="control-label col-sm-3" for="location_building">Building</label>
                        <div class="col-sm-9">
                            <select class="form-control chosen-select" name="location_building" id="location_building">
                            	<option value="">Select Building</option>
                            	<?php
                            	$ld_building_res = ""; 
                            	foreach ($locationclass->show_location_detail_by_type('building') as $ld_building) {
                            		$ld_building_res .= "<option value='$ld_building[building_id]'>$ld_building[building_name]</option>";
                            	}
                            	echo $ld_building_res;
                            	?>
                            </select>
                        </div>
                    </div>
                    
					<div class="form-group">
                        <label class="control-label col-sm-3" for="location_floor">Floor</label>
                        <div class="col-sm-9">
                            <select class="form-control chosen-select" name="location_floor" id="location_floor">
                            	<option value="">Select Floor</option>
                            	<?php
                            	$ld_floor_res = ""; 
                            	foreach ($locationclass->show_location_detail_by_type('floor') as $ld_floor) {
                            		$ld_floor_res .= "<option value='$ld_floor[floor_id]'>$ld_floor[floor_name]</option>";
                            	}
                            	echo $ld_floor_res;
                            	?>
                            </select>
                        </div>
                    </div>

					<?php endif ?>

                    <div class="form-group">
                        <label class="control-label col-sm-3" for="active">Active</label>
                        <div class="col-sm-9">
                            <select class="form-control chosen-select" name="active" id="active">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr class="dashed" />
                <div class="modal-footer" id="modal_footer_location">
                    <input type="hidden" name="action" id="action" value="add_location">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div>
<!-- /.modal -->

<!-- location details modal -->
<div class="modal fade" id="modal_dialog_location_details">
	<form name="form_location_details" class="form-horizontal validetta" enctype="multipart/form-data" id="form_location_details" action="process.php" method="post">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="modal_title_location_details">Location Details</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
                        <label class="control-label col-sm-4" id="location_detail_name_label" for="location_details_name">Location Details</label>
                        <div class="col-sm-8">
                            <input type="hidden" name="location_detail_type" id="location_detail_type" value=""> 
                            <input type="hidden" name="location_detail_id" id="location_detail_id" value=""> 
                            <input type="text" class="form-control" name="location_detail_name" id="location_detail_name" value="" placeholder="Name" data-validetta="required">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="active">Active</label>
                        <div class="col-sm-8">
                            <select class="form-control chosen-select" name="active" id="active_ld">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                    </div>
				</div>
				<div class="modal-footer">
                    <input type="hidden" name="action" id="action_ld" value="add_location_details">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- ./location details modal -->

<?php

// get footer
include("./include/include_footer.php");
// get plugins
include("./include/init_datatables.php");
include("./include/init_validetta.php");
include("./include/init_showpassword.php");
include("./include/init_chosen.php");
// get page setting
echo "<script type='text/javascript' src='./js/location_management.js'></script>";
//include("./include/include_modal_location.php");
?>