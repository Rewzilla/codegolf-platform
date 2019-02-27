
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
int magic, bin, hex, dec;
struct list{
	long long unsigned val;
	struct list *next;
};

struct list *head;

struct list *createnode(){

	struct list *tmp = malloc(sizeof(struct list));
	tmp->next = NULL;
	return tmp;
}

int checkpal(unsigned long long val, int base){

	unsigned long long forward = val;
	unsigned long long reversed = 0;
	unsigned char digit;

	while(val > 0){
		digit = val % base;
		reversed = reversed * base + digit;
		val = val / base;
	}
	if(forward == reversed)
		return 1;
	return 0;
}

void createeverything(){

	long long unsigned decbinary[34] ={0x1bc1ef07b, 0x25714a3a9, 0x44c6db191, 0x78feabf8f, 0x1177405dd1, 0x19d5111573, 0x1fc98e327f, 0x11f5654d5f1, 0x14933019925, 0x15768382dd5, 0x1a1657d4d0b, 0x1a1b8823b0b, 0x1d1a4d64b17, 0x5241a8ac125, 0x692ca229a4b, 0x6a01afac02b, 0x8a05e97a051, 0x1f0d2952961f, 0x1f63c000078df, 0x350af34b3d42b, 0x65f6ccd99b7d3, 0xb2ff5666aff4d, 0x25271ed2de3929, 0x26706f2d3d8399, 0x40f10df7d84781, 0x7929d8808dca4f, 0x83baf8241f5dc1, 0x85b038241c0da1, 0xc6c8a081051363, 0x23cb824309074f1, 0x459fb7aaaf6fcd1, 0x61a5d7abeaf5d2c3, 0x864409d81b902261, 0x96fc9a1bd8593f69};
	long long unsigned hexbinary[33] = {0x5777202222027775, 0x5777205555027775, 0x5777207777027775, 0x5777220000227775, 0x5777222222227775, 0x5777225555227775, 0x5777227777227775, 0x5777250000527775, 0x5777252222527775, 0x5777255555527775, 0x5777257777527775, 0x5777270000727775, 0x5777272222727775, 0x5777275555727775, 0x5777277777727775, 0x5777500000057775, 0x5777502222057775, 0x5777505555057775, 0x5777507777057775, 0x5777520000257775, 0x5777522222257775, 0x5777525555257775, 0x5777527777257775, 0x5777550000557775, 0x5777552222557775, 0x5777555555557775, 0x5777557777557775, 0x5777570000757775, 0x5777572222757775, 0x5777575555757775, 0x5777577777757775, 0x5777700000077775, 0x5777702222077775};
	long long unsigned dechexs[32] = {0x6432c2346, 0x6a7dfd7a6, 0x6b36a63b6, 0x704c2c407, 0x78dbfbd87, 0x942080249, 0xa34d9d43a, 0xab38083ba, 0xbe69a96eb, 0xd33b5b33d, 0x5ad9229da5, 0x12998d89921, 0x17be5a5eb71, 0x1a4b202b4a1, 0x23465256432, 0x272ef7fe272, 0x318f2a2f813, 0x72c9d1d9c27, 0xd052989250d, 0xfb34c6c43bf, 0x2907c77c7092, 0x169e87878e961, 0x1cf6c373c6fc1, 0x1dac4a0a4cad1, 0x2e6767e7676e2, 0x5edb5c1c5bde5, 0x121dd4664dd121, 0x71b03844830b17, 0x73efb8118bfe37, 0xe5a09411490a5e, 0xfb1002222001bf, 0x52d3b89698b3d25};
	
	head = createnode();
	head->val = 0;//only number I found to be palindromic for everything.
	hex = bin = magic = dec = 1;
	struct list * tmp = head;
	srand(time(0));
	int ran = rand()%75+25;
	int test;
	while(ran--){
		tmp->next = createnode();
		tmp = tmp->next;
		switch(rand()%4){
			case 0:
				tmp->val = decbinary[rand()%34];
				bin++;
				dec++;
				magic++;
				break;
			case 1:
				tmp->val = hexbinary[rand()%33];
				hex++;
				bin++;
				magic++;
				break;
			case 2:
				tmp->val = dechexs[rand()%32];
				hex++;
				dec++;
				magic++;
				break;
			case 3://random number have to test in case they actually get a random palindrome
				tmp->val = rand();
				tmp->val <<= 32;
				tmp->val += rand();
				test = 0;
				if(checkpal(tmp->val, 2)){
					test++;
					bin++;
				}
				if(checkpal(tmp->val, 10)){
					test++;
					dec++;
				}
				if(checkpal(tmp->val, 16)){
					test++;
					hex++;
				}
				if(test > 1)
					magic++;
				break;
		}
	}

}
	//decimal will not work 

void setup() {//A magical palindrome is a phrase I just made up (which is good/bad news for you) eax points to the start of a linked list, and each node holds one value easy right, well each value is a 64 bit value. You are probably wondering what makes this so magical, well the answer is the base the palindrome is tested. So your problem is to return into eax the total number of values that are a palindrome in multiple bases at once, ie. base 2 and 16, base 10 and 16, etc... in ebx put a total of all numbers that are palindromes in base 2, in ecx a total of all numbers that are palindromes in base 16, and in edx a total of all the numbers that are palindromes in base 10

	createeverything();
	eax = 0x650000;
	unsigned int address;
	for(int i = 0;head != NULL;i++){
		
		memcpy(mem+0x50000-i*0x50, &head->val, 8);
		if(head->next == NULL)
			address = 0;
		else
			address =0x650000-(i*0x50+0x50);
		memcpy(mem+0x50000-i*0x50+0x8, &address, 4);
		head = head->next;
	}

}

bool verify() {
	
	return eax == magic
	       	&& ebx == bin
	       	&& ecx == hex
		&& edx == dec;

}


