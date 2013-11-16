<?php
/** NGinx Log Actions
*
*
* @copyright 2013 B Tasker, All Rights Reserved
* @license GNU GPL V2
*
* Configuration file - See http://www.bentasker.co.uk/documentation/linux/253-keeping-hitcounts-accurate-when-using-an-nginx-caching-proxy
*
*/


$log_location = '/var/log/nginx';
$log_name = 'access.log';

$log_location = dirname(__FILE__)."/Log_Examples";
$log_name = 'access.log';

// We need to define the log record structure - you can grab this from your NGinx config file
// Note: If you've include time_local, follow it with an entry called timezone
$log_struct = array('remote_addr','-','remote_user', 'time_local','timezone','request','status','body_bytes_sent','http_referer','http_user_agent','http_x_forwarded_for','http_host','upstream_cache_status');

// What (PHP date) format are the dates in? Don't go any further than the end of the time (excluding minutes & seconds)
// Example for Nginx's 'local time' "[d/M/Y:H:"
$date_format = "[d/M/Y:H:";

