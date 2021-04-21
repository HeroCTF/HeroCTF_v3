import base64
from pwn import *

HOST = "127.0.0.1"
PORT = 7002
s = remote(HOST, PORT)

def isB64(s):
    try:
        tmp = base64.b64decode(s.encode()).decode()
        tmp = base64.b64encode(tmp.encode()).decode()
        if tmp == s:
            return True
        else:
            return False
    except:
        return False

def isB32(s):
    try:
        tmp = base64.b32decode(s.encode()).decode()
        tmp = base64.b32encode(tmp.encode()).decode()
        if tmp == s:
            return True
        else:
            return False
    except:
        return False

def isB16(s):
    try:
        tmp = base64.b16decode(s.encode()).decode()
        tmp = base64.b16encode(tmp.encode()).decode()
        if tmp == s:
            return True
        else:
            return False
    except:
        return False

def isBin(s):
    for l in s:
        if l != "0" and l != "1":
            return False
    return True

def decodeBin(s):
    out = ""
    for i in range (0, len(s), 7):
        tmp = s[i:i+7]
        dec = int(tmp, 2)
        char = chr(dec)
        out += char
    return out

s.recvuntil("hurry !\n\n")
msg = s.recvuntil("\n")[:-1].decode()
s.recvuntil(">> ")

while not msg.startswith("pass"):
    if isBin(msg):
        msg = decodeBin(msg)
    elif isB64(msg):
        msg = base64.b64decode(msg.encode()).decode()
    elif isB32(msg):
        msg = base64.b32decode(msg.encode()).decode()
    elif isB16(msg):
        msg = base64.b16decode(msg.encode()).decode()

passwd = msg.split("pass:")[1]
s.send((passwd+"\n").encode())

print(s.recvall().decode())