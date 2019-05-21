
#ifndef _HOLE_H
#define _HOLE_H

#include <stdbool.h>
#include <unicorn/unicorn.h>
#include <string.h>
#include <stdlib.h>
#include <time.h>

#define TEXT_BASE   0x00400000
#define TEXT_SIZE   0x00200000
#define DATA_BASE	0x00600000
#define DATA_SIZE	0x00200000
#define STACK_BASE  0x00800000
#define STACK_SIZE  0x00200000

unsigned int eax, ebx, ecx, edx,
	esi, edi, ebp, esp, eip;

unsigned char mem[DATA_SIZE];

uc_engine *uc;
uc_err err;

int challenges; //used for challenges on holes to test if correct instructions were used

void setup();
bool verify();

static void hook_code(uc_engine *uc, uint32_t address, int size, void *user_data);

bool tests[14];


enum challengevalues{MOV, ADD, ANDOR, ADC, CMPXCHGXCHG, PUSHPOP, RRRRR, SBB, SUB, XADD, XOR, ODD, EVEN, PRINTABLE, EVENODD};

void setbit(int location);
void clearbit(int location);

#endif
