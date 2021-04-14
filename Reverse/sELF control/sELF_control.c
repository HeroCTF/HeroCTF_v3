#include <stdio.h>
#include <stdlib.h>
#include <uuid/uuid.h>
#include <unistd.h>

// gcc -o sELF_control sELF_control.c -luuid

int main(){

	printf("██╗  ██╗███████╗██████╗  ██████╗  ██████╗████████╗███████╗\n");
	printf("██║  ██║██╔════╝██╔══██╗██╔═══██╗██╔════╝╚══██╔══╝██╔════╝\n");
	printf("███████║█████╗  ██████╔╝██║   ██║██║        ██║   █████╗  \n");
	printf("██╔══██║██╔══╝  ██╔══██╗██║   ██║██║        ██║   ██╔══╝  \n");
	printf("██║  ██║███████╗██║  ██║╚██████╔╝╚██████╗   ██║   ██║     \n");
	printf("╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝ ╚═════╝  ╚═════╝   ╚═╝   ╚═╝     \n");
	printf("================ sELF control (by SoEasY) ================\n\n"); 

	uuid_t binuuid;
	int ch;
	char *uuid = malloc(37);
	char execute[88], xxd[48];

	uuid_generate_random(binuuid);
	uuid_unparse(binuuid, uuid);

	FILE *original, *copy;

	original = fopen("READFLAG", "rb");
	copy = fopen(uuid, "wb");

	if(original == NULL){
		printf("[-] Impossible to open the original file.\n");
		exit(1);
	}

	while((ch = fgetc(original)) != EOF)
		fputc(ch, copy);

	fclose(original);
	fclose(copy);

	for(int i=0; i<2; i++){
		
		FILE *file = fopen(uuid, "r+");
		long int offset1 = 3;
		unsigned int val1;

		if(file == NULL){
			printf("[-] Impossible to open the temporary file.\n");
			exit(1);
		}
	
		printf("\nPosition of the byte to patch in hex (example: %02X) : ", rand()%32);
		scanf("%x", &offset1);
		printf("Value to put at this offset in hex (example: %02X) : ", rand()%32);
		scanf("%x", &val1);

		fseek(file, offset1, SEEK_SET);
		fputc(val1, file);
	
		fclose(file);
	}

	// printf("\n[+] ELF header : \n");
	// sprintf(xxd, "xxd %s | head\0", uuid);
	// system(xxd);

	printf("\n[+] Execution : \n");
	sprintf(execute, "chmod +x %s && ./%s\0", uuid, uuid);
	system(execute);
	
	remove(uuid);
	return 0;
}
