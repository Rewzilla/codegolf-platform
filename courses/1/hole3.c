
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
unsigned char *string;

void setup() {
	srand(time(0));
	eax = 0x600000;
	int size = rand()% 40 + 10;
	string = malloc(size+1);
	for(int i = 0; i < size; i++){
		string[i] = rand()%254+1;
	}
	string[size] = 0;
	
	memcpy(mem, string, strlen(string)+1);//grab that null byte
	
}

bool verify() {
	int size = strlen(string);
	
	for(int i = 0; i < size/2; i++){
		string[i] += string[size-i-1];
		string[size-i-1] = string[i] - string[size-i-1];
		string[i]-= string[size-i-1];

	}
	
	return !strncmp(mem+eax-0x600000, string, size);
		
}
