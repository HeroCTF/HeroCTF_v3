#!/usr/bin/env python3
from pwn import xor

# Open the encrypted image
flag_enc = open("flag.png.enc", "rb").read()

# Retrieve the first 8 bytes of the key thanks to the PNG magic bytes
png_magic_bytes = [137, 80, 78, 71, 13, 10, 26, 10]
key_dec = []
for i, magic in enumerate(png_magic_bytes):
    key_dec.append(flag_enc[i] ^ magic)

# Bruteforce the last byte (0 to 10)
key = bytes(key_dec)
for i in range(10):
    flag = open(f"flag_{i+1}.png", "wb")
    flag.write(xor(flag_enc, key + bytes([i])))
