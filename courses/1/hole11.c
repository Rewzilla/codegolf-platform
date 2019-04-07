
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

int *final;
int size;

void creatematrix(int x,int y){
	
	int gap = 0;
	int xpos = x-1;
	int ypos = y-1;
	int xdir = 0;
	int ydir = -1;
	for(int i = 1; i <x*y+1; i++,xpos+=xdir, ypos+=ydir){
		final[xpos*x + ypos] = i;
		
		
		if(ypos == y-1-gap && xpos == x-2-gap){
			xdir = 0;
			ydir = -1;
			gap++;
		}
		else if(ypos == gap && xpos == x-1-gap){
			xdir = -1;
			ydir = 0;
		}
		else if(xpos == gap && ypos == gap){
			xdir = 0;
			ydir = 1;
		}
		else if(ypos == y-1-gap && xpos == gap){
			xdir = 1;
			ydir = 0;
		}	
			
	}
}

void setup() {
//from a request your goal is to create a spiral matrix x*x, eax holds a pointer to the address to store the final matrix and ebx will hold x. The first number should go in the bottom right of the matrix and then continue clockwise

	eax = 0x600000;
	ebx = rand() % 15 + 5;
	size = ebx*ebx;
	final = malloc(ebx*ebx*4);
	creatematrix(ebx,ebx);
}

bool verify() {

	return !memcmp(mem + eax-0x600000, final, size*4);

}
