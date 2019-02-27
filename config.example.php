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