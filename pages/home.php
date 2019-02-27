<?php

if(!defined("IN_MAIN"))
	die("Access Denied");

?>

<!--
<ul class="breadcrumb">
		<li class="breadcrumb-item active">Welcome <?php echo logged_in() ? htmlentities($_SESSION["username"]) : "Guest"; ?></li>
</ul>
-->

<?php

$sql = $db->prepare("SELECT title, body, ts FROM news ORDER BY ts DESC;");
$sql->execute();
$sql->bind_result($title, $body, $timestamp);

while($sql->fetch()) {

	?>
	<div class="card">
		<div class="card-header">
			<?php echo $title; ?>
		</div>
		<div class="card-body">
			<p class="card-text">
				<?php echo $body; ?>
			</p>
			<footer class="blockquote-footer">Posted: <?php echo $timestamp; ?></footer>
		</div>
	</div>
	<?php

}

$sql->close();