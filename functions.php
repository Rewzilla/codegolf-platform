<?php

function redirect($page = false, $halt = false) {

	global $default_page;

	if(!$page)
		$page = $default_page;

	header("Location: /" . $page);

	if($halt !== false)
		die($halt);

}

function logged_in() {

	return isset($_SESSION["username"]);

}

function get_userid() {

	global $db;

	$sql = $db->prepare("SELECT id FROM users WHERE username=?;");
	$sql->bind_param("s", $_SESSION["username"]);
	$sql->execute();
	$sql->bind_result($userid);
	$sql->fetch();
	$sql->close();

	return $userid;

}

function valid_user($username, $password) {

	global $db, $hash_algo;

	$password = hash($hash_algo, $password);

	$sql = $db->prepare("SELECT * FROM users WHERE username=? AND password=?;");
	$sql->bind_param("ss", $username, $password);
	$sql->execute();
	$sql->store_result();

	$exists = $sql->num_rows > 0;

	$sql->close();

	return $exists;

}

function user_exists($username) {

	global $db;

	$sql = $db->prepare("SELECT * FROM users WHERE username=?;");
	$sql->bind_param("s", $username);
	$sql->execute();
	$sql->store_result();

	return $sql->num_rows > 0;

}

function create_user($username, $password, $email) {

	global $db, $hash_algo;

	$password = hash($hash_algo, $password);

	$sql = $db->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?);");
	$sql->bind_param("sss", $username, $password, $email);
	$sql->execute();
	$sql->close();

}

function update_password($username, $password) {

	global $db, $hash_algo;

	$password = hash($hash_algo, $password);

	$sql = $db->prepare("UPDATE users SET password=? WHERE username=?;");
	$sql->bind_param("ss", $password, $username);
	$sql->execute();
	$sql->close();

}

function leaderboard($course, $hole) {

	global $db;

	$ret = array();

	$sql = $db->prepare("SELECT users.username, MIN(solves.score) as score, MAX(solves.at) FROM solves JOIN users ON users.id=solves.user WHERE solves.course=? AND solves.hole=? GROUP BY users.username ORDER BY score, solves.at ASC;");
	$sql->bind_param("ii", $course, $hole);
	$sql->execute();
	$sql->bind_result($username, $score, $at);

	while($sql->fetch()) {

		$ret[] = array(
			"username" => $username,
			"score" => $score,
			"timestamp" => $at,
		);

	}

	$sql->close();

	return $ret;

}

function par($course, $hole) {

	global $db;

	$ret = 0;
	$total = 0;

	$sql = $db->prepare("SELECT MIN(solves.score) as score FROM solves WHERE solves.course=? AND solves.hole=? GROUP BY solves.user;");
	$sql->bind_param("ii", $course, $hole);
	$sql->execute();
	$sql->bind_result($score);

	while($sql->fetch()) {

		$ret += $score;
		$total++;

	}

	$sql->close();

	$ret = $total > 0 ? floor($ret / $total) : "unknown";

	return $ret;

}

function scorecard($username, $course) {

	global $db;

	$ret = array();

	$sql = $db->prepare("SELECT hole, MIN(score) as score FROM solves JOIN users ON users.id=solves.user WHERE users.username=? and solves.course=? GROUP BY hole ORDER BY solves.hole;");
	$sql->bind_param("si", $username, $course);
	$sql->execute();
	$sql->bind_result($hole, $score);

	while($sql->fetch()) {
		$ret[$hole] = $score;
	}

	return $ret;

}