#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#define SUDOKU_SIZE 9

/* -----------------------------------*/
int compfill(char x[SUDOKU_SIZE][SUDOKU_SIZE]){
    int l, m, c = 0;
    
    for(m = 0; m < SUDOKU_SIZE; m++){
        for(l = 0; l < SUDOKU_SIZE; l++)
            if(x[m][l] != ' ')
                c++;
    
    }
    if (c == SUDOKU_SIZE * SUDOKU_SIZE)
        return 1;
    else
        return 0;
}
/* -----------------------------------*/



/* -----------------------------------*/
int checkc(char x[SUDOKU_SIZE][SUDOKU_SIZE], int d, int e, int choice){
    int i, g, h, m, n;

    if(choice == ' ')
        return 1;

    if(choice > '9' || choice < '1'){
        // type number between 1 to 9
        return 0;
    }

    if(d <= 2 && d >= 0){
        g = 0;
        h = 2;
    
    }if(d <= 5 && d >= 3){
        g = 3;
        h = 5;
    
    }if(d <= 8 && d >= 6){
        g = 6;
        h = 8;
    
    }if(e <= 2 && e >= 0){
        m = 0;
        n = 2;
    
    }if(e <= 5 && e >= 3){
        m = 3;
        n = 5;
    
    }if(e <= 8 && e >= 6){
        m = 6;
        n = 8;
    }
    
    for(g = g; g <= h; g++){
        for(m = m; m <= n; m++){
            if(x[g][m] == choice)
                // same number already in box
                return 0;
        }
    }

    for (i = 0; i < SUDOKU_SIZE; i++){

        if(x[d][i] == choice)
            // same number already in row
            return 0;

        else if(x[i][e] == choice)
            // same number already in column
            return 0;
    }
    return 1;
}
/* -----------------------------------*/




/* -----------------------------------*/
void getFlag(char x[SUDOKU_SIZE][SUDOKU_SIZE]){
    char flag[82];
    memset(flag, 0, 81);

    printf("Hero{");
    for (int d = 0; d < SUDOKU_SIZE; d++){
        for (int e = 0; e < SUDOKU_SIZE; e++)
            printf("%c", x[d][e]);
    }
    printf("}\n");
}
/* -----------------------------------*/




/* -----------------------------------*/

int main(int argc, char** argv){

    if(argc < 2){
        printf("Usage : %s <serial>\n", argv[0]);
        exit(EXIT_FAILURE);
    }

    char *ptr = argv[1];

    char x[SUDOKU_SIZE][SUDOKU_SIZE], choice;
    int d, e, com, check;

    for(d = 0; d < SUDOKU_SIZE; d++){
        for(e = 0; e < SUDOKU_SIZE; e++)
            x[d][e]=' ';
    }

    // top left
    x[1][1] = '2';
    x[2][2] = '3';

    // middle left
    x[3][0] = '9';
    x[3][2] = '5';
    x[4][0] = '7';

    // bottom left
    x[6][1] = '5';
    x[6][2] = '6';
    x[7][1] = '1';

    // top middle
    x[0][3] = '5';
    x[0][4] = '4';
    x[0][5] = '6';
    x[2][3] = '9';

    // middle
    x[5][4] = '9';
    x[5][5] = '3';

    // middle bottom
    x[6][5] = '8';
    x[7][4] = '3';
    x[7][5] = '9';

    // top right
    x[0][8] = '9';
    x[1][8] = '7';
    x[2][8] = '4';

    // middle right
    x[3][7] = '7';
    x[4][7] = '2';

    // bottom right
    x[8][6] = '8';
    x[8][8] = '6';

    do{
        d = ((int)*ptr) - '0';
        ptr += 1;

        e = ((int)*ptr) - '0';
        ptr += 1;

        --d;
        --e;

        choice = ptr[0];
        ptr += 1;

        check = checkc(x,d,e,choice);

        if(check != 0)
            x[d][e] = choice;

        com = compfill(x);

    }while(com == 0 && *ptr != '\0');

    if(com == 1){
        puts("\nWell done ! You can validate with this flag : ");
        getFlag(x);
        return EXIT_SUCCESS;
    }else{
        puts("Nope.");
        return EXIT_FAILURE;
    }
}

/*

COMPILATION WITH SSE : gcc -O3 -o WTF WTF.c ; strip WTF 
INPUT : 111127138172183214239243258261275286315326352367371388423442451464476498524531548556565579593616628632647674681695712744757773789791818834846877885892913929937941955962984
FLAG : Hero{178546239429381567563927184935214678741865923682793415256478391814639752397152846}
*/
