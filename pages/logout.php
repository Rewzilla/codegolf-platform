<?php

if(!defined("IN_MAIN") || !logged_in())
	die("Access Denied");

session_destroy();

redirect("home");

?>

<div class="alert alert-success" role="alert">
	You have been logged out
</div>