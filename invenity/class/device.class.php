<?php
/**
* Device Class
* Device management class such as device, device type
*
* @author 		Noerman Agustiyan
* @version 		0.2
*/

require_once(__DIR__ . '/../lib/db.class.php');
require_once(__DIR__ . '/../class/inventory.class.php');
require_once(__DIR__ . '/../class/location.class.php');
require_once(__DIR__ . '/../class/system.class.php');

class DeviceClass
{
	/**
	* Construct
	* 
	*/
	function __construct()
	{
		$this->db        = new DB();
		$this->inventory = new inventory();
		$this->locClass  = new LocationClass();
		$this->sysClass  = new SystemClass();
	}


	/**
	* Select device type
	* 
	* @param 	string 	$type_name
	* @param 	string 	$type_code
	* @param 	string 	$active
	* @return 	array 	$process
	* 
	*/
	public function show_device_type($type_name="", $type_code="", $active="")
	{
		$query = "SELECT 
					type_id, 
					type_name, 
					type_code, 
					active, 
					(SELECT COUNT(*) FROM device_list WHERE type_id = dt.type_id) as device_total  
					FROM device_type AS dt ";

		// additional parameters?
		if ($type_name!="" || $type_code!="" || $active!="") {
			$query .= " WHERE ";

			if ($type_name!="") {
				$type_name = strtolower(trim($type_name));
				$query     .= " type_name = '$type_name' ";
				if ($type_code!="") {
					$type_code = strtoupper(trim($type_code));
					$query     .= " OR type_code = '$type_code' ";
				}
			}
			if ($type_code!="") {
				$type_code = strtoupper(trim($type_code));
				$query     .= " type_code = '$type_code' ";
			}
			if ($active!="") {
				if ($type_name!="" || $type_code!="") {
					$query .= " AND ";
				}
				$query .= " active = '$active' ";
			}
		}
		$query .= " ORDER BY type_name ASC";
		$process = $this->db->query($query);
		return $process;
	}


	/**
	* Add device type
	* 
	* @param 	array 	$dt_type
	* @return 	string 	$process
	* 
	*/
	public function add_device_type($dt_type)
	{
		// Set var
		$type_name = addslashes(trim($dt_type["type_name"]));
		$type_code = addslashes(strtoupper(trim($dt_type["type_code"])));
		$active    = $dt_type["active"];

		// Check if device exists
		$type_check = count($this->show_device_type($type_name, $type_code));
		if ($type_check>0) {
			// Send back with notification
			$process = 0;
			$notification = "|<br>Device type or code is already exists in the database!";
		}
		else {
			// Insert to database & create notification
			$query        = "INSERT INTO device_type 
							(type_name, type_code, active, created_by, created_date, updated_by, updated_date) 
							VALUES ('$type_name', '$type_code', '$active', '$_SESSION[username]', NOW(), '$_SESSION[username]', NOW()) ";
			$process      = $this->db->query($query);
			$notification = "|";
			// create log
			if ($process>0) {
				$this->sysClass->save_system_log($_SESSION['username'], $query);
			}
		}

		return $process.$notification;
	}


	/**
	* Change device type status
	*
	* @param 	array 	$dt_type
	* @return 	string 	$process
	*
	*/
	public function device_type_change_status($dt_type)
	{
		// assign variable
		$type_id   = $dt_type["type_id"];
		$type_name = $dt_type["type_name"];
		$active    = $dt_type["status"];

		// create query
		$query   = "UPDATE device_type 
					SET active='$active', updated_by='$_SESSION[username]', updated_date=NOW(), revision=revision+1 
					WHERE type_id='$type_id'";

		// edit to database
		$process = $this->db->query($query);

		// create system log
		if ($process>0) {
			$this->sysClass->save_system_log($_SESSION['username'], $query);
		}

		return $process;
	}



	/**
	* Select device
	* 
	* @param 	string 	$device_serial
	* @param 	string 	$device_status
	* @param 	string 	$device_id
	* @return 	array 	$process
	* 
	*/
	public function show_device($device_serial="", $device_status="", $device_id="")
	{
		$query = "SELECT a.*, 
					b.`type_name`, 
					c.`location_name`, 
					d.`place_id`, 
					d.`building_id`, 
					d.`floor_id`, 
					lp.`place_name`, 
					lb.`building_name`, 
					lf.`floor_name`  
					FROM device_list a 
					INNER JOIN device_type b ON a.`type_id` = b.`type_id` 
					LEFT JOIN location c ON a.`location_id` = c.`location_id` 
					LEFT JOIN location_details d ON a.`location_id` = d.`location_id` 
					LEFT JOIN location_place lp ON d.`place_id` = lp.`place_id`  
					LEFT JOIN location_building lb ON d.`building_id` = lb.`building_id`  
					LEFT JOIN location_floor lf ON d.`floor_id` = lf.`floor_id`
					";

		// If additional param exists
		if ($device_serial!="" || $device_status!="" || $device_id!="") {
			$query .= " WHERE ";
		}

		// if device serial isn't empty
		if ($device_serial != "") {
			$query .= " device_serial = '$device_serial' ";
		}
		// if device status isn't empty
		if ($device_status != "") {
			if ($device_serial != "") {
				$query .= " AND ";
			}
			$query .= " device_status = '$device_status' ";
		}
		// if device id isn't empty
		if ($device_id != "") {
			if ($device_serial != "" || $device_status != "") {
				$query .= " AND ";
			}
			$query .= " device_id = '$device_id' ";
		}

		$process = $this->db->query($query);
		return $process;
	}



	/**
	* Select device by type_id
	* 
	* @param 	string 	$type_id
	* @return 	array 	$process
	* 
	*/
	public function show_device_by_type($type_id)
	{
		$query = "SELECT a.*, 
					b.`type_name`, 
					c.`location_name`, 
					d.`place_id`, 
					d.`building_id`, 
					d.`floor_id`, 
					lp.`place_name`, 
					lb.`building_name`, 
					lf.`floor_name` 
					FROM device_list a 
					INNER JOIN device_type b ON a.`type_id` = b.`type_id` 
					LEFT JOIN location c ON a.`location_id` = c.`location_id` 
					LEFT JOIN location_details d ON a.`location_id` = d.`location_id` 
					LEFT JOIN location_place lp ON d.`place_id` = lp.`place_id` 
					LEFT JOIN location_building lb ON d.`building_id` = lb.`building_id`  
					LEFT JOIN location_floor lf ON d.`floor_id` = lf.`floor_id`
					WHERE a.`type_id` = '$type_id'";

		$process = $this->db->query($query);
		return $process;
	}



	/**
	* Generate device code
	* Device code format based on system setting 
	* 
	* @param 	string 	$device_type_code
	* @return 	string
	* 
	*/
	public function generate_device_code($device_type_code="")
	{
		// get from master
		$device_code = trim(strip_tags(addslashes($this->inventory->setting_data("device_code_format"))));

		// insert year (if exists)
		$device_code = str_replace("year", date("Y"), $device_code);

		// insert devtype (if exists)
		if ($device_type_code!="") {
			$device_code = str_replace("devtype", $device_type_code, $device_code);
		}
		
		// check the last number from db
		$last_device_code = 0;
		$query = "SELECT device_code FROM device_list WHERE device_code !='' ORDER BY device_id DESC LIMIT 1";
		foreach ($this->db->query($query) as $datas) {
			$last_device_code = $datas["device_code"];
		}
		// get number
		if (strpos($last_device_code, "/")!==FALSE) {
			$x_code_number = explode("/", strrev($last_device_code));
			$code_number   = strrev($x_code_number[0]);
			$code_number   = $code_number+1;
		}
		else {
			$code_number = 1;
		}

		// return it!
		return $device_code."/".$code_number;
	}



	/**
	* Add device
	*
	* @param 	array 	$dt_device
	* @param 	array 	$dt_photo
	*
	*/
	public function add_device($dt_device, $dt_photo)
	{
		// Set var
		$device_code        = $dt_device["dev_code"];
		$type_id            = $dt_device["dev_type_id"];
		$device_brand       = addslashes(trim($dt_device["dev_brand"]));
		$device_model       = addslashes(trim($dt_device["dev_model"]));
		$device_color       = addslashes(trim($dt_device["dev_color"]));
		$device_serial      = addslashes(trim($dt_device["dev_serial"]));
		$device_description = trim($dt_device["dev_description"]);
		$device_status      = '';//$dt_device["dev_status"];
		$location_id        = '';//$dt_device["location_id"];
		$device_m2          = $dt_device["dev_m2"];
		$device_dua			= '';//$dt_device[2];
		$device_mx2         = $dt_device["dev_mx2"];
		$device_kg          = $dt_device["dev_kg"];
		$device_kg1          = '';//$dt_device["dev_kg1"];
		$device_cek                = $dt_device["dev_cek"];
		$device_mprod              = $dt_device["dev_mprod"];
		//$keterangan         = $dt_device["dev_keterangan"];
		//$note               = $dt_device["dev_note"];
		$device_deployment_date = "0000-00-00 00:00:00";
		if ($device_status!="new" ) {
			$device_deployment_date = "NOW()";
		}

		// Check if device exists
		$dev_check = count($this->show_device($device_serial));
		if ($dev_check>0) {
			// Send back with notification
			$process                         = 0;
			$notification                    = "|<br>Device is already exists in the database!";
			$_SESSION['new_type_id']         = $type_id;
			$_SESSION['new_dev_brand']       = $device_brand;
			$_SESSION['new_dev_model']       = $device_model;
			$_SESSION['new_dev_serial']      = $device_serial;
			$_SESSION['new_dev_description'] = $device_description;
			$_SESSION['new_dev_status']      = $dev_status;
			$_SESSION['new_location_id']     = $location_id;
			$_SESSION['new_m2']              = $device_m2;
			$_SESSION['new_x2']              = $device_mx2;
			$_SESSION['new_kg']              = $device_kg;
			$_SESSION['new_kg1']             = $device_kg1;
			$_SESSION['new_cek']             = $device_cek;
			$_SESSION['new_mprod']         = $device_mprod;
			//$_SESSION['new_keterangan']      = $keterangan;
			//$_SESSION['new_note']            = $note;
		}
		else {
			// Check if dt_photo isn't empty
			if ($dt_photo!="") {
				// Init var
				$save_count   = 0;
				$error_count  = 0;
				$notification = "";
				$photo_name_text = array();
				
				//file foto
				if(!empty($dt_photo['dev_photo'])){
					foreach($dt_photo['dev_photo'] as $key=>$val){
						$i = 0;	
						foreach($val as $v){
							$photo_files[$i][$key] = $v;               		
							$i++;
						}
					}
					$i=1;
					foreach($photo_files as $key=>$val){
						
						// Set var
						$location  = "./assets/images/device_photos/";
						$file_name = $val['name'];
						$file_size = $val['size'];
						$file_tmp  = $val['tmp_name'];
						$file_type = $val['type'];
						
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
									$errors[] = "<br>Extension not allowed, please use png, jpg or gif file.";
								}

								// Verify size
								if($file_size > 2097152){
									$errors[]="<br>File size must be less than 2 MB.";
								}

								// Set new name
								$new_photo_name = 'img_'.$device_serial."_".$i.".".$file_ext;
								$photo_name_text[] = $location.'img_'.$device_serial."_".$i.".".$file_ext;
								// Upload file process
								if(empty($errors)==true){
									// Upload
									move_uploaded_file($file_tmp, $location.$new_photo_name);
									// Create thumb
									$this->inventory->create_thumbnail($location.$new_photo_name, $location.'img_'.$device_serial."_".$i."_thumbnail.".$file_ext, "200", "150");
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
							$new_photo_name = "standard_device.jpg";
							// nomor asal :P
							$save_count = $save_count+5;
						}

						// If error_count == 0 > SUCCESS!
						if ($error_count==0 && $notification=="" && $save_count>0) {
							$notification .= "<br>Photo Uploaded successfully!";
						}
						$i++;				
					}					
				}
				
				//file lain
				if(!empty($dt_photo['dev_files'])){
					foreach($dt_photo['dev_files'] as $key=>$val){
						$i = 0;	
						foreach($val as $v){
							$files[$i][$key] = $v;               		
							$i++;
						}
					}
					$i=1;
					
					foreach($files as $key=>$val){
						// Set var
						$location  = "./assets/images/device_photos/";
						$file_name = $val['name'];
						$file_size = $val['size'];
						$file_tmp  = $val['tmp_name'];
						$file_type = $val['type'];
						// If file name isn't empty
						if ($file_name!="") {
							// Check if file is the real image
							// $check_image = getimagesize($file_tmp);
							if($check_image !== false) {
								// Verify extension
								$extensions = array("doc", "docx", "xls", "xlsx", "pdf");
								$file_ext   = explode('.',$file_name);
								$file_ext   = strtolower(end($file_ext));
								if(in_array($file_ext,$extensions ) === false){
									$errors[] = "<br>Extension not allowed, please use png, jpg or gif file.";
								}

								// Verify size
								if($file_size > 2097152){
									$errors[]="<br>File size must be less than 2 MB.";
								}

								// Set new name
								$new_photo_name = 'file_'.$device_serial."_".$i.".".$file_ext;
								$photo_name_text[] = $location.'file_'.$device_serial."_".$i.".".$file_ext;
								// Upload file process
								if(empty($errors)==true){
									// Upload
									move_uploaded_file($file_tmp, $location.$new_photo_name);
									// Create thumb
									// $this->inventory->create_thumbnail($location.$new_photo_name, $location.$device_serial."_thumbnail.".$file_ext, "200", "150");
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
							$new_photo_name = "standard_device.jpg";
							// nomor asal :P
							$save_count = $save_count+5;
						}

						// If error_count == 0 > SUCCESS!
						if ($error_count==0 && $notification=="" && $save_count>0) {
							$notification .= "<br>Photo Uploaded successfully!";
						}
						$i++;				
					}

					
				}
				
				if(!empty($photo_name_text)){
					$device_photo = "";
					foreach($photo_name_text as $val){
						$device_photo .= $val .','; 
						
					}
					$device_photo = rtrim($device_photo,',');	
				}
				$process_photo_upload = $save_count;
			}
			else {
				$device_photo         = "./assets/images/device_photos/standard_device.jpg";
				$process_photo_upload = "1";
			}

			// if photo upload success 
			if ($process_photo_upload>0) {
				// Insert to database & create notification
				$query        = "INSERT INTO device_list (
					type_id, 
					device_code, 
					device_brand, 
					device_model, 
					device_serial, 
					device_color, 
					device_description, 
					device_photo, 
					device_status, 
					location_id, 
					m2,
					mx2,
					kg,
					kg1,
					cek,
					mprod,
					device_deployment_date, 
					created_by, 
					created_date, 
					updated_by, 
					updated_date) 
				VALUES (
					'$type_id', 
					'$device_code', 
					'$device_brand', 
					'$device_model', 
					'$device_serial', 
					'$device_color', 
					'$device_description', 
					'$device_photo', 
					'$device_status', 
					'$location_id', 
					'$device_m2', 
					'$device_mx2',
					'$device_kg',
					'$device_kg1',
				    '$device_cek',
					'$device_mprod',
					'$device_deployment_date', 
					'$_SESSION[username]', 
					NOW(), 
					'$_SESSION[username]', 
					NOW())";
				$process = $this->db->query($query);
				// $notification = "|";
				// create log
				if ($process>0) {
					$this->sysClass->save_system_log($_SESSION['username'], $query);
				}
			}
			else {
				$process = 0;
				$_SESSION['new_type_id']         = $type_id;
				$_SESSION['new_dev_brand']       = $device_brand;
				$_SESSION['new_dev_model']       = $device_model;
				$_SESSION['new_dev_color']      =  $device_color;
				$_SESSION['new_dev_serial']      = $device_serial;
				$_SESSION['new_dev_description'] = $device_description;
				$_SESSION['new_dev_status']      = $dev_status;
				$_SESSION['new_location_id']     = $location_id;
				$_SESSION['new_m2']         = $device_m2;
				$_SESSION['new_mx2']         = $device_mx2;
				$_SESSION['new_kg']         = $device_kg;
				$_SESSION['new_kg1']         = $device_kg1;
				$_SESSION['new_cek']         = $device_cek;
				$_SESSION['new_mprod']         = $device_mprod;
				// $_SESSION['errors']           = $process_photo_upload;
			}
		}
		return $process.$notification;
	}

	/**
	* Edit device
	*
	* @param 	array 	$dt_device
	*
	*/
	public function edit_device($dt_device, $dt_photo){
		// var_dump($dt_device, $dt_photo);
		// Set var
		$location  = "./assets/images/device_photos/";
		$device_id          = $dt_device["dev_id"];
		$device_brand       = addslashes(trim($dt_device["dev_brand"]));
		$device_model       = addslashes(trim($dt_device["dev_model"]));
		$device_color       = addslashes(trim($dt_device["dev_color"]));
		$device_serial      = addslashes(trim($dt_device["dev_serial"]));
		$device_description = trim($dt_device["dev_description"]);
		$device_m2                 = $dt_device["dev_m2"];
		$device_mx2                = $dt_device["dev_mx2"];
		$device_kg                 = $dt_device["dev_kg"];
		//$device_kg1                = $dt_device["dev_kg1"];
		$device_cek                = $dt_device["dev_cek"];
		$device_mprod              = $dt_device["dev_mprod"];
		
		// Check if device exists
		$dev_check = count($this->show_device("","",$device_id));
		if ($dev_check>0) {
			// Get current values
			$dev_curr_value = $this->show_device("","",$device_id);
			foreach ($dev_curr_value as $data) {
				$c_device_brand       = $data["device_brand"];
				$c_device_model       = $data["device_model"];
				$c_device_color       = $data["device_color"];
				$c_device_serial      = $data["device_serial"];
				$c_device_description = $data["device_description"];
				$c_device_photo       = $data["device_photo"];
				$c_device_status      = $data["device_status"];
				$c_location_id        = $data["location_id"];
				$c_device_m2          = $data["m2"];
				$c_device_mx2         = $data["mx2"];
				$c_device_kg          = $data["kg"];
				$c_device_kg1         = $data["kg1"];
				$c_device_cek         = $data["cek"];
				$c_device_mprod       = $data["mprod"];
				//$c_device_keterangan        = $data["keterangan"];
				//$c_device_note        = $data["note"];
			}
			
			//$files_attach = explode(',', $c_device_photo);		
			
			foreach(explode(',', $c_device_photo) as $key=>$val){
				$value = explode('/', $val);
				$ext = explode('.', $value[4]);
				$ext = $ext[1];
				
				if($ext == 'png' || $ext == 'jpg' || $ext == 'gif'|| $ext == 'jpeg'){
					$old_files_attach['dev_photo'][] = $value[4];
				}else{
					$old_files_attach['dev_files'][] = $value[4];
				}		
				
				$old_files_for_filter[] = $value[4]; 
			}
			
			if(!empty($dt_device['deleted'])){
				foreach($dt_device['deleted'] as $val){
					// $check_image = getimagesize($val);
					$thumbnail_file = explode('.', $val);
					if($thumbnail_file[1] == 'jpg' || $thumbnail_file[1] == 'gif' || $thumbnail_file[1] == 'png'){
						$thumbnail_file = $thumbnail_file[0].'_thumbnail.'.$thumbnail_file[1];					
						// var_dump($thumbnail_file);
						unlink('./assets/images/device_photos/'.$thumbnail_file);
					}
					unlink('./assets/images/device_photos/'.$val);
				}
			}
			
			// var_dump($old_files_attach, $new_files_attach, $old_files_for_filter);
			// die;
			// Changes check
			$changes ='';
			if ($device_brand!=$c_device_brand) {
				$changes .= "Dev brand : $c_device_brand -> $device_brand. ";
			}
			if ($device_model!=$c_device_model) {
				$changes .= "Dev model : $c_device_model -> $device_model. ";
			}
			if ($device_color!=$c_device_color) {
				$changes .= "Dev color : $c_device_color -> $device_color. ";
			}
			if ($device_serial!=$c_device_serial) {
				$changes .= "Dev serial : $c_device_serial -> $device_serial. ";
			}
			if ($device_description!=$c_device_description) {
				$changes .= "Dev description : $c_device_description -> $device_description. ";
			}
			if ($device_m2!=$c_device_m2) {
				$changes .= "Dev m2 : $c_device_m2 -> $device_m2. ";
			}
			if ($device_mx2!=$c_device_mx2) {
				$changes .= "Dev mx x 2 : $c_device_mx2 -> $device_mx2. ";
			}
			if ($device_kg!=$c_device_kg) {
				$changes .= "Dev kg id : $c_device_kg -> $device_kg. ";
			}
			if ($device_cek!=$c_device_cek) {
				$changes .= "Dev cek : $c_device_cek -> $device_cek. ";
			}
			if ($device_mprod!=$c_device_mprod) {
				$changes .= "Dev mprod: $c_device_mprod -> $device_mprod. ";
			}	
			
			// Insert to device changes
			$query_changes = "INSERT INTO device_changes (device_id, changes, updated_by, updated_date) 
								VALUES ('$device_id', '".addslashes($changes)."', '$_SESSION[username]', NOW())";
			$changes_process = $this->db->query($query_changes);

			// Edit process
			// Init var
			$save_count   = 0;
			$error_count  = 0;
			$notification = "";
			$photo_name_text = array();
			
			if($dt_photo['dev_photo']['error'][0] == 0){
				// var_dump('p');
				
				//file foto
				if(!empty($dt_photo['dev_photo'])){
					foreach($dt_photo['dev_photo'] as $key=>$val){
						$i = 0;	
						foreach($val as $v){
							$photo_files[$i][$key] = $v;               		
							$i++;
						}
					}
					$i=1;
					$dev_photo_idx = count($old_files_attach['dev_photo']);
					$dev_photo_idx++;
					foreach($photo_files as $key=>$val){
						
						// Set var
						$location  = "./assets/images/device_photos/";
						$file_name = $val['name'];
						$file_size = $val['size'];
						$file_tmp  = $val['tmp_name'];
						$file_type = $val['type'];
						
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
									$errors[] = "<br>Extension not allowed, please use png, jpg or gif file.";
								}

								// Verify size
								if($file_size > 2097152){
									$errors[]="<br>File size must be less than 2 MB.";
								}

								// Set new name
								$new_photo_name = 'img_'.$device_serial."_".$dev_photo_idx.".".$file_ext;
								$photo_name_text[] = $location.'img_'.$device_serial."_".$dev_photo_idx.".".$file_ext;
								// Upload file process
								if(empty($errors)==true){
									// Upload
									move_uploaded_file($file_tmp, $location.$new_photo_name);
									// Create thumb
									$this->inventory->create_thumbnail($location.$new_photo_name, $location.'img_'.$device_serial."_".$dev_photo_idx."_thumbnail.".$file_ext, "200", "150");
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
							$new_photo_name = "standard_device.jpg";
							// nomor asal :P
							$save_count = $save_count+5;
						}

						// If error_count == 0 > SUCCESS!
						if ($error_count==0 && $notification=="" && $save_count>0) {
							$notification .= "<br>Photo Uploaded successfully!";
						}
						$i++;				
					}					
				}
			}else{
				$process_photo_upload = $save_count;
			}
			
			if($dt_photo['dev_files']['error'][0] == 0){
				// var_dump('f');
				//file lain
				if(!empty($dt_photo['dev_files'])){
					foreach($dt_photo['dev_files'] as $key=>$val){
						$i = 0;	
						foreach($val as $v){
							$files[$i][$key] = $v;               		
							$i++;
						}
					}
					$i=1;
					$dev_file_idx = count($old_files_attach['dev_files']);
					$dev_file_idx++;
					foreach($files as $key=>$val){
						// Set var
						$location  = "./assets/images/device_photos/";
						$file_name = $val['name'];
						$file_size = $val['size'];
						$file_tmp  = $val['tmp_name'];
						$file_type = $val['type'];
						// If file name isn't empty
						if ($file_name!="") {
							// Check if file is the real image
							// $check_image = getimagesize($file_tmp);
							if($check_image !== false) {
								// Verify extension
								$extensions = array("doc", "docx", "xls", "xlsx", "pdf");
								$file_ext   = explode('.',$file_name);
								$file_ext   = strtolower(end($file_ext));
								if(in_array($file_ext,$extensions ) === false){
									$errors[] = "<br>Extension not allowed, please use png, jpg or gif file.";
								}

								// Verify size
								if($file_size > 2097152){
									$errors[]="<br>File size must be less than 2 MB.";
								}

								// Set new name
								$new_photo_name = 'file_'.$device_serial."_".$dev_file_idx.".".$file_ext;
								$photo_name_text[] = $location.'file_'.$device_serial."_".$dev_file_idx.".".$file_ext;
								// Upload file process
								if(empty($errors)==true){
									// Upload
									move_uploaded_file($file_tmp, $location.$new_photo_name);
									// Create thumb
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
							$dev_file_idx++;
						}
						else {
							$new_photo_name = "standard_device.jpg";
							// nomor asal :P
							$save_count = $save_count+5;
						}

						// If error_count == 0 > SUCCESS!
						if ($error_count==0 && $notification=="" && $save_count>0) {
							$notification .= "<br>Photo Uploaded successfully!";
						}
						$i++;				
					}

					
				}
				
				if(!empty($photo_name_text)){
					$device_photo = "";
					foreach($photo_name_text as $val){
						$device_photo .= $val .','; 
						
					}
					$device_photo = rtrim($device_photo,',');	
				}
				$process_photo_upload = $save_count;
			}else{
				$process_photo_upload = $save_count;
			}
			
			
			
			
			$query_photo = '';
			if(!empty($dt_device['dev_photo'])){
				foreach($dt_device['dev_photo'] as $val){
					$photo_name_text[] = $location.$val;
				}
			}
			if(!empty($dt_device['dev_files'])){
				foreach($dt_device['dev_files'] as $val){
					$photo_name_text[] = $location.$val;
				}
			}
			if(!empty($photo_name_text)){
				$device_photo = "";
				foreach($photo_name_text as $val){
					$device_photo .= $val .','; 
					
				}
				$device_photo = rtrim($device_photo,',');	
			}
			
			// var_dump($photo_name_text, $device_photo);
			// die;
			
			
			if(!empty($dt_device['dev_photo'])){
				$location  = "./assets/images/device_photos/";
				
			}
			
			if(!empty($dt_device['dev_files'])){
				$location  = "./assets/images/device_photos/";
			}
			// if photo name empty
			// if ($new_photo_name!="") {
				// $process_photo_upload = $save_count;
				// $device_photo         = $location.$new_photo_name;
				// $query_photo          = "device_photo = '$device_photo', ";
			// }
			// empty (dont update photo)
			// else {
				// $process_photo_upload = "1";
				// $query_photo          = "";
				// If serial changes, update photo name in db, change photo name file
				// if ($c_device_photo!="./assets/images/device_photos/standard_device.jpg" && $c_device_serial!=$device_serial) {
					// $device_photo = str_replace($c_device_serial, $device_serial, $c_device_photo);
					// $query_photo  = "device_photo = '$device_photo', ";

					// photo name
					// rename($c_device_photo, $device_photo);

					// thumbnail name
					// $newnames    = explode(".", strrev($device_photo), 2);
					// $newname_ext = strrev($newnames[0]);
					// $newname     = strrev($newnames[1])."_thumbnail.".$newname_ext;
					// $thumbnails  = explode(".", strrev($c_device_photo), 2);
					// $thumb_ext   = strrev($thumbnails[0]);
					// $thumb_name  = strrev($thumbnails[1]);
					// $thumb_name  = rename($thumb_name."_thumbnail.".$thumb_ext, $newname);
				// }
			// }
			

			// if photo upload success //EDITED By BIMA
			if ($process_photo_upload>=0) {
				// Update database & create notification
				$query = "UPDATE device_list 
							SET 
							device_brand = '$device_brand', 
							device_model = '$device_model', 
							device_color = '$device_color', 
							device_serial = '$device_serial', 
							device_description = '$device_description', 
							device_photo = '$device_photo',
							device_deployment_date = NOW(), 
							updated_by = '$_SESSION[username]', 
							updated_date = NOW(), 
							revision = revision+1,
							m2 = '$device_m2', 
							mx2 = '$device_m2', 
							kg = '$device_kg',  
							cek = '$device_cek',
							mprod = '$device_mprod'
							WHERE device_id = '$device_id' ";
				$process = $this->db->query($query);
				// create log
				if ($process>0) {
					$this->sysClass->save_system_log($_SESSION['username'], $query);
				}
			}
			else {
				$process = 0;
				$_SESSION['new_dev_brand']       = $device_brand;
				$_SESSION['new_dev_model']       = $device_model;
				$_SESSION['new_dev_color']       = $device_color;
				$_SESSION['new_dev_serial']      = $device_serial;
				$_SESSION['new_dev_description'] = $device_description;
				$_SESSION['new_dev_status']      = $dev_status;
				$_SESSION['new_location_id']     = $location_id;
				$_SESSION['new_dev_m2']         = $device_m2;
				$_SESSION['new_dev_mx2']         = $device_mx2;
				$_SESSION['new_dev_kg']         = $device_kg;
				$_SESSION['new_dev_kg1']         = $device_kg1;
				$_SESSION['new_dev_cek']         = $device_cek;
				$_SESSION['new_mprod']         = $device_mprod;
			}

		}
		else {
			$process      = 0;
			$notification = "No Device Found!";
		}

		return $process.$notification;
	}
	


	/**
	* Select device for report
	* 
	* @param 	string 	$type
	* @param 	string 	$criteria
	* @param 	string 	$device_id
	* @return 	array 	$process
	* 
	*/
	public function show_device_report($type="", $criteria="")
	{
		$query = "SELECT 
					a.*, 
					b.`type_name`, 
					c.`location_name`,
					d.`place_id`, 
					d.`building_id`, 
					d.`floor_id`,  
					lp.`place_name`,  
					lb.`building_name`,  
					lf.`floor_name`  
				FROM device_list a 
				INNER JOIN device_type b ON a.`type_id` = b.`type_id` 
				LEFT JOIN location c ON a.`location_id` = c.`location_id` 
				LEFT JOIN location_details d ON c.`location_id` = d.`location_id` 
				LEFT JOIN location_place lp ON d.`place_id` = lp.`place_id`  
				LEFT JOIN location_building lb ON d.`building_id` = lb.`building_id`  
				LEFT JOIN location_floor lf ON d.`floor_id` = lf.`floor_id`";
				
		if ($criteria!="") {
			$query .= "WHERE $type IN ($criteria)"; 
		}

		$query .= "ORDER BY $type ASC";

		$process = $this->db->query($query);
		return $process;
	}
}
?>