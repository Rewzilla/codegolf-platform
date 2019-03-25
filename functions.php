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

function insecretleaderboard($user,$course){

	global $db;

	$sql = $db->prepare("SELECT * FROM secret WHERE userid=? AND course=?");
	$sql->bind_param("ii",$user,$course);
	$sql->execute();
	$sql->store_result();

	return $sql->num_rows > 0;

}

function addsecretleaderboard($user,$course){

	global $db;

	$sql = $db->prepare("INSERT INTO secret(userid, course) VALUES(?,?);");
	$sql->bind_param("ii",$user,$course);
	$sql->execute();
	
	$sql->close();
}

function secretleaderboard($course){
	
	global $db;

	$sql = $db->prepare("SELECT username, time FROM secret JOIN users on users.id=secret.userid WHERE course=? order by time;");
	$sql->bind_param("i",$course);
	$sql->execute();
	$sql->bind_result($user, $time);

	$ret = array();

	while($sql->fetch())
		$ret[] = array(
			"username" => $user,
			"timestamp" => $time
	);

	$sql->close();

	return $ret;

}

function n($course, $user) {

	global $db;
	$count = 0;

	$sql = $db->prepare("SELECT COUNT(*) FROM (SELECT solves.hole FROM solves WHERE solves.score='1337' AND solves.course=? AND solves.user=? GROUP BY hole) tmp;");
	$sql->bind_param("ii", $course, $user);
	$sql->execute();
	$sql->bind_result($count);
	$sql->fetch();

	$sql->close();

	return $count;
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

function leaderboard($course, $hole) {##broken

	global $db;

	$ret = array();

	$sql = $db->prepare("SELECT tmp.username, MIN(tmp.score) as score, tmp.at FROM (SELECT users.username, solves.score, MIN(solves.at) as at FROM solves JOIN users ON users.id=solves.user WHERE course=? AND hole=? GROUP BY username, score) tmp GROUP BY username ORDER BY score;");
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

function holepar($course, $hole) {
	
	global $db;

	$sql = $db->prepare("SELECT CEIL(AVG(score)) as score FROM (SELECT MIN(solves.score) as score FROM solves WHERE solves.course=? AND solves.hole=? GROUP BY solves.user) tmp;");
	$sql->bind_param("ii", $course, $hole);
	$sql->execute();
	$sql->bind_result($score);
	$sql->fetch();

	$sql->close();

	return $score;

}

function par($list) { 

	$total = 0;

	foreach($list as $arrays)
		$total += $arrays["score"];

	return $total/count($total);

}

function coursepar($course) {#should return an array, of pars
	
	global $db;
	$ret = array();
	
	$sql = $db->prepare("SELECT tmp.hole as hole, CEIL(AVG(score)) as score FROM (SELECT MIN(solves.score) as score, solves.hole as hole FROM solves WHERE solves.course=? GROUP BY solves.user, solves.hole) tmp GROUP BY tmp.hole;");
	$sql->bind_param("i",$course);
	$sql->execute();
	$sql->bind_result($hole, $score);

	while($sql->fetch())
		$ret[$hole] = $score;

	$sql->close();

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

	$sql->close();

	return $ret;

}
