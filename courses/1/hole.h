
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

void setup();
bool verify();

#define DEBUG() printf(								\
		"EAX:%08x EBX:%08x ECX:%08x EDX:%08x\n"		\
		"ESI:%08x EDI:%08x EBP:%08x ESP:%08x\n",	\
		eax, ebx, ecx, edx,							\
		esi, edi, ebp, esp							\
	);

#endif
