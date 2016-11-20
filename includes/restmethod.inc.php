<?php
/**
 * 
 * Details:
 * This abstract class should be extended from your method.
 * 
 * Modified: 20-Nov-2016
 * Made Date: 19-Nov-2016
 * Author: Hosvir
 * 
 * */
 
require("./includes/methodinterface.inc.php");

abstract class restMethod implements methodInterface {
	public $allowedMethods = "";
	
	/**
	 * 
	 * Check if the specified method is allowed.
	 * 
	 * @param: request method
	 * 
	 * @returns: boolean
	 * 
	 * */
	public function allowedMethod($method) {
		$allowed = explode(",", $this->allowedMethods);
		
		foreach($allowed as $m) {
			if($m == $method) return true;
		}
		
		return false;
	}
	
	/**
	 * 
	 * Options method.
	 * 
	 * @returns: allowed request methods.
	 * 
	 * */
	public function options() {
		header("Allow: " . $this->allowedMethods);
	}
		
}

?>
