
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
int max;
int min;

void setup() {
//eax points to a 3d array with the size x, y, and z stored in ebx, ecx, and edx respectively. find the total, maximum, and minimum and store them in eax, ebx, and ecx, again respectively.
	
	srand(time(0));
	int x = rand() % 90 + 10; // 10-100
	int y = rand() % 90 + 10; 
	int z = rand() % 90 + 10;
	total = 0;
	int tmp;
	min = 1000;
	max = -1;
	ebx = x;
	x *= y*z;
	int *arr = malloc(x*4);
	for(int i = 0; i < x; i++){
		tmp = rand() % 100000;
		total += tmp;
		arr[i] = tmp;
		if(tmp > max)
			max = tmp;
		if(tmp < min)
			min = tmp;
	}

	eax = 0x600000;
	ecx = y;
	edx = z;
	memcpy(mem, arr, x*4);

}

bool verify() {
	
	return eax == total 
		&& ebx == max 
		&& ecx == min;

}
