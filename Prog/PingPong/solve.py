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
