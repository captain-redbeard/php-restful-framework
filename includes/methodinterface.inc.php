<?php
/**
 * 
 * Details:
 * Method interface.
 * 
 * Modified: 20-Nov-2016
 * Made Date: 19-Nov-2016
 * Author: Hosvir
 * 
 * */
interface methodInterface {
	public function requiresAuthentication();
	
	public function allowedMethod($method);
	
	public function get($PARAMS = null, $mysqli = null);
	public function put($PARAMS = null, $mysqli = null);
	public function post($PARAMS = null, $mysqli = null);
	public function delete($PARAMS = null, $mysqli = null);
	public function options();
}

?>
