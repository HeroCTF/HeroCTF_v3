# fatBoy

## TODO : Add caesar cipher on top of vinegere

### Category

Reverse

### Description

You'll never find my flag.

Format : **Hero{flag}**<br>
Author : **SoEasY**

### Files

- fatBoy

### Write up

We can notive that this file is a universal mach-o, which means that it can be runned on multiple architectures.
The algorithm is a simple Vinegère cipher with a key unxored at the begining of the encryption function.
After solving the challenge in x86_64, we find the flag "Hero{IMSORRYBUTTHISISNOTTHEFLAG}" with the key "BESTRONG", and we have to reverse the ARM version to find the good flag which is "Hero{WTFISTHISFUCKINGFILEFORMAT}" with the key "FATMACHO".


#### Solution

![image](https://user-images.githubusercontent.com/34216946/112377984-a8f61b80-8ce6-11eb-97ca-a814a9cd6bed.png)

### Flag

Hero{WTFISTHISFUCKINGFILEFORMAT}
