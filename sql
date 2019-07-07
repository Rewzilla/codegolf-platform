Delete from holes where course = '2';
Delete from holes where course = '3';


insert into holes(course,number,description) values('2','0',"Driving Range: <br>Welcome to the c driving range here you are able to test your creative solutions, as long as the program is syntatically correct it should run and return the size. You are also able to send in a string through stdin with the input box below. Have Fun!");

INSERT INTO holes(course,number,description) VALUES('2','1',"Welcome to the first hole in the c course, to get you started here are a couple pointers: every input has an ending newline, every output must also have an ending newline. Otherwise pretty much anything goes for your solution, so Good Luck! Now for your first challenge try to get used to the system by printing \"Hello World!\"");

INSERT INTO holes(course,number,description) VALUES('2','2',"Congrats now that you understand what you are doing try to solve this one. Given an int, x, print out the sum of all the numbers between 0 and x, inclusive. <br>Example: <br>&emsp;&emsp;Input: 10<br>&emsp;&emsp;Output: 55");

INSERT INTO holes(course,number,description) VALUES('2','3',"For this hole you are given a string and must swich the case of the characters in the string. Sounds easy right.<br>Example: <br>&emsp;&emsp;Input: CaSe SWap 3A5Y<br>&emsp;&emsp;Output: cAsE swAP 3a5y");

INSERT INTO holes(course,number,description) VALUES('2','4',"For this challenge you will be given two positive integers, what you have to do is return the greatest common divisor between the two numbers. <br>Example: <br>&emsp;&emsp;Input: 246<br>&emsp;&emsp;Output: 888");

INSERT INTO holes(course,number,description) VALUES('2','5',"This is an easy one, given a string return the reverse of it. Remember that strings are all ended by a newline, but this newline is not to be included in the reversal and should stay at the end.<br>Example: <br>&emsp;&emsp;Input: Reverse Me<br>&emsp;&emsp;Output: eM esreveR ");

INSERT INTO holes(course,number,description) VALUES('2','6',"This hole is a simple counting experiment, given a string print out the number of newlines, words, and spaces. For this hole you should count the ending newline as well.<br>Example: <br>&emsp;&emsp;Input: \"This string contains seventy eight characters<br>eleven words<br> and three newlines\"<br>&emsp;&emsp;Output: 78 11 3");

INSERT INTO holes(course,number,description) VALUES('2','7',"For this challenge you will be given a number, all you have to do is return the largest number made by deleting one of the digits. Don't over think it. Almost forgot to tell you that the number will be larger than zero, not a float, and may not always be an int32, enjoy! <br>Example: <br>&emsp;&emsp;Input: 123<br>&emsp;&emsp;Output: 23");

INSERT INTO holes(course,number,description) VALUES('2','8',"For this challenge your program will be given a list of integers. Each will be positive, and in the range 1 - 1,000,000. The list will be space-seperated and followed by a signle newline at the end.<br><br>Your job is to print the same list, but with HTML tags around \"interesting\" numbers. these numbers, and their correspoinding HTML tags are...<br><br> - Prime numbers:&emsp;should be made bold (&lt;b&gt;&lt;/b&gt;)<br> - Perfect squares:&emsp;should be underlined (&lt;u&gt;&lt;/u&gt;)<br><br>The list you print should also be space-seperated and follow the same order as the original list.<br><br>Example: <br>Input: 10 11 12 13 14 15 16 17 18 19 20<div>Output:&nbsp10&nbsp<b>11</b>&nbsp12&nbsp<b>13</b>&nbsp14&nbsp15&nbsp<u>16</u>&nbsp<b>17</b>&nbsp18&nbsp<b>19</b>&nbsp20</div>");

INSERT INTO holes(course,number,description) VALUES('2','9',"For this challenge, given a string return the rot13 of the string. You only need to rotate alphabetic characters. Quick and simple, how hard could it really be.<br>Example: <br>&emsp;&emsp;Input: Please rotate me if you could<br>&emsp;&emsp;Output: Cyrnfr ebgngr zr vs lbh pbhyq");

INSERT INTO holes(course,number,description) VALUES('2','10',"This one may be a bit tougher than the others, but here we go. Given a string reverse all characters found within parenthesis and remove the parenthesis. It's that simple so maybe you will not have a tough time after all.<br>Example: <br>&emsp;&emsp;Input: This is (reversed), this is ((reversal) detsen)<br>&emsp;&emsp;Output: This is desrever, this is a nested reversal");

INSERT INTO holes(course,number,description) VALUES('2','11',"I hope you can understand binary becuase I am going to throw a binary string at you and you need to return the ascii equivalent.<br>Example: <br>&emsp;&emsp;Input: 01010100011010000110100101110011001000000110100101110011001000000110000100100000010100110111010001110010011010010110111001100111<br>&emsp;&emsp;Output: This is a String");

INSERT INTO holes(course,number,description) VALUES('2','12',"This problem requires a simple solution that everyone should know how to do, given a set of numbers return the numbers back but sorted. You can use whatever algorithm you want, personally though, I prefer the random sort!<br>Example: <br>&emsp;&emsp;Input: 8 9 6 5 7 2 3 8 26 9 30 8<br>&emsp;&emsp;Output: 2 3 5 6 7 8 8 8 9 9 26 30");

INSERT INTO holes(course,number,description) VALUES('2','13',"You probably have not noticed this yet but so far these holes have been set into a pattern. While this pattern does not matter too much I at least owe it to you to let you know that the holes are going to start being more random and maybe harder depending on your background. With that said lets get started for this challenge you will be given a string, return 'True' or 'False' depending on whether this string is a valid IPv4 address.<br>Example: <br>&emsp;&emsp;Input: 192.156.a.-55.123<br>&emsp;&emsp;Output: False");

INSERT INTO holes(course,number,description) VALUES('2','14',"That was a pretty easy one, wasn't it? Anyways lets get back to jumping randomly to another challenge. For this  challenge you will be given one single number, lets call this number x. Your job is to return an array of numbers x by x. The pattern for this array shall be a spiral matrix, starting in the top left of the array and going clockwise increase the number by one. To keep everyone on the same page put one space between numbers and a newlines at the end. <br>Example: <br>&emsp;&emsp;Input: 5<br>&emsp;&emsp;Output: 1 2 3 4 5<br>16 17 18 19 6<br>15 24 25 20 7<br>14 23 22 21 8<br>13 12 11 10 9");

INSERT INTO holes(course,number,description) VALUES('2','15',"Ok, now do not get upset this is a fun one. Given a string return the base64 encoded version of the string. Look how easy I was able to describe it, this should be a cake walk. Also, incase you do not know the base64 alphabet is 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/='<br>Example: <br>&emsp;&emsp;Input: I am a string<br>&emsp;&emsp;Output: SSBhbSBhIHN0cmluZw==");

INSERT INTO holes(course,number,description) VALUES('2','16',"This may be my favorite hole besides 18 *wink wink*, you will be given a set of positive integers and you have to sort them. 'What makes this a hole 16 problem then', you ask? What an excellent question you have. This will not be a conventional sort. You will sort the numbers first by the number of ones in their binary form, then if these are the same, sort the numbers by the reverse values. Good Luck.<br>Example: <br>&emsp;&emsp;Input: 1024 91210 8675309 9068517 3<br>&emsp;&emsp;Output: 1024 3 91210 9068517 8675309");

INSERT INTO holes(course,number,description) VALUES('2','17',"Now that the tough ones are done lets go with more playful challenges. For this challenge we will be making a minesweeper board. You will be given an array of numbers, made up of 1's and 0's. This represents the game board, 1's are bombs and 0's are safe spots, but during the game you are not shown the bombs but the number bombs in the vicinity. So count up all nearby bombs and return the final game board instead.<br>Example: <br>&emsp;&emsp;Input: 0 1 0<br>1 0 1<br>0 1 0<br>1 0 1<br>&emsp;&emsp;Output: 2 2 2<br>2 4 2<br>3 4 3<br>1 3 1<br>");

INSERT INTO holes(course,number,description) VALUES('2','18',"Elcomeway otay ethay inalfay olehay inyay isthay oursecay. Welcome to the final hole in this course. I can't say that I am surprised that you made it this far, but this challenge is weird. Given a string convert the string to pig latin. Here are the rules:<br>&emsp;1. Words beginning with consonants, take all the consonants before the first vowel, move them to the end of the word, and add 'ay'. (latin -> atinlay)<br>&emsp;2. If a word begins in a vowel, y included, add 'yay' to the end. (example -> exampleyay)<br>Don't worry about capital letters, I made it a little bit easier for you.<br><br>Example: <br>&emsp;&emsp;Input: convert this sentence to latin of the pigs<br>&emsp;&emsp;Output: onvertcay isthay entencesay otay atinlay ofyay ethay igspay");

INSERT INTO holes(course, number, description) VALUES('1','0',"Driving Range: <br>This is the driving range for the x86 course, here you can come in and test your skills or just figure out what works and what does not. As long as the code is valid it will run and be scored. You also have the ability to set the starting values in registers as well as send in a starting char/int array. The register can be input with any decimal, hex, or binary value, you must have the values correctly formated if they are hex or binary. Such as, having '0x' for hex and '0b' for binary. For an int array only decimal values are allowed and must be comma seperated. The array is stored at memory address 0x600000.");

INSERT INTO courses(id, language, image, syntax, description) VALUES('3', 'C-Extended', '/images/c.jpg', 'c_cpp', 'This is the Extended C course, this builds off of the original c course and has a variety of challenges repurposed from our previous codegolf site. Enjoy!');

INSERT INTO holes(course, hole, description) VALUES('3', '0', 'Same as the original c course's Driving range, here you can practice to your hearts content, all input will be passed in through stdin. As long as the program runs successfully you will get a success. Have fun');

INSERT INTO holes(course,number, description) VALUES('3','1','Bank Transactions<br><hr style="border:2px dashed #000;"><br><br>A local bank has asked you to build a transaction resolution system.  It will<br>work as follows.<br><br>   1. You will be given a list of accounts and their balances in the form:<br><br>      #12345:$99.12<br><br>      Where the first #N is the account number and the $N.NN is the balance.<br>      Account numbers will always be between 4 and 8 digits.  Balances will<br>      always be positive, and always represented as a floating point number<br>      defined to two decimal places.  There may be an arbitrary number of<br>      accounts.<br><br>   2. You will then be given a list of transactions in the form:<br><br>      #12345->#98765:$12.34<br><br>      Where the -> means that the first account is sending money to the<br>      second account, and the dollar value represents the amount sent.  The<br>      account numbers and dollar values will follow the same rules from above.<br>      There may be an arbitrary number of transactions.<br><br>   3. You must then print out a list of final account balances, ordered by<br>      balance in *descending* order, and in the same format that you read<br>      them in.<br><br><br>Example<br><hr style="border:2px dashed #000;"><br>If your program reads the input:<br><br>#12345:$56.75<br>#98765:$22.11<br>#12345->#98765:$23.45<br><br>It should output:<br><br>#98765:$45.56<br>#12345:$33.30<br><br><br>');

INSERT INTO holes(course,number, description) VALUES('3','2','Greater Gap<br><hr style="border:2px dashed #000;"><br><br>A gap is found in a string if two consecutive characters ascii values are<br>farther than 2 apart. For example the string "ACBDF" has no gap greater<br>than 2 apart, as the string "AbCD" has a large gap between the ascii value<br>for \'A\' and for \'b\'. In this challenge you will read an arbitrary number of<br>strings on STDIN and should output "yes" or "no" to whether there was a gap<br>found. Input will only consist of alphabetic characters a-zA-Z.<br><br>Example<br><hr style="border:2px dashed #000;"><br>If your program reads the input:<br>ACBDF<br>BBBBBBBBBBBBBBBBBBBBBBBB<br>bazyx<br>acegikmoq<br>BAcD<br><br>It should output:<br>yes<br>yes<br>no<br>yes<br>no<br><br><br>');

INSERT INTO holes(course,number, description) VALUES('3','3','GenCyber<br><hr style="border:2px dashed #000;"><br><br><br>This challenge is for GenCyber2019 campers!<br><br>You will be given an 8-character string on stdin followed by a single <br>newline (\n).  The string will always be "GenCyber", but with one character<br>replaced with something incorrect; for instance "GenC7ber".<br><br>Your job is to print the index of the incorrect character (starting from 0), <br>the incorrect chracter, and the correct character for that position, seperated<br>by colons, and followed by a newline (\n).<br><br>Example<br><hr style="border:2px dashed #000;"><br>If your program reads the input:<br>GenCyFer<br><br>It should output:<br>5:F:b<br><br>Or, if your program reads the input:<br>%enCyber<br><br>It should output:<br>0:%:G<br><br>Or, if your program reads the input:<br>GenCybez<br><br>It should output:<br>7:z:r<br><br><br>');

INSERT INTO holes(course,number, description) VALUES('3','4','Palindromes<br><hr style="border:2px dashed #000;"><br><br>A palindrome is a string that reads the same forwards or backwards.  For<br>instance, the strings "racecar" and "1234321" are both palindromes.  In this<br>challenge you will read an arbitrary number of strings on STDIN and should<br>ouput whether the string is a palindrome, followed by a colon, and then the<br>sum of the ascii values of each character in the string.<br><br>Example<br><hr style="border:2px dashed #000;">If your program reads the input:<br><br>ABCBA<br>AB22BA<br>hello<br><br>It should output:<br><br>yes:329<br>yes:362<br>no:532<br><br>Because "ABCBA" is a palindrome and its character sum is: 65+66+67+66+65=329<br>etc...<br><br><br>');

INSERT INTO holes(course,number, description) VALUES('3','5','GenCyber 2!<br><hr style="border:2px dashed #000;"><br><br>This challenge involves finding the N\'th prime number.  You will be given<br>a single integer N, and you must print the N\'th prime number (followed by a<br>newline).  N will be counted from 1, and the first prime number is two.<br>In other words, the list of possibilities is...<br><br>1:2<br>2:3<br>3:5<br>4:7<br>5:11<br>6:13<br>7:17<br>etc...<br><br><br>Example<br><hr style="border:2px dashed #000;"><br>If your program reads the input:<br>12<br><br>It should output:<br>37<br><br><br>Or if it reads the input:<br>23<br><br>It should output:<br>83<br><br><br><br>');

INSERT INTO holes(course,number, description) VALUES('3','6','Run Length Encoding<br><hr style="border:2px dashed #000;"><br><br>Run Length Encoding (RLE) is a lossless data compression algorithm in which<br>runs of identical characters in a stream of data are represented as a single<br>character and a run length.  To avoid ambiguity, for the sake of this task, each<br>character/length set will be represented as "%N$C", where "N" is a decimal integer<br>of arbitrary length, and "C" is a single character in the range 0x20-0x7e.<br><br>For instance...<br><br>rle("XXXXYYYZZzzzzzzzzzzzzzzzzzzzz") -> "%4$X%3$Y%2$Z%20$z"<br>rle("AAAAAaaawwwwwwwwwwwwe!") -> "%5$A%3$a%12$w%1$e%1$!"<br><br>Similarly, the process can be reverse...<br><br>unrle("%12$*%1$1%1$2%1$3%1$4") -> "************1234"<br>unrle("%23$$") -> "$$$$$$$$$$$$$$$$$$$$$$$"<br><br>Your program will be given a series of newline seperated strings in the form:<br>e ...<br>d ...<br>e ...<br>d ...<br>d ...<br>e ...<br>e ...<br>...etc...<br><br>If the line begins with "e ", the rest of the data should be RLE-encoded.  If<br>the line begins with "d ", the rest of the data should be RLE-decoded.  Your<br>program should print each answer on a newline.<br><br><br><br>Example<br><hr style="border:2px dashed #000;"><br>If your program reads the input:<br>e aaaaBBBBcccc<br>d %13$z%3$q%1$b<br>e A<br>d %10$?%5$Z<br><br>It should output:<br>%4$a%4$B%4$c<br>zzzzzzzzzzzzzqqqb<br>%1$A<br>??????????ZZZZZ<br><br><br><br><br>');

INSERT INTO holes(course,number, description) VALUES('3','7','C + VI = 106<br><hr style="border:2px dashed #000;"><br><br>Thanks/credit to Shawn Zwach for this challenge!<br><br>This challenge is designed with our fantastic 150 students in mind again, and<br>still only requires basic C knowledge to complete. Your program will read from<br>stdin until input stops. Each line will contain two integers represented by<br>Roman numerals (subtractive notation) separated by an operator for addition(+),<br>subtraction(-), or multiplication(*). There may be any number of leading or<br>trailing spaces surrounding the numbers. For each line of input, you must print<br>one line of output with the result of the operation as a number followed by a<br>new line. Once all operations are completed, print the sum of the result of all<br>ops followed by a newline. The largest integer you must handle on either side<br>of an operator is 300. There will be at most 100 lines of input.<br><br><br>Example<br><hr style="border:2px dashed #000;"><br>If your program reads the input:<br><br>XXIX * III<br>   CXL - IX<br>CCVII + VII<br> X + X<br>    II *III<br> IV - V<br><br>It should output:<br><br>87<br>131<br>214<br>20<br>6<br>-1<br><br><br><br>');

INSERT INTO holes(course,number, description) VALUES('3','8','Postfix (RPN) Calculator<br><hr style="border:2px dashed #000;"><br><br>From Wikipedia...<br><br>Reverse Polish notation (RPN) is a mathematical notation in which every<br>operator follows all of its operands ... for instance, to add 3 and 4, one<br>would write "3 4 +" rather than "3 + 4". If there are multiple operations,<br>the operator is given immediately after its second operand; so the expression<br>written "3 - 4 + 5" in conventional notation would be written "3 4 - 5 +"<br>in RPN: 4 is first subtracted from 3, then 5 added to it.<br><br> -- https://en.wikipedia.org/wiki/Reverse_Polish_notation<br><br><hr style="border:2px dashed #000;"><br>Your task is to write a program that solves RPN expressions. These expressions<br>will be given to the program on STDIN (user input), one-per-line, seperated by<br>a single newline character (\n).  They will only contain single-digit numbers<br>(i.e. 0-9, nothing larger), but may be of arbitrary length and complexity. Your<br>program should read each in, and then output a single integer and a newline as<br>a result.  It must handle five operators: + , -, *, /, %. That is, addition,<br>subtraction, multiplication, integer division, and modulo.<br><br>For example, if your program read in...<br><br>62+<br>92-8+<br>57+9-34*+7%<br>78+99*+3/<br><br>Then it should output...<br><br>8<br>15<br>1<br>32<br><br><br>');

INSERT INTO holes(course,number, description) VALUES('3','9','Student ID Number Verification<br><hr style="border:2px dashed #000;"><br><br>Thanks/credit to Evan Bolt for this challenge!<br><br>DSU is thinking about switching to new student ID scheme.  Under the new<br>scheme, student ID\'s would have the following format requirements:<br><br> - Must be either 7, 8, or 9 digits long<br> - Must NOT begin with a 0 (zero)<br> - Must NOT contain two consecutive identical digits (i.e. 9877653 is invalid)<br> - The sum of all the digits must NOT be a multiple of 7 or 11<br><br>Your jobs is to write a program that takes a list of ID\'s on stdin and print<br>either "valid" or "invalid" for each.  Both the input numbers, and your<br>output data should each be newline seperated.<br><br><br>Example<br><hr style="border:2px dashed #000;"><br>If your program reads the input:<br><br>1111111<br>34712346<br>25<br>891367829<br>0458193<br>9247281<br><br>It should output:<br><br>invalid<br>valid<br>invalid<br>valid<br>invalid<br>invalid<br><br>This is because:<br><br>1111111    : has consecutive identical digits<br>34712346   : follows all the rules<br>25         : is too short<br>891367829  : follows all the rules<br>0458193    : begins with a leading zero<br>9247281    : 9+2+4+7+2+8+1 = 33 is a multiple of 11<br><br><br><br>');

INSERT INTO holes(course,number, description) VALUES('3','10','Parabola Zeros<br><hr style="border:2px dashed #000;"><br><br>This problem is base off the problem created by Kyle Korman for the DSU Programming Competition.<br><br>You\'re doing some homework, and you realize how nice it would be to have a<br>program that tells you how many "intersections" a parabola has with<br>a linear function. You settle on just inputting coefficiens for everything, <br>because who cares if anyone else can understand your program?<br><br>The first input will contain three integers: A, B, and C. They<br>relate to the parabola in the form, y = Ax^2 + Bx + C. The line after this<br>will contain two integers D and E. They relate to the line in the form,<br>y = Dx + E. The range for A, B, and C are between -25 to 25 and the,<br>range for D and E is -10000 to 10000.<br><br>Given the equations return how many times the two intersect.<br><br>Example<br><hr style="border:2px dashed #000;"><br>If your program reads the input:<br>16 -1 -23<br>103 -3657<br><br>It should output:<br>0<br><br>Or, if your program reads the input:<br>-23 25 0<br>807 6647<br><br>It should output:<br>1<br><br>Or, if your program reads the input:<br>-21 -5 -20<br>8746 -2909<br><br>It should output:<br>2<br><br><br>');

CREATE TABLE `challenges` (
  `hole` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `value` int(11) DEFAULT NULL,
  `course` int(11) NOT NULL,
  PRIMARY KEY ('hole','user','course')
) ENGINE=InnoDB AUTO_INCREMENT=592 DEFAULT CHARSET=utf8mb4;
