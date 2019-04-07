
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
int num;
struct nodes{
	int *distance;
};

struct nodes **list;

struct nodes* createnode(){
	
	struct nodes *tmp = malloc(sizeof(struct nodes));
	return tmp;
}

void creategraph(){
	list = malloc(num*sizeof(struct nodes*));
	for(int i = 0; i < num;i++){
		list[i] = createnode();
		list[i]->distance = malloc(num*sizeof(int));//gives array for distance between each.
	}
	int tmp;
	int nodes;
	for(int i = 0; i < num; i++){//set it up to where everynode is connected to everynode but distances are different for each.
		for(int j = 0; j < num; j++){
			if(j == i){
				list[i]->distance[j] = 0;
				continue;
			}
			list[i]->distance[j] = rand() % 150;
		}	
	}
}

int *totals;
int fsp(int node){
	int val = 9999999;
	int check = 1;
	totals[node] = 1;
	for(int i = 0; i < num; i++)
		if(!totals[i]){
			check = 0;
		}
	if(check){
		totals[node] = 0;
		return 0;
	}
	int tmp ;
	for(int i = 1; i < num; i++){
		if(totals[i])
			continue;
		tmp = list[node]->distance[i];
		tmp += fsp(i);
		if(tmp < val)
			val = tmp;
	}
	totals[node] = 0;
	return val;
	
}

void setup() {//You are given a total undirected graph(each node consists of a connection to every other node). Find the shortest path that reaches every node only one time. There are ten nodes and each node contains an integer array of the distances between it and the nth node it connects with. Then the node contains a pointer to a link table containing pointers to each node. Eax points to the first node, put the shortest path into eax when finished.
	num = 10;
	creategraph();
	
	eax = 0x600000;//used as a tmp variable for memcpy
	int values[num];
	for(int i = 0; i < num; i++){
		memcpy(mem+0x25000+0x5000*i, list[i]->distance, num*4);//array of distances
//		memcpy(mem+0x25000+0x5000*i+num*4, &eax, 4);//pointer to array of nodes
		values[i] = 0x625000+0x5000*i;//initialize array for pointer values
	}
	
	memcpy(mem, values, num*4);
	eax = 0x600000;
	
}

bool verify() {

	totals = calloc(num, 4);
	
	return fsp(0)==eax;

}
