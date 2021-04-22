from pwn import *
import time

HOST = "chall0.heroctf.fr"
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
timings = []
while True:
    start = time.time()
    try:
        s.recv(1).decode()
    except EOFError:
        break
    d = round(time.time()-start, 2)
    print(d)
    timings.append(d)
    #if (d > 0.05):
        
        
        #flag1 += FLAG_CASE1[d]
        #flag2 += FLAG_CASE2[d]

flag1 = decode_morse(flag1)
flag2 = decode_morse(flag2)

print("[+] Flag is : ", flag1, flag2)