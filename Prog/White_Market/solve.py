from pyzbar.pyzbar import decode
from PIL import Image
from pwn import *
from base64 import b64decode

def parseFile():
    food = []
    with open("market.txt","r") as lines:
        for line in lines:
            food.append(line.strip("\n"))
    return food

def connect():
    ip = "chall0.heroctf.fr"
    port = 7005
    io = remote(ip,port)
    io.recvuntil("(y/n)")
    io.sendline("y")
    return io

def flag(io,food):
    try:
        while True:
            content = io.recvuntil("?").decode().split(": ")[1].split("\n")[0]
            f = open("current.png","wb")
            f.write(b64decode(content))
            f.close()
            barcode = decode(Image.open("current.png"))[0][0].decode()
            print(barcode)
            price = [s for s in food if barcode in s][0].split(":")[2]
            io.sendline(price)
            print(io.recvline().decode())
    except:
        io.interactive()
        sys.exit(-1)

def main():
    food = parseFile()
    io = connect()
    flag(io,food)

if __name__ == "__main__":
    main()
