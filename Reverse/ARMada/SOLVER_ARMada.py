#!/usr/bin/env python3

import base64
from pwn import *

STANDARD_ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/'
CUSTOM_ALPHABET = 'CTwGhcJj+nKSqARsQ27omX0Iley91ufDbPxVY4ar5UgMNt/L3BvzkFiHZW6dOp8E'

def custom64Decode(input):
    DECODE_TRANS = str.maketrans(CUSTOM_ALPHABET, STANDARD_ALPHABET)
    newStr =  input.translate(DECODE_TRANS) + '='
    return base64.b64decode(newStr)

def main():
    r = remote("127.0.0.1", 3000)

    rep = ""
    while "Hero{" not in rep:
        try:
            r.recvuntil("New cipher : ", drop=True)
        except:
            print("\nFLAG : " + str(r.recvline())[2:][:-3])
            break
        cipher = str(r.recvline().replace(b'\n', b''))[2:][:-1]
        log.success("CIPHER : " + cipher)
        answer = custom64Decode(str(cipher))
        log.success(b"ANSWER : " + answer)
        r.sendline(answer.strip())
        rep = str(r.recvline())

if __name__ == "__main__":
    main()