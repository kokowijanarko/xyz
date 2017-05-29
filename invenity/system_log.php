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
require_once(__DIR__ . '/class/system.class.php');
$sysClass  = new SystemClass();

// Check if user already logged in
include("./include/signin_status.php");

// get header
include("./include/include_header.php");

?>
<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				<i class="glyphicon glyphicon-list-alt"></i> &nbsp; <?php echo $current_page_name; ?>
			</h3>
			<br>
		</div>
		<div class='panel-body'>
		<?php 
			// Get current component
			$data     = $sysClass->show_system_logs();
			$data_num = count($data);

			// Show if exists
			if ($data_num!=0) {
				$no         = 0;
				$data_table = "<table class='table table-bordered table-striped' id='datatable'><thead><tr><th>No</th><th>Date</th><th>Username</th><th>Description</th></tr></thead><tbody>";
				foreach ($data as $dt_logs) {
					$no++;
					$username    = $dt_logs["username"];
					$log_date    = date_format(date_create($dt_logs["log_date"]), "d/m/Y");
					$description = strip_tags($dt_logs["description"]);
					$data_table  .= "<tr><td>$no</td><td>$log_date</td><td>$username</td><td>$description</td></tr>";
				}
				$data_table .= "</tbody></table>";
				echo $data_table;
			}
			// No data found?
			else {
				echo "<p>No System Log Found!</p>";
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
?>