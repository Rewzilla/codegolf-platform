<?php

error_reporting(E_ALL);

$default_page = "home";

$pages = array(
	"anonymous" => array(
		"home",
		"login",
		"register",
	),
	"logged_in" => array(
		"home",
		"play",
		"account",
		"logout",
	),
);

$mysql_host = "CHANGEME";
$mysql_user = "CHANGEME";
$mysql_pass = "CHANGEME";
$mysql_db = "CHANGEME";

$hash_algo = "sha512";

$tmp_dir = "/dev/shm";

$recaptcha_secret = "CHANGEME";
$recaptcha_sitekey = "CHANGEME";

$cdn = array(
	"ace_js"		=> "https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.3/ace.js",
	"recaptcha_js"	=> "https://www.google.com/recaptcha/api.js",
	"jquery_js"		=> "https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js",
	"popper_js"		=> "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js",
	"bootstrap_js"	=> "https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js",
	"bootstrap_css"	=> "https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css",
);
