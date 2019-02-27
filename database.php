<?php

$db = new mysqli($mysql_host, $mysql_user, $mysql_pass, $mysql_db);

if(!$db)
	die("Database error");
