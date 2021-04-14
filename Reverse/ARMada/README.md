# ARMada

### Category

Reverse

### Description

You are commissioned to test a new military-grade encryption, but apparently the developers haven't invented much...

nc challs.heroctf.fr 3000

Format : **Hero{flag}**<br>
Author : **SoEasY**

### Files

- ARMada.bin

### Write up

After reversing the binary (quite annoying beacause of C++ and ARM arch :D), we find that this is just an implementation of base64 with a custom alphabet.

#### by SoEasY

```python
#!/usr/bin/env python3

import base64
from pwn import *

# Standard base64 alphabet designed by RFC n°3548 (https://tools.ietf.org/html/rfc3548, page 4)
STANDARD_ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/'

CUSTOM_ALPHABET_XORED = [
    0x01, 0x16, 0x35, 0x05, 0x2A, 0x21, 0x08, 0x28,
    0x69, 0x2C, 0x09, 0x11, 0x33, 0x03, 0x10, 0x31,
    0x13, 0x70, 0x75, 0x2D, 0x2F, 0x1A, 0x72, 0x0B,
    0x2E, 0x27, 0x3B, 0x7B, 0x73, 0x37, 0x24, 0x06,
    0x20, 0x12, 0x3A, 0x14, 0x1B, 0x76, 0x23, 0x30,
    0x77, 0x17, 0x25, 0x0F, 0x0C, 0x36, 0x6D, 0x0E,
    0x71, 0x00, 0x34, 0x38, 0x29, 0x04, 0x2B, 0x0A,
    0x18, 0x15, 0x74, 0x26, 0x0D, 0x32, 0x7A, 0x07
]

# Function to decode base64 with a custom alphabet
def custom64Decode(input, custom_alphabet):
    DECODE_TRANS = str.maketrans(custom_alphabet, STANDARD_ALPHABET)
    newStr =  input.translate(DECODE_TRANS) + '='
    return base64.b64decode(newStr)

def main():
    # Recover the custom alphabet wich is just xored with 0x42
    custom_alphabet = ''
    for val in CUSTOM_ALPHABET_XORED:
        custom_alphabet += chr(val ^ 0x42)
    
    # Connect to the service
    r = remote("127.0.0.1", 3000)

    while True:
        # If EOFError raised, print last line which is the flag and stop
        try:
            r.recvuntil("New cipher : ", drop=True)
        except:
            log.success("-----> FLAG : " + str(r.recvline())[2:][:-3])
            break
        
        # Get the cipher a format it
        cipher = str(r.recvline().replace(b'\n', b''))[2:][:-1]
        log.success("CIPHER : " + cipher)

        # Decode the cipher and send the answer back to the service
        answer = custom64Decode(str(cipher), custom_alphabet)
        log.success(b"ANSWER : " + answer)
        r.sendline(answer.strip())

        # Receive the line saying "Nice job !"
        r.recvline()

if __name__ == "__main__":
    main()
```

### Flag

Hero{0h_w0W_s0_y0u_not1c3d_1t_w4s_cust0m_b64_?}