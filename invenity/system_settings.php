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

/**
* 	Check if user already logged in
*/
if (!isset($_SESSION['username']) && !isset($_SESSION['level'])) {
	// form filled -> process sign in and refresh if success
	if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['action']) && $_POST['action']=="sign_in") {
		$userClass->sign_in($_POST['username'], $_POST['password']);
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
		$userClass->sign_out();
	}
	else {
		// System Settings Save Process :
		if (isset($_POST) && isset($_FILES)) {
			$save_status = $sysClass->save_system_settings($_POST, $_FILES);
		}
		else {
			$save_status = "";
		}

		// get header
		include("./include/include_header.php");
		?>
		
    	<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
    		<?php
    			if ($save_status!="") {
    				echo "<div class='well well-lg'>$save_status</div>";
    			}
    		?>
    		<div class="panel panel-primary">
    			<!-- <div class="panel-heading">
    				<h3 class="panel-title"><i class="glyphicon glyphicon-cog"></i> &nbsp; <?php if ($invClass->setting_data("inventory_name")!="") { echo $invClass->setting_data("inventory_name"); } else {echo "Inventory System";} ?> Settings</h3>
    			</div> -->
    			<div class="panel-body">
    				<form name="form_settings" action="" method="post" enctype="multipart/form-data" class="form-horizontal">
    					<legend>General</legend>
		    			<div class="form-group">
		    				<label for="inventory_name" class="control-label col-sm-3">Inventory Name</label>
		    				<div class="col-sm-9">
			    				<input type="text" name="inventory_name" id="inventory_name" class="form-control" value="<?php echo $invClass->setting_data("inventory_name"); ?>">
		    				</div>
		    			</div>

		    			<div class="form-group">
		    				<label for="inventory_slogan" class="control-label col-sm-3">Inventory Slogan</label>
		    				<div class="col-sm-9">
			    				<input type="text" name="inventory_slogan" id="inventory_slogan" class="form-control" value="<?php echo $invClass->setting_data("inventory_slogan"); ?>">
		    				</div>
		    			</div>

		    			<div class="form-group">
		    				<label for="inventory_description" class="control-label col-sm-3">Descriptions</label>
		    				<div class="col-sm-9">
			    				<textarea name="inventory_description" id="inventory_description" class="form-control" rows="4" style="resize:vertical; max-height:150px;"><?php echo $invClass->setting_data("inventory_description"); ?></textarea>
			    			</div>
		    			</div>

		    			<div class="form-group">
		    				<label for="inventory_location" class="control-label col-sm-3">Location</label>
		    				<div class="col-sm-9">
			    				<textarea name="inventory_location" id="inventory_location" class="form-control" rows="4" style="resize:vertical; max-height:150px;"><?php echo $invClass->setting_data("inventory_location"); ?></textarea>
			    			</div>
		    			</div>

		    			<div class="form-group">
		    				<label for="inventory_phone_number" class="control-label col-sm-3">Phone Number</label>
		    				<div class="col-sm-9">
			    				<input type="text" name="inventory_phone_number" id="inventory_phone_number" class="form-control" value="<?php echo $invClass->setting_data("inventory_phone_number"); ?>">
		    				</div>
		    			</div>

		    			<div class="form-group">
		    				<label for="inventory_fax_number" class="control-label col-sm-3">Fax Number</label>
		    				<div class="col-sm-9">
			    				<input type="text" name="inventory_fax_number" id="inventory_fax_number" class="form-control" value="<?php echo $invClass->setting_data("inventory_fax_number"); ?>">
		    				</div>
		    			</div>

		    			<div class="form-group">
		    				<label for="inventory_email" class="control-label col-sm-3">Email Address</label>
		    				<div class="col-sm-9">
			    				<input type="email" name="inventory_email" id="inventory_email" class="form-control" value="<?php echo $invClass->setting_data("inventory_email"); ?>">
		    				</div>
		    			</div>

		    			<div class="form-group">
		    				<label for="inventory_website" class="control-label col-sm-3">Website</label>
		    				<div class="col-sm-9">
			    				<input type="text" name="inventory_website" id="inventory_website" class="form-control" value="<?php echo $invClass->setting_data("inventory_website"); ?>">
		    				</div>
		    			</div>

		    			<br>
		    			<legend>Devices</legend>
						
						<div class="form-group">
		    				<label for="inventory_website" class="control-label col-sm-3">Code Format</label>
		    				<div class="col-sm-9">
		    					<div class="input-group">
				    				<input type="text" name="device_code_format" id="device_code_format" class="form-control" value="<?php echo $invClass->setting_data("device_code_format"); ?>">
		    						<div class="input-group-addon">/ increment_number</div>
		    					</div>
		    					<p class="help-block">You can customized device code format based on your preferences. Every devices should have different code. Incremental number in the back of the format is mandatory. Note that not every character is allowed to be device code format such as space and backslash.
		    					<br>
		    					This is preformatted string you can use :
									<ul>
										<li>year    : current year </li>
										<li>devtype : device type code </li>
									</ul>
		    					</p>
		    				</div>
		    			</div>

		    			<br>
		    			<legend>Display</legend>

		    			<div class="form-group">
		    				<?php 
		    					// Current Color Scheme
		    					$current_color_scheme = $invClass->setting_data("color_scheme");
		    				?>
		    				<label class="control-label col-sm-3">Color Scheme</label>
		    				<div class="col-sm-9">
		    					<div class="row">
		    						<div class="col-sm-4">
		    							<div class="color-swatches" id="site-default.min.css" style="cursor:pointer;<?php if ($current_color_scheme=="site-default.min.css") { echo "border:solid #4A89DC;"; } ?>" onclick="set_color_scheme(this.id)">
							                <div class="swatches">
							                    <div class="clearfix">
							                        <div class="pull-left light" style="background-color:#656D78"></div>
							                        <div class="pull-right dark" style="background-color:#434A54"></div>
							                    </div>
							                    <div class="infos text-center">
							                        <h4>Default</h4>
							                    </div>
							                </div>
							            </div>
		    						</div>
		    						<div class="col-sm-4">
		    							<div class="color-swatches" id="site-aqua.min.css" style="cursor:pointer;<?php if ($current_color_scheme=="site-aqua.min.css") { echo "border:solid #4A89DC;"; } ?>" onclick="set_color_scheme(this.id)">
							                <div class="swatches">
							                    <div class="clearfix">
							                        <div class="pull-left light" style="background-color:#4FC1E9"></div>
							                        <div class="pull-right dark" style="background-color:#3BAFDA"></div>
							                    </div>
							                    <div class="infos text-center">
							                        <h4>Aqua</h4>
							                    </div>
							                </div>
							            </div>
		    						</div>
		    						<div class="col-sm-4">
		    							<div class="color-swatches" id="site-mint.min.css" style="cursor:pointer;<?php if ($current_color_scheme=="site-mint.min.css") { echo "border:solid #4A89DC;"; } ?>" onclick="set_color_scheme(this.id)">
							                <div class="swatches">
							                    <div class="clearfix">
							                        <div class="pull-left light" style="background-color:#48CFAD"></div>
							                        <div class="pull-right dark" style="background-color:#37BC9B"></div>
							                    </div>
							                    <div class="infos text-center">
							                        <h4>Mint</h4>
							                    </div>
							                </div>
							            </div>
		    						</div>
		    					</div>
		    				</div>
		    				<input type="hidden" name="color_scheme" id="color_scheme" value="<?php echo $invClass->setting_data("color_scheme"); ?>">
		    			</div>

		    			<hr class="dashed" />

		    			<div class="form-group">
		    				<label for="inventory_website" class="control-label col-sm-3">Background</label>
		    				<div class="col-sm-9">
		    					<div class="row">
			    				<?php 
				    				// Current Background
			    					$current_background = $invClass->setting_data("body_background");

			    					// Loop Available Images
									$dirname     = "assets/images/backgrounds/";
									$images_path = glob($dirname."*.png");
									foreach($images_path as $image_path) {
										// Get background name
											// Explode!
											$explode_image_path = explode("/", $image_path);
											// Count! Get The Last Param
											$count_explode = count($explode_image_path);
											// Get! The Name
											$image_name = $explode_image_path[$count_explode-1];

										if ($current_background==$image_name) {
											echo "<div class='col-sm-4 text-center'><img src='$image_path' name='$image_name' id='$image_name' class='img-thumbnail bg-image' style='height:100px; border:solid #4A89DC; cursor:pointer' title='$image_name' onclick=\"set_body_background(this.id)\" /> <p>$image_name</p></div>";
										}
										else {
											echo "<div class='col-sm-4 text-center'><img src='$image_path' name='$image_name' id='$image_name' class='img-thumbnail bg-image' style='height:100px; cursor:pointer' title='$image_name' onclick=\"set_body_background(this.id)\" /> <p>$image_name</p> </div>";
										}
									}
			    				?>
			    				<input type="hidden" name="body_background" id="body_background" value="<?php echo $invClass->setting_data("body_background"); ?>">
		    					</div>
		    				</div>
		    			</div>

		    			<hr class="dashed" />

		    			<div class="form-group">
		    				<label for="inventory_logo" class="control-label col-sm-3">Logo</label>
		    				<div class="col-sm-9">
			    				Current Logo : <img src="./assets/images/<?php if ($invClass->setting_data("inventory_logo")!="") { echo $invClass->setting_data("inventory_logo"); } else {echo "logo.png";} ?>" height="50">
			    				<br>
			    				<div class="input-group">
			                        <span class="input-group-addon">Upload : </span>
			                        <input type="file" name="inventory_logo" id="inventory_logo" class="form-control">
			                    </div>
		                        <span class="help-block">Leave this field empty if you don't want to change your icon. (PNG Only!)</span>
			    			</div>
		    			</div>

		    			<hr class="dashed" />

		    			<br>
		    			<legend>Addon</legend>

						<?php 
							// Current location detail setting
							$current_location_details = $invClass->setting_data("location_details");
						?>
		    			<div class="form-group">
		    				<label class="control-label col-sm-3">Location Details</label>
		    				<div class="col-sm-9">
		    					<select name="location_details" id="location_details" class="form-control">
		    						<option value="enable" <?php if ($current_location_details=="enable"): ?>selected<?php endif ?>>Enable</option>
		    						<option value="disable" <?php if ($current_location_details=="disable"): ?>selected<?php endif ?>>Disable</option>
		    					</select>
		    					<span class="help-block">Make detailed location settings such as places, buildings and floors</span>
		    				</div>
		    			</div>

		    			<hr class="dashed" />

    					<div class="form-group">
    						<div class="col-sm-12 text-center">
	    						<button type="button" class="btn btn-primary" id="confirm_save_system_settings"><i class="glyphicon glyphicon-save"></i> Save</button>
	    						<input type="submit" class="btn btn-primary hidden" id="save_system_settings">
    						</div>
    					</div>
    				</form>
    			</div>
    		</div>
    	</div>
	<?php
		// get footer
		include("./include/include_footer.php");
		// get plugin init
		include("./include/init_tinymce.php");
		// get page setting
		echo "<script type='text/javascript' src='./js/system_settings.js'></script>";
	}
}
?>