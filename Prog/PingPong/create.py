#!/usr/bin/env python3

flag = "Hero{p1n6_p0n6_15_fun}"

content = ""
for c in flag:
    content += format(ord(c), '08b')

convert = {
    "0": "PONG",
    "1": "PING"
}

with open("output.txt", "w") as output:
    for c in content:
        output.write(convert[c] + "\n")
