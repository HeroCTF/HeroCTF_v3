#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <errno.h>
 
int main() {
  FILE *file;
  int chr;
  int count;
   
  if((file = fopen("flag.txt", "r")) == NULL)
      fprintf(stderr, "WTF ? An error ? Impossible, I'm the best\n");

    while((chr = getc(file)) != EOF)
      fprintf(stdout, "%c", chr);
    fclose(file);
  exit(0);
}