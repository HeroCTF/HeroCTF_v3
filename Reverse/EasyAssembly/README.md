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
# EasyAssembly.c:17:    int input = getInput();
        call    getInput        #
        movl    %eax, -8(%rbp)  # tmp85, input
# EasyAssembly.c:19:    modified = input >> 2;
        movl    -8(%rbp), %eax  # input, tmp89
        sarl    $2, %eax        #, tmp88
        movl    %eax, -4(%rbp)  # tmp88, modified
# EasyAssembly.c:21:    if(modified == 1337404)
        cmpl    $1337404, -4(%rbp)      #, modified
        jne     .L5     #,
# EasyAssembly.c:22:            isGood = 0;
        movl    $0, isGood(%rip)        #, isGood
.L5:
# EasyAssembly.c:24:    if(!isGood)
        movl    isGood(%rip), %eax      # isGood, isGood.1_1
# EasyAssembly.c:24:    if(!isGood)
        testl   %eax, %eax      # isGood.1_1
        jne     .L6     #,
# EasyAssembly.c:25:            printf("Well done ! You can validate with the flag Hero{%d:%d}\n", input, modified);
        movl    -4(%rbp), %edx  # modified, tmp90
        movl    -8(%rbp), %eax  # input, tmp91
        movl    %eax, %esi      # tmp91,
        leaq    .LC1(%rip), %rdi        #,
        movl    $0, %eax        #,
        call    printf@PLT      #
        jmp     .L7     #
.L6:
# EasyAssembly.c:28:            puts("Argh... Try harder buddy you can do it !");
        leaq    .LC2(%rip), %rdi        #,
        call    puts@PLT        #
```

So we can see here that at the end of the main function, the alue of `isGood` must be zero to print the flag.

Earlier in the programm we can see that the input will be divided by 4 via the `sarl  $2, -4(%rbp)` instruction (divided by 2, 2 times) and stocked in a new int called `modified`. After that, the result will be compared with the int value `1337404`.

```nasm
# EasyAssembly.c:21:    if(modified == 1337404)
        cmpl    $1337404, -4(%rbp)      #, modified
        jne     .L5     #,
# EasyAssembly.c:22:            isGood = 0;
        movl    $0, isGood(%rip)        #, isGood
.L5:
# EasyAssembly.c:24:    if(!isGood)
        movl    isGood(%rip), %eax      # isGood, isGood.1_1
# EasyAssembly.c:24:    if(!isGood)
        testl   %eax, %eax      # isGood.1_1
        jne     .L6     #,
```
So we juste have to multiply 1337404 by 4 to find the correct input !

```python
Python 3.8.5 (default, Jan 27 2021, 15:41:15) 
[GCC 9.3.0] on linux
Type "help", "copyright", "credits" or "license" for more information.
>>> 1337404 * 4
5349616
```

4 differents inputs are flagging the challenge (5349616, 5349617, 5349618 and 5349619) : this is due to non floating-point arithmetic.

### Flags

Hero{5349616:1337404}
Hero{5349617:1337404}
Hero{5349618:1337404}
Hero{5349619:1337404}
