
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

struct list{
	int type;
	int i;
	unsigned char c;
	unsigned char *s;
	struct list* next;
};

struct list* head;
int ints, chars, strings;
int total;
struct list* createnode(){
	
	struct list* tmp = malloc(sizeof(struct list));
	tmp->type = rand()%3;
	int size = rand()%25+5;
	tmp->s= malloc(size);
	switch(tmp->type){
		case 0:
			ints++;
			tmp->i = rand() % 0x25000;
			
			total+=tmp->i;
			break;
		case 1:
			chars++;
			tmp->c = rand()%255;
			total += tmp->c*8;
			break;
		case 2:
			strings++;
			for(int i = 0; i < size-1; i++){
				tmp->s[i] = rand()%254+1;
				total+=tmp->s[i]*4;
			}
			tmp->s[size-1] = 0;
	}
	tmp->next = NULL;
	return tmp;
}

void createll(){
	ints = chars = strings = total = 0;
	int num = rand()%15+10;
	head = createnode();
	struct list* tmp = head;
	for(int i = 0; i < num; i++){
		tmp->next = createnode();
		tmp = tmp->next;
	}
}

void setup() {//eax holds a pointer to a linked list head node, the struct is designed with int type, int i, char c, null terminated char *s, and struct *next. Based on the type represents what other values have been filled, 0 = int, 1 = char, 2 = string. if the type is an int add the int to your total, if it is a char multiply the character by 8 and add that value to you total, and if the value is a string multiply every character in the string by 4 and add that to your total. Put the total for the entire linked list in eax, the number of ints in ebx, the number of chars in ecx, and the number of strings in edx;
	createll();
	eax = 0x650000;
	int stringloc = 0x700000;
	int location = eax - 0x1000;
	
	for(int i = 0; head != NULL; i++, head=head->next,stringloc+=0x500, location-=0x1000){
		memcpy(mem+0x50000-0x1000*i, &head->type, 4);
		memcpy(mem+0x50000-0x1000*i+4, &head->i,4);
		memcpy(mem+0x50000-0x1000*i+8, &head->c,1);
		memcpy(mem+0x50000-0x1000*i+12, &stringloc, 4);//check up on this
		memcpy(mem+stringloc-0x600000, head->s, strlen(head->s)+1);
			
		
		if(head->next == NULL)
			location = 0;

		memcpy(mem+0x50000-0x1000*i+16, &location, 4);

	}

}

bool verify() {
	
	return eax == total
	       	&& ebx == ints
	       	&& ecx == chars
	       	&& edx == strings;

}
