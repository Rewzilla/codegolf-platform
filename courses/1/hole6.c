
#include <stdbool.h>
#include <unicorn/unicorn.h>
#include "hole.h"
#include <time.h>

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
//changed the hole, did not like the challenge
int wincheck;//variable for who one
int X;
int O;
char board[9];

bool checkboard( int x, int y){
	
	if((board[y] == board[3+y] && board[3+y] == board[6+y])
			||( board[x*3] == board[x*3+1] && board[x*3] == board[x*3+2] )
			|| (x==y && board[0] == board[4] && board[4] == board[8]) 
			|| (x+y==2 && board[2] == board[4] && board[4] == board[6]))
		return 1;
	return 0;
}

void createboard(){
	
	for(int i = 0; i < 9; i++)
		board[i] = ' ';
	int x, y;
	X=0;
	O=0;
	for(int i = 0; i < 9; i++){
		
		while(1){
			x = rand()%3;
		       	y = rand()%3;
			if(board[x*3+y] == ' ')
				break;
		}
		if(i%2){
			board[x*3+y] = 'X';
			X+=x*3+y;
		}
		else {
			board[x*3+y] = 'O';
			O+=x*3+y;
		}
		if(checkboard(x, y)){
			wincheck = i%2+1; //X = 2, O = 1, Tie = 0
			break;
		}
	}
	
}

void setup() {//eax holds a pointer to a tic tac toe game board string, each place is represented by either a 'X', 'O', or ' '. Find who won the match, if there was a winner, and store that in eax, 0 for tie, 1 for O, and 2 for X. Also, find the sum of each players indexes and store them in ebx for X and ecx for O

	createboard();
	eax = 0x600000;
	memcpy(mem, board, 9);
	
}

bool verify() {//check for who wins or tie also check for sum of players

	return eax == wincheck//who won 0 for tie, 1 for o, 2 for x
		&& ebx == X//sum of indexes of x
		&& ecx == O;//sum of indexes of o

}




