<?php
/**
 *
 * Details:
 * This is an example method showing the requirements for all methods.
 * 
 * Modified: 20-Nov-2016
 * Made Date: 19-Nov-2016
 * Author: Hosvir
 * 
 * 
 * 
 * 
 * PDO wrapper example for database access.
 * 
 *  - static access
 *  - all variables are passed through the array which 
 *      automatically works out the data type.
 *  - query, variables, mysqli connection
 * 
	 
 $examples = QB::select("SELECT name, type, size, file 
		 
							FROM files 
								
							WHERE status = ? 
							AND cancelled = ? 
								
								
							ORDER BY name 
							LIMIT 10;", 
								
							array("example",0), 
							
							$mysqli);
 * 
 * 
 * 
 * */
require("./includes/restmethod.inc.php");

class method extends restMethod {
	
	/**
	 * 
	 * Construct the method specifying allowed HTTP methods.
	 * */
	function __construct() {
		$this->allowedMethods = "GET,PUT,POST,DELETE,OPTIONS,HEAD";
	}
	
	/**
	 * 
	 * Check if this method requires authentication.
	 * 
	 * @returns: boolean
	 * 
	 * */
	public function requiresAuthentication() {
		return true;
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
		//Folder location
		$directory = "./examplefiles/";
		$files = scandir($directory);
		$filearray = array();
		
		foreach($files as $file) {
			if($file != "." && $file != "..") {
				array_push($filearray, array(
											"name" => $file,
											"type" => pathinfo($directory . $file, PATHINFO_EXTENSION),
											"size" => filesize($directory . $file),
											"modified" => filemtime($directory . $file), 
											"file" => file_get_contents($directory . $file)
											)
				);
			}
		}
		
		//Fill results
		$examples = array("files" => $filearray);
		
		return array(
					"status" => SUCCESSSTATUS, 
					"code" => 0, 
					"message" => "Retrieved example.", 
					"results" => $examples
					);
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
		//Folder location
		$directory = "./examplefiles/";
		$result = "";
		
		//Get parameters
		if(isset($PARAMS['name'])) $name = clean_input($PARAMS['name']);
		if(isset($PARAMS['extension'])) $extension = clean_input($PARAMS['extension']);
		if(isset($PARAMS['file'])) $file = $PARAMS['file'];
		
		//Check that parameters are set
		if(isset($name) && isset($extension) && isset($file)) {
			
			//Check if the file exists, if so perform update
			if(file_exists($directory . $name . "." . $extension)) {
				$modifiedStart = filemtime($directory . $name . "." . $extension);
				$exfile = fopen($directory . $name . "." . $extension, "w");
				fwrite($exfile, $file);
				fclose($exfile);
				$modifiedEnd = filemtime($directory . $name . "." . $extension);
				
				//Check if the modified date has changed
				if($modifiedStart == $modifiedEnd) {
					$result = array(
								"status" => SUCCESSSTATUS, 
								"code" => 0, 
								"message" => "Updated file.", 
								"results" => $modifiedEnd
								);
				}else{
					$result = array(
								"status" => ERRORSTATUS, 
								"code" => 1102, 
								"message" => "Failed to update file."
								);
				}
			}else { //Otherwise new file
				$exfile = fopen($directory . $name . "." . $extension, "w");
				fwrite($exfile, $file);
				fclose($exfile);
				
				$result = array(
								"status" => SUCCESSSTATUS, 
								"code" => 0, 
								"message" => "Created file."
								);
			}
		}else{
			$result = array(
							"status" => ERRORSTATUS, 
							"code" => 1101, 
							"message" => "Missing parameters, expected {name, extension, file}"
							);
		}
		
		return $result;
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
		//Folder location
		$directory = "./examplefiles/";
		$result = "";
		
		//Get parameters
		if(isset($PARAMS['name'])) $name = clean_input($PARAMS['name']);
		if(isset($PARAMS['extension'])) $extension = clean_input($PARAMS['extension']);
		if(isset($PARAMS['file'])) $file = $PARAMS['file'];
		
		//Check that parameters are set
		if(isset($name) && isset($extension) && isset($file)) {
			$rstring = generateRandomString(6);
			$exfile = fopen($directory . $name . "-" . $rstring . "." . $extension, "w");
			fwrite($exfile, $file);
			fclose($exfile);
				
			$result = array(
							"status" => SUCCESSSTATUS, 
							"code" => 0, 
							"message" => "Created file.", 
							"results" => $name . "-" . $rstring . "." . $extension
							);
		}else{
			$result = array(
							"status" => ERRORSTATUS, 
							"code" => 1101, 
							"message" => "Missing parameters, expected {name, extension, file}"
							);
		}
		
		return $result;
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
		//Folder location
		$directory = "./examplefiles/";
		$result = "";
		
		//Get parameters
		if(isset($PARAMS['name'])) $name = clean_input($PARAMS['name']);
		if(isset($PARAMS['extension'])) $extension = clean_input($PARAMS['extension']);
		
		//Check that parameters are set
		if(isset($name) && isset($extension)) {
			$deleted = unlink($directory . $name . "." . $extension);
				
			$result = array(
							"status" => SUCCESSSTATUS, 
							"code" => 0, 
							"message" => "Deleted file.", 
							"results" => $deleted
							);
		}else{
			$result = array(
							"status" => ERRORSTATUS, 
							"code" => 1101, 
							"message" => "Missing parameters, expected {name, extension}"
							);
		}
		
		return $result;
	}
	
}
?>
