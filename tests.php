<?php
/**
 * 
 * Details:
 * Run tests on our examples.
 * 
 * Modified: 20-Nov-2016
 * Made Date: 19-Nov-2016
 * Author: Hosvir
 * 
 * */
header('Content-type: text/HTML; charset=UTF-8');

/**
 * 
 * Example curl function.
 * 
 */
function curl($path, $data, $method, $headers = FALSE, $customheader = null) {
	$cheaders = null;
	
    $url = $path;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    
	if($method == "HEAD") {
		curl_setopt($ch, CURLOPT_NOBODY, TRUE);
	}else{
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
	}
    
	if($data != null) {
		$data_string = json_encode($data);		
		curl_setopt($ch, CURLOPT_POST, count($data));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(   
			'Content-Length: ' . strlen($data_string),                                                                          
			'Content-Type: application/json; charset=UTF-8')                                                                    
		);
	}

	if($customheader != null) {
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($customheader));
	}

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_VERBOSE, $headers);
	curl_setopt($ch, CURLOPT_HEADER, $headers);
	curl_setopt($ch, CURLINFO_HEADER_OUT, $headers);
	curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate");
	
    $result = curl_exec($ch);
    
    if($headers) {
		$request = curl_getinfo($ch, CURLINFO_HEADER_OUT);
		echo $request;
	}

    curl_close($ch);

    return $result;
}

function contains($contains, $container) {
    return strpos(strtolower($container), strtolower($contains)) !== false;
}

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    
    for($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $randomString;
}


//Request methods
$verbs = "OPTIONS,HEAD,GET,PUT,POST,DELETE";
$page = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
$page = str_replace("tests.php", "", $page);

//exampletwo requires authentication
$methods = "example,exampletwo";

//For each request method
foreach(explode(",", $methods) as $method) {
	//Echo results
	echo "<h2>$method tests.</h2>";
	echo "<hr>";

	foreach(explode(",", $verbs) as $verb) {
		//Switch request methods to get data
		switch($verb) {
			case "PUT":
				$data = array("name" => "Example", "extension" => "txt", "file" => "Updated text: " . generateRandomString(rand(8,128)));
				break;
			case "POST":
				$data = array("name" => "Example", "extension" => "txt", "file" => "New file content: " . generateRandomString(rand(8,128)));
				break;
			case "DELETE":
				$deletefile = "";
				foreach(scandir("./examplefiles/") as $file) {
					if(contains("Example-", $file)) {
						$deletefile = $file;
						if(rand(0,2) == 1) break;
					}
				}
				
				$data = array("name" => str_replace(".txt", "", $deletefile), "extension" => "txt");
				break;
			default:
				$data = null;
				break;
		}
		
		//Check for AUTH method
		$customheader = $method == "exampletwo" ? 'Authenticate: abc' : null;
		
		echo "<strong>$verb:</strong><br/>";
		echo "<pre>";
		print_r(curl($page . $method, $data, $verb, true, $customheader));
		echo "</pre>";
		echo "<hr>";
	}
}

/**
 * 
 * Real world usage.
 * 
 * $result = json_decode(curl("https://yoururl.com/api/methodname", array("email" => "example@test.com"), "GET", false), true);
 * 
 * - Access the json values like a normal array.
 *  - e.g $result['first_name']
 **/
?>
