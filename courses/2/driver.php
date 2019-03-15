<?php

if(!defined("IN_MAIN") || !logged_in())
	die("Access Denied");

include("testcases.php");

function testcase($hole, $code) {

	global $tmp_dir, $testcases;

	$name = md5($code);

	$c_file = $tmp_dir . "/" . $name . ".c";
	$e_file = $tmp_dir . "/" . $name;
	$seccomp = dirname(__FILE__) . "/seccomp.c";

	file_put_contents($c_file, $code);

	$output = shell_exec(
		"gcc -std=c99 -w -o " . $e_file . " -lseccomp " . $seccomp . " " . $c_file . " 2>&1 " .
		"|grep -v '.o: In function'" .
		"|grep -v 'function is dangerous and should not be used'"
	);

	$io = $testcases[$hole]();

	if (!empty($output)) {

		$output = str_replace($c_file, "/path/to/code.c", $output);
		$ret = "fail";
		$size = "inf";

	} else {

		$descspec = array(
			0 => array("pipe", "r"),
			1 => array("pipe", "w"),
			2 => array("pipe", "w"),
		);

		$run = proc_open(dirname(__FILE__) . "/runner " . $e_file, $descspec, $pipes, $tmp_dir);

		fwrite($pipes[0], $io["input"]);
		fclose($pipes[0]);
		$result = stream_get_contents($pipes[1]);
		$err = stream_get_contents($pipes[2]);
		fclose($pipes[1]);
		fclose($pipes[2]);
		$retval = proc_close($run);

		if(strpos($err, "Bad system call") !== false) {
			$output = "Dangerous system call detected.  No hax plz.";
			$ret = "fail";
			$size = "inf";
		} else if($retval == 137) {
			$output = "Program took too long to run.";
			$ret = "fail";
			$size = "inf";
		} else if($result != $io["output"]) {
			$output = "Incorrect solution.";
			$ret = "fail";
			$size = "inf";
		} else {
			$output = "";
			$ret = "pass";
			$size = filesize($c_file) - 1;
		}

	}

	@unlink($c_file);
	@unlink($e_file);

	return array(
		"valid" => $ret == "pass",
		"size" => $size,
		"output" => $output,
	);

}