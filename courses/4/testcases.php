<?php

srand(time());

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