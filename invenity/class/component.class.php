<?php
/**
* Component Class
* Manage component system
*
* @author Noerman Agustiyan
* @version 0.1
*/

require_once(__DIR__ . '/../lib/db.class.php');
require_once(__DIR__ . '/system.class.php');

class ComponentClass
{
	/**
	* Construct
	* 
	*/
	public function __construct() {
		$this->db       = new DB();
		$this->sysClass = new SystemClass();
	}


	/**
	* Show all components
	*
	* @return 	array 	$process
	*
	*/
	public function show_component()
	{
		$query   = "SELECT component_id, component_name, component_page, active FROM component WHERE component_type = 'standard'";
		$process = $this->db->query($query);
		return $process;
	}


	/**
	* Add new components
	*
	* @param 	array 	$dt_component
	* @return 	string 	$process
	*
	*/
	public function add_component($dt_component)
	{
		// assign variable
		$component_name = $dt_component["component_name"];
		$component_page = $dt_component["component_page"];
		$active         = $dt_component["active"];

		// check if data exists
		$query   = "SELECT component_id FROM component WHERE component_name = '$component_name' OR component_page = '$component_page'";
		$num_row = count($this->db->query($query));

		// if exists, process = 0
		if ($num_row>=1) {
			$process = 0;
		}
		// save process
		else {
			// create query
			$query   = "INSERT INTO component (component_name, component_page, component_type, active, created_by, created_date, updated_by, updated_date) VALUES ('$component_name', '$component_page', 'standard', '$active', '$_SESSION[username]', NOW(), '$_SESSION[username]', NOW())";

			// add to database
			$process = $this->db->query($query);

			// create system log
			if ($process>0) {
				$this->sysClass->save_system_log($_SESSION['username'], $query);
			}
		}

		return $process;
	}


	/**
	* Edit components
	*
	* @param 	array 	$dt_component
	* @return 	string 	$process
	*
	*/
	public function edit_component($dt_component)
	{
		// assign variable
		$component_id   = $dt_component["component_id"];
		$component_name = $dt_component["component_name"];
		$component_page = $dt_component["component_page"];
		$active         = $dt_component["active"];

		// create query
		$query = "UPDATE component SET component_name = '$component_name', component_page = '$component_page', active = '$active', updated_by = '$_SESSION[username]', updated_date = NOW(), revision = revision+1 WHERE component_id = '$component_id' ";

		// add to database
		$process = $this->db->query($query);

		// create system log
		if ($process>0) {
			$this->sysClass->save_system_log($_SESSION['username'], $query);
		}

		return $process;
	}



	/**
	* Change component status
	*
	* @param 	array 	$dt_component
	* @return 	string 	$process
	*
	*/
	public function component_change_status($dt_component)
	{
		// assign variable
		$component_id = $dt_component["component_id"];
		$active       = $dt_component["status"];

		// create query
		$query   = "UPDATE component SET active = '$active', updated_by = '$_SESSION[username]', updated_date = NOW(), revision = revision+1 WHERE component_id = '$component_id'";

		// add to database
		$process = $this->db->query($query);

		// create system log
		if ($process>0) {
			$this->sysClass->save_system_log($_SESSION['username'], $query);
		}

		return $process;
	}
}

?>