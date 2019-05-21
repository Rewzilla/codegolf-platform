<?php

#used to create dynamic file used on driving range

$template = "
#include <stdbool.h>
#include <unicorn/unicorn.h>
#include \"/var/www/html/courses/1/hole.h\"

extern unsigned int eax, ebx, ecx, edx, esi, edi, ebp, esp;
extern unsigned char mem[0x200000];

void debug(int eax, int ebx, int ecx, int edx, int esi, int edi, int ebp, int esp){
	unsigned int stack;
		
	printf(	\"EAX: 0x%08x EBX: 0x%08x ECX: 0x%08x EDX: 0x%08x,\"		\
		\"ESI: 0x%08x EDI: 0x%08x EBP: 0x%08x ESP: 0x%08x,\",	\
		eax, ebx, ecx, edx,							\
		esi, edi, ebp, esp);
	printf( \"Stack:,\");
	
	if(esp >= STACK_BASE && esp <= STACK_BASE + STACK_SIZE && ebp >= STACK_BASE && ebp <= STACK_BASE + STACK_SIZE)

		while(1){
			uc_mem_read(uc, esp, &stack, 4);
			printf( \"%p: 0x%08x%s\", esp, stack, (esp==ebp?\" <= EBP,\":\",\"));
			if(esp>=0x9ffffc)
				break;
			esp+=4;
		}
	else
		printf(\"Stack offset is not correct\");
}

void setup() {

}

bool verify() {
	debug(eax, ebx, ecx, edx, esi, edi, ebp, esp);
	return 1;
}";

?>

