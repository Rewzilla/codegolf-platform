<?php

if(!defined("IN_MAIN"))
	die("Access Denied");

if(isset($_POST["submit"])) {

	if(valid_user($_POST["username"], $_POST["password"])) {

		?>
		<div class="alert alert-success" role="alert">
			Logged in
		</div>
		<?php

		$_SESSION["username"] = $_POST["username"];

		redirect("home");

	} else {

		?>
		<div class="alert alert-danger" role="alert">
			Invalid username or password
		</div>
		<?php

	}

}

?>

<form action="/login" method="POST">

	<div class="form-group">

		<label for="username">Username</label>
		<input name="username" type="text" class="form-control">
		<br>

		<label for="password">Password</label>
		<input name="password" type="password" class="form-control">
		<br>

		<input name="submit" type="submit" value="Log in" class="btn btn-primary">

	</div>

</form>