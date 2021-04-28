# WTF

### Category

Reverse

### Description

Can you resolve this problem ?

Format : **Hero{flag}**<br>
Author : **SoEasY**

### Files

- WTF.bin

### Write up

This challenge in nothing more than a sudoku game enchanced with SSE inctructions (cf XMM registers). The binary is stripped and at the macho format (OSX) to harden binary analysis (sorry for that :D).

<img src="https://user-images.githubusercontent.com/34216946/115773560-c3d4b200-a3b0-11eb-8156-505d955ddcd1.png" width="500" height="500">

If we decompile the main function (`_start` in this case), we have this : 

```c
__int64 __fastcall start(int a1, __int64 a2)
{
  char *v2; // r12
  char v3; // al
  unsigned int v4; // ebx
  __int64 v5; // r15
  char v6; // r13
  int v7; // ecx
  __int64 i; // rax
  char v10[8]; // [rsp+0h] [rbp-98h]
  __int128 v11[6]; // [rsp+8h] [rbp-90h] BYREF

  if ( a1 <= 1 )
  {
    printf("Usage : %s <serial>\n", *(const char **)a2);
    exit(1);
  }
  v2 = *(char **)(a2 + 8);
  qmemcpy(v11, "                                                                                6", 81);
  BYTE10(v11[0]) = 50;
  WORD2(v11[1]) = 14643;
  BYTE13(v11[1]) = 53;
  BYTE4(v11[2]) = 55;
  *(_WORD *)((char *)&v11[3] + 7) = 13877;
  LOBYTE(v11[4]) = 49;
  *(_WORD *)((char *)v11 + 3) = 13365;
  BYTE5(v11[0]) = 54;
  *(_WORD *)((char *)&v11[3] + 1) = 13113;
  BYTE11(v11[3]) = 56;
  *(_WORD *)((char *)&v11[4] + 3) = 14643;
  BYTE8(v11[0]) = 57;
  BYTE1(v11[1]) = 55;
  WORD5(v11[1]) = 14644;
  BYTE2(v11[2]) = 55;
  BYTE11(v11[2]) = 50;
  BYTE14(v11[4]) = 56;
  v3 = *v2;
  while ( 1 )
  {
    v4 = v3 - 49;
    v5 = v2[1] - 49LL;
    v6 = v2[2];
    if ( (unsigned int)sub_100003A30(v11, v4, (unsigned int)v5, (unsigned int)v6) )
      *((_BYTE *)v11 + 9 * (int)v4 + v5) = v6;
    v2 += 3;
    v7 = 0;
    for ( i = 8LL; i != 89; i += 9LL )
      v7 += (v10[i] != 32)
          + (v10[i + 1] != 32)
          + (v10[i + 2] != 32)
          + (v10[i + 3] != 32)
          + (v10[i + 4] != 32)
          + (v10[i + 5] != 32)
          + (v10[i + 6] != 32)
          + (v10[i + 7] != 32)
          + (*((_BYTE *)v11 + i) != 32);
    if ( v7 == 81 )
      break;
    v3 = *v2;
    if ( !*v2 )
    {
      puts("Nope.");
      return 1LL;
    }
  }
  puts("\nWell done ! You can validate with this flag : ");
  sub_100003BE0(v11);
  return 0LL;
}
```

We can see at the end that a function is dedicated to print the flag, let's check this one : 

![unknown](https://user-images.githubusercontent.com/34216946/116388807-8773dc80-a81c-11eb-9d85-da5db1851f6e.png)

This function will obviously iterate on a int\[9]\[9] tab (or char\[9]\[9] for example) and print all the content with "Hero{" at the beginning and "}" at the end : it prints 9 elements of an array and loop while i != 0x59 (== 0x89) with a start at 8, for a total of 81 (which is 9x9).

Afer conseidering the main loop of the `_start` function, we can see that the programm will split 3 char of our input by loop like that : 
- row number (as int)
- column number (as int)
- value to put (as char)

By the way we can consider the initialisation part before this loop :

```c
  v2 = *(char **)(a2 + 8);
  qmemcpy(v11, "                                                                                6", 81);
  BYTE10(v11[0]) = '2';
  WORD2(v11[1]) = '93';
  BYTE13(v11[1]) = '5';
  BYTE4(v11[2]) = '7';
  *(_WORD *)((char *)&v11[3] + 7) = '65';
  LOBYTE(v11[4]) = '1';
  *(_WORD *)((char *)v11 + 3) = '45';
  BYTE5(v11[0]) = '6';
  *(_WORD *)((char *)&v11[3] + 1) = '39';
  BYTE11(v11[3]) = 56;
  *(_WORD *)((char *)&v11[4] + 3) = '93';
  BYTE8(v11[0]) = '9';
  BYTE1(v11[1]) = '7';
  WORD5(v11[1]) = '94';
  BYTE2(v11[2]) = '7';
  BYTE11(v11[2]) = '2';
  BYTE14(v11[4]) = '8';
```
  
Thanks to all this clues we can understand that this is a 9x9 sudoku grid. After recovering the grid we have this :

<img src="https://user-images.githubusercontent.com/34216946/115768094-22e2f880-a3aa-11eb-93c1-80f4e558d246.png" width="350" height="350">

We can then use an online sudoku solver to have the correct input.

<img src="https://user-images.githubusercontent.com/34216946/115768177-4148f400-a3aa-11eb-85f1-fea2883ddab2.png" width="350" height="350">.

So a correct input could be for example : 
```
111127138172183214239243258261275286315326352367371388423442451464476498524531548556565579593616628632647674681695712744757773789791818834846877885892913929937941955962984
```

We can try : 
```bash
$ ./WTF_macho 111127138172183214239243258261275286315326352367371388423442451464476498524531548556565579593616628632647674681695712744757773789791818834846877885892913929937941955962984

Well done ! You can validate with this flag : 
Hero{178546239429381567563927184935214678741865923682793415256478391814639752397152846}
```

The flag is then constituted of all the number of the sudoku grid completed !

### Flag

Hero{178546239429381567563927184935214678741865923682793415256478391814639752397152846}
