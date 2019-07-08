<?php


if(!defined("IN_MAIN") || !logged_in())
	die("Access Denied");

function validate($string){
	
	if(is_numeric($string))
		return 0;
	else if($string[1] == 'b')
		return 2;
	else if($string[1] == 'x')
		return 3;
	return 1;

}

function testcase($hole, $code, $input, $registers, $type) {

	global $tmp_dir;
	
	$name = md5($code);

	$asm_file = $tmp_dir . "/" . $name . ".s";
	$bin_file = $tmp_dir . "/" . $name . ".bin";
	$c_file = $tmp_dir . "/" . $name;

	if($hole == 0){
		include("template.php");
		$template = explode("setup() {", $template);
		$final = $template[0] . "setup() {\n";	
		$_SESSION["input"]=$input;
		$_SESSION["registers"]=$registers;
		$_SESSION["type"]=$type;
		
		foreach($registers as $register => $string){

			switch(validate($string)){
				case 0:
					$value = strval($string);
					break;
				case 2:
					$value = bindec($string);
					break;
				case 3:
					$value = hexdec($string);
					break;
				case 1:
					$value = 0;
					$_SESSION["type"][$register]=0;
			}

			$final .= $register . " = " . $value  . ";\n";
		}
		if(isset($input) && $input != "")#check for int or string
			
			if($type == NULL){ #int creates an int * then sets mem
				$tmp = explode(",",$input);
				$counter = 0;

				foreach($tmp as $word)	
					$counter += validate($word);

				if(!$counter)
					$final .= "int array[ ] = {" . $input . "};\nmemcpy(mem, array, " . strval(substr_count($input, ",") + 1) * 4 . ");";
				else
					$_SESSION["input"] = "";

			}else {#string
				$array = str_split($input,1);
				$blacklist = " ;\"'(){}[]<>?:`~\\|/";#blacklist characters not allowed in strings
				$tester = 1;

				foreach($array as $chars)

					if(strpos($blacklist, $chars))
						$tester = 0;

				if($tester)
					$final .= "memcpy(mem, \"" . $input . "\", " . strlen($input) . ");\n";
				else
					$_SESSION["input"] = "";
			}
		$final .= $template[1];
		file_put_contents($c_file . ".c", $final);
		shell_exec("gcc -lpthread -lunicorn -o " . $c_file . " " . $c_file . ".c /var/www/html/courses/1/hole.c");		
	}

	$code =
		"bits 32\n" .
		$code . "\n";

	file_put_contents($asm_file, $code);

	for($x = 0; $x<10;$x++){

		$output = shell_exec("nasm -f bin -o " . $bin_file . " " . $asm_file . " 2>&1");

		if(!empty($output)) {
			$output = str_replace($asm_file, "/path/to/code.s", $output);
			$ret = "fail";
			$size = "inf";

		} else if($hole==0){	
			$output = shell_exec("objdump -D -b binary -Mintel,i386 -mi386 " . $bin_file . " | grep -P '[0-9a-f]+:\\t'") . "\n";
			$ret = "pass";
			$output .= str_replace(",", "\n", exec("timeout 5 " . $c_file . " " . $bin_file));

			if(!strpos($output, "EAX"))
			       $output .= "Program crashed or Timeout Occured, please limit your execution to below 5 seconds\n";	
			$size = filesize($bin_file);

		} else {

			if($hole == 18){
				$timeout = 25;
			}
			else{
				$timeout = 5;
			}
			
			$output = shell_exec("objdump -D -b binary -Mintel,i386 -mi386 " . $bin_file . " | grep -P '[0-9a-f]+:\\t'");
			$ret = exec("timeout " . $timeout . " ./courses/1/hole" . $hole . " " . $bin_file);
			
			if($ret == ""){
				$output = "Program crashed or Timeout detected please limit your execution to below " . $timeout . " seconds\n" . $output;
				$ret = "fail";
			}
			
			$size = filesize($bin_file);
		}

		if($ret=="fail" || ($hole != 2 && $hole != 3 && $hole != 4 && $hole != 6 && $hole != 7 && $hole != 14))
			break;

	}


	@unlink($asm_file);
	@unlink($bin_file);

	if($hole == 0){
		@unlink($c_file);
		@unlink($c_file . ".c");
	}

	return array(
		"valid" => $ret != "fail",
		"size" => $size,
		"output" => $output,
		"challenges" => $ret
	);

}
