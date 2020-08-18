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
	return array("input" => $input, "output" => $output);	

}

$testcases = array(

	"0" => function(){

		return array("input"=>NULL,"output"=>NULL);	
	},

	"1" => function() {

		$num = rand(2,12);

		$accounts = array();
		$balances = array();

		$input = "";

		for($x = 0; $x < $num; $x++){
			$actlen = rand(4,8);
			$tmp ="";

			for($y = 0; $y < $actlen; $y++)
				$tmp .= rand(0,9);

			array_push($accounts, $tmp);

			array_push($balances,round(rand(0,100)/100 + rand(0,1000), 2));
			$input .= '#' . $accounts[$x] . ':$' . $balances[$x] . '\n';
		}

		$numtrans = rand(1,15);	
		$output = "";

		for($x = 0; $x < $numtrans; $x++){
			$amount = round(rand(0,100)/100 + rand(1,max($balances))-1,2);
			
			while(1){
				$sender = rand(0,$num-1);
				
				if($balances[$sender] > $amount)
					break;

			}
			
			$reciever = rand(0,$num-1);

			while($reciever == $sender)
				$reciever = rand(0,$num-1);

			$input .= '#' . $accounts[$sender] . '->#' . $accounts[$reciever] . ':$' . $amount . '\n';	
			$balances[$sender] -= $amount;
			$balances[$reciever] += $amount;
		}	

		for($x = 0; $x < $num; $x++)
			$output .= '#' . $accounts[$x] . ':$' . number_format($balances[$x],2,'.','') . '\n';	


		return io($input, $output);

	},

	"2" => function() use ($alphabet) {

		$num = rand(1,15);
		$input = "";
		$output = "";

		for($x = 0; $x < $num; $x++)
		{	
			$tmp = "";
			$size = rand(1,15);
			$test = rand(0,1);
			$last = 0;
			$ltmp = 0;

			for($y = 0; $y < $size; $y++){
				if($test || $size == 1){
					
					if($y == 0)	
						$ltmp =rand(0,51);
					else
						while(1){
							$ltmp = $last;
							$ltmp += rand(-2,2);
							
							if($ltmp >= 0 && $ltmp <= 52 && 
							(($alphabet[$ltmp] < 'a' && $tmp[-1] < 'a') || 
							($alphabet[$ltmp] >= 'a' && $tmp[-1] >= 'a')))
								break;
						}
					$last = $ltmp;
					$tmp .= $alphabet[$last];
				}
				else #don't like this idea since it does not always guarentee a no
					$tmp .= $alphabet[rand(0,51)];

			}

			$input .= $tmp . '\n';
			$output .= ($test?"no":"yes") . '\n';

		}

		return io($input, $output);

	},

	"3" => function() use ($alphabet){

		$input = "";
		$output = "";
		$string = "GenCyber";
		$loc = rand(0,7);
		
		while(1){
			$tmp = $alphabet[rand(0,strlen($alphabet)-1)];
			if($tmp != $string[$loc])
				break;
		}

		$output = $loc . ':' . $tmp . ':' . $string[$loc] . '\n';
		$input = $string . '\n';
		$input[$loc] = $tmp;		

		return io($input, $output);
	},

	"4" => function() use ($alphabet){

		$input = "";
		$output = "";
		$num = rand(2,15);

		for($x = 0; $x < $num; $x++){
			$strlen = rand(1,25);
			$test = rand(0,1);
			$string = "";
			$total = 0;
			if($test || $strlen == 1){
				for($y = 0; $y < $strlen/2; $y++){
					$string .= $alphabet[rand(0, strlen($alphabet)-1)];	
					$total += ord($string[-1]);
				}
				$total*=2;
				$tmp = strrev($string);
				if($strlen%2)
				{
					$string .= $alphabet[rand(0,strlen($alphabet)-1)];
					$total += ord($string[-1]);

				}
				$string .= $tmp;
			}
			else
				for($y = 0; $y < $strlen; $y++){
					$string .= $alphabet[rand(0,strlen($alphabet)-1)];
					$total += ord($string[-1]);
				}
			$input .= $string . '\n';
			$output .= ($test?"yes":"no") . ":" . $total . '\n';
		}

		return io($input, $output);
	},

	"5" => function() use ($alphabet){

		$input = "";
		$output = "";

		$prime = 2;
		$num = rand(1,100);
		$current = 1;

		while($current < $num && $prime < 1000){
			$prime++;
			$test = 0;
		
			for($y = 2; $y <= sqrt($prime); $y++)

				if(!($prime%$y)){
					$test++;
					break;
				}

			if(!$test){
				$current++;
			}
		}

		$input .= $num . '\n';
		$output .= $prime . '\n';

		return io($input, $output);


	},

	"6" => function() {
		
		$num = rand(1,10);
		$input = "";
		$output = "";
		for($x = 0; $x < $num; $x++){

			$string1 = "";
			$string2 = "";
			$tmp = rand(1,10);

			

			for($y = 0; $y < $tmp; $y++){
				$tmp2 = rand(1,20);
				$string1 .= str_repeat(chr(rand(32,0x7e)),$tmp2);
				$string2 .= "%" . $tmp2 . "$" . $string1[-1];
			}
			$string1 .= '\n';
			$string2 .= '\n';

			if(rand(0,1)){
				$input .= "e " . $string1 . '\n';
				$output .= $string2 . '\n';
			}
			else{
				$input .= "d " . $string2 . '\n';
				$output .= $string1 . '\n';
			}


		}
		

		return io($input, $output);

	},
	
	"7" => function() {
			//Code found at https://stackoverflow.com/questions/14994941/numbers-to-roman-numbers-with-php

		$input = "";
		$output = "";
		$num = rand(1,15);

		while($num--){
			$number = rand(1,300);
			$number2 = rand(1,300);
			$number3 = $number;
		
			for($x = 0; $x < 2; $x++){

				$map = array('C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
				$returnValue = '';

				while ($number > 0) {

					foreach ($map as $roman => $int) {

					    if($number >= $int) {
						$number -= $int;
						$returnValue .= $roman;
						break;
					    }
					}
				}

				$input .= $returnValue;

				if($x == 1){
					$input .= '\n';
					continue;
				}
				
				switch(rand(0,2)){
					case 0:
						$output .= $number3 + $number2 . '\n';
						$input .= ' + ';
						break;
					case 1:
						$output .= $number3 - $number2 .'\n';
						$input .= ' - ';
						break;
					case 2:
						$output .= $number3 * $number2 . '\n';
						$input .= ' * ';

				}
				$number = $number2;
			}

		}

		return io($input, $output);

	},

	"8" => function() {

		$createrpn = function(){
			$operations = rand(1,15);
			$string = "";

			while($operations>0){

				if($string=="")
					$start = 1;
				else
					$start = 0;
				$stack = rand(1+$start,$operations);

				for($x = 0; $x < $stack; $x++)
					$string .= rand(0,9);

				for($x = 0; $x < $stack-$start; $x++){
					switch(rand(0,3)){
						case 0:
							$char = '+';
							break;
						case 1:
							$char = '-';
							break;

						case 2:
							$char = '*';
							break;

						case 3:
							$char = '/';
							break;

						case 4:
							$char = '%';
							break;

					}
					$string .= $char;
				}
				$operations-=$stack;
			}

			return $string;
		};

		$findvalue = function($string){
			$stack = array();
			$total = 0;
			$first = -1;

			for($x = 0; $x < strlen($string); $x++){

				if(is_numeric($string[$x]))
					$stack[] = intval($string[$x]);
				else{
					if($first == -1)
						$first = array_pop($stack);		
					$second = $first;

					if(sizeof($stack) == 0)
						$first = $total;
					else
						$first = array_pop($stack);

					switch($string[$x]){
						case '+':
							$first += $second;
							break;
							
						case '-':
							$first -= $second;
							break;

						case '*':
							$first *= $second;
							break;

						case '/':
							if($second == 0)
								return -99999;
							$first /= $second;
							break;

						case '%':

							if($second == 0)
								return -99999;
							$first %= $second;
							break;
					}
					if(sizeof($stack) == 0 && $x+1 < strlen($string) && is_numeric($string[$x+1]))
					{
						$total = $first;
						$first = -1;
					}
				}
			}
			$total = $first;

			return $total;
		};
 
		$input = "";
		$output = "";

		$num = rand(1,15);

		while($num--){
			$string = $createrpn();
			$value = $findvalue($string);

			if($value == -99999){
				$num++; #value failed probably divide by zero
				continue;
			}
			$input .= $string . '\n';
			$output .= round($value) . '\n';
		}

		return io($input, $output);	
	},

	"9" => function() use ($alphabet){

		$output = "";
		$input = "";

		$numbers = "0123456789";
		$num = rand(1,15);

		while($num--){
			
			$total = 0;
			$string = "";
			if(rand(0,1)){#valid
				$size = rand(7,9);
		
				while(1){
					for($x = 0; $x < $size; $x++){

						while(1){
							$string[$x] = $numbers[rand(0,9)];

							if(($x == 0 && $string[$x] != '0') || ($x > 0 && $string[$x] != $string[$x-1]))
								break;

						}
						$total += strval($string[$x]);
					}

					if($total % 7 && $total % 11)
						break;

				}
				$input .= $string . '\n';
				$output .= "valid" . '\n';
			}
			else{#notvalid
				
				switch(rand(0.4)){
					case 0:#too short
						$qwerty = rand(1,6);
						while($qwerty--)
							$string .= $numbers[rand(0,9)];
						break;

					case 1:#too long
						$qwerty = rand(10,20);
						while($qwerty--)
							$string .= $numbers[rand(0,9)];
						break;

					case 2:#leading zero
						$string .= strval(0);
						$qwerty = rand(6,8);

						while($qwerty--)
							$string .= $numbers[rand(0,9)];
						break;

					case 3:#multiple of 7 or 11
						while(1){
							$string = '';
							$total = 0;
							$qwerty = rand(7,9);

							while($qwerty--){
								$string .= $numbers[rand(0,9)];
								$total += strval($string[-1]);
							}

							if($total % 7 == 0 || $total % 11 == 0)
								break;
						}
						break;

					case 4:#consecutive nums
						$size = rand(7,9);
						$consecutive = rand(2,$size);

						for($x = 0; $x < $size; $x++){
							
							if(($x + $consecutive) == $size){
								$size -= $x;
								$character = strval(rand(0,9));
								while($size--)
									$string .= $character;
							}
							else if(rand(0,1) && $consecutive > 0){
								$character = strval(rand(0,9));
								$x+= $consecutive;
								while($consecutive--){
									$string .= $character;
								}

							}
							else{
								$string .= strval(rand(0,9));
							}
						}
				}	

				$input .= $string . '\n';
				$output .= "invalid" . '\n';
			}

		}

		return io($input, $output);

	},

	"10" => function(){

		$input = "";
		$output = "";

		do{
			$a = rand(-25,25);
		} while(!$a);

		$b = rand(-25,25);
		$c = rand(-25,25);

		switch(rand(1,1)){
			case 0: #zero zeroes

				do{
					$tmpb = $b;
					$tmpc = $c;

					$d = rand(-10000,10000);
					$e = rand(-10000,10000);

					$tmpb -= $d;
					$tmpc -= $e;
					
					$k = $tmpb*$tmpb - (4*$a*$tmpc);

				}while($k >= 0);
				$z = 0;
				break;
				
			case 1: #one 

				$intersect = rand(-100,100); #good sized range
				

				$d = 2*$a * $intersect + $b;
				
				$e = ($a*$intersect*$intersect + $b*$intersect + $c) - ($d * $intersect);
				$z = 1;
				break;

			case 2: #two
				do{
					$tmpb = $b;
					$tmpc = $c;

					$d = rand(-10000,10000);
					$e = rand(-10000,10000);

					$tmpb -= $d;
					$tmpc -= $e;

					$k = $tmpb * $tmpb - (4*$a*$tmpc);

				}while($k <= 0);
				$z = 2;
		}
		$input .= $a . ' ' . $b . ' ' . $c . '\n' . $d . ' ' . $e . '\n';
		$output .= $z . '\n';
		

		return io($input, $output);
		
	},

	"11" => function() use ($wordlist){

		$output = "OXOXOXOXOX\nXOXOXOXOXO\nOXOXOXOXOX\nXOXOXOXOXO\nOXOXOXOXOX\n";

		return io('', $output);

	},


	"12" => function() {

		return io('', '');

	},

	"14" => function() {
		
		return io('', '');

	},

	"13" => function()use ($alphabet) {

		return io('', '');

	},

	"15" => function() use ($alphabet) {

		return io('', '');

	},

	"16" => function() {

		return io('', '');

	},

	"17" => function() {

		return io('', '');

	},

	"18" => function() use ($wordlist) {

		return io('', '');

	}

);

?>
