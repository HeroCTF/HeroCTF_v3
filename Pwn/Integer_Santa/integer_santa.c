#include <stdio.h>
#include <stdlib.h>
#include <string.h>

void welcome(){
        printf("██╗  ██╗███████╗██████╗  ██████╗  ██████╗████████╗███████╗\n"
               "██║  ██║██╔════╝██╔══██╗██╔═══██╗██╔════╝╚══██╔══╝██╔════╝\n"
               "███████║█████╗  ██████╔╝██║   ██║██║        ██║   █████╗  \n"
               "██╔══██║██╔══╝  ██╔══██╗██║   ██║██║        ██║   ██╔══╝  \n"
               "██║  ██║███████╗██║  ██║╚██████╔╝╚██████╗   ██║   ██║     \n"
               "╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝ ╚═════╝  ╚═════╝   ╚═╝   ╚═╝     \n");
        printf("================ Integer Santa (by SoEasY) ===============\n\n");
        fflush(stdout);
}

int main(){

        char *flag = "Hero{W31rd_0v3rFl0w_f0r_Xm4s}";
        char* ptr = flag;
	unsigned int tours = 1;
        unsigned int valeur = 0xcafebabe;
        char input[64];

        welcome();
        printf("Ho ho ho... It's Integer Santa !\nTell me what do you wan for Xmas kiddo (you can ask for %d gift only !!!) : ", tours);
        fgets(input, 100, stdin);

        if (strstr(input, "flag") != NULL){
                puts("NO !!! I WILL NEVER GIVE YOU THE FLAG !!!!!!!!!");
                exit(EXIT_FAILURE);
        }

        for(int i=0; i < tours; i++){
                if(i > strlen(flag))
                        break;
                printf("%.*s\n", strlen(input) == 0 && valeur==0xcafebabe, ptr);
		ptr += 1;
        }
        puts("Alright ! I'll tell my pixies :)\nSee u kiddo !");

        return EXIT_SUCCESS;
}
