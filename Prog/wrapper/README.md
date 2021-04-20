# Wrapped

### Category

Prog

### Description

Hey ! I need your help ! I tried to store some data safely, but I can't remember how I did it... I have to send it to my boss right now ! If you help me I have a little gift for you ;) But you have to hurry !
<br>/!\ If you are using a script, you have to append '\n' to any data you wish to send back.


Format : **Hero{flag}**<br>
Author : **Log_s**

### Write up

The message to send back is randomly wrapped within different base representation (base64, base32, base16, base2).
You can use [CyberChef](https://gchq.github.io/CyberChef) to understand that. It will automatically detect the base
except for binary. In this case, it's easy to recognize, and you have to use custom parameters to decode it (no seperator
and 7bits length because that's how ascii works).

Here are some functions that detect which base is currently used :
```python
import base64

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
```

Now we juste have to decode unwrappe the pass, layer by layer. After a few tries, you'll see that the pass format is
`pass:thepassishere`. So we know when to stop : when the resulting string starts with "pass:".

Let's complete the previous code with this one, and we should be good to go !

```python
from pwn import *

HOST = "127.0.0.1"
PORT = 7002
s = remote(HOST, PORT)

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
```

```bash
$ python3 solve.py 
[+] Opening connection to 127.0.0.1 on port 7002: Done
[+] Receiving all data: Done (54B)
[*] Closed connection to 127.0.0.1 port 7002
Yeah ! Here is a gift : Hero{wr4pp3d_4g4in_aNd_AgA1n}
```


### Flag

```Hero{wr4pp3d_4g4in_aNd_AgA1n}```