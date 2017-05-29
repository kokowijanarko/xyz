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
	?>

	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				<i class="glyphicon glyphicon-user"></i> &nbsp; <?php echo $current_page_name; ?>
				<span class="pull-right"><button type="button" class="btn btn-default btn-sm" onclick="show_add_new_user()"><i class="glyphicon glyphicon-plus"></i> Add New</button></span>
			</h3>
			<br>
		</div>
		<div class='panel-body'>
		<?php 
			// Get current user
			$data     = $userclass->show_users();
			$data_num = count($data);

			// Show if exists
			if ($data_num!=0) {
				$data_table = "<table class='table table-bordered table-striped' id='datatable'><thead><tr><th>Username</th><th>Real Name</th><th>Photo</th><th>Active</th><th>Actions</th></tr></thead><tbody>";
				foreach ($data as $user_data) {
					$username   = $user_data["username"];
					$first_name = $user_data["first_name"];
					$last_name  = $user_data["last_name"];
					$photo      = $user_data["photo"];
					$level      = $user_data["level"];
					$active     = $user_data["active"];
					
					if ($active=="yes") {
						$active_status = "<span class='label label-success'>Yes</span><input type='hidden' id='uactive_$username' value='yes'>";
						$button_status = "<button type='button' title='Deactive' class='btn btn-danger btn-sm' onclick=\"user_change_status('$username', '$first_name $last_name', 'no')\"><i class='glyphicon glyphicon-remove'></i></button>";
					}
					elseif ($active=="no") {
						$active_status = "<span class='label label-danger'>No</span><input type='hidden' id='uactive_$username' value='no'>";
						$button_status = "<button type='button' title='Activate' class='btn btn-success btn-sm' onclick=\"user_change_status('$username', '$first_name $last_name', 'yes')\"><i class='glyphicon glyphicon-ok'></i></button>";
					}
					$data_table    .= "<tr>
						<td id='username_$username'>$username</td>
						<td id='real_name_$username'>$first_name $last_name</td>
						<td><img src='$photo' width='100'></td>
						<td>$active_status</td>
						<td>$button_status <a href='user_edit.php?username=$username' title='Edit' class='btn btn-default btn-sm'><i class='glyphicon glyphicon-pencil'></i></a></td>
					</tr>";
				}
				$data_table .= "</tbody></table>";
				echo $data_table;
			}
			// No data found?
			else {
				echo "<p>No Data Found!</p>";
			}
		?>
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