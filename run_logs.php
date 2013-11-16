<?php
/** NGinx Log Actions
*
*
* @copyright 2013 B Tasker, All Rights Reserved
* @license GNU GPL V2
*
* Process an NGinx Access log and call a domain specific handler for each
*
*/

$mydir = dirname(__FILE__);

require "${mydir}/config.php";

// Build the filename - later versions will allow this to be specified in argv
$filename = "$log_location/$log_name";


// Load the log
if (!$fh = fopen($filename,"r")){
	echo "Could not open log\n";
	die;
}

// Calculate the date stamp we're looking for
$check_date = date($date_format,strtotime("-1 hour"));
$datelen = strlen($check_date);

// Identify some array keys
$hostkey = array_search("http_host",$log_struct);
$datekey = array_search("time_local",$log_struct);
$cachestatpos = array_search("upstream_cache_status",$log_struct);
$stat = array_search("status",$log_struct);
$requestpos = array_search("request",$log_struct);

// OK, let's read the log
while (!feof($fh)){
	$data = fgetcsv($fh, 2048," ");


	// Check whether we need to process the log entry
	if (1==2 && substr($data[$datekey],0,$datelen) != $check_date){
		echo "Skipping log entry\n";
		continue;
	}

	// Get data from the entry

	$host = $data[$hostkey]; 
	$cache_status = $data[$cachestatpos];
	$status = $data[$stat];
	$request_string = $data[$requestpos];
	$request_method = substr($request_string,0,3);

	$request = substr($request_string,4);
	$request = explode(" ",$request);

	$request_path = $request[0];
	$http_version = (isset($request[1]))? $request[1] : '';

	// See if we have a custom handler for the domain - call it if so
	if (!empty($host) && is_dir("${mydir}/Domains/$host")){
		include "${mydir}/Domains/$host/process-entry.php";
	}


}
