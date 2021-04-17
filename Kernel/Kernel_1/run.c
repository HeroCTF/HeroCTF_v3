#include <unistd.h>

/* setuid script wrapper */

int main()
{
    char *argv[] = { ".run_vm", NULL };
    execve(argv[0], argv, NULL);
    return 0;
}
