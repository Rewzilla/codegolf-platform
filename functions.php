<!-- Jquery -->
<?php if(isset($_GET["course"]) && $_GET["course"] == "1" && isset($_GET['hole']) &&(isset($_SESSION["scores"][1]) && count($_SESSION["scores"][1]) == 18)){?> 

<script>
window.onload = function(){

	$('#Challenges').attr('title', <?php 
		switch(floor(($_GET["hole"]-1)/3)){
				#These hints kinda suck so feel free to change them
			case 0:
				echo '"Mov your way to the finish for this challenge"';
				break;
			case 1:
				echo '"Fun fact the XOR operator is turing complete"';
				break;
			case 2:
				echo '"ODD way to capitalize the first word"';
				break;
			case 3:
				echo '"EVEN if you figure this out it will not be easy"';
				break;
			case 4:
				echo '"Having a PRINTABLE option is sometimes the only way"';
				break;
			case 5:
				echo '"This one will be tough so no riddle. Every byte must be opposite of the first EVEN/ODD style. Such that if you start with EVEN then go ODD or if you start ODD go EVEN and so on."';
				break;
		
		}
	?>
	);

};
</script>

<?php
}
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

function leaderboard($course, $hole) {##broken

	global $db;

	$ret = array();

	$sql = $db->prepare("select tmp.username, min(tmp.score) AS score, tmp.at, tmp.challenge as challenge from (SELECT users.username, solves.score, MIN(solves.at) as at, challenges.value as challenge FROM solves NATURAL LEFT JOIN challenges JOIN users ON users.id=solves.user WHERE course=? AND hole=? GROUP BY username, score)tmp GROUP BY username ORDER BY score;");
	$sql->bind_param("ii", $course, $hole);
	$sql->execute();
	$sql->bind_result($username, $score, $at, $challenge);

	while($sql->fetch()) {

		$ret[] = array(
			"username" => $username,
			"score" => $score,
			"timestamp" => $at,
			"challenge" => $challenge
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
function updatescore($user, $course, $hole, $score, $challenges){

	global $db;

	$sql = $db->prepare("INSERT INTO solves (user, course, hole, score) VALUES (?, ?, ?, ?);");
	$sql->bind_param("iiii", $user, $course, $hole, $score);
	$sql->execute();
	$sql->close();
	
	if($course == 1){

		$val = $_SESSION["leaderboard"][$course][$hole];

		foreach($val as $users){
			if($users["username"] == $_SESSION["username"])
				$challenges |= $users["challenge"];
		}
		
		$sql = $db->prepare("INSERT INTO challenges(hole,user,value,course) values(?, ?, ?, ?) ON DUPLICATE KEY UPDATE value=?;");
		$sql->bind_param("iiiii", $hole, $user, $challenges, $course, $challenges);
		$sql->execute();
		$sql->close();
	}
	
}

function getchallenges($user, $course){

	global $db;
	$ret = array();

	$sql = $db->prepare("SELECT value, hole FROM challenges JOIN users ON users.id = challenges.user WHERE course=? and username=? ORDER BY hole");
	$sql->bind_param("is",$course, $user);
	$sql->execute();
	$sql->bind_result($value, $hole);

	while($sql->fetch())
		$ret[$hole]=check_challenge($value, $hole);
	
	$sql->close();
	
	return $ret;


}

function check_challenge($value, $hole){

		switch(($hole-1)/3){
			case 0:
				$value = $value&1;#Mov
				break;
			case 1:
				$value = $value&1024;#xor
				break;
			case 2:
				$value = $value&2048;#odd
				break;
			case 3:
				$value = $value&4096;#even
				break;
			case 4:
				$value = $value&8192;#printable
				break;
			case 5:
				$value = $value&16384;#alternate
				break;

		}

	return $value;
}
