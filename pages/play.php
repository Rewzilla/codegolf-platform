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
<!--
		<div class="card" style="width: 400;">
			<img class="card-img-top" src="/images/comingsoon.png">
			<div class="card-body">
				<h5 class="card-title">C</h5>
				<p class="card-text">Coming soon...<br><br><br></p>
			</div>
		</div>
-->
	</div>
	<?php

	$sql->close();

} else {

	$scores = scorecard($_SESSION["username"], $_GET["course"]);

	$par = array("n.a");
	for($i=1; $i<=18; $i++)
		$par[$i] = par($_GET["course"], $i);

	$sql = $db->prepare("SELECT language, description, syntax FROM courses WHERE id=?;");
	$sql->bind_param("i", $_GET["course"]);
	$sql->execute();
	$sql->bind_result($language, $description, $syntax);
	$sql->fetch();
	$sql->close();

	if(!isset($_GET["hole"])) {

		$sql = $db->prepare("SELECT id, course, number, description FROM holes WHERE course=?;");
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
			<?php while($sql->fetch()) { ?>
				<tr>
					<td><a href="/play/<?php echo $course; ?>/<?php echo $number; ?>">Hole <?php echo $number; ?> </a></td>
					<td><?php echo strlen($description) > 80 ? substr($description, 0, 80) . "..." : $description; ?></td>
					<td><?php echo $par[$number]; ?></td>
					<td><?php echo $scores[$number] ?? " "; ?></td>
				</tr>
			<?php } ?>
		</table>
		<br>
		<?php

		$sql->close();

	} else {

		$sql = $db->prepare("SELECT id, course, number, description FROM holes WHERE course=? AND number=?;");
		$sql->bind_param("ii", $_GET["course"], $_GET["hole"]);
		$sql->execute();
		$sql->bind_result($id, $course, $number, $description);
		$sql->fetch();
		$sql->close();

		?>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="/play">Courses</a></li>
			<li class="breadcrumb-item"><a href="/play/<?php echo $course; ?>"><?php echo $language; ?></a></li>
			<li class="breadcrumb-item active">Hole <?php echo $number; ?></li>
		</ul>

		<?php
		if(isset($_POST["submit"])) {

			include("courses/" . $course . "/driver.php");

			$ret = testcase($number, $_POST["code"]);

			if($ret !== false && $ret["valid"]) {

				$userid = get_userid();

				$sql = $db->prepare("INSERT INTO solves (user, course, hole, score) VALUES (?, ?, ?, ?);");
				$sql->bind_param("iiii", $userid, $course, $number, $ret["size"]);
				$sql->execute();
				$sql->close();

			}

			?>
			<div class="row">
				<div class="col-lg">
				<?php
				if($ret["valid"]) {
					?>
					<div class="alert alert-success alert-dismissible fade show">
						Success! Code was <?php echo $ret["size"]; ?> bytes.<br>
						<hr>
						<pre><?php echo htmlspecialchars($ret["output"]); ?></pre>
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

		<div class="row">


			<div class="col-lg">
				<h5>Code</h5>
				<form action="/play/<?php echo $course; ?>/<?php echo $number; ?>" method="POST" onsubmit="document.getElementById('code').value = editor.getValue()">
					<div class="form-group">
						<div class="card card-body editor" id="editor" style="position: relative; height: 400px; width: 100%;"></div>
						<script src="<?php echo $cdn["ace_js"]; ?>" type="text/javascript" charset="utf-8"></script>
						<script>
							var editor = ace.edit("editor");
							editor.setTheme("ace/theme/textmate");
							editor.getSession().setMode("ace/mode/<?php echo $syntax; ?>");
							<?php if(isset($_POST["submit"])) { ?>editor.setValue(atob("<?php echo base64_encode($_POST["code"]); ?>"));<?php } ?>
						</script>
						<input type="hidden" id="code" name="code" value="">
					</div>
					<input type="submit" class="btn btn-primary" name="submit" value="Run">
				</form>
			</div>

			<div class="col-md-4">
				<h5>Description</h5>
				<div class="card card-body">
					<?php echo $description; ?>
				</div>
				<br>
				<h5>Par <kbd><?php echo par($course, $number); ?></kbd></h5>
				<br>
			</div>

		</div>
		<br>

		<?php

		$list = leaderboard($course, $number);

		?>

		<div class="row">

			<div class="col-lg">
				<h5>Leaderboard</h5>
				<table class="table table-bordered table-striped">
					<tr><th>Username</th><th>Score</th><th>Timestamp</th></tr>
					<?php foreach($list as $line) { ?>
						<tr><td><?php echo htmlentities($line["username"]); ?></td><td><?php echo $line["score"]; ?></td><td><?php echo $line["timestamp"]; ?></td></tr>
					<?php } ?>
				</table>
				<br>
			</div>

		</div>

		<?php

	}

}