# EasyAssembly

### Category

Reverse

### Description

Don't worry, this one is quite easy :)

Format : **Hero{flag}**<br>
Author : **SoEasY**

### Files

- EasyAssembly.asm

### Write up

The .asm file was compiled with gcc with the option `-S`, to make it assembly and not a binary code, and with the `-fverbose-asm` option which will help the comprehension of the assembly by commenting it with the corresponding C code !

We can see here the main function :

```nasm
main:
.LFB7:
        .cfi_startproc
        endbr64
        pushq   %rbp    #
        .cfi_def_cfa_offset 16
        .cfi_offset 6, -16
        movq    %rsp, %rbp      #,
        .cfi_def_cfa_register 6
        subq    $16, %rsp       #,
# EasyAssembly.c:16:    int input = getInput();
        call    getInput        #
        movl    %eax, -4(%rbp)  # tmp85, input
# EasyAssembly.c:18:    input = input >> 2;
        sarl    $2, -4(%rbp)    #, input
# EasyAssembly.c:20:    if(input == 1337404)
        cmpl    $1337404, -4(%rbp)      #, input
        jne     .L5     #,
# EasyAssembly.c:21:            isGood = 0;
        movl    $0, isGood(%rip)        #, isGood
.L5:
# EasyAssembly.c:23:    if(!isGood)
        movl    isGood(%rip), %eax      # isGood, isGood.1_1
# EasyAssembly.c:23:    if(!isGood)
        testl   %eax, %eax      # isGood.1_1
        jne     .L6     #,
# EasyAssembly.c:24:            printf("Well done ! You can validate with the flag Hero{%d}\n", input);
        movl    -4(%rbp), %eax  # input, tmp86
        movl    %eax, %esi      # tmp86,
        leaq    .LC1(%rip), %rdi        #,
        movl    $0, %eax        #,
        call    printf@PLT      #
        jmp     .L7     #
.L6:
# EasyAssembly.c:27:            puts("Argh... Try harder buddy you can do it !");
        leaq    .LC2(%rip), %rdi        #,
        call    puts@PLT        #
```

So we can see here that at the end of the main function, the alue of `isGood` must be zero

### Flag

Hero{666}
