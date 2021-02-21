# h4XOR

### Category

Crypto

### Description

Can you recover the **flag.png** image ?

Format : **Hero{flag}**<br>
Author : **xanhacks**

### Files

- [xor.py](xor.py)
- [flag.png.enc](flag.png.enc)

### Hints

The **xor** function is from the **pwntools** module.

### Write up

We know that if **flag ^ key = enc**, then **enc ^ key = flag**. So, we need to recover the key.
The **flag.png.enc** appears to be a PNG file and all the PNG image starts with the same **magic bytes**.

The key is 9 bytes long with the last byte only from 0 to 9. The 8 first bytes can be recovered thanks to the **PNG magic bytes**.
The last byte can be bruforced easily, only 10 choices.

Let's solve this challenge with python.

```python
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
```

Let's check the 10 images. Bingo, the last image was valid !

![flag](flag.png)

### Flag

Hero{123_xor_321}