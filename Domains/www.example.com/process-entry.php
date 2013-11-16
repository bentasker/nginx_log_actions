<?php
/** NGinx Log Actions
*
*
* @copyright 2013 B Tasker, All Rights Reserved
* @license GNU GPL V2
*
* Domain specific handler for www.example.com
*
*/


$excluded_paths = array("/","/index.php","/foo/bar/","/blog/");

// Work out if we need to place a request (let's not perpetuate any errors)
if ($cache_status == 'CACHE_HIT' && $status == 200 && $request_method == 'GET'){

	$request = substr($request_string,4);
	$request = explode(" ",$request);

	$request_path = $request[0];
	$http_version = $request[1];

	if (!in_array($request_path,$excluded_paths)){
		// Would place a request for
		echo "Placing request for http://www.example.com{$request_path} (Request time {$data[$datekey]})\n";
	
	
		$ch = curl_init("http://www.example.com{$request_path}");
		curl_setopt($ch, CURLOPT_HTTPHEADER,array("X-LOGPARSING-NOCACHE: True"));
	    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
		curl_setopt($ch,CURLOPT_USERAGENT,"Log-Parse Cache-Hit Updater V1.1");
	    	$resp = curl_exec($ch);
	    	curl_close($ch);

		// We don't actually want to do anything with the response.
		unset($resp);
	}

	
}
