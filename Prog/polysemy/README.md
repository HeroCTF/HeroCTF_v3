# Polysemy

### Category

Prog

### Description

Good morning agent, we have intercepted this communication on our secure line this
morning at 6am, and it's endlessly playing since then. We can't make any sense of it, and we
can't believe it's about chocolate. Your mission, should you choose to accept it is
to find the hidden meaning of this communication. Good luck.

/!\ If you are using a script, you have to append '\n' to any data you wish to send back.<br>
/!\ I bended the official rules : I went from 3 to 4 (you'll get it when you will get there)

```
Host : chall0.heroctf.fr
Port : 7004
```

Format : **HERO(FLAG)**<br>
Author : **Log_s**

### Hints
 - The flag format is slightly different from the usual one
 - Tic Tac, Tic Tac

### Write up

The different flag format, and the "tic tac" hint can put you on the right path. Morse code is all about
timing, and it does not contain any translation for lowercase characters or "{}" symbols.

If we record the different timings for each printed letter, there are these four different ones.
```
0.1
0.2
0.25
0.35
```

The official timings for morse code are the following : 
 - 1 unit : duration of a dot
 - 3 units : duration of a dash
 - 1 unit : spacing between two symbols of the same letter
 - 3 units : spacing between two letters
 - 7 units : spacing between two words

Now in the way the challenge is made, there can be no "duration" equivalent in printing letters,
so we'll have to assume that there are considered in the pauses. Considering the values we've recorded
the only possibility is that 1 unit equals to 0.05 seconds because the smallest recorded value is 0.1
(1 dot followed by a pause).

However, a problem presents itself : 0.2 seconds can represent a dash followed by a small pause (for the same letter)
or a dot at the end of a letter, followed by a triple pause. That's why a warning said "I went from
3 to 4". Either the dash duration was taken up to 4, or the pause between two letter was. So there are
two cases to test. One of them will probably create some invalid morse code.

Let's some up :
 - 0.1s : a dot and a the mandatory pause between two symbols of the same letter (0.05 + 0.05)
 - 0.2s / 0.25s : 
   - a dash and the mandatory pause between two symbols of the same letter (3 x 0.05 + 0.05) or (4 x 0.05 + 0.05)
    - OR
    - a dot followed by a change of letter (0.05 + 3 x 0.05) or (0.05 + 4 x 0.05)
 - 0.35s : a dash followed by a change of letter (4 x 0.05 + 3 x 0.05) or (3 x 0.05 + 4 x 0.05)

```python
from pwn import *
import time

HOST = "127.0.0.1"
PORT = 7004

MORSE_CODE_DICT = {'.-': 'A', '-...': 'B',
                   '-.-.': 'C', '-..': 'D', '.': 'E',
                   '..-.': 'F', '--.': 'G', '....': 'H',
                   '..': 'I', '.---': 'J', '-.-': 'K',
                   '.-..': 'L', '--': 'M', '-.': 'N',
                   '---': 'O', '.--.': 'P', '--.-': 'Q',
                   '.-.': 'R', '...': 'S', '-': 'T',
                   '..-': 'U', '...-': 'V', '.--': 'W',
                   '-..-': 'X', '-.--': 'Y', '--..': 'Z',
                   '.----': '1', '..---': '2', '...--': '3',
                   '....-': '4', '.....': '5', '-....': '6',
                   '--...': '7', '---..': '8', '----.': '9',
                   '-----': '0', '--..--': ', ', '.-.-.-': '.',
                   '..--..': '?', '-..-.': '/', '-....-': '-',
                   '-.--.': '(', '-.--.-': ')'}
FLAG_CASE1 = {0.1: ".", 0.2: "-", 0.25: ". ", 0.35: "- "}
FLAG_CASE2 = {0.1: ".", 0.2: ". ", 0.25: "-", 0.35: "- "}

def decode_morse(morse):
    splitted = morse.split(" ")
    flag = ""
    for char in splitted:
        try:
            flag += MORSE_CODE_DICT[char]
        except KeyError:
            return ""
    return flag

s = remote(HOST, PORT)

flag1 = ""
flag2 = ""

print("[+] Reading timings")
while True:
    start = time.time()
    try:
        s.recv(1).decode()
    except EOFError:
        break
    d = round(time.time()-start, 2)
    if (d > 0.05):
        flag1 += FLAG_CASE1[d]
        flag2 += FLAG_CASE2[d]

flag1 = decode_morse(flag1)
flag2 = decode_morse(flag2)

print("[+] Flag is : ", flag1, flag2)
```
It creates the following output.
```
[+] Opening connection to 127.0.0.1 on port 7004: Done
[+] Reading timings
[+] Flag is :  HERO(H1DD3N-M0RS3-C0D3( 
```
The last character is not right, for a simple reason : 
 - -.--. is the morse for '('
 - -.--.- is the morse for ')'

Since the challenge is based on the timings of characters relatively to the next, the last one can not be compared.
The final dash in lost, which inverts the parenthesis. But it's easy enough to fix it by hand when
you know the flag format ;)

### Flag

```HERO(H1DD3N-M0RS3-C0D3)```
