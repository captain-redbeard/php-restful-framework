<?php
/**
 * 
 * Details:
 * Small collection of helpful functions.
 * 
 * Modified: 09-Sep-2015
 * Made Date: 09-Sep-2015
 * Author: Hosvir
 * 
 * */

/**
 * 
 * Convert the time to the specified timezone.
 * 
 * */
function convert_time($timeConvert){
	$userTime = new DateTime($timeConvert, new DateTimeZone(TIMEZONE));
	$userTime->setTimezone(new DateTimeZone($_SESSION['timezone']));
	return $userTime->format('Y-m-d h:i:s A');
}

/**
 * 
 * Check if one string contains another.
 * 
 * */
function contains($contains, $container) {
    return strpos(strtolower($container), strtolower($contains)) !== false;
}

/**
 * 
 * Check if the string is contained in the array.
 * 
 * */
function arrayContains($contains, &$container) {
	foreach($container as $key => $val){
		if(contains($contains, $val)) return true;
	}
	
	return false;
}

/**
 * 
 * Clean the passed input to remove any unwanted characters.
 * 
 * */
function clean_input($input){
	$clean = strip_tags($input);
	$clean = preg_replace('/[^a-zA-Z0-9 \-]/i',' ', $clean);
	return $clean;
}

/**
 * 
 * Backspace last character.
 * 
 * */
function backspace($string){
	return substr($string, 0, -1);
}

/**
 * 
 * Truncate the string to the specified length.
 * 
 * */
function truncateString($str, $len) {
	if(strlen($str) > $len)
		$str = substr($str, 0, $len) . "..";
		
	return $str;
}

/**
 * 
 * Generate a random string.
 * 
 * */
function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    
    for($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $randomString;
}
?>
