<?php
require("./includes/restmethod.inc.php");

class method extends restMethod {
	
	/**
	 * 
	 * Construct the method specifying allowed HTTP methods.
	 * 
	 * List:
	 * GET, PUT, POST, DELETE, OPTIONS, HEAD
	 * 
	 * */
	function __construct() {
		$this->allowedMethods = "GET,PUT,POST,DELETE,OPTIONS,HEAD";
	}
	
	/**
	 * 
	 * Check if this method requires authentication.
	 * 
	 * @returns: boolean
	 * */
	public function requiresAuthentication() {
		return false;
	}	
	
	/**
	 * 
	 * Get method.
	 * 
	 * @param: $PARAMS - parameters
	 * @param: $mysqli - mysqli connection
	 * 
	 * @returns: result array.
	 * 
	 * */
	public function get($PARAMS = null, $mysqli = null) {
		
	}
	
	/**
	 * 
	 * Put method.
	 * 
	 * Details:
	 * Insert new record if it does not already exist, otherwise 
	 * update existing record.
	 * 
	 * @param: $PARAMS - parameters
	 * @param: $mysqli - mysqli connection
	 * 
	 * @returns: result array.
	 * 
	 * */
	public function put($PARAMS = null, $mysqli = null) {
		
	}
	
	/**
	 * 
	 * Post method.
	 * 
	 * Details:
	 * Insert new record every time.
	 * 
	 * @param: $PARAMS - parameters
	 * @param: $mysqli - mysqli connection
	 * 
	 * @returns: result array.
	 * */
	public function post($PARAMS = null, $mysqli = null) {
		
	}
	
	/**
	 * 
	 * Delete method.
	 * 
	 * @param: $PARAMS - parameters
	 * @param: $mysqli - mysqli connection
	 * 
	 * @returns: result array.
	 * 
	 * */
	public function delete($PARAMS = null, $mysqli = null) {
		
	}
	
}
?>
