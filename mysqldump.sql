--
-- Table structure for table `challenges`
--

DROP TABLE IF EXISTS `challenges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `challenges` (
  `hole` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  PRIMARY KEY (`hole`,`user`,`course`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `challenges`
--

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(64) DEFAULT NULL,
  `syntax` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,'32-bit x86','NASM/intel syntax.  Scores calculated based on assembled byte-count, not source code size.  Code will be emulated, thus system calls will not work. (sorry hackers!).','/images/32bit_x86.jpg','assembly_x86'),(2,'C','Good ol\' C!  Code must conform to C99 standard.  Some system calls are blacklisted, but most will work.<br><p style=\"font-weight: bold; color: red;\">UNDER CONSTRUCTION</p>','/images/c.jpg','c_cpp'),(3,'C-Extended','This is the Extended C course, this builds off of the original c course and has a variety of challenges repurposed from our previous codegolf site. Enjoy!','/images/c.jpg','c_cpp');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `holes`
--

DROP TABLE IF EXISTS `holes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `holes` (
  `course` int(11) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `title` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`course`,`number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `holes`
--

LOCK TABLES `holes` WRITE;
/*!40000 ALTER TABLE `holes` DISABLE KEYS */;
INSERT INTO `holes` VALUES (1,0,'Driving Range','This is the driving range for the x86 course, here you can come in and test your skills or just figure out what works and what does not. As long as the code is valid it will run and be scored. You also have the ability to set the starting values in registers as well as send in a starting char/int array. The register can be input with any decimal, hex, or binary value, you must have the values correctly formated if they are hex or binary. Such as, having \'0x\' for hex and \'0b\' for binary. For an int array only decimal values are allowed and must be comma seperated. The array is stored at memory address 0x600000.'),
(1,1,'1337','Put the number 0x1337 in EAX, EBX, ECX, and EDX'),
(1,2,'Array Sumation','EAX contains a pointer to an array of 32-bit signed integers. EBX contains the array length. Put the sum of all elements in EAX, the maximum value in EBX, and the minimum value in ECX.'),
(1,3,'Reversing Text','EAX contains a pointer to a null-terminated string.  Reverse the string in place, so that EAX points to the beginning of the reversed string once complete.'),
(1,4,'Word Count','EAX points to a null-terminated string. Put the number of lines (seperated by \'\\n\') into EAX, the number of words (seperated by \' \' or \'\\n\') into EBX, and the number of characters (total bytes) into ECX.'),
(1,5,'Custom Strcat','EAX and EBX each point to null-terminated strings.  ECX points to an uninitialized buffer of length (strlen(EAX)+strlen(EBX)).  Fill ECX\'s buffer by combining EAX\'s buffer and EBX\'s buffer one character at a time, alternating characters.  For instance, if EAX=\"abc\" and EBX=\"xzy\", ECX should be set to \"axbycz\".  When complete, point EAX to the beginning of the final buffer (that ECX had been pointing to).'),
(1,6,'Tic-Tac-Toe','EAX points to a 2D character array representing a tic-tac-toe game (3x3, i.e. 9 contiguous bytes).  Each character in the array will be one of \'X\', \'O\', or \' \' (space). Put an integer in EAX representing who won (0 for tie, 1 for O, 2 for X). If the character array was {\'X\',\'X\',\'X\',\'O\',\'O\',\' \',\' \',\' \',\' \'}, then the game board would look like this... <pre>\n\nX|X|X\n-+-+-\nO|O| \n-+-+-\n | | \n</pre>\nand the answer would be...\n\nEAX=2'),
(1,7,'3D Array','EAX contains a pointer to a 3D array of uint32\'s (NxNxN, i.e. N*N*N contiguous bytes), EBX contains the width, ECX contains the length, and EDX contains the height. Put the sum of all elements in EAX, the maximum value into EBX, and the minimum value into ECX.'),
(1,8,'Base32 Encode','EAX contains a pointer to a null-terminated string.  EBX contains a pointer to a buffer of sufficient size to solve this challenge.  Base32 encode EAX\'s string and store the result in EBX\'s buffer. Once complete, point EAX to the begining of the final encoded buffer.  Use the standard base32 character set (i.e. [A-Z2-7=]).'),
(1,9,'Base32 Decode','Wasn\'t the last hole fun!  Let\'s do it in reverse now.  EAX contains a pointer to a null-terminated base32 encoded string.  EBX contains a pointer to a buffer of sufficient size to solve this challenge.  Base32 decode EAX\'s string and store the result in EBX\'s buffer. Once complete, point EAX to the begining of the final decoded buffer.  Again, use the standard base32 character set (i.e. [A-Z2-7=]).'),
(1,10,'Linked List Sort','EAX contains a pointer to the first element in a linked list.  Each list element is a structure composed of a signed 32-bit integer followed by a 32-bit pointer to the next list element (example below).  The last list element\'s pointer will be set to NULL.  Sort the list in ascending order according to the integer value.  Make sure that EAX still points to the first element afterward.<pre>\n\nstruct elem {\nint val;\nstruct elem *next;\n}\n\n</pre>'),
(1,11,'Spiral Array','EAX contains a pointer to an NxN 2D uint32 array, and EBX contains N (the height and width of the array).  Fill the array with the numbers 1-N in a spiral pattern, starting in the lower-right corner (i.e. coordinates (N-1,N-1)), and moving clockwise.  For instance, if N=4, your final array would look like...<pre>\n\n[  7,  8,  9, 10]\n[  6, 15, 16, 11]\n[  5, 14, 13, 12]\n[  4,  3,  2,  1]\n\n</pre>'),
(1,12,'Base64 Encode','EAX contains a pointer to a null-terminated string.  EBX contains a pointer to a buffer of sufficient size to solve this challenge.  Base64 encode EAX\'s string and store the result in EBX\'s buffer. Once complete, point EAX to the begining of the final encoded buffer.  Use the standard base64 character set (i.e. [A-Za-z0-9+/=]).'),
(1,13,'Base64 Decode','It\'s your lucky day!  You get to do that last hole in reverse now too!  EAX contains a pointer to a null-terminated base64 encoded string.  EBX contains a pointer to a buffer of sufficient size to solve this challenge.  Base64 decode EAX\'s string and store the result in EBX\'s buffer. Once complete, point EAX to the begining of the final decoded buffer.  Again, use the standard base64 character set (i.e. [A-Za-z0-9+/=]).'),
(1,14,'Two The Power','EAX contains an array of uint32\'s and EBX contains the number of array elements.  Count up how many of the elements are powers of two and put that total in EAX.'),
(1,15,'Bitwise Sort','EAX contains a pointer to an array of 52 uint64\'s.  Sort the array by the number of 1\'s in each number\'s binary representation, ascending.  Numbers with equal numbers of 1\'s in their binary representation should be sorted by numeric value.  Ensure EAX points to the beginning of the array once complete.'),
(1,16,'Handline Structures','EAX contains a pointer to the first element in a linked listed, where each element is defined by the structure below.  The \'type\' field may be one of:\n<ol start=0><li>Integer</li><li>Character</li><li>String</li></ol> Walk the list and build your final answer as follows: <ul><li>If the element is an integer type, add the value of \'i\' to the final answer</li><li>If the element is a character type, multiply \'c\'s value by 8 and add the result to your final answer</li><li> If the element is a string type, multiply each of the characters in \'s\' by 4 and add all of them to your final answer</li></ul>Put this final answer in EAX, the number of integer elements in EBX, the number of character elements in ECX, and the number of string elements in EDX.<pre>\n\nstruct elem {\nint type;\nint i;\nunsigned char c;\nunsigned char *s\nstruct elem *next;\n}\n</pre>(NOTE: 3 bytes of alignment padding exists between \'i\' and \'c\')'),
(1,17,'Magic Palindrome','A \'magic palindrome\' (a phrase we just made up!) is a number which is a palindrome in more than one base.  For instance, the number 26896769862 is a decimal palindrome, but is ALSO a hexidecimal palindrome (0x6432c2346)!  For this challenge, EAX will point to the first node in a linked list of palindromic numbers.  The structure defining each element is listed below.  Walk the list, analyze each, and put the number of magic palindromes in EAX, the number of binary palindromes in EBX, the number of hexidecimal palindromes in ECX, and the number of decimal palindromes in EDX.  (Note: Only base2, base10, and base16 need be considered when checking for magic palindromes.  Other bases may be safely ignored.)<pre>\n\nstruct elem {\nlong long val;\nstruct elem *next;\n}\n</pre>'),
(1,18,'Shortest Path','EAX contains a pointer to an array of pointers to integer arrays. There will be ten pointers, and ten integers in each array, for a total 100 integers arranged as a 10x10 pointer-based 2D array. (see diagram below). Each array represents one of ten nodes in a fully connected graph. Each element in each array represents the \"distance\" to that node from the current node. Compute the total distance of the shortest path starting at node-0 and visiting all nodes once and only once. Once finished, put the total distance in EAX. <img src=\"/images/hole18.png\" width=\"100%\">'),
(2,0,'Driving Range','Welcome to the c driving range here you are able to test your creative solutions, as long as the program is syntatically correct it should run and return the size. You are also able to send in a string through stdin with the input box below. Have Fun!'),
(2,1,'Hello World','Welcome to the first hole in the c course, to get you started here are a couple pointers: every input has an ending newline, every output must also have an ending newline. Otherwise pretty much anything goes for your solution, so Good Luck! Now for your first challenge try to get used to the system by printing \"Hello World!\"'),
(2,2,'Sum of X','Congrats now that you understand what you are doing try to solve this one. Given an int, x, print out the sum of all the numbers between 0 and x, inclusive. <br>Example: <br>&emsp;&emsp;Input: 10<br>&emsp;&emsp;Output: 55'),
(2,3,'SwItCh cAsE','For this hole you are given a string and must swich the case of the characters in the string. Sounds easy right.<br>Example: <br>&emsp;&emsp;Input: CaSe SWap 3A5Y<br>&emsp;&emsp;Output: cAsE swAP 3a5y'),
(2,4,'GCD','For this challenge you will be given two positive integers, what you have to do is return the greatest common divisor between the two numbers. <br>Example: <br>&emsp;&emsp;Input: 246<br>&emsp;&emsp;Output: 888'),
(2,5,'Reverse Text','This is an easy one, given a string return the reverse of it. Remember that strings are all ended by a newline, but this newline is not to be included in the reversal and should stay at the end.<br>Example: <br>&emsp;&emsp;Input: Reverse Me<br>&emsp;&emsp;Output: eM esreveR '),
(2,6,'Word Count','This hole is a simple counting experiment, given a string print out the number of newlines, words, and spaces. For this hole you should count the ending newline as well.<br>Example: <br>&emsp;&emsp;Input: \"This string contains seventy eight characters<br>eleven words<br> and three newlines\"<br>&emsp;&emsp;Output: 78 11 3'),
(2,7,'Largest Sub Number','For this challenge you will be given a number, all you have to do is return the largest number made by deleting one of the digits. Don\'t over think it. Almost forgot to tell you that the number will be larger than zero, not a float, and may not always be an int32, enjoy! <br>Example: <br>&emsp;&emsp;Input: 123<br>&emsp;&emsp;Output: 23'),
(2,8,'HTML Tags','For this challenge your program will be given a list of integers. Each will be positive, and in the range 1 - 1,000,000. The list will be space-seperated and followed by a single newline at the end.<br><br>Your job is to print the same list, but with HTML tags around \"interesting\" numbers. these numbers, and their correspoinding HTML tags are...<br><br> - Prime numbers:&emsp;should be made bold (&lt;b&gt;&lt;/b&gt;)<br> - Perfect squares:&emsp;should be underlined (&lt;u&gt;&lt;/u&gt;)<br><br>The list you print should also be space-seperated and follow the same order as the original list.<br><br>Example: <br>Input: 10 11 12 13 14 15 16 17 18 19 20<div>Output:&nbsp10&nbsp<b>11</b>&nbsp12&nbsp<b>13</b>&nbsp14&nbsp15&nbsp<u>16</u>&nbsp<b>17</b>&nbsp18&nbsp<b>19</b>&nbsp20</div>'),
(2,9,'ROT 13','For this challenge, given a string return the rot13 of the string. You only need to rotate alphabetic characters. Quick and simple, how hard could it really be.<br>Example: <br>&emsp;&emsp;Input: Please rotate me if you could<br>&emsp;&emsp;Output: Cyrnfr ebgngr zr vs lbh pbhyq'),
(2,10,'Selective Reversing','This one may be a bit tougher than the others, but here we go. Given a string reverse all characters found within parenthesis and remove the parenthesis. It\'s that simple so maybe you will not have a tough time after all.<br>Example: <br>&emsp;&emsp;Input: This is (reversed), this is ((reversal) detsen)<br>&emsp;&emsp;Output: This is desrever, this is a nested reversal'),
(2,11,'To Ascii','I hope you can understand binary becuase I am going to throw a binary string at you and you need to return the ascii equivalent.<br>Example: <br>&emsp;&emsp;Input: 01010100011010000110100101110011001000000110100101110011001000000110000100100000010100110111010001110010011010010110111001100111<br>&emsp;&emsp;Output: This is a String'),
(2,12,'Simple Sort','This problem requires a simple solution that everyone should know how to do, given a set of numbers return the numbers back but sorted. You can use whatever algorithm you want, personally though, I prefer the random sort!<br>Example: <br>&emsp;&emsp;Input: 8 9 6 5 7 2 3 8 26 9 30 8<br>&emsp;&emsp;Output: 2 3 5 6 7 8 8 8 9 9 26 30'),
(2,13,'IPv4','You probably have not noticed this yet but so far these holes have been set into a pattern. While this pattern does not matter too much I at least owe it to you to let you know that the holes are going to start being more random and maybe harder depending on your background. With that said lets get started for this challenge you will be given a string, return \'True\' or \'False\' depending on whether this string is a valid IPv4 address.<br>Example: <br>&emsp;&emsp;Input: 192.156.a.-55.123<br>&emsp;&emsp;Output: False'),
(2,14,'Spiral Matrix','That was a pretty easy one, wasn\'t it? Anyways lets get back to jumping randomly to another challenge. For this  challenge you will be given one single number, lets call this number x. Your job is to return an array of numbers x by x. The pattern for this array shall be a spiral matrix, starting in the top left of the array and going clockwise increase the number by one. To keep everyone on the same page put one space between numbers and a newlines at the end. <br>Example: <br>&emsp;&emsp;Input: 5<br>&emsp;&emsp;Output: 1 2 3 4 5<br>16 17 18 19 6<br>15 24 25 20 7<br>14 23 22 21 8<br>13 12 11 10 9'),
(2,15,'Base64 Encode','Ok, now do not get upset this is a fun one. Given a string return the base64 encoded version of the string. Look how easy I was able to describe it, this should be a cake walk. Also, incase you do not know the base64 alphabet is \'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=\'<br>Example: <br>&emsp;&emsp;Input: I am a string<br>&emsp;&emsp;Output: SSBhbSBhIHN0cmluZw=='),
(2,16,'Bitwise Sort','This may be my favorite hole besides 18 *wink wink*, you will be given a set of positive integers and you have to sort them. \'What makes this a hole 16 problem then\', you ask? What an excellent question you have. This will not be a conventional sort. You will sort the numbers first by the number of ones in their binary form, then if these are the same, sort the numbers by the reverse values. Good Luck.<br>Example: <br>&emsp;&emsp;Input: 1024 91210 8675309 9068517 3<br>&emsp;&emsp;Output: 1024 3 91210 9068517 8675309'),
(2,17,'Minesweeper','Now that the tough ones are done lets go with more playful challenges. For this challenge we will be making a minesweeper board. You will be given an array of numbers, made up of 1\'s and 0\'s. This represents the game board, 1\'s are bombs and 0\'s are safe spots, but during the game you are not shown the bombs but the number bombs in the vicinity. So count up all nearby bombs and return the final game board instead.<br>Example: <br>&emsp;&emsp;Input: 0 1 0<br>1 0 1<br>0 1 0<br>1 0 1<br>&emsp;&emsp;Output: 2 2 2<br>2 4 2<br>3 4 3<br>1 3 1<br>'),
(2,18,'Pig Latin','Elcomeway otay ethay inalfay olehay inyay isthay oursecay. Welcome to the final hole in this course. I can\'t say that I am surprised that you made it this far, but this challenge is weird. Given a string convert the string to pig latin. Here are the rules:<br>&emsp;1. Words beginning with consonants, take all the consonants before the first vowel, move them to the end of the word, and add \'ay\'. (latin -> atinlay)<br>&emsp;2. If a word begins in a vowel, y included, add \'yay\' to the end. (example -> exampleyay)<br>Don\'t worry about capital letters, I made it a little bit easier for you.<br><br>Example: <br>&emsp;&emsp;Input: convert this sentence to latin of the pigs<br>&emsp;&emsp;Output: onvertcay isthay entencesay otay atinlay ofyay ethay igspay'),
(3,0,'Driving Range','Same as the original c course\'s Driving range, here you can practice to your hearts content, all input will be passed in through stdin. As long as the program runs successfully you will get a success. Have fun'),
(3,1,'Bank Transactions','A local bank has asked you to build a transaction resolution system.  It will<br>work as follows.<br><br>   1. You will be given a list of accounts and their balances in the form:<br><br>      #12345:$99.12<br><br>      Where the first #N is the account number and the $N.NN is the balance.<br>      Account numbers will always be between 4 and 8 digits.  Balances will<br>      always be positive, and always represented as a floating point number<br>      defined to two decimal places.  There may be an arbitrary number of<br>      accounts.<br><br>   2. You will then be given a list of transactions in the form:<br><br>      #12345->#98765:$12.34<br><br>      Where the -> means that the first account is sending money to the<br>      second account, and the dollar value represents the amount sent.  The<br>      account numbers and dollar values will follow the same rules from above.<br>      There may be an arbitrary number of transactions.<br><br>   3. You must then print out a list of final account balances, ordered by<br>      balance in *descending* order, and in the same format that you read<br>      them in.<br><br><br>Example<br><hr style=\"border:2px dashed #000;\"><br>If your program reads the input:<br><br>#12345:$56.75<br>#98765:$22.11<br>#12345->#98765:$23.45<br><br>It should output:<br><br>#98765:$45.56<br>#12345:$33.30<br><br><br>'),
(3,2,'Greater Gap','A gap is found in a string if two consecutive characters ascii values are<br>farther than 2 apart. For example the string \"ACBDF\" has no gap greater<br>than 2 apart, as the string \"AbCD\" has a large gap between the ascii value<br>for \'A\' and for \'b\'. In this challenge you will read an arbitrary number of<br>strings on STDIN and should output \"yes\" or \"no\" to whether there was a gap<br>found. Input will only consist of alphabetic characters a-zA-Z.<br><br>Example<br><hr style=\"border:2px dashed #000;\"><br>If your program reads the input:<br>ACBDF<br>BBBBBBBBBBBBBBBBBBBBBBBB<br>bazyx<br>acegikmoq<br>BAcD<br><br>It should output:<br>yes<br>yes<br>no<br>yes<br>no<br><br><br>'),
(3,3,'GenCyber','This challenge is for GenCyber2019 campers!<br><br>You will be given an 8-character string on stdin followed by a single <br>newline (\n).  The string will always be \"GenCyber\", but with one character<br>replaced with something incorrect; for instance \"GenC7ber\".<br><br>Your job is to print the index of the incorrect character (starting from 0), <br>the incorrect chracter, and the correct character for that position, seperated<br>by colons, and followed by a newline (\n).<br><br>Example<br><hr style=\"border:2px dashed #000;\"><br>If your program reads the input:<br>GenCyFer<br><br>It should output:<br>5:F:b<br><br>Or, if your program reads the input:<br>%enCyber<br><br>It should output:<br>0:%:G<br><br>Or, if your program reads the input:<br>GenCybez<br><br>It should output:<br>7:z:r<br><br><br>'),
(3,4,'Palindromes','A palindrome is a string that reads the same forwards or backwards.  For<br>instance, the strings \"racecar\" and \"1234321\" are both palindromes.  In this<br>challenge you will read an arbitrary number of strings on STDIN and should<br>ouput whether the string is a palindrome, followed by a colon, and then the<br>sum of the ascii values of each character in the string.<br><br>Example<br><hr style=\"border:2px dashed #000;\">If your program reads the input:<br><br>ABCBA<br>AB22BA<br>hello<br><br>It should output:<br><br>yes:329<br>yes:362<br>no:532<br><br>Because \"ABCBA\" is a palindrome and its character sum is: 65+66+67+66+65=329<br>etc...<br><br><br>'),
(3,5,'GenCyber 2!','This challenge involves finding the N\'th prime number.  You will be given<br>a single integer N, and you must print the N\'th prime number (followed by a<br>newline).  N will be counted from 1, and the first prime number is two.<br>In other words, the list of possibilities is...<br><br>1:2<br>2:3<br>3:5<br>4:7<br>5:11<br>6:13<br>7:17<br>etc...<br><br><br>Example<br><hr style=\"border:2px dashed #000;\"><br>If your program reads the input:<br>12<br><br>It should output:<br>37<br><br><br>Or if it reads the input:<br>23<br><br>It should output:<br>83<br><br><br><br>'),
(3,6,'Run Length Encoding','Run Length Encoding (RLE) is a lossless data compression algorithm in which<br>runs of identical characters in a stream of data are represented as a single<br>character and a run length.  To avoid ambiguity, for the sake of this task, each<br>character/length set will be represented as \"%N$C\", where \"N\" is a decimal integer<br>of arbitrary length, and \"C\" is a single character in the range 0x20-0x7e.<br><br>For instance...<br><br>rle(\"XXXXYYYZZzzzzzzzzzzzzzzzzzzzz\") -> \"%4$X%3$Y%2$Z%20$z\"<br>rle(\"AAAAAaaawwwwwwwwwwwwe!\") -> \"%5$A%3$a%12$w%1$e%1$!\"<br><br>Similarly, the process can be reverse...<br><br>unrle(\"%12$*%1$1%1$2%1$3%1$4\") -> \"************1234\"<br>unrle(\"%23$$\") -> \"$$$$$$$$$$$$$$$$$$$$$$$\"<br><br>Your program will be given a series of newline seperated strings in the form:<br>e ...<br>d ...<br>e ...<br>d ...<br>d ...<br>e ...<br>e ...<br>...etc...<br><br>If the line begins with \"e \", the rest of the data should be RLE-encoded.  If<br>the line begins with \"d \", the rest of the data should be RLE-decoded.  Your<br>program should print each answer on a newline.<br><br><br><br>Example<br><hr style=\"border:2px dashed #000;\"><br>If your program reads the input:<br>e aaaaBBBBcccc<br>d %13$z%3$q%1$b<br>e A<br>d %10$?%5$Z<br><br>It should output:<br>%4$a%4$B%4$c<br>zzzzzzzzzzzzzqqqb<br>%1$A<br>??????????ZZZZZ<br><br><br><br><br>'),
(3,7,'C + VI = 106','Thanks/credit to Shawn Zwach for this challenge!<br><br>This challenge is designed with our fantastic 150 students in mind again, and<br>still only requires basic C knowledge to complete. Your program will read from<br>stdin until input stops. Each line will contain two integers represented by<br>Roman numerals (subtractive notation) separated by an operator for addition(+),<br>subtraction(-), or multiplication(*). There may be any number of leading or<br>trailing spaces surrounding the numbers. For each line of input, you must print<br>one line of output with the result of the operation as a number followed by a<br>new line. Once all operations are completed, print the sum of the result of all<br>ops followed by a newline. The largest integer you must handle on either side<br>of an operator is 300. There will be at most 100 lines of input.<br><br><br>Example<br><hr style=\"border:2px dashed #000;\"><br>If your program reads the input:<br><br>XXIX * III<br>   CXL - IX<br>CCVII + VII<br> X + X<br>    II *III<br> IV - V<br><br>It should output:<br><br>87<br>131<br>214<br>20<br>6<br>-1<br><br><br><br>'),
(3,8,'Postfix (RPN) Calculator','From Wikipedia...<br><br>Reverse Polish notation (RPN) is a mathematical notation in which every<br>operator follows all of its operands ... for instance, to add 3 and 4, one<br>would write \"3 4 +\" rather than \"3 + 4\". If there are multiple operations,<br>the operator is given immediately after its second operand; so the expression<br>written \"3 - 4 + 5\" in conventional notation would be written \"3 4 - 5 +\"<br>in RPN: 4 is first subtracted from 3, then 5 added to it.<br><br> -- https://en.wikipedia.org/wiki/Reverse_Polish_notation<br><br><hr style=\"border:2px dashed #000;\"><br>Your task is to write a program that solves RPN expressions. These expressions<br>will be given to the program on STDIN (user input), one-per-line, seperated by<br>a single newline character (\n).  They will only contain single-digit numbers<br>(i.e. 0-9, nothing larger), but may be of arbitrary length and complexity. Your<br>program should read each in, and then output a single integer and a newline as<br>a result.  It must handle five operators: + , -, *, /, %. That is, addition,<br>subtraction, multiplication, integer division, and modulo.<br><br>For example, if your program read in...<br><br>62+<br>92-8+<br>57+9-34*+7%<br>78+99*+3/<br><br>Then it should output...<br><br>8<br>15<br>1<br>32<br><br><br>'),
(3,9,'Student ID Number Verification','Thanks/credit to Evan Bolt for this challenge!<br><br>DSU is thinking about switching to new student ID scheme.  Under the new<br>scheme, student ID\'s would have the following format requirements:<br><br> - Must be either 7, 8, or 9 digits long<br> - Must NOT begin with a 0 (zero)<br> - Must NOT contain two consecutive identical digits (i.e. 9877653 is invalid)<br> - The sum of all the digits must NOT be a multiple of 7 or 11<br><br>Your jobs is to write a program that takes a list of ID\'s on stdin and print<br>either \"valid\" or \"invalid\" for each.  Both the input numbers, and your<br>output data should each be newline seperated.<br><br><br>Example<br><hr style=\"border:2px dashed #000;\"><br>If your program reads the input:<br><br>1111111<br>34712346<br>25<br>891367829<br>0458193<br>9247281<br><br>It should output:<br><br>invalid<br>valid<br>invalid<br>valid<br>invalid<br>invalid<br><br>This is because:<br><br>1111111    : has consecutive identical digits<br>34712346   : follows all the rules<br>25         : is too short<br>891367829  : follows all the rules<br>0458193    : begins with a leading zero<br>9247281    : 9+2+4+7+2+8+1 = 33 is a multiple of 11<br><br><br><br>'),
(3,10,'Parabola Zeros','This problem is base off the problem created by Kyle Korman for the DSU Programming Competition.<br><br>You\'re doing some homework, and you realize how nice it would be to have a<br>program that tells you how many \"intersections\" a parabola has with<br>a linear function. You settle on just inputting coefficiens for everything, <br>because who cares if anyone else can understand your program?<br><br>The first input will contain three integers: A, B, and C. They<br>relate to the parabola in the form, y = Ax^2 + Bx + C. The line after this<br>will contain two integers D and E. They relate to the line in the form,<br>y = Dx + E. The range for A, B, and C are between -25 to 25 and the,<br>range for D and E is -10000 to 10000.<br><br>Given the equations return how many times the two intersect.<br><br>Example<br><hr style=\"border:2px dashed #000;\"><br>If your program reads the input:<br>16 -1 -23<br>103 -3657<br><br>It should output:<br>0<br><br>Or, if your program reads the input:<br>-23 25 0<br>807 6647<br><br>It should output:<br>1<br><br>Or, if your program reads the input:<br>-21 -5 -20<br>8746 -2909<br><br>It should output:<br>2<br><br><br>'),
(3,11,'Golden','Credit for this challenge goes to Richard Golden (LSU)<br><br>This challenge is slightly different than the original challenge but we will <br>press on. You will be given no input and expected to output the same string<br>every time. A 5*5 string of alternating O\'s and X\'s<br><br>Example<br><hr style=\"border:2px dashed #000;\"><br>If your program reads the input:<br><br><br>It should output:<br><br>OXOXOXOXOX<br>XOXOXOXOXO<br>OXOXOXOXOX<br>XOXOXOXOXO<br>OXOXOXOXOX<br><br>');
/*!40000 ALTER TABLE `holes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (2,'Welcome beta-testers!','Hello and welcome to the ALL NEW codegolf platform!  After tons of participation and positive feedback on the <a href=\"http://codegolf.net/\">old codegolf platform</a> we\'ve decided to rebuild it, bigger and better than ever.  Improvements include...<br><ul><li>In-browser code editor and submission!  No more shell scripts</li><li>Support for multiple \"courses\" (languages).</li><li>Support for 18 separate \"holes\" (challenges) in each course.</li><li>\"Par\" calculation for each hole (average of all users\' best submissions)</li><li>The ability to change your password or delete your account</li><li>Many more good things to come.</li></ul>In the future, we plan to add...<br><ul><li>C</li><li>64-bit x86 Assembly</li><li>ARM Assembly</li><li>MIPS Assembly</li><li>Others?</li></ul>For now, this beta is ONLY open to DSU students.  In the future we plan to open it up to all CAE schools as a way to promote collaboration between universities.  Until then, please test anything and everything, and provide feedback about what you like or would like to see changed.  Feedback can be sent directly to Andrew (andrew dot kramer at dsu dot edu | @Rewzilla).  All feedback, positive and negative is appreciated!<br><br>Also, a big thanks to Logan Stratton (@LMS) for creating the x86 and C Courses!<br><br>Enjoy!','2018-12-11 02:05:15');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solves`
--

DROP TABLE IF EXISTS `solves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hole` int(11) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `course` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;


