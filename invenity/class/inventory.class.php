<?php
/**
* Inventory Class
* All inventory system needs
*
* @author 		Noerman Agustiyan
* @version 		0.1
*/

require_once(__DIR__ . '/../lib/db.class.php');

class Inventory
{
	/**
	* Construct
	* 
	*/
	public function __construct() {
		$this->db = new DB();	
	}


	/**
	* Get Inventory System Setting Data
	*
	* @param 		string 	$setting_name
	* @return 		string 	$setting_value
	*/
	public function setting_data($setting_name)
	{
		$query         = "SELECT setting_value FROM system_settings WHERE setting_name = '$setting_name' AND active = 'yes'";
		$setting_value = $this->db->single($query);
		return $setting_value;
	}


	/**
	* Generate main menu based on component and privilege
	*
	* @param 		string 	$privilege
	* @return 		array 	$main_menu_array
	*/
	public function main_menu($privileges)
	{
		// Fetch component
		if ($privileges!="*") {
			$query = "SELECT component_id, component_name, component_page FROM component WHERE component_id IN ($privileges) AND active = 'yes' ORDER BY component_type DESC";
		}
		else {
			$query = "SELECT component_id, component_name, component_page FROM component WHERE active = 'yes' ORDER BY component_type DESC";
		}
		$main_menu_array = $this->db->query($query);

		// Return array result
		return $main_menu_array;
	}


	/**
	* Create image thumbnail
	*
	* @param 		string 	$source_image
	* @param 		string 	$destination_image_url
	* @param 		string 	$get_width
	* @param 		string 	$get_height
	* @return 		
	*
	*/
	public function create_thumbnail($source_image, $destination_image_url, $get_width, $get_height){
		// var_dump($source_image, $destination_image_url);
		ini_set('memory_limit','512M');
		set_time_limit(0);

		$image_array = explode('/',$source_image);
		$image_name  = $image_array[count($image_array)-1];
		$max_width   = $get_width;
		$max_height  = $get_height;
		$quality     = 100;

		//Set image ratio
		list($width, $height) = getimagesize($source_image);
		$ratio  = ($width > $height) ? $max_width/$width : $max_height/$height;
		$ratiow = $width/$max_width ;
		$ratioh = $height/$max_height;
		$ratio  = ($ratiow > $ratioh) ? $max_width/$width : $max_height/$height;

		if($width > $max_width || $height > $max_height) {
			$new_width  = $width * $ratio;
			$new_height = $height * $ratio;
		}
		else {
			$new_width  = $width;
			$new_height = $height;
		}

		if (preg_match("/.jpg/i","$source_image") or preg_match("/.jpeg/i","$source_image")) {
			//JPEG type thumbnail
			$image_p = imagecreatetruecolor($new_width, $new_height);
			$image   = imagecreatefromjpeg($source_image);
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			imagejpeg($image_p, $destination_image_url, $quality);
			imagedestroy($image_p);

		} elseif (preg_match("/.png/i", "$source_image")){
			//PNG type thumbnail
			$im      = imagecreatefrompng($source_image);
			$image_p = imagecreatetruecolor ($new_width, $new_height);
			imagealphablending($image_p, false);
			imagecopyresampled($image_p, $im, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			imagesavealpha($image_p, true);
			imagepng($image_p, $destination_image_url);

		} elseif (preg_match("/.gif/i", "$source_image")){
			//GIF type thumbnail
			$image_p = imagecreatetruecolor($new_width, $new_height);
			$image   = imagecreatefromgif($source_image);
			$bgc     = imagecolorallocate ($image_p, 255, 255, 255);
			imagefilledrectangle ($image_p, 0, 0, $new_width, $new_height, $bgc);
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			imagegif($image_p, $destination_image_url, $quality);
			imagedestroy($image_p);

		} else {
			echo 'unable to load image source';
			exit;
		}
	}


	/**
	*	
	*	
	*/


}
?>
