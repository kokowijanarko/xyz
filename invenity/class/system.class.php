<?php
/**
* System_settings Class
* All inventory system needs
*
* @author 		Noerman Agustiyan
* @version 		0.1
*
*/

require_once(__DIR__ . '/../lib/db.class.php');
require_once(__DIR__ . '/../class/inventory.class.php');

class SystemClass
{
	/**
	* Construct
	* 
	*/
	public function __construct() {
		$this->db       = new DB();	
		$this->invClass = new Inventory();	
	}



	/**
	* Get single data from table
	*
	* @param 		string 	$field
	* @param 		string 	$table
	* @param 		string 	$criteria
	*
	* @return 		string 	$result
	*
	*/
	public function get_single_data($field, $table, $criteria)
	{
		$query  = "SELECT $field FROM $table WHERE $criteria";
		$result = $this->db->single($query);
		return $result;
	}



	/**
	* Show system logs
	*
	* @return 		array 	$result
	*
	*/
	public function show_system_logs()
	{
		$query  = "SELECT log_date, username, description FROM system_logs ORDER BY log_date DESC";
		$result = $this->db->query($query);
		return $result;
	}



	/**
	* Save system log
	* Create system log based on user query.
	*
	* @param 		string 	$username
	* @param 		string 	$query
	*
	*/
	public function save_system_log($username, $query)
	{
		// Check query process
		$raw_statement = explode(" ", $query);
		
		// Which SQL statement is used 
		$statement     = strtolower($raw_statement[0]);
		
		if ($statement === 'insert') {
			// Get table name (3rd position based on INSERT INTO 'table')
			$table            = $raw_statement[2];
			$log_descriptions = "$username insert new data into the $table table on ".date("Y/m/d H:i:s");
		}
		elseif ( $statement === 'update' ) {
			// Get table name (2nd position based on UPDATE 'table')
			$table            = $raw_statement[1];
			$log_descriptions = "$username update data : ";
			// Left limit -> SET -> First "SET"
			$left_limit       = explode("SET", $query, 2);
			// Right limit -> WHERE -> Reverse String "EREHW" to avoid another "WHERE" from query input
			$right_limit      = explode("EREHW", strrev($left_limit[1]), 2);
			// Get edited column and new values
			$updated_columns  = addslashes(strrev($right_limit[1]));
			$updated_columns  = explode(", updated_by", $updated_columns);
			$updated_columns  = $updated_columns[0];
			$update_criteria  = addslashes(strrev($right_limit[0]));
			$log_descriptions .= "$updated_columns where $update_criteria from $table table on ".date("Y/m/d H:i:s");
		}
		else {
			return NULL;
		}

		// Process save to system log
		$query_system_log = "INSERT INTO system_logs (log_date, username, description) VALUES (NOW(), '$username', '$log_descriptions')";
		$process          = $this->db->query($query_system_log);
	}



	/**
	* Save system settings data
	*
	* @param 		array 	$postdata
	* @param 		array 	$filedata
	*
	* @return 		string 	$notification
	*
	*/
	public function save_system_settings($postdata, $filedata="")
	{
		// Init var
		$save_count   = 0;
		$error_count  = 0;
		$notification = "";

		// Save post data
		foreach ($postdata as $setting_name => $setting_value) {
			// Check if new value is the same with old value
			$old_value = $this->get_single_data("setting_value", "system_settings", " setting_name='$setting_name'");

			// If not the same
			if ($setting_value != $old_value) {
				// Update new data
				$query   = "UPDATE system_settings SET setting_value='$setting_value', updated_by='$_SESSION[username]', updated_date=NOW(), revision=revision+1 WHERE setting_name='$setting_name'";
				$process = $this->db->query($query);

				// If process error, insert new data
				if ($process==0) {
					$query_2 = "INSERT INTO system_settings VALUES ('$setting_name', '$setting_value', 'yes', '$_SESSION[username]', NOW(), '$_SESSION[username]', NOW(), 0)";
					$process = $this->db->query($query_2);
					// Set system log
					$this->save_system_log($_SESSION['username'], $query_2);
					if ($process==0) {
						// Set error count flag and notification
						$error_count = $error_count+1;
						$notification .= "Error, $setting_name cannot be added to system settings!<br>";
					}
					else {
						// Set save count flag
						$save_count = $save_count+1;
					}
				}
				// update success
				else if ($process>0) {
					// Set system log
					$this->save_system_log($_SESSION['username'], $query);
					$save_count = $save_count+1;
				}
			}
		}

		// Save file data
		if ($filedata!="") {
			foreach ($filedata as $setting_name_file => $setting_value_file_save) {
				// Set var
				$location      = "./assets/images/";
				$file_name     = $_FILES[$setting_name_file]['name'];
				$file_size     = $_FILES[$setting_name_file]['size'];
				$file_tmp      = $_FILES[$setting_name_file]['tmp_name'];
				$file_type     = $_FILES[$setting_name_file]['type'];
				$new_file_name = $this->get_single_data("setting_value", "system_settings", " setting_name='$setting_name_file'" );
				// $new_file_name = $this->invClass->setting_data($setting_name_file);

				// If file name isn't empty
				if ($file_name!="") {
					// Check if file is the real image
					$check_image = getimagesize($file_tmp);
	    			if($check_image !== false) {
						// Verify extension
						$extensions = array("png");
						$file_ext   = explode('.',$file_name);
						$file_ext   = strtolower(end($file_ext));
						if(in_array($file_ext,$extensions ) === false){
							$errors[] = "Extension not allowed, please use png file.<br>";
						}

						// Verify size
						if($file_size > 2097152){
							$errors[]="File size must be less than 2 MB.";
						}

						// Process upload file
						if(empty($errors)==true){
							// Upload
						    move_uploaded_file($file_tmp, $location.$new_file_name);
						    // Update new data, create log and set flag
							$query   = "UPDATE system_settings SET updated_by='$_SESSION[username]', updated_date=NOW(), revision=revision+1 WHERE setting_name='$setting_name_file'";
							$process = $this->db->query($query);
							if ($process>0) {
								// Set system log
								$this->save_system_log($_SESSION['username'], $query);
								$save_count = $save_count+1;
							}
						}
						else {
							// Set error count flag and notification
							$error_count  = $error_count+1;
							foreach ($errors as $upload_error) {
								$notification .= $upload_error;
							}
						}
					}
				}	
			}

			// If error_count == 0 > SUCCESS!
			if ($error_count==0 && $notification=="" && $save_count>0) {
				$notification .= "System settings updated successfully!";
			}
		}

		return $notification;
	}



}