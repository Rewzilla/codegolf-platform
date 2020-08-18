
#include <stdbool.h>
#include <unicorn/unicorn.h>

#include "hole.h"

extern unsigned int eax, ebx, ecx, edx,	esi, edi, ebp, esp, eip;

extern uc_engine *uc;
extern uc_err err;


int main(int argc, char *argv[]) {

	FILE *fp, *rp;				// File containing x86 bytes
	size_t sz;				// Size of the file
	unsigned char *code;	// Pointer to the code in memory
	char sran[4];
	int sr;
	challenges = 0;

	// Ensure we got exactly two command line arguments
	if(argc != 2)
		return -1;

	// Open the code file
	fp = fopen(argv[1], "r");
	if(!fp)
		return -1;

	// Check the file size
	fseek(fp, 0, SEEK_END);
	sz = ftell(fp);
	fseek(fp, 0, SEEK_SET);

	// Allocate memory for the code
	code = malloc(sz);
	if(!code)
		return -1;

	// Read the file into memory
	fread(code, sizeof(unsigned char), sz, fp);
	fclose(fp);

	// Initialize the Unicorn Engine
	err = uc_open(UC_ARCH_X86, UC_MODE_32, &uc);
	if(err != UC_ERR_OK)
		return -1;

	//seed the rand
	rp = fopen("/dev/urandom", "r");
	if(!rp)
		srand(time(0));
	else{
		//read(rp, sran, 4);
		sr = fgetc(rp);
		sr += fgetc(rp) << 8;
		sr += fgetc(rp) << 16;
		sr += fgetc(rp) << 24;
		srand(sr);
	}

	for(int x = 0; x < 18; x++)
		tests[x] = 0;
	// Setup the environment
	setup();

	// Set initial register values
	// eax, ebx, ecx, edx, edi, esi come from globals
	ebp = STACK_BASE + STACK_SIZE - 4;
	esp = STACK_BASE + STACK_SIZE - 4;
	eip = TEXT_BASE;
	uc_reg_write(uc, UC_X86_REG_EAX, &eax);
	uc_reg_write(uc, UC_X86_REG_EBX, &ebx);
	uc_reg_write(uc, UC_X86_REG_ECX, &ecx);
	uc_reg_write(uc, UC_X86_REG_EDX, &edx);
	uc_reg_write(uc, UC_X86_REG_ESI, &esi);
	uc_reg_write(uc, UC_X86_REG_EDI, &edi);
	uc_reg_write(uc, UC_X86_REG_EBP, &ebp);
	uc_reg_write(uc, UC_X86_REG_ESP, &esp);
	uc_reg_write(uc, UC_X86_REG_EIP, &eip);

	// Map space for text, data, and stack segments
	uc_mem_map(uc, TEXT_BASE, TEXT_SIZE, UC_PROT_ALL);
	uc_mem_map(uc, DATA_BASE, DATA_SIZE, UC_PROT_ALL);
	uc_mem_map(uc, STACK_BASE, STACK_SIZE, UC_PROT_ALL);

	// Write the code into the text segment
	uc_mem_write(uc, TEXT_BASE, code, sz);

	// Write memory array into data segment
	uc_mem_write(uc, DATA_BASE, mem, DATA_SIZE);

	// Create hook for challenges
	uc_hook hook;
	uc_hook_add(uc, &hook, UC_HOOK_CODE, hook_code, NULL, 1, 0);

	// Begin emulation.  Run until hlt
	err = uc_emu_start(uc, TEXT_BASE, TEXT_BASE+sz, 0, 0);
	if(err)
		return -1;

	// Pull registers from emulation environment
	uc_reg_read(uc, UC_X86_REG_EAX, &eax);
	uc_reg_read(uc, UC_X86_REG_EBX, &ebx);
	uc_reg_read(uc, UC_X86_REG_ECX, &ecx);
	uc_reg_read(uc, UC_X86_REG_EDX, &edx);
	uc_reg_read(uc, UC_X86_REG_ESI, &esi);
	uc_reg_read(uc, UC_X86_REG_EDI, &edi);
	uc_reg_read(uc, UC_X86_REG_EBP, &ebp);
	uc_reg_read(uc, UC_X86_REG_ESP, &esp);
	uc_reg_read(uc, UC_X86_REG_EIP, &eip);

	// Pull memory from emulation environment
	uc_mem_read(uc, DATA_BASE, mem, DATA_SIZE);

	// Check the result
	if(verify()){
		//check bytes for even, odd, and printable
		int direction = 0;
		for(int x = 0; x < sz; x++){

			if(!tests[ODD])

				if(code[x] % 2 == 1)
					setbit(ODD);
				else
					clearbit(ODD);

			if(!tests[EVEN])
				
				if(code[x] % 2 == 0)
					setbit(EVEN);
				else
					clearbit(EVEN);
			
			if(!tests[PRINTABLE])
				
				if(code[x] >= 0x20 && code[x] <= 0x7f)
					setbit(PRINTABLE);
				else
					clearbit(PRINTABLE);

			if(!tests[EVENODD])
				if(x == 0 && code[x]%2==1)
					direction = 1;//odd first
					
				if(((!direction && x % 2 == 0 && code[x] % 2 == 0)\
				|| (!direction && x % 2 && code[x] % 2)) || \
				((direction && x%2 && code[x]%2==0) || \
				 (direction && x % 2 == 0 && code[x] % 2)))
					setbit(EVENODD);
				else
					clearbit(EVENODD);
		
		}
	
		printf("%d\n", challenges);

	}
	else
		puts("fail");

	return verify();

}

static void hook_code(uc_engine *uc, uint32_t address, int size, void *user_data)//used for code hooks
{
	unsigned char tmp, tmp2;

	uc_mem_read(uc, address, &tmp, 1);

	if(tmp == 0x66)//word identifier
		uc_mem_read(uc,++address, &tmp, 1);

	//Mov
	if(!tests[MOV]){
		if((tmp >= 0x88 && tmp <= 0x8e) || \
		(tmp >= 0xa0 && tmp <= 0xa3) || \
		(tmp >= 0xb0 && tmp <= 0xbf) || \
		tmp == 0xc6 || tmp == 0xc7)
			setbit(MOV);
		else
			clearbit(MOV);
	}
	//Add
	if(!tests[ADD])

		if(tmp >= 0x00 && tmp <= 0x05)
		       setbit(ADD);
		else if(tmp >= 0x80 && tmp <= 0x83){
			uc_mem_read(uc, address+1, &tmp2, 1);
			if(tmp2 >= 0xc0 && tmp2 <= 0xc7)
				setbit(ADD);
			else
				clearbit(ADD);
		}
		else
			clearbit(ADD);

	//AND0R
	if(!tests[ANDOR])

		if((tmp >= 0x20 && tmp <= 0x25) || (tmp >= 0x08 && tmp <= 0x0d))
			setbit(ANDOR);
		else if(tmp >= 0x80 && tmp <= 0x83){
			uc_mem_read(uc, address+1, &tmp2, 1);
			if((tmp2 >= 0xc9 && tmp2 <= 0xcf) || (tmp2 >= 0xe0 && tmp2 <= 0xe7))
				setbit(ANDOR);
			else
				clearbit(ANDOR);
		}
		else
			clearbit(ANDOR);

	//ADC
	if(!tests[ADC])

		if(tmp >= 0x10 && tmp <= 0x15)
			setbit(ADC);
		else if(tmp >= 0x80 && tmp <= 0x83){
			uc_mem_read(uc, address+1, &tmp2, 1);
			if(tmp2 >= 0xd0 && tmp2 <= 0xd7)
				setbit(ADC);
			else
				clearbit(ADC);
		}
		else
			clearbit(ADC);

	//CMPXCHGXCHG
	if(!tests[CMPXCHGXCHG])
		//xchg
		if(tmp == 0x86 || tmp == 0x87 || (tmp >= 0x90 && tmp <= 0x97))
			setbit(CMPXCHGXCHG);
		//cmpxchg
		else if(tmp == 0x0f){
			uc_mem_read(uc, address+1, &tmp2, 1);
			if(tmp2 == 0xb0 || tmp2 == 0xb1 || tmp == 0xc7)
				setbit(CMPXCHGXCHG);
			else
				clearbit(CMPXCHGXCHG);
		}
		else
			clearbit(CMPXCHGXCHG);

	//PUSHPOP
	if(!tests[PUSHPOP])
		//push/pop single opcodes
		//why do these all have to be spread out
		if(tmp == 0xff || (tmp >= 0x50 && tmp <= 0x60) || tmp == 0x6a \
		|| tmp == 0x68 || tmp == 0x0e || tmp == 0x16 \
		|| tmp == 0x1e || tmp == 0x06 || tmp == 0x8f \
		|| tmp == 0x58 || tmp == 0x1f || tmp == 0x07 \
		|| tmp == 0x17)
			setbit(PUSHPOP);
		else if(tmp == 0x0f){
			uc_mem_read(uc, address+1, &tmp2, 1);
			if(tmp2 == 0xa0 || tmp2 == 0xa8 \
			|| tmp2 == 0xa1 || tmp2 == 0xa9)
				setbit(PUSHPOP);
			else
				clearbit(PUSHPOP);
		}
		else
			clearbit(PUSHPOP);

	//RRRRR //no idea why it is called this
	//rcr, sar, rcl
	if(!tests[RRRRR])

		if((tmp >= 0XD1 && tmp <= 0xD3) || tmp == 0xc0 || tmp == 0xc1){
			uc_mem_read(uc, address+1, &tmp2, 1);
			if((tmp2 >= 0xd0 && tmp2 <= 0xdf) || (tmp2 >= 0xf8 && tmp2 <= 0xff))
				setbit(RRRRR);
			else
				clearbit(RRRRR);
		}
		else
			clearbit(RRRRR);

	//SBB
	if(!tests[SBB])

		if(tmp >= 0x18 && tmp <= 0x1d)
			setbit(SBB);
		else if(tmp >= 0x80 && tmp <= 0x83){
			uc_mem_read(uc, address+1, &tmp2, 1);
			if(tmp2 >= 0xd8 && tmp2 <= 0xdf)
				setbit(SBB);
			else
				clearbit(SBB);
		}
		else
			clearbit(SBB);

	//SUB
	if(!tests[SUB])

		if(tmp >= 0x28 && tmp <= 0x2d)
			setbit(SUB);
		else if(tmp >= 0x80 && tmp <= 0x83){
			uc_mem_read(uc, address+1, &tmp2, 1);
			if(tmp2 >= 0xe8 && tmp2 <= 0xef)
				setbit(SUB);
			else
				clearbit(SUB);
		}

	//XADD
	if(!tests[XADD])

		if(tmp == 0x0f){
			uc_mem_read(uc, address+1, &tmp2, 1);
			if(tmp2 >= 0xc0 && tmp2 <= 0xc1)
				setbit(XADD);
			else
				clearbit(XADD);
		}

	//XOR
	if(!tests[XOR])

		if(tmp >= 0x30 && tmp <= 0x34)
			setbit(XOR);
		else if(tmp >= 0x80 && tmp <= 0x83){
			uc_mem_read(uc, address+1, &tmp2, 1);
			if(tmp2 >= 0xf0 && tmp2 <= 0xf7)
				setbit(XOR);
			else
				clearbit(XOR);
		}


}

void setbit(int location){
	
	challenges |= 1 << location;
}

void clearbit(int location){
	
	challenges &= ~(1 << location);
	tests[location]=1;
}

