#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <sys/types.h>
#include <string.h>

void do_a_barrel_roll()
{
    char* barrel = "AY CARAMBA !";
    strstr("AY", barrel);

    random();
    
}

int main(int argc, char **argv)
{
    setbuf(stdout, 0);
    printf("Please, give us your thoughts about our client service :\n>>>");

    char who[350];
    gets(who);

    int32_t buffer_length = strlen(who);

    printf("I am now going to translate your sentence to computer");
    for (int happy; happy < buffer_length; ++happy)
    {
        printf("%02x", who[happy]);
    }

    // execve("/bin/ls", NULL, NULL);
    printf("We actually don't care about what you think. Bye.\n");


}