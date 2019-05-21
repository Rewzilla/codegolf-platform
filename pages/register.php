<?php

if(!defined("IN_MAIN"))
	die("Access Denied");

if(isset($_POST["submit"])) {

	$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret .
		"&response=" . $_POST["g-recaptcha-response"] . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
	$captcha = true;#json_decode($response, true)["success"];

	if(!$captcha) {

		?>
		<div class="alert alert-danger" role="alert">
			Invalid CAPTCHA
		</div>
		<?php

	} else if(user_exists($_POST["username"])) {

		?>
		<div class="alert alert-danger" role="alert">
			User already exists
		</div>
		<?php

	} else if($_POST["password"] != $_POST["confirm"]) {

		?>
		<div class="alert alert-danger" role="alert">
			Passwords do not match
		</div>
		<?php

	} else {
		print $_POST["username"];
		create_user($_POST["username"], $_POST["password"], $_POST["email"]);

		$_SESSION["username"] = $_POST["username"];

		?>
		<div class="alert alert-success" role="alert">
			Account created
		</div>
		<?php

		redirect("home");

	}

}

?>

<form action="/register" method="POST">

	<div class="form-group">

		<label for="username">Username</label>
		<input name="username" type="text" class="form-control">
		<br>

		<label for="email">Email</label>
		<input name="email" type="email" class="form-control">
		<br>

		<label for="password">Password</label>
		<input name="password" type="password" class="form-control">
		<br>

		<label for="confirm">Confirm Password</label>
		<input name="confirm" type="password" class="form-control">
		<br>

		<div class="form-group">
			<div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_sitekey; ?>"></div>
		</div>

		<input name="submit" type="submit" value="Register" class="btn btn-primary">

	</div>

</form>
