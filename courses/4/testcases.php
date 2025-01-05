<?php

srand(time());

$lower = "abcdefghijklmnopqrstuvwxyz";
$upper = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$digit = "0123456789";
$alphanum = $lower . $upper . $digit;
$symbols = ".,/;:<>?!";
$all_chars = $lower . $upper . $digit . $symbols;
$wordlist = array("This", "is", "my", "random", "sentence", "generator", "list", "I", "think", "my", "plan", "should", "work", "but", "who", "knows", "anyways", "if", "there", "are", "other", "words", "or", "a", "different", "and", "better", "way", "becomes", "available", "please", "do", "not", "hesitate", "to", "change", "this", "method", "thanks", "extra");

$testcases = array(

	"1" => function() {

		return array("input" => "", "output" => "Hello World!\n");

	},

	"2" => function() {

		global $alphanum;

		$str = "";

		for ($x=0; $x<rand(32, 64); $x++)
			$str .= $alphanum[rand() % strlen($alphanum)];

		$str .= "\n";

		return array("input" => $str, "output" => strlen($str) - 1);

	},

	"3" => function() {

		if (rand() % 4 == 0) {

			$chars = "atc";
			$gs = (rand() % 7) + 1;
			$str = "";

			$str = "a";

			for ($x=0; $x<$gs; $x++)
				$str .= "g";

			for ($x=0; $x<(23 - 9); $x++)
				$str .= $chars[rand() % strlen($chars)];

			for ($x=0; $x<(7 - $gs); $x++)
				$str .= "g";

			$str .= "t";

			$output = "positive\n";

		} else {

			$chars = "actg";

			$str = "";

			for ($x=0; $x<(rand() % 64); $x++)
				$str .= $chars[rand() % strlen($chars)];

			// this technically still *could* be positive, but the chances are statistically zero
			$output = "negative\n";

		}

		return array("input" => $str, "output" => $output);

	},

	"4" => function() {

	},

	"5" => function() {

	},

	"6" => function() {

	},

	"7" => function() {

	},

	"8" => function() {

	},

	"9" => function() {

	},

	"10" => function() {

	},

	"11" => function() {

	},

	"12" => function() {

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

	}

);

?>