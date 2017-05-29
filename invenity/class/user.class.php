<?php
/**
* User Class
* User management class such as sign in, sign out, create new user and edit existing user
*
* @author 		Noerman Agustiyan
* @version 		0.1
*/
	
require_once(__DIR__ . '/../lib/db.class.php');
require_once(__DIR__ . '/../class/inventory.class.php');
require_once(__DIR__ . '/../class/system.class.php');

class UserClass
{

	/**
	* Construct
	* 
	*/
	public function __construct() {
		$this->db        = new DB();
		$this->inventory = new inventory();
		$this->sysClass  = new SystemClass();
	}



	/**
	* Sign In
	*
	* @param 	string 	$username
	* @param 	string 	$password
	*/
	public function sign_in($username, $password)
	{
		// Get salt
		$query = "SELECT salt FROM users WHERE username = '$username'";
		$fetch = $this->db->query($query,'',PDO::FETCH_ASSOC);
		foreach ($fetch as $dt_salt) {
			$salt = $dt_salt['salt'];
		}

		// Set password
		$password_salted = hash("SHA512", $password.$salt);
		
		// Check users and privileges
		$query = "SELECT users.`username`, users.`first_name`, users.`last_name`, users.`level`, users.`photo`, user_privileges.`privileges` FROM users INNER JOIN user_privileges ON users.`username`=user_privileges.`username` WHERE users.`username`='$username' AND users.`password`='$password_salted' AND users.`active`='yes' AND user_privileges.`username`='$username'";
		$fetch = $this->db->query($query);

		// If data exists
		if ($fetch!=0) {
			// Fetch user data
			foreach ($fetch as $dt_user) {
				$username   = $dt_user['username'];
				$first_name = $dt_user['first_name'];
				$last_name  = $dt_user['last_name'];
				$level      = $dt_user['level'];
				$user_photo = $dt_user['photo'];
				$privileges = $dt_user['privileges'];
			}

			if ($level!="") {
				$_SESSION["username"]   = $username;
				$_SESSION["first_name"] = $first_name;
				$_SESSION["last_name"]  = $last_name;
				$_SESSION["level"]      = $level;
				$_SESSION["user_photo"] = $user_photo;
				$_SESSION["privileges"] = $privileges;
				// Refresh current page
				header("Refresh: 0");
				die();
			}
			else {
				$_SESSION['sign_in_error']    = 1;
				$_SESSION['sign_in_username'] = $username;
				$_SESSION['sign_in_password'] = $password;
				header("Location: ./index.php");
				die();
			}
		}
		// No data found
		else {
			$_SESSION['sign_in_error']    = 1;
			$_SESSION['sign_in_username'] = $username;
			$_SESSION['sign_in_password'] = $password;
			header("Location: ./index.php");
			die();
		}
	}



	/**
	* Sign Out
	*
	*/
	public function sign_out()
	{
		// session_destroy();
		unset($_SESSION["username"],
			$_SESSION["first_name"],
			$_SESSION["last_name"],
			$_SESSION["level"],
			$_SESSION["user_photo"],
			$_SESSION["privileges"]);
		header("Location: ./index.php");
		die();
	}



	/**
	* Show Existing Users
	*
	* @return 	array 	$result
	*
	*/
	public function show_users($username="")
	{
		if ($username!="") {
			$query  = "SELECT * FROM users WHERE username = '$username' AND level = 'user'";
		} else {
			$query  = "SELECT * FROM users WHERE level = 'user' ORDER BY username ASC";
		}
		$result = $this->db->query($query);
		return $result;
	}



	/**
	* Show All Existing Users
	*
	* @return 	array 	$result
	*
	*/
	public function show_all_user($username="")
	{
		if ($username!="") {
			$query  = "SELECT * FROM users WHERE username = '$username'";
		} else {
			$query  = "SELECT * FROM users ORDER BY username ASC";
		}
		$result = $this->db->query($query);
		return $result;
	}



	/**
	* Show User Privileges
	* other than standard privileges such as location and device manager
	*
	* @param 	string 	$username
	* @param 	string 	$level
	* @return 	array 	$result
	*
	*/
	public function user_privileges($username="", $level="")
	{
		$current_privileges = "";
		// If username and level isn't empty, get current privileges
		if ($username!="" && $level!="") {
			$query_2 = "SELECT privileges FROM users INNER JOIN user_privileges ON users.username = user_privileges.username WHERE users.username = '$username' AND users.level = '$level'";
			$fetch_current_privileges = $this->db->query($query_2);
			foreach ($fetch_current_privileges as $current_privileges) {
				$current_privileges = $current_privileges['privileges'];
			}
		}

		// Show standard and active components
		$result = "";
		$query  = "SELECT component_id, component_name FROM component WHERE component_type = 'standard' AND active = 'yes'";
		$fetch  = $this->db->query($query);
		
		if (count($fetch)>0) {
			foreach ($fetch as $dt_com) {
				$component_id   = $dt_com['component_id'];
				$component_name = $dt_com['component_name'];
				// If privileges exists
				if ($current_privileges!="*") {
					if (strpos($current_privileges, $component_id) !== FALSE) {
						$result .= "<input type='checkbox' name='privileges[]' id='priv_$component_id' value='$component_id' checked=''> <label for='priv_$component_id'>$component_name</label><br>";
					}
					else {
						$result .= "<input type='checkbox' name='privileges[]' id='priv_$component_id' value='$component_id'> <label for='priv_$component_id'>$component_name</label><br>";
					}
				}
				else {
					$result .= "";
				}
			}
		}
		else {
			$result .= "No Additional Privileges.";
		}

		return $result;
	}



	/**
	* Change user status
	*
	* @param 	array 	$dt_user
	* @return 	string 	$process
	*
	*/
	public function user_change_status($dt_user)
	{
		// assign variable
		$username = $dt_user["username"];
		$active   = $dt_user["status"];

		// create query
		$query   = "UPDATE users SET active='$active', updated_by='$_SESSION[username]', updated_date=NOW(), revision=revision+1 WHERE username='$username'";

		// add to database
		$process = $this->db->query($query);

		// create system log
		if ($process>0) {
			$this->sysClass->save_system_log($_SESSION['username'], $query);
		}

		return $process;
	}



	/**
	* Add New User
	*
	* @param 	array 	$dt_user
	* @param 	array 	$photo
	* @return 	string 	$process
	*
	*/
	public function add_user($dt_user, $photo="")
	{
		// assign variable
		$first_name = addslashes(trim($dt_user["first_name"]));
		$last_name  = addslashes(trim($dt_user["last_name"]));
		$username   = addslashes(trim($dt_user["username"]));
		$salt       = hash("SHA256", rand());
		$password   = hash("SHA512", $dt_user["password"].$salt);
		$active     = $dt_user["active"];
		$privileges = $dt_user["privileges"];
		// $photo      = $dt_user["photo"];

		// Check if username exists
		$num_row = count($this->show_users($username));

		// if exists, process = 0, set callback var
		if ($num_row>0) {
			$process = 0;
			// send back inputed variable
			$_SESSION['new_first_name'] = $first_name;
			$_SESSION['new_last_name']  = $last_name;
			$_SESSION['new_username']   = $username;
			$_SESSION['new_password']   = $dt_user["password"];
		}
		// save process
		else {
			// upload photo if photo set
			if ($photo!="") {
				// Init var
				$save_count   = 0;
				$error_count  = 0;
				$notification = "";
				
				foreach ($photo as $photo_name => $photo_name_value) {
					// Set var
					$location  = "./assets/images/user_photos/";
					$file_name = $_FILES[$photo_name]['name'];
					$file_size = $_FILES[$photo_name]['size'];
					$file_tmp  = $_FILES[$photo_name]['tmp_name'];
					$file_type = $_FILES[$photo_name]['type'];

					// If file name isn't empty
					if ($file_name!="") {
						// Check if file is the real image
						$check_image = getimagesize($file_tmp);
		    			if($check_image !== false) {
							// Verify extension
							$extensions = array("png", "jpg", "jpeg", "gif");
							$file_ext   = explode('.',$file_name);
							$file_ext   = strtolower(end($file_ext));
							if(in_array($file_ext,$extensions ) === false){
								$errors[] = "<br>Extension not allowed, please use png, jpg or gif file.<br>";
							}

							// Verify size
							if($file_size > 2097152){
								$errors[]="<br>File size must be less than 2 MB.";
							}

							// Set new name
							$new_photo_name = $username.".".$file_ext;

							// Upload file process
							if(empty($errors)==true){
								// Upload
								move_uploaded_file($file_tmp, $location.$new_photo_name);
								$save_count = $save_count+1;
							}
							else {
								// Set error count flag and notification
								$error_count = $error_count+1;
								foreach ($errors as $upload_error) {
									$notification .= $upload_error;
								}
							}
						}
					}
					else {
						$save_count = 0;
					}

					// If error_count == 0 > SUCCESS!
					if ($error_count==0 && $notification=="" && $save_count>0) {
						$notification .= "<br>Photo Uploaded successfully!";
					}
				}
				
				$user_photo           = $location.$new_photo_name;
				$process_photo_upload = $save_count;

				if ($process_photo_upload==0) {
					// set var
					$user_photo           = "./assets/images/user_photos/standard_photo.jpg";
					$process_photo_upload = 1;
				}
			}
			else {
				// set var
				$user_photo           = "./assets/images/user_photos/standard_photo.jpg";
				$process_photo_upload = 1;
			}

			// if process photo upload == 1, save database and log
			if ($process_photo_upload==1) {
				// create query users
				$query   = "INSERT INTO users (username, password, salt, level, active, first_name, last_name, photo, created_by, created_date, updated_by, updated_date) VALUES ('$username', '$password', '$salt', 'user', '$active', '$first_name', '$last_name', '$user_photo', '$_SESSION[username]', NOW(), '$_SESSION[username]', NOW())";

				// add to database users
				$process = $this->db->query($query);

				// create system log users
				if ($process>0) {
					$this->sysClass->save_system_log($_SESSION['username'], $query);
				}

				// check additional privileges
				$user_privileges = "";
				$i               = 0;
				$total           = count($privileges);
				foreach ($privileges as $privileges) {
					$i++;
					if ($i!=$total && $privileges!="") {
						$user_privileges .= "$privileges ";
					}
				}
				trim($user_privileges);
				if ($user_privileges!="") {
					str_replace(" ", ",", $user_privileges);
					$user_privileges = "5,6,7,".$user_privileges;
				}
				else {
					$user_privileges = "5,6,7";
				}

				// create query privileges
				$query   = "INSERT INTO user_privileges (username, privileges, created_by, created_date, updated_by, updated_date, revision) VALUES ('$username', '$user_privileges', '$_SESSION[username]', NOW(), '$_SESSION[username]', NOW(), '0')";

				// add to database privileges
				$process = $this->db->query($query);

				// create system log privileges
				if ($process>0) {
					$this->sysClass->save_system_log($_SESSION['username'], $query);
				}
			}
			// else, return to form
			else {
				$process = 0;
				$_SESSION['new_first_name'] = $first_name;
				$_SESSION['new_last_name']  = $last_name;
				$_SESSION['new_username']   = $username;
				$_SESSION['new_password']   = $dt_user["password"];
				$_SESSION['errors']         = $process_photo_upload;
			}
		}

		return $process;
	}



	/**
	* Edit User
	*
	* @param 	array 	$dt_user
	* @param 	array 	$photo
	* @return 	string 	$process
	*
	*/
	public function edit_user($dt_user, $photo="")
	{
		$username   = $dt_user["username"];
		$first_name = $dt_user["first_name"];
		$last_name  = $dt_user["last_name"];
		$privileges = $dt_user["privileges"];

		if ($dt_user["password"]!="") {
			$salt       = hash("SHA256", rand());
			$password   = hash("SHA512", $dt_user["password"].$salt);
		}

		// upload photo if photo set
		if ($photo["name"]!="") {
			// set var | upload
			// $ppu = $this->photo_upload($username, $photo);
			// Init var
			$save_count   = 0;
			$error_count  = 0;
			$notification = "";
			
			foreach ($photo as $photo_name => $photo_name_value) {
				// Set var
				$location  = "./assets/images/user_photos/";
				$file_name = $_FILES[$photo_name]['name'];
				$file_size = $_FILES[$photo_name]['size'];
				$file_tmp  = $_FILES[$photo_name]['tmp_name'];
				$file_type = $_FILES[$photo_name]['type'];

				// If file name isn't empty
				if ($file_name!="") {
					// Check if file is the real image
					$check_image = getimagesize($file_tmp);
	    			if($check_image !== false) {
						// Verify extension
						$extensions = array("png", "jpg", "jpeg", "gif");
						$file_ext   = explode('.',$file_name);
						$file_ext   = strtolower(end($file_ext));
						if(in_array($file_ext,$extensions ) === false){
							$errors[] = "<br>Extension not allowed, please use png, jpg or gif file.<br>";
						}

						// Verify size
						if($file_size > 2097152){
							$errors[]="<br>File size must be less than 2 MB.";
						}

						// Set new name
						$new_photo_name = $username.".".$file_ext;

						// Upload file process
						if(empty($errors)==true){
							// Upload
							move_uploaded_file($file_tmp, $location.$new_photo_name);
							$save_count = $save_count+1;
						}
						else {
							// Set error count flag and notification
							$error_count = $error_count+1;
							foreach ($errors as $upload_error) {
								$notification .= $upload_error;
							}
						}
					}
				}
				else {
					$save_count = $save_count+5;
				}

				// If error_count == 0 > SUCCESS!
				if ($error_count==0 && $notification=="" && $save_count>0) {
					$notification .= "<br>Photo Uploaded successfully!";
				}
			}

			// break process and notification
			$ppu_break                 = explode("|", $ppu);
			$process_photo_upload      = $save_count;
			$notification_photo_upload = $notification;
			$photo_query               = " photo='".$location.$new_photo_name."', ";
		}
		else {
			// set var
			$process_photo_upload      = 1;
			$notification_photo_upload = "";
			$photo_query               = "";
		}

		// if process photo upload == 1, save database and log
		if ($process_photo_upload>0) {
			// create query users
			$query = "UPDATE users SET first_name='$first_name', last_name='$last_name', $photo_query updated_by='$_SESSION[username]', updated_date=NOW(), revision = revision+1 WHERE username = '$username'";
				$custom_query = "UPDATE users SET first_name='$first_name', last_name='$last_name', $photo_query updated_by='$_SESSION[username]', updated_date=NOW(), revision = revision+1 WHERE username = '$username'";

			// update password if password field filled
			if ($dt_user["password"]!="") {
				$query   = "UPDATE users SET first_name='$first_name', last_name='$last_name', password='$password', salt='$salt', $photo_query updated_by='$_SESSION[username]', updated_date=NOW(), revision = revision+1 WHERE username = '$username'";
				$custom_query = "UPDATE users SET first_name='$first_name', last_name='$last_name', password='new password', salt='new salt', $photo_query updated_by='$_SESSION[username]', updated_date=NOW(), revision = revision+1 WHERE username = '$username'";
			}

			// add to database users
			$process = $this->db->query($query);

			// create system log users (custom because we dont want to log the password and salt)
			if ($process>0) {
				$this->sysClass->save_system_log($_SESSION['username'], $custom_query);
			}

			// check additional privileges
			if ($privileges!="*") {
				// 5,6,7 -> standard setting (device [5] and location [6] and report [7])
				$user_privileges = "";
				$i               = 0;
				$total           = count($privileges);
				foreach ($privileges as $privilege) {
					$i++;
					if ($i<=$total && $privilege!="") {
						$user_privileges .= "$privilege ";
					}
				}

				if ($user_privileges!="") {
					$user_privileges = str_replace(" ", ",", trim($user_privileges));
					$user_privileges = "5,6,7,".$user_privileges;
				}
				else {
					$user_privileges = "5,6,7";
				}

				// create query privileges
				$query   = "UPDATE user_privileges SET privileges='$user_privileges', updated_by='$_SESSION[username]', updated_date=NOW(), revision=revision+1 WHERE username='$username'";

				// add to database privileges
				$process = $this->db->query($query);

				// create system log privileges
				if ($process>0) {
					$this->sysClass->save_system_log($_SESSION['username'], $query);
				}
			}
		}
		else {
			$process = 0;
			$notification_photo_upload = "No file uploaded!";
		}

		// Set session if edited user is current user
		if ($_SESSION['username'] == $username ) {
			$_SESSION['first_name'] = $first_name;
			$_SESSION['last_name']  = $last_name;
		}

		return $process."|".$notification_photo_upload;
	}



	/**
	* Upload User Photo
	*
	* @param 	string 	$username
	* @param 	array 	$photo
	* @return 	string 	$process
	*
	*/
	public function photo_upload($username, $photo)
	{
		// Init var
		$save_count   = 0;
		$error_count  = 0;
		$notification = "";
		
		foreach ($photo as $photo_name => $photo_name_value) {
			// Set var
			$location  = "./assets/images/user_photos/";
			$file_name = $_FILES[$photo_name]['name'];
			$file_size = $_FILES[$photo_name]['size'];
			$file_tmp  = $_FILES[$photo_name]['tmp_name'];
			$file_type = $_FILES[$photo_name]['type'];

			// If file name isn't empty
			if ($file_name!="") {
				// Check if file is the real image
				$check_image = getimagesize($file_tmp);
    			if($check_image !== false) {
					// Verify extension
					$extensions = array("png", "jpg", "jpeg", "gif");
					$file_ext   = explode('.',$file_name);
					$file_ext   = strtolower(end($file_ext));
					if(in_array($file_ext,$extensions ) === false){
						$errors[] = "<br>Extension not allowed, please use png, jpg or gif file.<br>";
					}

					// Verify size
					if($file_size > 2097152){
						$errors[]="<br>File size must be less than 2 MB.";
					}

					// Set new name
					$new_photo_name = $username.".".$file_ext;

					// Upload file process
					if(empty($errors)==true){
						// Upload
						move_uploaded_file($file_tmp, $location.$new_photo_name);
						$save_count = $save_count+1;
					}
					else {
						// Set error count flag and notification
						$error_count = $error_count+1;
						foreach ($errors as $upload_error) {
							$notification .= $upload_error;
						}
					}
				}
			}
			else {
				$save_count = $save_count+5;
			}

			// If error_count == 0 > SUCCESS!
			if ($error_count==0 && $notification=="" && $save_count>0) {
				$notification .= "<br>Photo Uploaded successfully!";
			}
		}

		return $save_count."|".$notification;
	}


}

?>