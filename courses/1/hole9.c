
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

unsigned char *string1;
unsigned char *final;

void base32encode(){//easiest way to do this
	final = malloc(100);
	char *base32 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ234567";
	unsigned char character;
	int location = 8;
	int shiftval;
	int j = 0;
	unsigned char tmp = 0;
	for(int i = 0; i < strlen(string1); j++){

		character = string1[i];

		shiftval = 8-location;
		character <<= shiftval;
		character >>= 3;
		if(location > 4){
			location-=5;
			if(location < 1){
				location += 8;
				i++;
			}
		}
		else{
			i++;
			tmp = string1[i];
			shiftval = 11 - shiftval;
			tmp >>= shiftval;
			character ^= tmp;
			location += 3;
		}
		final[j]=base32[character];
	}
	tmp = 8 - j%8;
	if(tmp < 7)
		for(int i = 0; i < tmp; i++,j++)
			final[j] = '=';
	final[j] = 0;
}

void createstring(){

	int size = rand()%25+25;
	string1 = malloc(size+1);
	for(int i = 0; i < size; i++)
		string1[i] = rand()%254+1;
	string1[size];
	base32encode();

}

void setup() {
//wasn't that last hole fun now lets decode that string we just made, eax points to in and ebx points to the final location, same character sets. When you finished move into eax the strings location
	srand(time(0));

	createstring(); 
	eax = 0x600000;
	ebx = 0x650000;
	memcpy(mem, final, strlen(final)+1);

}

bool verify() {
	
	return !strncmp(mem+eax-0x600000, string1, strlen(string1)+1);

}
