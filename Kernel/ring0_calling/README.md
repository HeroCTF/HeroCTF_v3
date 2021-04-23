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

After looking in the `/backups` folder, we see that there is a syscall_tbl which lists all the syscalls callable by the system.
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

You can then base64 your compiled binary, run the Qemu VM, go to /mnt/share and use vim to paste our base64 into a temporary file. Then base64 -d this file to a new file and execute your binary !

```bash
$ cd /mnt/share
$ vim temp
$ base64 -d temp > shellcode
$ chmod +x shellcode
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

Then, if we use the `dmesg` command we can see at the end :

```
[...]
[    1.864165] Freeing unused kernel image (initmem) memory: 1192K
[    1.867397] Write protecting the kernel read-only data: 20480k
[    1.870326] Freeing unused kernel image (text/rodata gap) memory: 2032K
[    1.871748] Freeing unused kernel image (rodata/data gap) memory: 576K
[    1.872798] Run /init as init process
[    1.872816]   with arguments:
[    1.872835]     /init
[    1.872851]   with environment:
[    1.872869]     HOME=/
[    1.872878]     TERM=linux
[    1.966004] busybox (65) used greatest stack depth: 14800 bytes left
[    2.021415] mount (68) used greatest stack depth: 14472 bytes left
[    2.128192] tsc: Refined TSC clocksource calibration: 3094.174 MHz
[    2.128740] clocksource: tsc: mask: 0xffffffffffffffff max_cycles: 0x2c99c85147f, max_idle_ns: 440795276187 ns
[    2.130438] clocksource: Switched to clocksource tsc
[    2.390885] input: ImExPS/2 Generic Explorer Mouse as /devices/platform/i8042/serio1/input/input3
[    8.315779] ls (73) used greatest stack depth: 14280 bytes left
[   44.505155] random: crng init done
[   79.864089] Hero{0h_d4mn_y0u_4r2_th3_sysc4ll_m4st3r_!!!}
[   79.867214] binary (85) used greatest stack depth: 14136 bytes left
```


### Flag

Hero{0h_d4mn_y0u_4r2_th3_sysc4ll_m4st3r_!!!}
