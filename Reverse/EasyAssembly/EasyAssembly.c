#include <stdlib.h>
#include <stdio.h>

// gcc -S -fverbose-asm -o EasyAssembly.asm EasyAssembly.c

unsigned int value = 24564753;
int isGood = 12345;

int getInput(void){
        char input[12];

        printf("Hey ! Have you got a password for me ? ");
        fgets(input, 12, stdin);
        return atoi(input);
}

int main(void){
        int input = getInput();

        input = input >> 2;

        if(input == 1337404)
                isGood = 0;

        if(!isGood)
                printf("Well done ! You can validate with the flag Hero{%d}\n", input);

        else
                puts("Argh... Try harder buddy you can do it !");

        return EXIT_SUCCESS;
}
