#!/usr/bin/env python3

import random, time

FLAG = "HeroCTF{n0t_s0_r4nd0m_4ft3r_4ll}"
random.seed(time.time())
t = 0

print("Everybody loves a little guessing challenge right ? Guess the number \o/\n\t- Love, Mersenne\n")
while t < 1000:
    rand = random.getrandbits(32)
    try:
        guess = int(input("Guess me : "))
    except ValueError:
        print("I'm a number remember ?")
        exit()
    if rand == guess:
        print("how can you be so lucky... here you go... {}".format(FLAG))
    else:
        print("Nop, it was {} :) But you can try again\n".format(rand))

print("\nI can't take your mediocrity any longer")
