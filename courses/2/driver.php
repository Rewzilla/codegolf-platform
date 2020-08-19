<?php

if(!defined("IN_MAIN") || !logged_in())
	die("Access Denied");

include("testcases.php");

function testcase($hole, $code, $input) {
	
	global $tmp_dir, $testcases;
	
	$name = md5($code);

	$c_file = $tmp_dir . "/" . $name . ".c";
	$e_file = $tmp_dir . "/" . $name;
	$seccomp = dirname(__FILE__) . "/seccomp.blacklist.c";
	file_put_contents($c_file, $code);

	$output = shell_exec(
		"gcc -std=c99 -w -o " . $e_file . " " . $seccomp . " " . $c_file . " -lseccomp 2>&1 " .
		"|grep -v '.o: In function'" .
		"|grep -v '.o: in function'" .
		"|grep -v 'function is dangerous and should not be used'"
	);

	
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

		for($x = 0; $x<10; $x++){
			$run = proc_open(dirname(__FILE__) . "/runner " . $e_file, $descspec, $pipes, $tmp_dir);
			$io = $testcases[$hole]();

			if($io["output"] == NULL && $input != ""){
				$_SESSION["input"]=$input;
				$io["input"]=$input;
			}

			fwrite($pipes[0], $io["input"]);
			fclose($pipes[0]);
			$result = stream_get_contents($pipes[1]);

			if($hole == 0)
				$io["output"] = $result;
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
			} else if($result != $io["output"]){

				#var_dump($io["input"]);
				#var_dump($io["output"]);
				#var_dump($result);
				$output = "Incorrect Solution.";
				$ret = "fail";
				$size = "inf";
			} else {
				$output = "";

				if($hole == 0)
					$output = "Output recieved: " . $result;
				
				$ret = "pass";
				$size = filesize($c_file);
			}
			if($output != "" || $hole == 0)
				break;
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
