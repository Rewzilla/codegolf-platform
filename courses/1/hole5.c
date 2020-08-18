
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
unsigned char *string1, *string2;
void setup() {//combine the strings one character at a time
	int size = rand()%25+25;
	string1 = malloc(size+1);
	string2 = malloc(size+1);
	for(int i = 0; i < size; i++){
		string1[i] = rand()%254+1;
		string2[i] = rand()%254+1;
	}
	string1[size] = 0;
	string2[size] = 0;

	eax = 0x600000;
	ebx = 0x650000;
	ecx = 0x700000;
	memcpy(mem, string1, strlen(string1)+1);
	memcpy(mem+0x50000, string2, strlen(string2)+1);
}

bool verify() {

	unsigned char *string3 = malloc(strlen(string1)*2+1);
	for(int i = 0, j = 0; i < strlen(string1); i++, j++){
		string3[j++] = string1[i];
		string3[j] = string2[i];
	}

	return !strncmp(mem+eax-0x600000, string3, strlen(string3));

}
