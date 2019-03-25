<?php

if(!defined("IN_MAIN") || !logged_in())
	die("Access Denied");

if(!isset($_GET["course"])) {

	$sql = $db->prepare("SELECT id, language, description, image FROM courses;");
	$sql->execute();
	$sql->bind_result($id, $language, $description, $image);

	?>
	<ul class="breadcrumb">
		<li class="breadcrumb-item active">Courses</li>
	</ul>
	<div class="card-columns">
		<?php while($sql->fetch()) { ?>
		<div class="card" style="width: 400;">
			<a href="/play/<?php echo $id; ?>"><img class="card-img-top" src="<?php echo $image; ?>"></a>
			<div class="card-body">
				<h5 class="card-title"><a href="/play/<?php echo $id; ?>"><?php echo $language; ?></a></h5>
				<p class="card-text"><?php echo $description; ?></p>
			</div>
		</div>
		<?php } ?>
	</div>
	<?php

	$sql->close();
	$_SESSION=array("username"=>$_SESSION["username"]);

} else if(isset($_GET["hole"]) && $_GET["hole"]==1337 && n($_GET["course"], $user = get_userid()) == 18){

	echo '<script>document.body.style.backgroundImage="url(\'/images/secret.jpg\')";</script>';
	$course = $_GET["course"];

	if(!insecretleaderboard($user, $course))
		addsecretleaderboard($user,$course);

	$list = secretleaderboard($course);

	?>

	<div class="row" style="background-color:white; margin:0 5px;">

		<div class="col-lg" style="clear:both;" >
			<h1> Congratulations!!</h1><h2>On sucking this much at code golf. Anyways here is a secret page only a handful will ever find. You now have the chance to view upon your name on this leaderboard, but alas this page is only for this course, guess you need to get your name on the other leaderboards as well. Anyways have fun!!
			</h2>
		</div>
		<br>
		<div class="col-lg" style = "clear: both;float:left;">
			<h5>Leaderboard</h5>
			<table class="table table-bordered table-striped">
				<tr><th>Username</th><th>Timestamp</th></tr>
				<?php foreach($list as $line) { ?>
					<tr><td><?php echo htmlentities($line["username"]); ?></td><td><?php echo $line["timestamp"]; ?></td></tr>
				<?php } ?>
			</table>
			<br>
		</div>
			
	</div>
	<?php

} else {
	if(isset($_SESSION["scores"][$_GET["course"]])){
		$scores=$_SESSION["scores"][$_GET["course"]];
		$par = $_SESSION["par"][$_GET["course"]];

	} else{
		$scores = scorecard($_SESSION["username"], $_GET["course"]);
		$_SESSION["scores"][$_GET["course"]] = $scores;
		$par = coursepar($_GET["course"]);
		$_SESSION["par"][$_GET["course"]]=$par;
	}

	$sql = $db->prepare("SELECT language, description, syntax FROM courses WHERE id=?;");
	$sql->bind_param("i", $_GET["course"]);
	$sql->execute();
	$sql->bind_result($language, $description, $syntax);
	$sql->fetch();
	$sql->close();
 
	if(!isset($_GET["hole"])) {

		$sql = $db->prepare("SELECT id, course, number, description FROM holes WHERE course=? ORDER BY number;");
		$sql->bind_param("i", $_GET["course"]);
		$sql->execute();
		$sql->bind_result($id, $course, $number, $description);

		?>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="/play">Courses</a></li>
			<li class="breadcrumb-item active"><?php echo $language; ?></li>
		</ul>
		<h5>Scorecard</h5>
		<table class="table table-bordered table-striped">
			<tr><th>Hole</th><th>Description</th><th>Par</th><th>My Best</th></tr>
			<?php $counter = count($scores)+4; while($sql->fetch() && $counter--) { ?>
				<tr <?php  if(isset($scores[$number]) && $scores[$number]<$par[$number] )echo 'style="background:lightgreen;";'?>>
					<td><a href="/play/<?php echo $course; ?>/<?php echo $number; ?>">Hole <?php echo $number; ?> </a></td>
					<td><?php echo strlen($description) > 80 ? substr($description, 0, 80) . "..." : $description; ?></td>
					<td><?php if(isset($scores[$number]))echo $par[$number] ?? "unknown"; else if($number == 0) echo " "; else echo "Hidden"; ?></td>
					<td><?php echo $scores[$number] ?? " "; ?></td>
				</tr>
			<?php } ?>
		</table>
		<br>
		<?php

		$sql->close();

	} else {

		$sql = $db->prepare("SELECT id, course, number, description FROM holes WHERE course=? AND number=? ORDER BY number ASC;");
		$sql->bind_param("ii", $_GET["course"], $_GET["hole"]);
		$sql->execute();
		$sql->bind_result($id, $course, $number, $description);
		$sql->fetch();
		$sql->close();

		?>
		<ul class="breadcrumb" style="display:flex;" >
			<li class="breadcrumb-item" ><a href="/play">Courses</a></li>
			<li class="breadcrumb-item"><a href="/play/<?php echo $course; ?>"><?php echo $language; ?></a></li>
			<li class="breadcrumb-item active">Hole <?php echo $number; ?></li>
		</ul>

		<?php
		if(isset($_POST["submit"])) {

			include("courses/" . $course . "/driver.php");

			$ret = testcase($number, $_POST["code"], (!isset($_POST["input"])?NULL:$_POST["input"]), (!isset($_POST["registers"])?NULL:$_POST["registers"]), (!isset($_POST["type"])?NULL:$_POST["type"]));

			if($ret !== false && $ret["valid"] && $number != 0) {

				$userid = get_userid(); # do not switch to session, could switch users then

				$sql = $db->prepare("INSERT INTO solves (user, course, hole, score) VALUES (?, ?, ?, ?);");
				$sql->bind_param("iiii", $userid, $course, $number, $ret["size"]);
				$sql->execute();
				$sql->close();

				if(!isset($_SESSION["scores"][$course][$number]) || $_SESSION["scores"][$course][$number]>$ret["size"]){
					$_SESSION["scores"][$course][$number]=$ret["size"];
					$_SESSION["par"][$course][$number]=holepar($course,$number);
				}

			}

			?>
			<div class="row">
				<div class="col-lg">
				<?php
				if($ret["valid"]) {
					?>
					<div class="alert alert-success alert-dismissible fade show" style="display:flex;flex-direction:column;">
						
						Success! Code was <?php echo $ret["size"]; ?> bytes.<br>
						<hr >
						<pre><?php if($ret["size"] == 1337){ echo "With all these hacker skills and thats the best score you get. Not very 1337 of you: " . $n=n($course,$userid); if($n==18 && $number==18)header("Location: /play/" . $course . "/1337"); die(); }  echo htmlspecialchars($ret["output"]); ?></pre>
					
						<button class="nexthole" onclick="window.location.href = '/play/<?php echo ($number == 18?"":$course . "/" . strval($number+1)); ?>';";><?php echo ($number == 18?"Back to Courses":"Next Hole"); ?></button>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<?php
				} else {
					?>
					<div class="alert alert-danger alert-dismissible">
						Fail! Code didn't work.<br>
						<hr>
						<pre><?php echo htmlspecialchars($ret["output"]); ?></pre>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
					</div>
					<?php
				}
				?>
				</div>
			</div>
			<?php

		}
		?>

				<form id="post" action="/play/<?php echo $course; ?>/<?php echo $number; ?>" method="POST" onsubmit="document.getElementById('code').value = editor.getValue();">
		<div class="row">
				<div style="width:100%;padding:0 15px;">
				<?php if($number == 0 && $course == 1){#pretty ugly but it seems to do its job
					$registers = array("eax","ebx","ecx","edx","esi","edi","ebp","esp"); ?>
					<table class="table table-striped"><tr>

					<?php for($x = 0; $x < 6; $x++){
						if(!($x%2) && $x != 0){
							echo "</tr><tr>";
						}
							echo "<td style=\"text-align:center;\">" . $registers[$x] . " " . "<input value=\"" . (isset($_SESSION["registers"])?$_SESSION["registers"][$registers[$x]]:0) . "\" name=\"registers[" . $registers[$x] . "]\"> </td>";
					}
					}?>
					</tr></table>
				</div>
		<div class="col-lg">
								

				<h5>Code</h5>
					<div class="form-group">
						<div class="card card-body editor" id="editor" style="position: relative; height: 400px; width: 100%;"></div>
						<script src="<?php echo $cdn["ace_js"]; ?>" type="text/javascript" charset="utf-8"></script>
						<script>
							var editor = ace.edit("editor");
							editor.setTheme("ace/theme/textmate");
							editor.getSession().setMode("ace/mode/<?php echo $syntax; ?>");
							<?php if(isset($_POST["submit"])) { ?>editor.setValue(atob("<?php echo base64_encode($_POST["code"]); ?>"));<?php } ?>
						</script>
					</div>
						<input type="hidden" id="code" name="code" value="">
						<?php
							if($number == 0){
								echo '<div style="float:right;display:flex;">';
								if($course == 1)#I'm not going to even try to pretend that I understand what happened with the session type variable but it works
									echo '<div class="onoffswitch style="float:left;"><input type=checkbox name="type" class="onoffswitch-checkbox" id="myonoffswitch" value="1" ' . (isset($_SESSION["type"])&&isset($_SESSION["type"])=='1'?"checked":"") . ' >
										<label class="onoffswitch-label" for="myonoffswitch">
											<span class="onoffswitch-inner"></span>
										</label></div>';	
		echo '<div style="float:right;margin-left:10px;">
			Input: <input value="'. (isset($_SESSION['input'])?$_SESSION['input']:"") . '" name="input" margin-left:5px;" >
								</div>
								</div>';
							}	
						?>
					<input type="submit" class="btn btn-primary" name="submit[]" value="Run">
			</div>
			<div class="col-md-4">
				<h5>Description</h5>
				<div class="card card-body">
					<?php echo $description; ?>
				</div>
			<?php if($number != 0){

				if(!isset($_SESSION["leaderboard"][$course][$number]) || $ret["valid"])
					$_SESSION["leaderboard"][$course][$number] = leaderboard($course, $number);
				$list = $_SESSION["leaderboard"][$course][$number];
			?>
				<br>
				<h5>Par <kbd><?php if(isset($_SESSION['scores'][$course][$number])) echo $_SESSION['par'][$course][$number] ?? par($list); else echo "Hidden"; ?></kbd></h5>
				<br>
			<?php
			}
			?>
			</div>
		</div>
				</form>
		<br>
		
		<?php
			if($number != 0){
		
				

		?>

		<div class="row">

			<div class="col-lg">
				<h5>Leaderboard</h5>
				<table class="table table-bordered table-striped">
					<tr><th>Username</th><th>Score</th><th>Timestamp</th></tr>
					<?php foreach($list as $line) { ?>
						<tr><td><?php echo htmlentities($line["username"]); ?></td><td><?php if(isset($_SESSION['scores'][$course][$number]))echo $line["score"]; else echo "Hidden" ?></td><td><?php echo $line["timestamp"]; ?></td></tr>
					<?php } ?>
				</table>
				<br>
			</div>
				
		</div>
		
		<?php
		}

	}

}
