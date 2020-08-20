
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

unsigned long long array[52];
int counts[52];

void createarray(){
	int counter;
	for(int i = 0; i < 52; i++){
		counter = 0;
		array[i] = (long long)(rand() + rand())*RAND_MAX + rand() + rand();
		memcpy(mem+i*8, &array[i], 8);
		for(int j = 0; j < 64; j++){
			if(array[i]>>j&1)
				counter++;
		}
		counts[i]=counter;
	}

}

void sort(){
	long long tmp;
	for(int i = 0; i < 52; i++){
		for(int j = 0; j < 51;j++){
			if(counts[j] >= counts[j+1]){
				if(counts[j] == counts[j+1] && array[j] < array[j+1])
					continue;
						
				counts[j] += counts[j+1];
				counts[j+1] = counts[j]-counts[j+1];
				counts[j] -= counts[j+1];
				tmp = array[j];
				array[j] = array[j+1];
				array[j+1] = tmp;
			}
		}
	}
}

void setup() {//eax hold a pointer to an integer array with 52 values in it sort it by the number of 1's in it's binary representation, also the numbers are 64 bit, eax should point to the beginning when done(If the bit count is the same sort by value)

	createarray();
	eax = 0X600000;

}

bool verify() {

	sort();
	
	for(int i = 0; i < 52; i++){
		if(memcmp(mem+eax-0x600000+i*8, &array[i], 8))
			       return 0;	
	}
	return 1;
}
