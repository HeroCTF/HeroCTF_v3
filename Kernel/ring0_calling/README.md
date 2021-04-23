# Ring0 Calling

### Category

Kernel

### Description

I like to compile my kernels. And I like to do it the old way.
And I also like doing it 50x times because I forgot an option.

Can you get the flag ?

Format : **Hero{flag}**  
Author : **SoEasY & iHuggsy**

### Write up

After looking in the "backup" folder, we see that there is a syscall_tbl which lists all the syscalls callable by the system.
Number 442 is the __NR_HERO and Seems to be interesting !

We just have to call it and see what happens.

### Solution by SoEasY - in assembly (nasm) 

```nasm
BITS 64

section .data
        good db `Syscall executed!\nCheck dmesg now :)\n`
        good_len equ $-good

section .text
        global _start

_start:
        mov rax, 442
        syscall

_message:
        mov rax, 1
        mov rdi, 1
        mov rsi, good
        mov rdx, good_len
        syscall

_exit:
        mov rax, 60
        mov rdi, 0
        syscall
```

You can then assemble and link the program : 

```bash
$ nasm -f ELF64 -o shellcode.o shellcode.nasm
$ ld -o shellcode shellcode.o
```
Then execute it on the VM : 
```bash
$ ./shellcode                 
Syscall executed!
Check dmesg now :)
```

### Solution by iHuggsy - in C

```C
#define __NR_hero 442

long hero_syscall(void){
    return syscall(__NR_hero);
}

int main(int argc, char *argv[]){
    long activity;
    activity = hero_syscall();

    if(activity < 0){
        perror("Seems like it's a fail !\n");
    }

    else{
        printf("Seems ok, try to dmesg\n");
    }
    return 0;
}
```

Then, if we dmesg :

> [   24.598590] Hero{0h_d4mn_y0u_4r2_th3_sysc4ll_m4st3r_!!!}


### Flag

Hero{0h_d4mn_y0u_4r2_th3_sysc4ll_m4st3r_!!!}
