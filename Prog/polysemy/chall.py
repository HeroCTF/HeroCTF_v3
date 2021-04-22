#! /usr/bin/python3
from time import sleep
import sys

class Unbuffered(object):
   def __init__(self, stream):
       self.stream = stream
   def write(self, data):
       self.stream.write(data)
       self.stream.flush()
   def writelines(self, datas):
       self.stream.writelines(datas)
       self.stream.flush()
   def __getattr__(self, attr):
       return getattr(self.stream, attr)


UNIT = 0.1
HIDDEN = "HERO(H1DD3N-M0RS3-C0D3)"
DISPLAYED = "I love chocolate. This morning there was no more chocolate. But you probably don't care...."
MORSE_CODE_DICT = {'A': '.-', 'B': '-...',
                   'C': '-.-.', 'D': '-..', 'E': '.',
                   'F': '..-.', 'G': '--.', 'H': '....',
                   'I': '..', 'J': '.---', 'K': '-.-',
                   'L': '.-..', 'M': '--', 'N': '-.',
                   'O': '---', 'P': '.--.', 'Q': '--.-',
                   'R': '.-.', 'S': '...', 'T': '-',
                   'U': '..-', 'V': '...-', 'W': '.--',
                   'X': '-..-', 'Y': '-.--', 'Z': '--..',
                   '1': '.----', '2': '..---', '3': '...--',
                   '4': '....-', '5': '.....', '6': '-....',
                   '7': '--...', '8': '---..', '9': '----.',
                   '0': '-----', ', ': '--..--', '.': '.-.-.-',
                   '?': '..--..', '/': '-..-.', '-': '-....-',
                   '(': '-.--.', ')': '-.--.-'}

sys.stdout = Unbuffered(sys.stdout)

def pause(multiplier):
    sleep(multiplier * UNIT)

displayed_pointer = 0
for letter in HIDDEN:
    if letter == " ":
        pause(7)
    else:
        morse = MORSE_CODE_DICT[letter.upper()]
        for i, m in enumerate(morse):
            print(DISPLAYED[displayed_pointer], end="")
            displayed_pointer += 1
            if m == ".":
                pause(1)
            else:
                pause(3)
            if (i == len(morse)-1):
                pause(4)
            else:
                pause(1)
