# sELF control

### Category

Reverse

### Description

I found a program to read the flag but it seems to be broken... Could you help me patching patching two bytes to make it functional ? 

nc challs.heroctf.fr 2048

Format : **Hero{flag}**<br>
Author : **SoEasY**

### Files

- READFLAG.bin

### Write up

The title of the challenge is containing a clue : "ELF".
We can check the ELF header then (see wikipedia [here](https://en.wikipedia.org/wiki/Executable_and_Linkable_Format), a we find that :
- The architecture is not correct (IA-64 instead of amd64)
- The entry point is 0x10A1 instead of 0x10A0 (see the screenshot of IDA)

#### Solution

```bash
$ nc challs.heroctf.fr 2048
██╗  ██╗███████╗██████╗  ██████╗  ██████╗████████╗███████╗
██║  ██║██╔════╝██╔══██╗██╔═══██╗██╔════╝╚══██╔══╝██╔════╝
███████║█████╗  ██████╔╝██║   ██║██║        ██║   █████╗  
██╔══██║██╔══╝  ██╔══██╗██║   ██║██║        ██║   ██╔══╝  
██║  ██║███████╗██║  ██║╚██████╔╝╚██████╗   ██║   ██║     
╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝ ╚═════╝  ╚═════╝   ╚═╝   ╚═╝     
================ sELF control (by SoEasY) ================


Position of the byte to patch in hex (example: 03) : 12
Value to put at this offset in hex (example: 14) : 3e

Position of the byte to patch in hex (example: 1C) : 18
Value to put at this offset in hex (example: 03) : A0

[+] Execution : 
Hero{W0w_s0_y0u_4r3_4n_ELF_h34d3r_M4sT3r???}
```

### Flag

Hero{W0w_s0_y0u_4r3_4n_ELF_h34d3r_M4sT3r???}
