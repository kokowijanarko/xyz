<?php
/**
* Location Class
* Location management class such as location list, add new location, edit and set active location
*
* @author 		Noerman Agustiyan
* @version 		0.1
*/
	
require_once(__DIR__ . '/../lib/db.class.php');
require_once(__DIR__ . '/../class/inventory.class.php');
require_once(__DIR__ . '/../class/system.class.php');

class LocationClass
{

	/**
	* Construct
	* 
	*/
	public function __construct() {
		$this->db        = new DB();
		$this->inventory = new inventory();
		$this->sysClass  = new SystemClass();

		$this->location_details_addon = $this->inventory->setting_data("location_details");
	}



	/**
	* Show Existing Locations
	*
	* @param 	string 	$location_name
	* @return 	array 	$result
	*
	*/
	public function show_location($location_name="")
	{
		// if location_details in settings enabled
		// Left join all the details
		if ($this->location_details_addon == "enable") {
			$query = "SELECT 
			 l.location_id, 
			 l.location_name,
			 l.location_photo, 
			 l.active, 
			 lp.place_id,
			 lp.place_name,
			 lb.building_id, 
			 lb.building_name,
			 lf.floor_id,
			 lf.floor_name 
			FROM location l 
			LEFT JOIN location_details ld ON l.location_id = ld.location_id AND ld.active='yes' 
			LEFT JOIN location_place lp ON ld.place_id = lp.place_id 
			LEFT JOIN location_building lb ON ld.building_id = lb.building_id 
			LEFT JOIN location_floor lf ON ld.floor_id = lf.floor_id 
			";
		}
		// else, fetch the location only
		else {
			$query = "SELECT 
			 l.location_id, 
			 l.location_name,
			 l.location_photo, 
			 l.active
			FROM location l 
			";
		}

		// If location_name set
		if ($location_name!="") {
			$query .= " WHERE l.location_name = '$location_name' ";
		}

		$query .= " ORDER BY l.location_name ASC ";

		$result = $this->db->query($query);
		return $result;
	}



	/**
	* Add location
	* 
	* @param 	array 	$dt_location
	* @return 	string 	$process
	* 
	*/
	public function add_location($dt_location)
	{
		// Set var location
		$location_name = addslashes($dt_location["location_name"]);
		$active        = $dt_location["active"];

		// Check if device exists
		$type_check = count($this->show_location($location_name));
		if ($type_check>0) {
			// Send back with notification
			$process = 0;
			$notification = "|<br>Location is already exists in the database!";
		}
		else {
			// location
			// Insert to database & create notification
			$query   = "INSERT INTO location (location_name, active, created_by, created_date, updated_by, updated_date) 
						VALUES ('$location_name', '$active', '$_SESSION[username]', NOW(), '$_SESSION[username]', NOW()) ";
			$process = $this->db->query($query);

			// Get last insert id  from location table as FK in location_details 
			$location_id = $this->db->lastInsertId();

			// If location_details enable, insert location_details
			if ($this->location_details_addon=="enable") {
				$query = "INSERT INTO location_details 
							VALUES ('', '$location_id', '$dt_location[location_place]', '$dt_location[location_building]', '$dt_location[location_floor]', 'yes',  '$_SESSION[username]', NOW(), '$_SESSION[username]', NOW(), '0')";
				$this->db->query($query);
			}

			$notification = "|";
			// create log
			if ($process>0) {
				$this->sysClass->save_system_log($_SESSION['username'], $query);
			}
		}

		return $process.$notification;
	}



	/**
	* Edit location
	*
	* @param 	array 	$dt_location
	* @return 	string 	$process
	*
	*/
	public function edit_location($dt_location)
	{
		// assign variable
		$location_id   = $dt_location["location_id"];
		$location_name = $dt_location["location_name"];
		$active        = $dt_location["active"];

		// create query
		$query = "UPDATE location SET 
					location_name = '$location_name', 
					active = '$active', 
					updated_by = '$_SESSION[username]', 
					updated_date = NOW(), 
					revision = revision+1 
					WHERE location_id = '$location_id' ";

		// add to database
		$process = $this->db->query($query);

		// create system log
		if ($process>0) {
			$this->sysClass->save_system_log($_SESSION['username'], $query);
		}

		// if location_details enable
		if ($this->location_details_addon=="enable") {
			// location_details check
			// If data exists, update.
			if (count($this->show_location_details($location_id))>0) {
				// get detail_id 
				foreach ($this->show_location_details($location_id) as $datas) {
					$detail_id = $datas["detail_id"];
				}
				$query = "UPDATE location_details SET 
							place_id = '$dt_location[location_place]', 
							building_id = '$dt_location[location_building]', 
							floor_id = '$dt_location[location_floor]',
							updated_by = '$_SESSION[username]', 
							updated_date = NOW(), 
							revision = revision+1 WHERE detail_id = '$detail_id'";
			}
			// else, insert
			else {
				$query = "INSERT INTO location_details 
							VALUES ('', '$location_id', '$dt_location[location_place]', '$dt_location[location_building]', '$dt_location[location_floor]', 'yes',  '$_SESSION[username]', NOW(), '$_SESSION[username]', NOW(), '0')";
			}
			// RUN
			$this->db->query($query);

			// system log
			$this->sysClass->save_system_log($_SESSION['username'], $query);
		}

		return $process;
	}



	/**
	* Change location status
	*
	* @param 	array 	$dt_location
	* @return 	string 	$process
	*
	*/
	public function location_change_status($dt_location)
	{
		// assign variable
		$location_id   = $dt_location["location_id"];
		$location_name = $dt_location["location_name"];
		$status        = $dt_location["status"];

		// create query
		$query   = "UPDATE location SET active='$status', updated_by='$_SESSION[username]', updated_date=NOW(), revision=revision+1 WHERE location_id='$location_id'";

		// edit to database
		$process = $this->db->query($query);

		// create system log
		if ($process>0) {
			$this->sysClass->save_system_log($_SESSION['username'], $query);
		}

		return $process;
	}


	/**
	*	Location details
	*
	*/


	/**
	* Location Add on
	* Check if location detail exists
	* 
	* @param 	string 	$location_id
	* @return 	array 	$location_details
	* 
	*/
	public function show_location_details($location_id)
	{
		$query = "SELECT 
			 ld.detail_id, 
			 ld.location_id, 
			 ld.place_id,
			 ld.building_id, 
			 ld.floor_id,
			 ld.active
			FROM location_details ld 
			WHERE location_id = '$location_id' AND active = 'yes' ";
		$location_details = $this->db->query($query);
		return $location_details;
	}



	/**
	*	Location Add on
	*	Location detail based on type
	*	
	*	@param 	string 	$type
	*	@param 	string 	$name
	* 	@param 	array 	$result
	*	
	*/
	public function show_location_detail_by_type($type, $name="")
	{
		$table_name = "location_".$type;
		$field_name = $type."_name";
		if ($name!="") {
			$query  = "SELECT * FROM $table_name WHERE $field_name = '$name'";
		} else {
			$query  = "SELECT * FROM $table_name ORDER BY $field_name ASC";
		}
		$result = $this->db->query($query);
		return $result;
	}



	/**
	* Add location details
	* 
	* @param 	array 	$dt_location
	* @return 	string 	$process
	* 
	*/
	public function add_location_details($dt_location)
	{
		// Set var
		$type        = $dt_location["location_detail_type"];
		$detail_name = addslashes($dt_location["location_detail_name"]);
		$active      = $dt_location["active"];

		// Check if location details exists
		$ld_check = count($this->show_location_detail_by_type($type, $detail_name));
		if ($ld_check>0) {
			// Send back with notification
			$process = 0;
			$notification = "|<br>Location Details <strong>'$detail_name'</strong> is already exists in the database!";
		}
		else {
			// location
			// Insert to database & create notification
			$table_name = "location_".$type;
			$query   = "INSERT INTO $table_name (".$type."_name, active, created_by, created_date, updated_by, updated_date) 
						VALUES ('$detail_name', '$active', '$_SESSION[username]', NOW(), '$_SESSION[username]', NOW()) ";
			$process = $this->db->query($query);

			$notification = "|";
			// create log
			if ($process>0) {
				$this->sysClass->save_system_log($_SESSION['username'], $query);
			}
		}
		// return
		return $process.$notification;
	}



	/**
	* Change location detail status
	*
	* @param 	array 	$details
	* @return 	string 	$process
	*
	*/
	public function location_detail_change_status($details)
	{
		// assign variable
		$location_detail_type = $details["location_detail_type"];
		$location_detail_id   = $details["location_detail_id"];
		$status               = $details["status"];
		$table_name           = "location_".$location_detail_type;
		$field_name           = $location_detail_type."_id";

		// create query
		$query   = "UPDATE $table_name SET active='$status', updated_by='$_SESSION[username]', updated_date=NOW(), revision=revision+1 WHERE $field_name='$location_detail_id'";

		// edit to database
		$process = $this->db->query($query);

		// create system log
		if ($process>0) {
			$this->sysClass->save_system_log($_SESSION['username'], $query);
		}

		return $process;
	}



	/**
	* Edit location details
	* 
	* @param 	array 	$dt_location
	* @return 	string 	$process
	* 
	*/
	public function edit_location_details($dt_location)
	{
		// Set var
		$location_detail_type = $dt_location["location_detail_type"];
		$location_detail_id   = $dt_location["location_detail_id"];
		$location_detail_name = $dt_location["location_detail_name"];
		$active               = $dt_location["active"];

		// Update database & create notification
		$table_name  = "location_".$location_detail_type;
		$detail_name = $location_detail_type."_name";
		$detail_id   = $location_detail_type."_id";

		$query   = "UPDATE $table_name SET 
					$detail_name = '$location_detail_name', 
					active = '$active', 
					updated_by = '$_SESSION[username]', 
					updated_date = NOW(), 
					revision = revision+1 
					WHERE $detail_id = '$location_detail_id' ";
		$process = $this->db->query($query);

		$notification = "|";
		// create log
		if ($process>0) {
			$this->sysClass->save_system_log($_SESSION['username'], $query);
		}

		// return
		return $process.$notification;
	}



}

?>