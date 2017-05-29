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

// Check if user already logged in
include("./include/signin_status.php");

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
	// Get user detail
	$username = $_GET["username"];
	$data     = $userclass->show_users($username);
	$data_num = count($data);

	if ($data_num!=0) {
		foreach ($data as $user_data) {
			$username   = $user_data["username"];
			$first_name = $user_data["first_name"];
			$last_name  = $user_data["last_name"];
			$photo      = $user_data["photo"];
			$level      = $user_data["level"];
			$active     = $user_data["active"];
		}
	}
	?>

	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				<i class="glyphicon glyphicon-user"></i> &nbsp; User Edit
			</h3>
			<br>
		</div>
		<div class='panel-body'>
		    <form name="form_user" class="form-horizontal validetta" enctype="multipart/form-data" id="form_user" method="post" action="process.php">
                <legend>User Informations</legend>
                <div class="form-group">
                    <label class="control-label col-sm-3">Username</label>
                    <div class="col-sm-9">
                        <p class="form-control-static"><?php echo $username; ?></p>
                        <!-- <input type="text" class="form-control" value="<?php echo $username; ?>" disabled="disabled"> -->
                        <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="first_name">First Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" data-validetta="required" value="<?php echo $first_name; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="last_name">Last Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="<?php echo $last_name; ?>"> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="password">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password"> 
                        <label class="text-muted"><input id="show_password" type="checkbox"> Show password</label>
                        <span class="help-block">Fill this field <strong>only</strong> when you want to change the password.</span>
                    </div>
                </div>
                <hr class="dashed">
                <div class="form-group">
                    <label class="control-label col-sm-3" for="photo">User Photo</label>
                    <div class="col-sm-9">
                        <input type="file" class="form-control" name="photo" id="photo"> 
                        <span class="help-block">Max file size 2 Mb. Jpg, png and gif. (Optional)</span>
                    </div>
                </div>

                <legend>Additional Privileges</legend>
                <div class="form-group">
                    <label class="control-label col-sm-3"> </label>
                    <div class="col-sm-9">
                        <?php echo $userclass->user_privileges($username, "user"); ?>
                    </div>
                </div>
            	<hr class="dashed" />
                <input type="hidden" name="level" id="level" value="user">
                <input type="hidden" name="action" id="action" value="edit_user">
                <input type="hidden" name="action2" id="action2" value="edit_user">
                <a href="user_management.php" class="btn btn-default" >Cancel</a>
                <button type="submit" class="btn btn-primary">Save changes</button>
		    </form>
		</div>
	</div>
</div>
<?php

// get footer
include("./include/include_footer.php");
// get plugins
include("./include/init_datatables.php");
include("./include/init_validetta.php");
include("./include/init_showpassword.php");
// get page setting
echo "<script type='text/javascript' src='./js/user_management.js'></script>";
include("./include/include_modal_user.php");
?>