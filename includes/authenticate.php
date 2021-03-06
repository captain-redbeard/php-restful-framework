<?php
/**
 *
 * Details:
 * This is an example authentication method, it should be updated to 
 * use your own methods.
 * 
 * Modified: 25-Nov-2016
 * Made Date: 19-Nov-2016
 * Author: Hosvir
 * 
 * */
  
/**
 * 
 * Example authenticate method.
 * 
 * Replace with your own method.
 * 
 * */
function authenticate($PARAMS = null, $authenticate) { 
	//Varaibles
	$authkey = null;
	$loginresult;

	//Get parameters
	if(isset($PARAMS['authkey'])) $authkey = clean_input($PARAMS['authkey']);
	if(isset($authenticate)) $authkey = clean_input($authenticate);

	//Check for variables
	if($authkey == null) {
		return array(
					"status" => ERRORSTATUS, 
					"code" => 401, 
					"message" => "Missing parameters. Expected {authkey}"
					);
	}

	// ========== REAPLCE ME ==========
	//Check authentication details
	//Set loginresult varaible
	$loginresult = true;
	// ================================

	//Result
	if($loginresult) {
		return array(
					"status" => SUCCESSSTATUS, 
					"code" => 200, 
					"message" => "Authentication.", 
					"results" => array("authenticate" => $loginresult)
					);
	}else{
		return array(
					"status" => ERRORSTATUS, 
					"code" => 401, 
					"message" => "Authentication failed.", 
					"results" => array("authenticate" => $loginresult)
					);
	}
}

?>
