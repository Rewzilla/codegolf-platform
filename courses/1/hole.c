
#include <stdbool.h>
#include <unicorn/unicorn.h>

#include "hole.h"

extern unsigned int eax, ebx, ecx, edx,
					esi, edi, ebp, esp, eip;

extern uc_engine *uc;
extern uc_err err;

int main(int argc, char *argv[]) {

	FILE *fp, *rp;				// File containing x86 bytes
	size_t sz;				// Size of the file
	unsigned char *code;	// Pointer to the code in memory
	char sran[4];
	int sr;

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

	// Begin emulation.  Run until hlt
	err = uc_emu_start(uc, TEXT_BASE, TEXT_SIZE, 0, 0);
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
	if(verify())
		puts("pass");
	else
		puts("fail");

	return verify();

}
