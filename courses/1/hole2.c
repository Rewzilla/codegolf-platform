
#include <stdbool.h>
#include <memory.h>
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
int total, max, min;

void setup() {
	
	srand(time(0));
	eax = 0x00600000;
	ebx = rand()%80 + 20;//20-100
	
	int *arr = malloc(ebx*4);
	int tmp;
	total = 0;
	max = -1;
	min = 250;
	for(int i = 0; i < ebx; i++){
		tmp = rand() % 250;
		arr[i] = tmp;
		total += tmp;
		if(tmp > max)
			max = tmp;
		if(tmp < min)
			min = tmp;

	}
	memcpy(mem, arr, ebx * sizeof(int));

}

bool verify() {
	
	return eax == total
		&& ebx == max
		&& ecx == min;

}
