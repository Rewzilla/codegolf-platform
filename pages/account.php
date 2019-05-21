<?php

if(!defined("IN_MAIN") || !logged_in())
	die("Access Denied");

if(!isset($_GET["action"])) {

	?>
	<ul class="breadcrumb">
		<li class="breadcrumb-item active"><?php echo htmlentities($_SESSION["username"]); ?></li>
	</ul>
	<ul>
		<li><a href="/account/password">Change Password</a></li>
		<li><a href="/account/delete">Delete Account</a></li>
	</ul>
	<?php

} else {

	switch($_GET["action"]) {

		case "password":
			if(isset($_POST["submit"])) {

				if(!valid_user($_SESSION["username"], $_POST["oldpassword"])) {

					?>
					<div class="alert alert-danger">
						Invalid old password
					</div>
					<?php

				} else if($_POST["newpassword"] != $_POST["confirmpassword"]) {

					?>
					<div class="aler alert-danger">
						Passwords do not match
					</div>
					<?php

				} else {

					update_password($_SESSION["username"], $_POST["newpassword"]);

					?>
					<div class="alert alert-success">
						Password changed
					</div>
					<?php

				}

			}
			?>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="/account"><?php echo htmlentities($_SESSION["username"]); ?></a></li>
				<li class="breadcrumb-item active">Change Password</li>
			</ul>
			<form action="/account/password" method="POST">

				<div class="form-group">

					<label for="oldpassword">Old Password</label>
					<input name="oldpassword" type="password" class="form-control">
					<br>

					<label for="newpassword">New Password</label>
					<input name="newpassword" type="password" class="form-control">
					<br>

					<label for="confirmpassword">Confirm Password</label>
					<input name="confirmpassword" type="password" class="form-control">
					<br>

					<input name="submit" type="submit" value="Change Password" class="btn btn-primary">

				</div>

			</form>
			<?php
			break;

		case "delete":
			if(isset($_POST["submit"])) {

				$userid = get_userid();

				$sql = $db->prepare("DELETE FROM users WHERE id=?;");
				$sql->bind_param("i", $userid);
				$sql->execute();
				$sql->close();

				$sql = $db->prepare("DELETE FROM solves WHERE user=?;");
				$sql->bind_param("i", $userid);
				$sql->execute();
				$sql->close();

				$sql = $db->prepare("DELETE FROM challenges WHERE user=?;");
				$sql->bind_param("i", $userid);
				$sql->execute();
				$sql->close();

				redirect("logout");

			}
			?>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="/account"><?php echo htmlentities($_SESSION["username"]); ?></a></li>
				<li class="breadcrumb-item active">Delete Account</li>
			</ul>
			<form action="/account/delete" method="POST" onsubmit="return confirm('Are you absolutely sure?');">
				<input class="btn btn-danger" type="submit" name="submit" value="Delete my account">
			</form>
			<?php
			break;

	}

}
