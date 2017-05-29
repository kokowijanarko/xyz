<?php session_start();

// Check if user already logged in
if (isset($_SESSION['username']) && isset($_SESSION['level']) && $_SESSION['username']!="" && $_SESSION['level']!="") {
	
	header("Location: ./dashboard.php");
	die();
}
else {
	require_once('./class/inventory.class.php');
	$invClass = new Inventory();

	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>
			<?php
			if ($invClass->setting_data("inventory_name")!="") { 
				echo $invClass->setting_data("inventory_name"); 
			} else {
				echo "Inventory System";
			}
			?>
		</title>
		<!-- Styling -->
		<link rel="icon" href="./assets/images/favicon.ico">
		<link rel="stylesheet" type="text/css" href="./assets/css/<?php if ($invClass->setting_data("color_scheme")!="") { echo $invClass->setting_data("color_scheme"); } else {echo "site-default.min.css";} ?>">
		<link rel="stylesheet" type="text/css" href="./assets/plugins/pace/pace.css">
	</head>
	<body background="./assets/images/backgrounds/<?php if ($invClass->setting_data("body_background")!="") { echo $invClass->setting_data("body_background"); } else {echo "symphony.png";} ?>">
		<div class="docs-header">
			<!--nav-->
			<nav class="navbar navbar-default navbar-custom" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">
							<img src="assets/images/<?php if ($invClass->setting_data("inventory_logo")!="") { echo $invClass->setting_data("inventory_logo"); } else {echo "logo.png";} ?>" height="40">
						</a>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">
							<!-- <li><a class="nav-link current" href="#">Home</a></li>
							<li><a class="nav-link" href="#">About</a></li> -->
						</ul>
					</div>
				</div>
			</nav>
			<!--header-->
			<div class="topic">
				<div class="container">
					<div id="jGrowl-container" class="jGrowl top-right"></div>

					<div class="col-md-7">
						<h3>
							<?php 
							if ($invClass->setting_data("inventory_name")!="") { 
								echo $invClass->setting_data("inventory_name"); 
							} else {
								echo "Inventory System";
							}
							?>
						</h3>
						<h4>
							<?php 
							if ($invClass->setting_data("inventory_slogan")!="") { 
								echo $invClass->setting_data("inventory_slogan"); 
							} else {
								echo "Welcome to inventory system!";
							} 
							?>
						</h4>
					</div>

					<div class="col-md-5">
						<div class="advertisement">
							<form name="sign_in_form" id="sign_in_form" action="dashboard.php" method="post">
								<div class="form-group">
									<label for="username"><i class="glyphicon glyphicon-user"></i> &nbsp; Username</label>
									<input type="text" name="username" id="username" maxlength="30" class="form-control" autofocus required <?php if (isset($_SESSION['sign_in_username'])) { echo " value='".$_SESSION['sign_in_username']."'";} ?>>
								</div>
								<div class="form-group">
									<label for="password"><i class="glyphicon glyphicon-lock"></i> &nbsp; Password</label>
									<input type="password" name="password" id="password" class="form-control" required <?php if (isset($_SESSION['sign_in_password'])) { echo " value='".$_SESSION['sign_in_password']."'";} ?>>
								</div>
								<div class="form-group">
									<input type="hidden" name="action" value="sign_in">
									<button type="submit" id="sign_in_initiate" class="btn btn-primary"><i class="glyphicon glyphicon-log-in"></i> Sign In</button> 
									<span class="pull-right">Forgot your account?</span>
								</div>
							</form>
							
							<?php // Error when signing in - alert and removem session
								if (isset($_SESSION['sign_in_error']) && $_SESSION['sign_in_error']==1) {
								echo "<div class='alert alert-danger alert-dismissable' id='sign_in_alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Sign in failed!<br>Please check your username and password.</div>";
								session_destroy();
								}
							?>
						</div>
					</div>
				</div>
			</div>
	    </div>

	    <div class="container document">
	    	<div class="row">
		    	<div class="col-md-12 well">
		    		<div style="margin-top: 30px;"></div>
			    		<div class="col-md-6">
			    			<h4>About</h4>
			    			<?php echo $invClass->setting_data("inventory_description"); ?>
			    		</div>
			    		<div class="col-md-6">
			    			<h4>Location</h4>
		    				<?php echo $invClass->setting_data("inventory_location"); ?>
			    			<p>
			    				<i class="glyphicon glyphicon-phone-alt"></i> &nbsp; 
			    				Phone : <?php if ($invClass->setting_data("inventory_phone_number")!="") { echo $invClass->setting_data("inventory_phone_number"); } else {echo "-";} ?>
			    			</p>
			    			<p>
			    				<i class="glyphicon glyphicon-print"></i> &nbsp; 
			    				Fax : <?php if ($invClass->setting_data("inventory_fax_number")!="") { echo $invClass->setting_data("inventory_fax_number"); } else {echo "-";} ?>
			    			</p>
			    			<p>
			    				<i class="glyphicon glyphicon-envelope"></i> &nbsp; 
			    				<?php if ($invClass->setting_data("inventory_email")!="") { echo $invClass->setting_data("inventory_email"); } else {echo "-";} ?>
			    			</p>
			    			<p>
				    			<i class="glyphicon glyphicon-globe"></i> &nbsp; 
				    			<?php if ($invClass->setting_data("inventory_website")!="") { echo $invClass->setting_data("inventory_website"); } else {echo "-";} ?>
			    			</p>
			    		</div>
		    	</div>
	    	</div>
	    </div>

	</body>
	</html>

	<!-- Aditional Script -->
	<script type="text/javascript" src="./assets/js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./assets/plugins/pace/pace.js"></script>

<?php 
}
// /End else
?>
