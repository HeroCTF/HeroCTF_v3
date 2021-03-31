#include "TargetConditionals.h"
#include <stdio.h>
#include <string.h>

#if TARGET_CPU_ARM64
    // WTFISTHISFUCKINGFILEFORMAT
    #define MSG "CUZVTWPXYGOPLLVVLJFRGRZBGU"
    const char KEY[8] = {0xb9, 0xea, 0xb1, 0xc7, 0x1d, 0x7, 0x68, 0x8};

#elif TARGET_CPU_X86_64
    // IMSORRYBUTTHISISNOTTHEFLAG
    #define MSG "KRLIJGMIWYMB[HWZPTMNZTTSCL"
    const char KEY[8] = {0xbd, 0xee, 0xb6, 0xde, 0xe, 0xb, 0x6e, 0x0};

#endif

void welcome(){
        printf("██╗  ██╗███████╗██████╗  ██████╗  ██████╗████████╗███████╗\n"
               "██║  ██║██╔════╝██╔══██╗██╔═══██╗██╔════╝╚══██╔══╝██╔════╝\n"
               "███████║█████╗  ██████╔╝██║   ██║██║        ██║   █████╗  \n"
               "██╔══██║██╔══╝  ██╔══██╗██║   ██║██║        ██║   ██╔══╝  \n"
               "██║  ██║███████╗██║  ██║╚██████╔╝╚██████╗   ██║   ██║     \n"
               "╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝ ╚═════╝  ╚═════╝   ╚═╝   ╚═╝     \n");
        printf("=================== fatBoy (by SoEasY) ===================\n\n");
}

char* _(const char* msg){
    char xored[9];
    
    xored[0] = KEY[0] ^ 0xff;
    xored[1] = KEY[1] ^ 0xab;
    xored[2] = KEY[2] ^ 0xe5;
    xored[3] = KEY[3] ^ 0x8a;
    xored[4] = KEY[4] ^ 0x5c;
    xored[5] = KEY[5] ^ 0x44;
    xored[6] = KEY[6] ^ 0x20;
    xored[7] = KEY[7] ^ 0x47;
    xored[8] = '\0';
    
    int msgLen = (int) strlen(msg);
    int keyLen = (int) strlen(xored);
    int i, j;
 
    char newKey[msgLen], encryptedMsg[msgLen];
 
    // generating new key by repeating it
    for(i = 0, j = 0; i < msgLen; ++i, ++j){
        if(j == keyLen)
            j = 0;
        newKey[i] = xored[j];
    }
    newKey[i] = '\0';
 
    // encryption
    for(i = 0; i < msgLen; ++i)
        encryptedMsg[i] = ((msg[i] + newKey[i]) % 26) + 'B';
    encryptedMsg[i] = '\0';
 
    puts(encryptedMsg);
    return strdup(encryptedMsg);
}

int main(int argc, const char * argv[]) {
    char input[64];
    
    welcome();
    printf("You can't find my flag but you can try : ");
    fgets(input, 62, stdin);
    
    input[strcspn(input, "\n")] = 0;
    
    char* rep = _(input);
    if(!strcmp(MSG, rep)){
            printf("\nWell done !\nYou can (or maybe not?) validate this challenge with the flag Hero{%s} :D\n", input);
        
    }else{
        printf("\nNope... Try harder :)\n");
    }

    return 0;
}
