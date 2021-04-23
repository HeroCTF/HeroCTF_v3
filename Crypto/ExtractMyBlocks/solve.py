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

