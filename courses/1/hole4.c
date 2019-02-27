
#include <stdbool.h>
#include <unicorn/unicorn.h>
#include "hole.h"

//
// INSTRUCTIONS:
//
// Edit the setup() and verify() functions below according to the challenge.
//
// When emulation starts, all registers will be initialized to the values
// in these globals, and the "mem" buffer will be placed in memory at the
// address 0x00600000.  If you need registers to point to data, put the data
// in that array and calculate the necessary address from 0x00600000.
//

extern unsigned int eax, ebx, ecx, edx, esi, edi;
extern unsigned char mem[0x200000];
int lines, words, characters;

void makestring(){
	
	srand(time(0));
	lines = 0;
	char *wordlist[40] = {"This", "is", "my", "random", "sentence", "generator", "list", "I", "think", "my", "plan", "should", "work", "but", "who", "knows", "anyways", "if", "there", "are", "other", "words", "or", "a", "different", "and", "better", "way", "becomes", "available", "please", "do", "not", "hesitate", "to", "change", "this", "method", "thanks", "extra"};
	words = rand()%40+20;//20 to 50 words
	char *string = malloc(1024);
	string[0] = 0;
	
	for(int i = 0; i < words; i++){
		strcat(string, wordlist[rand()%40]);
		if(!(rand()%3))//1/3 chance at newline or space
		{
			lines++;
			strcat(string, "\n");
		}
		else
			strcat(string, " ");

	}	
	characters = strlen(string);//not sure if the null byte at the end counts as a character but default is no
	memcpy(mem, string, strlen(string)+1);
}


void setup() {//Eax points to a null terminated string, Put into eax the number of newlines, into ebx the number of words, and into ecx the number of characters

	makestring();
	eax = 0x600000;

}

bool verify() {

	return eax == lines
	       	&& ebx == words
	       	&& ecx == characters;

}
