<?php
/**
 * 
 * Details:
 * RESTful web service using JSON.
 * 
 * Modified: 20-Nov-2016
 * Made Date: 19-Nov-2016
 * Author: Hosvir
 * 
 * */
include("./includes/config.inc.php");
include("./includes/core.inc.php");
if(USEDB){ 
	include("./includes/db.inc.php");
	include("./includes/querybuilder.inc.php");
}else{
	$mysqli = null;
}

date_default_timezone_set(TIMEZONE);
header('Content-type: application/json; charset=UTF-8');

$method = null;
$result = null;
$executemethod = false;
$noresult = false;
$requestmethod = $_SERVER['REQUEST_METHOD'];
if(USEGET && isset($_GET['method'])) $method = strtolower(clean_input($_GET['method']));
if(USEPOST && isset($_POST['method'])) $method = strtolower(clean_input($_POST['method']));
$PARAMS = json_decode(file_get_contents("php://input"), true);
$authenticate = null;

foreach(getallheaders() as $name => $value) {
	if(strtolower($name) == "authenticate") {
		$authenticate = $value;
		break;
	}
}

//For each request method
if($method != null) {

	//Check for method
	if(file_exists("./methods/" . $method . ".php")) {
		include_once("./methods/" . $method . ".php");
		$m = new method();
			
		//Check if requires authentication
		if($m->requiresAuthentication()) {
			include_once("./includes/authenticate.php");
			$auth = authenticate($PARAMS, $authenticate);

			//Check if authenticate succeeds
			if($auth['status'] != ERRORSTATUS && $auth['results']['authenticate']) {
				$executemethod = true;
			}else {
				http_response_code(401);
				$result = $auth;
			}
		}else{
			$executemethod = true;				
		}
			
		//Run the method
		if($executemethod) {
			if($m->allowedMethod($requestmethod)) {
				switch($requestmethod) {
					case "GET":
						$result = $m->get($PARAMS, $mysqli);
						break;
					case "PUT":
						$result = $m->put($PARAMS, $mysqli);
						break;
					case "POST":
						$result = $m->post($PARAMS, $mysqli);
						break;
					case "DELETE":
						$result = $m->delete($PARAMS, $mysqli);
						break;
					case "OPTIONS":
						$m->options($mysqli);
						$noresult = true;
						break;
					case "HEAD":
						$m->get($PARAMS, $mysqli);
						$noresult = true;
						break;
				}
			}else{
				http_response_code(403);
				$result = array(
								"status" => ERRORSTATUS, 
								"code" => 1003, 
								"message" => "Request Method not allowed: {" . $requestmethod . "}"
								);
			}
		}
	}
	
	//If no methods, default to error
	if(!$noresult && $result == null) {
		http_response_code(404);
		$result = array(
						"status" => ERRORSTATUS, 
						"code" => 1001, 
						"message" => "Unknown method. Expected {method}"
						);
	}
}

//Return the result
if($result != null) {
	if(SHOWREQUESTINFO) {
		$appendmethod = array(
							"method" => $method, 
							"verb" => $requestmethod
							);		
		$result = array_merge($result, $appendmethod);
	}
	
	if(SHOWSYSTEM) {
		$end = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
		$systeminfo = array("system" => array(
										"api_version" => APIVERSION,
										"execution_time" => $end
									  )
					);

		$result = array_merge($result, $systeminfo);
	}
		
	if(!$noresult) print_r(json_encode($result, JSON_PRETTY_PRINT));
}
?>
