# Puzzle Me

### Category

Prog

### Description

Back to kindergarten ! Here is a puzzle to solve. Unfortunalty the other kids din't take good care of it, and the pieces are worn out...

Format : **Hero{flag}**<br>
Author : **Log_s**

### Files

 - pieces.zip

### Write up

Each image is corrupted. If you look closer, 2 bytes of the well known PNG header were alterned. If you patch them by hand, you'll see a valid PNG with a fair amount of green on it, *15x15* px big.

Last thing is to figure out how to put the pieces together. If we consider the altered bytes as coordinates, we could write the following script :
```python
#!/usr/bin/env python3

from PIL import Image
from os import listdir, system
import sys

DIR = "pieces/"
size = 15

files = listdir(DIR)
matrix = []

print("[*] Finding max values in x and y")
x_max = 0
y_max = 0
for file in files:
    f = open(DIR + file, "rb")
    f.seek(2)
    x = int.from_bytes(f.read(1), byteorder='big')
    y = int.from_bytes(f.read(1), byteorder='big')
    if x > x_max:
        x_max = x
    if y > y_max:
        y_max = y

# If the maximum index is 9, the size is 10
x_max += 1
y_max += 1

print("[*] Initializing the matrix containing the file names")
for y in range(y_max):
    matrix.append([])
    for x in range(x_max):
        matrix[y].append("")

print("[*] Storing the files and patching them")
print("|-------10%-------20%-------30%-------40%-------50%-------60%-------70%-------80%-------90%------100%|\n ", end="")
last = 0
for i, file in enumerate(files):
    f = open(DIR + file, "rb")
    f.seek(2)
    x = int.from_bytes(f.read(1), byteorder='big')
    y = int.from_bytes(f.read(1), byteorder='big')
    system("./patch " + DIR + file + " 0x4E 2")
    system("./patch " + DIR + file + " 0x47 3")
    matrix[y][x] = DIR + file
    if (int(100*i/len(files)) > last):
        last = int(100*i/len(files))
        sys.stdout.write("=")
        sys.stdout.flush()

print("\n[*] Reconstruct the initial image")
flag = Image.new('RGB', (x_max*size, y_max*size))
for y in range(y_max):
    for x in range(x_max):
        x_image = x * size
        y_image = y * size
        img = Image.open(matrix[y][x])
        flag.paste(img, (x_image, y_image))

flag.save("flag.png")

print("[+] Done")
```

The **patch** binary I am using is just a little C program I wrote for fast little patches. It may not be the fastest solution calling *os.system()* so many times, but I had the binary ready so it saved me some times.
### Flag

```Hero{PuZzzZZzzzZzzzzL3}```
