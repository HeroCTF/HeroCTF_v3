# Ping Pong

### Category

Prog

### Description

Could you get the flag ?

Format : **Hero{flag}**<br>
Author : **xanhacks**

### Files

- [output.txt](output.txt)

### Write up

Let's look at the file content.

```shell
$ cat output.txt
PONG
PING
PONG
PONG
PING
PONG
PONG
...
```

This looks like binary. Let's try to decode this to ASCII with PONG = 0 and PING = 1.

```python
#!/usr/bin/env python3

decode = {
    "PONG": "0",
    "PING": "1"
}

bits = ""
with open("output.txt", "r") as content:
    for line in content:
        bits += decode[line.strip()]

for i in range(len(bits) // 8):
    print(chr(int(bits[i*8:i*8+8], 2)), end="")
```

Execution :

```shell
$ python3 solve.py 
Hero{p1n6_p0n6_15_fun}
```

### Flag

Hero{p1n6_p0n6_15_fun}