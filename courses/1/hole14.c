
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
int total;

int createarray()
{
	total = 0;
	int number = rand()%400+100;
	unsigned int *array = malloc(number*4+4);
	for(int i = 0; i < number; i++){
		if(rand()%2){//make it a power of two
			array[i] = 1<<rand()%32;//create 32 bit power of two number;
			total++;
		}
		else
			array[i] = rand();

	}
	array[number] = 0;
	memcpy(mem, array, number*4+4);
	return number+1;

}


void setup() {//array has ebx number of unsigned integers figure out how many of the nubmers are a power of a power of 2 and put it into eax. Also, no Jarod 0 is not a power of 2

	ebx = createarray();
	eax = 0x600000;
}

bool verify() {
	
	return total == eax;

}
