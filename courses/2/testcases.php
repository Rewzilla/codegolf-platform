<?php

$urand = fopen("/dev/urandom", "r");
if($urand){
	$randstring = fread($urand, 4);
	$srand = 0;

	for($x=0; $x<4; $x++){
		$srand = ord($randstring[$x])+$srand*256;	
	}
	srand($srand);
}
else
	srand(time(0));

$alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.,/;:<>?! ";
$wordlist = array("This", "is", "my", "random", "sentence", "generator", "list", "I", "think", "my", "plan", "should", "work", "but", "who", "knows", "anyways", "if", "there", "are", "other", "words", "or", "a", "different", "and", "better", "way", "becomes", "available", "please", "do", "not", "hesitate", "to", "change", "this", "method", "thanks", "extra");

function io($input, $output){

	var_dump($input);
	var_dump($output);
	return array("input" => $input . "\n", "output" => $output . "\n");	

}

$testcases = array(

	"0" => function(){

		return array("input"=>NULL,"output"=>NULL);	
	},

	"1" => function() {

		return io("", "Hello World!");

	},

	"2" => function() {

		$value = rand(0,1000);

		return io(strval($value), strval($value*($value+1)/2));

	},

	"3" => function() use ($alphabet){
		
		$string ="";
		$size = rand(20,60);

		for($x=0; $x<$size;$x++)
			$string .= $alphabet[rand(0,strlen($alphabet)-1)];

		return io($string,strtolower($string) ^ strtoupper($string) ^ $string);
	},

	"4" => function() {

		$value1 = rand(0,1000);
		$value2 = rand(0,1000);
		$max = 0;
		for($x = 1; $x< $value1; $x++)
			if($value1%$x==0 && $value2%$x==0)
				$max = $x;
		return io(strval($value1) . " " . strval($value2), strval($max));
	},

	"5" => function() use ($alphabet){

		$string = "";
		$size = rand(20,60);
		for ($x=0; $x<$size; $x++)
			$string .= $alphabet[rand(0,strlen($alphabet)-1)];

		return io($string, strrev($string));

	},

	"6" => function() use ($wordlist) {

		$newlines = 1;
		$words = rand(20,60);
		$string = "";

		for ($x=0; $x<$words; $x++) {
			$string .= $wordlist[rand(0,39)];
			if(rand(0,2)) {
				$string .= " ";
			} else {
				$newlines++;
				$string .= "\n";
			}
		}

		return io($string, strval(strlen($string)+1) . " " . strval($words) . " " . strval($newlines));

	},
	
	"7" => function() {

		$value = strval(rand()*rand());
		$input = $value;
	
		$max = -1;
		
		for($x = 0; $x<strlen($value); $x++){
			$tmp = intval(substr($value,0,$x).substr($value, $x+1, strlen($value)-$x-1));

			if($max<$tmp)
				$max = $tmp;
		}

		$output = strval($max);

		return io($input, $output);

	},

	"8" => function() {

		$size = rand(20,40);
		$input = "";
		$output = "";
		$array = array(1);

		$func2 = function($x){

			if($x%2==0)
				return 1;

			for($y=3; $y<=ceil(sqrt($x));$y+=2)

				if($x%$y==0)
					return 1;

			return 0;
		};

		$function = function() use ($func2){

			for($x = rand(2,1000000); $func2($x); $x++)

				if($x==1000000)
					$x=2;

			return strval($x);
		};

		for($x = 0; $x < $size; $x++){

			switch(rand(0,2)){
				
				case 0:#anything
					array_push($array,rand(1,1000000));
					break;
				case 1:
					array_push($array,pow(rand(1,1000),2));
					break;
				case 2:#prime
					array_push($array, $function());
			}
		}
		
		$input = implode(" ", $array);

		$array = array_map(function($int){
			
			if(1==$int)
				return "<u>" . strval($int) . "</u>";
			$test = 0;	
			for($x = 2; $x < $int/2; $x++)

				if($int % $x == 0){

					if($x*$x==$int)
						return "<u>" . strval($int) . "</u>";
					$test = 1;		
				}
			if($test)
				return strval($int);

			return "<b>" . strval($int) . "</b>";
		}, $array);
		$output = implode(" ", $array);
		return io($input, $output);	
	},

	"9" => function() use ($alphabet){

		$string = "";
		$length = rand(20,60);

		for ($x=0; $x<$length; $x++)
			$string .= $alphabet[rand(0,strlen($alphabet)-1)];

		return io($string, str_rot13($string));

	},

	"10" => function() use ($alphabet){

		$string = "";
		$length = rand(20,60);

		for ($x=0; $x<$length; $x++)
			$string .= $alphabet[rand(0, strlen($alphabet)-1)];

		$reverses = rand(0,10);

		for ($x=0; $x<$reverses; $x++) {
			$location1 = rand(0,$length-1);
			$location2 = rand($location1, $length-1);
			$string = substr($string, 0, $location1) . "(" . substr($string, $location1, $location2-$location1) . ")" . substr($string, $location2);
			$length += 2;
		}

		$output = $string;

		while(preg_match('/\(([^()]*)\)/', $output, $m))
			$output = str_replace($m[0], strrev($m[1]), $output);

		return io($string, $output);
		
	},

	"11" => function() use ($wordlist){

		$words = rand(20,60);
		$string = $wordlist[rand(0,39)];

		for ( ; $words>0; $words--) {
			$string .= " " . $wordlist[rand(0,39)];
		}
		$array=str_split($string,1);
		for($x=0; $x<count($array); $x++){
			$array[$x] = str_pad(decbin(ord($array[$x])), 8, "0", STR_PAD_LEFT);
		}

		return io(implode($array), $string);

	},


	"12" => function() {

		$numberofnums = rand(20,60);
		$array = array();
		$input = strval(rand(0,1000));

		for ( ; $numberofnums>0; $numberofnums--) {
			array_push($array, rand(0,1000));
			#$input .= " " . strval($array[count($array) - 1]);
		}

		$input = implode(" ", $array);
		sort($array);
	
		
		$output = implode(" ", $array);

		return io($input, $output);
	},

	"14" => function() {#last minute rearange
		
		$size = rand(5,25);
		$array = array_fill(0,$size,array_fill(0,$size,""));
		$current = 1;

		for($x = 0; $x < intval(($size+1)/2); ++$x){
			for($y = $x; $y < $size-$x-1; ++$y)
				$array[$x][$y] = $current++;

			for($y = $x; $y < $size-$x-1; ++$y)
				$array[$y][$size-$x-1] = $current++;
			
			for($y = $size-$x-1; $y > $x; --$y)
				$array[$size-$x-1][$y] = $current++;

			for($y = $size-$x-1; $y > $x; --$y)
				$array[$y][$x] = $current++;
		}

		if($size&1)
			$array[intval($size/2)][intval($size/2)] = $size*$size;

		$input = strval($size);
		$output = "";

		for($x=0; $x<$size; $x++){
			
			for($y=0; $y<$size; $y++){
				$output .= strval($array[$x][$y]) . ($y < $size-1?" ":'');
			}
			$output .= ($x < $size-1?"\n":'');
		}

		return io($input, $output);
	},

	"13" => function()use ($alphabet) {

		$input = "";
		$output = "";

		$one = rand(1,255);
		$two = rand(1,255);
		$three = rand(1,255);
		$four = rand(1,255);

		if(rand(0,1)){
			$output = "False";

			switch(rand(0,5)){

				case 0: #missing number
					$four = 0;
					break;

				case 1: #number too high
					switch(rand(0,3)){
						case 0:
							$one = rand(256, 1000);
							break;
						
						case 1:
							$two = rand(256, 1000);
							break;
						
						case 2:
							$three = rand(256,1000);
							break;

						case 3:
							$four = rand(256,1000);
					}
					break;

				case 2: #number too low
					switch(rand(0,3)){
						case 0:
							$one = rand(-1000,-1);
							break;
						
						case 1:
							$two = rand(-1000,-1);
							break;
						
						case 2:
							$three = rand(-1000,-1);
							break;

						case 3:
							$four = rand(-1000,-1);
					}
					break;

				case 3: #letter
					switch(rand(0,3)){
						case 0:
							$one = $alphabet[rand(0, 51)];
							break;
						
						case 1:
							$two = $alphabet[rand(0, 51)];
							break;
						
						case 2:
							$three = $alphabet[rand(0, 51)];
							break;

						case 3:
							$four = $alphabet[rand(0, 51)];
					}
					break;
				
				case 4: #extra octet
					$four = strval($four) . "." . strval(rand(1,255));
					break;

				case 5: #extra letter
					$four = strval($four) . "." . $alphabet[rand(0,51)];
			}
			
		}
		else
			$output = "True";

		$input = strval($one) . "." . strval($two) . "." . strval($three) . "." . ($four != 0?strval($four):"");

		return io($input,$output);
	},

	"15" => function() use ($alphabet) {

		$size = rand(20,60);
		$input = "";

		for($x=0; $x<$size; $x++)
			$input .= $alphabet[rand(0,strlen($alphabet)-1)];

		$output = base64_encode($input);
		
		return io($input, $output);

	},

	"16" => function() {

		$size = rand(20,60);
		$array = array();
		$input = "";



		for($x=0; $x<$size; $x++){
			$tmp = rand();
			$input .= strval($tmp) . ($x<$size-1?" ":"");
			$count = 0;

			for($y=0; $y<32; $y++)

				if(($tmp >> $y)&1)
					$count++;

			$array[$count][] = $tmp;
		}

		ksort($array);
		$array = array_map(
			function($tmparray){ #this is pretty gross but it works
				
				$tmparray= array_map("strval",$tmparray);
				$tmparray=array_map("strrev",$tmparray);
				$tmparray=array_map("intval",$tmparray);
				sort($tmparray);
				$tmparray= array_map("strval",$tmparray);
				$tmparray=array_map("strrev",$tmparray);
				$tmparray=array_map("intval",$tmparray);
			
				return $tmparray;
			},$array);

		$array2 = array_map(
			function($tmparray){
				
				return implode(" ", $tmparray);
			},$array);

		$output = implode(" ", $array2);

		return io($input,$output);
	},

	"17" => function() {

		$x = rand(5,25);
		$y = rand(5,25);
		$inarr = array_fill(0,$x,array_fill(0,$y,0));
		$input = "";

		for($a=0; $a<$x; $a++){
			
			for($b=0; $b<$y; $b++){
				$inarr[$a][$b] = rand(0,1);
				$input .= strval($inarr[$a][$b]) . ($b<$y-1?" ":"");
			}

			$input .= ($a<$x-1?"\n":"");
		}
		
		$outarr=$inarr;
		$output = "";

		for($a=0; $a<$x; $a++){

			for($b=0; $b<$y; $b++){
				#this is ugly but it works
				$output .= strval($inarr[$a][$b+1] + $inarr[$a+1][$b+1] + $inarr[$a+1][$b] + $inarr[$a+1][$b-1] + $inarr[$a][$b-1] + $inarr[$a-1][$b-1] + $inarr[$a-1][$b] + $inarr[$a-1][$b+1] ) . ($b<$y-1?" ":"");
			}

			$output .= ($a<$x-1?"\n":"");
		}
		
		return io($input, $output);
	},

	"18" => function() use ($wordlist) {

		$words = rand(20,60);
		$array = array();

		for( ; $words>0; $words--)
			array_push($array, strtolower($wordlist[rand(0,39)]));

		$input = implode($array, " ");
		$array = array_map(
			function($word){

				switch($word[0]){

					case 'a':
					case 'e':
					case 'i':
					case 'o':
					case 'u':
					case 'y':
						$word .= "yay";
						break;
					default:

						for($x=0; $x<strlen($word); $x++)
							if($word[$x]=='a' || $word[$x]=='e' || $word[$x]=='i' || $word[$x]=='o' || $word[$x]=='u' || $word[$x]=='y'){
								$word = substr($word, $x, strlen($word)-$x) . substr($word,0,$x)."ay";
								break;
							}
				}
				return $word;
				
			}, $array);
		$output = implode($array, " ");

		return io($input, $output);
	}

);

?>
