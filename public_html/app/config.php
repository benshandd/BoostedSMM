<?php

$url = $_SERVER["SERVER_NAME"];
$last = substr($url, -1); 
$dab = "$url[0]$url[1]$url[2]$url[3]$url[4]$last" ; 

define('PATH', realpath('.'));
define('SUBFOLDER', false);
define('URL', "https://boostedsmm.com");
define('STYLESHEETS_URL', "//boostedsmm.com");
define('URL', "https://localhost/BoostedSMM/public_html/");
error_reporting(1);
date_default_timezone_set('Asia/Kolkata');

return [
  'db' => [
    'name'    =>  "boosteds_boosted",
    'host'    =>  'localhost',
    'user'    =>  "boosteds_boosted",
    'pass'    =>  "Unic0rn$101123",
    'charset' =>  'utf8mb4' 
  ]
];

