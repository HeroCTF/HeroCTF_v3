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

The goal here is to retrieve the flag, one character at a time. The *msg* variable is represented like this :

```
============== 3 blocks ===========   ~1 block    ~1 block
[14 bytes] + [payload] + [20 bytes] +  [flag]  + [10 bytes]
payload = account_id
34 bytes + payload are send before the flag
48-34=14
```

If you send a payload with a size of 14 bytes (14 chars) the flag will start on the fourth block. So, if you send only 13 chars, the first char of the flag will be on the end of the third block.

Third block : `our password : <fisrt_char_of_the_flag>`. So you can bruteforce it by sending :

```
our password : a
our password : b
our password : c
...
```

To do this you can add two bytes to the the first 14 bytes to complete the block, then write `our password : a`, ... and try to brute the flag.

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
