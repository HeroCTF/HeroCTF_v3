from PIL import Image
import random
import string
import os

DIR = "pieces/"

img = Image.open("full.png")
size_x, size_y = img.size

size = 15
names = ""

for y in range(int(size_y/size)):
    for x in range(int(size_x/size)):
        x_image = x*size
        y_image = y*size
        name = ''.join(random.choices(string.ascii_uppercase + string.digits, k=10))+".png"
        while name in names:
            name = ''.join(random.choices(string.ascii_uppercase + string.digits, k=10))+".png"
        piece = img.crop((x_image, y_image, x_image+size, y_image+size)).save(DIR+name)
        os.system("./patch " + DIR+name + " "+hex(x)+" 2")
        os.system("./patch " + DIR+name + " "+hex(y)+" 3")
