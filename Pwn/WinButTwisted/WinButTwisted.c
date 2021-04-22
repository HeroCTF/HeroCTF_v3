#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <fcntl.h>

int UNLOCKED = 0;


void set_lock()
{
    printf("Setting lock !");
    UNLOCKED = 1;
}

void shell()
{
    printf("In shell function ! ");
    if (UNLOCKED == 1)
    {
        char *buf;
        int fd = open("pwn/flag", O_RDONLY);
        read(fd, &buf, 50);
        printf("%.*s", 50, &buf);
    }

    
}

void hello_hero(int hero)
{
    printf("It looks like that's something a Hero would say\n");
}

void look_like()
{
    printf("Please keep being one. :)\n");
}

int main()
{
    setbuf(stdout, 0);
    int (*look)() = look_like;
    int (*hello)() = hello_hero;
    char buffer[32];

    printf("What would a hero say ?\n>>> ");
    fgets(buffer, 44, stdin);
    hello();
    look();

}


