<?php

srand(time(0));

$alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.,/;:<>?! ";
$wordlist = array("This", "is", "my", "random", "sentence", "generator", "list", "I", "think", "my", "plan", "should", "work", "but", "who", "knows", "anyways", "if", "there", "are", "other", "words", "or", "a", "different", "and", "better", "way", "becomes", "available", "please", "do", "not", "hesitate", "to", "change", "this", "method", "thanks", "extra");

$testcases = array(

	"1" => function() {

		return array("input" => "", "output" => "Hello World!");

	},

	"2" => function() {

		$string = "";

		for ($x=0; $x<50; $x++)
			$string .= rand() % 256;

		return array("input" => $string, "output" => $string);

	},

	"3" => function() {

		$value = rand() % 1000;

		return array("input" => $value, "output" => $value * ($value+1) / 2);

	},

	"4" => function() {

		$test = rand() % 2;
		$value = rand() % 2000;

		if ($test) {
			$square *= $value;
		} else {
			$spuare = $value;
			$value = 0;
		}

		return array("input" => $square, "output" => $value);

	},

	"5" => function() {

		$string = "";

		for ($x=0; $x<15; $x++)
			$string .= rand() % 256;

		return array("input" => $string, "output" => strrev($string));

	},

	"6" => function() {

		$newlines = 0;
		$words = rand() % 40 + 20;
		$string = "";

		for ($x=0; $x<$words; $x++) {
			$string .= wordlist[rand() % 40];
			if(rand() % 3) {
				$string .= " ";
			} else {
				$newlines++;
				$string .= "\n";
			}
		}

		return array("input" => $string, "output" => strlen($string) . " " . $words . " " . $newlines);

	},

	"7" => function() {

		$string = "";
		$length = rand() % 40 + 20;

		for ($x=0; $x<$length; $x++)
			$string .= alphabet[rand() % strlen(alphabet)];

		return array("input" => $string, "output" => str_rot13($string));

	},

	"8" => function() {

		$possibilities = "1234567890";
		$num = rand() % 1000 + 1000;
		$string = "0";

		for ($x=0; $x<$num; $x++)
			$string .= " " . $possibilities[rand() % 10];

		$search = rand() % 10;
		$replace = rand() % 10;

		return array("input" => $search . " " . $replace . "\n" . $string, "output" => str_replace($search, $replace, $string));

	},

	"9" => function() {

		function reverse($string) {
			return preg_match("/(\(([^()]*)\))/", $string, $m) ? reverse(preg_replace("/\(" . $m[2] . "\)/", strrev($m[2]), $string)) : $string;
		}

		$string = "";
		$length = rand() % 40 + 20;

		for ($x=0; $x<$length; $x++)
			$string .= alphabet[rand() % strlen(alphabet)];

		$reverses = rand() % 5;

		for ($x=0; $x<$reverses; $x++) {
			$location1 = rand() % $length;
			$location2 = rand() % $length - $location1 + $location1;
			$string = substr($string, 0, $location1) . "(" . substr($string, $location1, $location1 - $location2) . ")" . substr($string, $location2);
			$length += 2;
		}

		return reverse($string);

	},

	"10" => function() {

		$words = rand() % 40 + 20;
		$string = $wordlist[rand() % 40];

		for ( ; $words>0; $words--) {
			$string .= " " . $wordlist[rand() % 40];
		}

		return array("input" => pack($string), "output" => $string);

	},

	"11" => function() {

		$value1 = rand() % 1000;
		$value2 = rand() % 1000;

		return array("input" => $value1 . " " . $value2, "output" => gmp_gcd($value1, $value2));

	},

	"12" => function() {

		$numberofnums = rand() % 40 + 20;
		$array = array();
		$input = strval(rand() % 1000) . " ";

		for ( ; $numberofnums>0; $numberofnums--) {
			array_push($array, rand() % 1000);
			$input .= $array[count($array) - 1] . " ";
		}

		sort($array);

		$ouptut .= strval($array[0]) . " ";

		for($x=1; $x<count($array); $x++)
			$outut .= strval($array[$x]) . " ";

		return array("input" => $input, "output" => $output);

	},

	"13" => function() {

	},

	"14" => function() {

	},

	"15" => function() {

	},

	"16" => function() {

	},

	"17" => function() {

	},

	"18" => function() {

/* In progress

		$words = rand() % 40 + 20;
		$string = $wordlist[rand() % 40];

		for( ; $words>0; $words--)
			$string .= " " .$wordlist[rand() % 40];

*/

	}

);

?>