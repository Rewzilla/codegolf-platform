<?php

#used to create dynamic file used on driving range

$template = "
#include <stdbool.h>
#include <unicorn/unicorn.h>
#include \"/var/www/html/courses/1/hole.h\"

extern unsigned int eax, ebx, ecx, edx, esi, edi, ebp, esp;
extern unsigned char mem[0x200000];

void debug(int eax, int ebx, int ecx, int edx, int esi, int edi, int ebp, int esp){
	printf(	\"EAX: 0x%08x EBX: 0x%08x ECX: 0x%08x EDX: 0x%08x,\"		\
		\"ESI: 0x%08x EDI: 0x%08x EBP: 0x%08x ESP: 0x%08x\\n\",	\
		eax, ebx, ecx, edx,							\
		esi, edi, ebp, esp);
}

void setup() {

}

bool verify() {
	debug(eax, ebx, ecx, edx, esi, edi, ebp, esp);
	return 1;
}";

?>

