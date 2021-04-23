# ExtractMyBlocks

### Category

Crypto

### Description

The company PasswordS3cure created a new password reset functionality. Could you crack it and find the flag ?

```
nc chall0.heroctf.fr 10000
```

Format : **Hero{flag}**<br>
Author : **xanhacks**

### Files

- [challenge.py](challenge.py)

### Write up

```
============== 3 blocks ===========  1 block    1 block
[14 bytes] + [payload] + [20 bytes] + [flag] + [10 bytes] 
34 bytes + payload are send to us before the flag
48-34=14
```

Let's make a solve script in python :

```python
from pwn import *
from string import printable

context.log_level = "error"


def send_payload(payload):
    r = remote("chall0.heroctf.fr", 10000)
    r.sendlineafter("Please enter your account ID : ", payload)
    data = r.recvline()
    r.close()
    return data.strip()


OUTPUT_SIZE = 32

flag = ""
i = 1
while not flag.endswith("}"):
    flag_data = send_payload("a" * (14 - i))
    flag_blocks = flag_data[2 * OUTPUT_SIZE : 3 * OUTPUT_SIZE]

    for c in printable:
        to_send = "aaaour password : "[i:] + flag + c
        brute_data = send_payload(to_send)
        brute_blocks = brute_data[1 * OUTPUT_SIZE : 2 * OUTPUT_SIZE]

        if brute_blocks == flag_blocks:
            print(c, end="")
            flag += c
            break
    i += 1
```

Execution :

```shell
$ python3 solve.py
Hero{_BL0CK5_}
```

### Flag

Hero{\_BL0CK5_}
