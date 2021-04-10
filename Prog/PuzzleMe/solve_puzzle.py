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
