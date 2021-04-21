#include <stdio.h>
#include <unistd.h>
#include <stdlib.h>
#include <sys/ptrace.h>
#include <sys/wait.h>
#include <sys/syscall.h>
#include <sys/reg.h>

#define BAD_SYSCALL __NR_execve
#define BAD_SYSCALL2 __NR_execveat


int main(int argc, char *argv)
{
    pid_t child;
    int status, syscall_nr;

    child = fork();
    if (child == 0) 
    {
        /* In child. */
        ptrace(PTRACE_TRACEME, 0, NULL, NULL);
        execl("./x", NULL, NULL);
        // not reached
    }

    /* In parent. */
    while (1) 
    {
        wait(&status);

        /* Abort loop if child has exited. */
        if (WIFEXITED(status) || WIFSIGNALED(status))
            break;

        /* Obtain syscall number from the child's process context. */
        syscall_nr = ptrace(PTRACE_PEEKUSER, child, 4 * ORIG_EAX, NULL);
        

        if (syscall_nr != BAD_SYSCALL && 
            syscall_nr != BAD_SYSCALL2 && 
            syscall_nr >= 0) 
        {
            /* Allow system call. */
            ptrace(PTRACE_SYSCALL, child, NULL, NULL);
        } else {
            /* Terminate child. */
            printf("Child wants to execute system call %d: ", syscall_nr);
            printf("not allowed. Goodbye my boy :(.\n");
            ptrace(PTRACE_KILL, child, NULL, NULL);
        }
    }

    exit(EXIT_SUCCESS);
}