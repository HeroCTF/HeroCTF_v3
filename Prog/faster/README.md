# Faster

### Category

Prog

### Description

Send the result back in time ^^P.
/!\ If you are using a script, you have to append '\n' to any data you wish to send back.

```
Host : chall0.heroctf.fr
Port : 7002
```

Format : **Hero{flag}**<br>
Author : **Log_s**

### Write up

Of course the timespan is to short to solve this by hand. Here is one example of python script solving it :
```python
#!/usr/bin/env python3

import math
from pyzbar.pyzbar import decode
from PIL import Image
from pwn import *

HOST = "127.0.0.1"
PORT = 7002

# Connect to the server
s = remote(HOST, PORT)

print("[+] Recovering QR code")

# Get the data
s.recvuntil("\n\n".encode())
data = s.recvuntil("\n".encode()).decode()[:-1][::-1] #getting the payload, removing the last '\n', and reversing the string

# Create blank image
image_size = int(math.sqrt(len(data)))
blank = Image.new('RGBA', (image_size, image_size), (255, 255, 255))

# Fill in with black where there is a 1
for y in range(image_size):
    for x in range(image_size):
        if (data[y*image_size + x] == '1'):
                blank.putpixel((x,y), (0, 0, 0))

# Add the three missing QR squares
# This part can be done by experimenting : you don't have to be pixel precise in order to get a readable qr code
# Or you can open the file in GIMP and count the pixels
img = Image.open("./square.png")
img = img.resize((70,70))
blank.paste(img, (40, 40, 110, 110))
blank.paste(img, (220, 40, 290, 110))
blank.paste(img, (40, 220, 110, 290))

# Read the QR code
qr_text = decode(blank)[0][0].decode()

print("[+] Recovering plaintext")

# XOR the data to recover the plaintext
plaintext = ""
for l in (qr_text):
    plaintext += chr(ord(l) ^ ord("P"))

# Solve the operation
nb1 = int(plaintext.split(" ")[3])
nb2 = int(plaintext.split(" ")[5])
result = nb1*nb2

print("[+] Sending back result")

# Send back the result
s.recvuntil(">> ".encode())
s.send((str(result)+"\n").encode())

print(s.recvall().decode())

s.close()
```

### Flag

```Hero{D4mn_y0U_4r3_s0m3_F457_f3lla}```