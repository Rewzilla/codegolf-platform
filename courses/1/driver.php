<?php

if(!defined("IN_MAIN") || !logged_in())
	die("Access Denied");

function testcase($hole, $code) {

	global $tmp_dir;

	$name = md5($code);

	$asm_file = $tmp_dir . "/" . $name . ".s";
	$bin_file = $tmp_dir . "/" . $name . ".bin";

	$code =
		"bits 32\n" .
		$code . "\n" .
		"hlt";

	file_put_contents($asm_file, $code);

	$output = shell_exec("nasm -f bin -o " . $bin_file . " " . $asm_file . " 2>&1");

	if(!empty($output)) {

		$output = str_replace($asm_file, "/path/to/code.s", $output);
		$ret = "fail";
		$size = "inf";

	} else {

		$output = shell_exec("objdump -D -b binary -Mintel,i386 -mi386 " . $bin_file . " | grep -P '[0-9a-f]+:\\t' | head -n -1");
		$ret = exec("./courses/1/hole" . $hole . " " . $bin_file);
		$size = filesize($bin_file) - 1;

	}

	@unlink($asm_file);
	@unlink($bin_file);

	return array(
		"valid" => $ret == "pass",
		"size" => $size,
		"output" => $output,
	);

}