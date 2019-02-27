
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
struct design{
	int val;
	struct design *next;
};

struct design *head;
extern unsigned int eax, ebx, ecx, edx, esi, edi;
extern unsigned char mem[0x200000];

struct design* createnode(){
	struct design* tmp = malloc(sizeof(struct design));
	tmp->val = rand() % 1000;
	tmp->next = NULL;
	return tmp;
}

void sort(int num){
	
       	struct design*	tmp = head;
	int changer = 1;
	while(changer){
		changer=0;
		tmp = head;
		while(tmp->next != NULL){
			if(tmp->next->val < tmp->val){
				changer=1;
				tmp->next->val += tmp->val;
				tmp->val = tmp->next->val - tmp->val;
				tmp->next->val -= tmp->val;
			}
			tmp = tmp->next;
		}

	}
}


void createll(){
	
	srand(time(0));
	int num = rand() % 40 + 10;
	head = createnode();
	struct design* tmp = head;
	for(int i = 0; i < num; i++){
	
		tmp->next = createnode();
		tmp = tmp->next;
	}
	tmp = head;
	int location = 0x700000;
	int i;
	for(i = 0; tmp != NULL; i-=0x50, tmp=tmp->next){
		memcpy(0x100000+mem+i, &tmp->val, 4);
		location -= 0x50;
		memcpy(0x100000+mem+i+4, &location, 4);//so the golfer can't just walk by increasing by 4 has to jump through the next address;
	}
	
	i+=0x50;
	
	for(int j = 4; j < 8; j++){
		mem[0x100000+i+j] = 0;	
	};

	sort(num);

}

void setup() {//eax points to the first node of a linked list, your job is to sort the linked list however you want. Put the address of the head node back into eax when your done.
	srand(time(0));
	eax = 0x700000;
	createll();
}

bool verify() {

	int walker = eax;
	while(1){
		if((head == NULL && walker != 0) || (walker == 0 && head != NULL))
			return 0;
		else if(head == NULL && walker == 0)
			break;
		if(memcmp(&mem[walker-0x600000], &head->val, 4))
			return 0;
		
		memcpy(&walker, &mem[walker-0x600000+4], 4);
		head = head->next;
	}		
	return 1;
}
