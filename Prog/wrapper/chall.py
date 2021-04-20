#! /usr/bin/python3
import base64, secrets, string, signal

FLAG = "Hero{wr4pp3d_4g4in_aNd_AgA1n}"
TIMEOUT = 2
encodings = ["b64", "b32", "b16", "bin","b64", "b32", "b16", "bin"]

# Define the timeout handling
def interrupted(signum, frame):
    print("\n\nHmmm, I thought you were better than this...")
    exit()
signal.signal(signal.SIGALRM, interrupted)

# Generating password
chars = string.digits+ string.ascii_lowercase + string.digits;
passwd = ''.join(secrets.choice(chars) for i in range(15))
encoded = "pass:"+passwd

# Wrapping the password with each possibility in a random order
for i in range(secrets.randbelow(3)+3):
    choice = secrets.randbelow(4)
    if choice == 4:
        encoded = base64.b64encode(encoded.encode()).decode()
    elif choice == 3:
        encoded = base64.b32encode(encoded.encode()).decode()
    elif choice == 2:
        encoded = base64.b16encode(encoded.encode()).decode()
    else:
        tmp = bytearray(encoded, "utf8")
        encoded = ""
        for byte in tmp:
            tmp = bin(byte)[2:]
            if len(tmp) < 7:
                tmp = "0"*(7-len(tmp))+tmp
            encoded += tmp

signal.alarm(TIMEOUT)
print("Hey ! I need your help ! I tried to store some data safely, but I can't remember how I did it... I have to send "\
      "it to my boss right now ! If you help me I have a little gift for you ;) But you have to hurry !")
print()
print(encoded)
print()
user_input = input(">> ")

if user_input == passwd:
    print("Yeah ! Here is a gift : {}".format(FLAG))