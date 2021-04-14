#!/usr/bin/env python3

from random import randint
import qrcode, signal, socket

HOST = "127.0.0.1"
PORT = 7002
FLAG = "Hero{D4mn_y0U_4r3_s0m3_F457_f3lla}"
ENONCE = "Send the result back in time ^^P"
TIMEOUT = 3

# Define the timeout handling
def interrupted(signum, frame):
    print("\n\nNaaah, that won't cut it sorry :(\nCome back when you're faster...")
    exit()
signal.signal(signal.SIGALRM, interrupted)


def initChall():
    nb1 = randint(5000, 10000)
    nb2 = randint(5000, 10000)

    solution = nb1 * nb2

    msg = "solve this : {} x {}".format(nb1, nb2)
    encrypted = ""

    # xoring msg
    for i in msg:
        encrypted += chr(ord(i) ^ ord("P"))

    # Creating qr code
    qr = qrcode.make(encrypted)

    # Removing black squares on qr
    for x in range(40, 110):
        for y in range(40, 110):
            qr.putpixel((x, y), 255)
    for x in range(40, 110):
        for y in range(220, 290):
            qr.putpixel((x, y), 255)
    for x in range(220, 290):
        for y in range(40, 110):
            qr.putpixel((x, y), 255)

    output = ""
    # Pixels to 1 and 0
    for x in range(qr.size[0]):
        for y in range(qr.size[1]):
            if qr.getpixel((x, y)) == 255:
                output += "0"
            else:
                output += "1"

    # reverse string
    output = output[::-1]

    return str(solution), output.strip(), qr


def main():
    global ENONCE, TIMEOUT

    signal.alarm(TIMEOUT)

    solution, challData, qr= initChall()
    print(ENONCE)
    print("\n"+challData)
    response = input("\nAnswer ?\n>> ")

    if (response == str(solution)):
        print("Congratz man ! Here you go : {}".format(FLAG))
    else:
        print("Nop, ain't it")

    signal.alarm(0)


if __name__ == "__main__":
    main()
