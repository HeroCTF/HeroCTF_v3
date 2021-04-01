# PRo Random Guesser

### Category

Prog

### Description

Everybody loves a little guessing challenge right ? Guess the number \o/
    - Love, Mersenne
/!\ If you are using a script, you have to append '\n' to any data you wish to send back.

URL : http://challs.heroctf.fr:XXXX

Format : **Hero{flag}**<br>
Author : **Log_s**

### Write up

It's a simple challenge with a simple solution. As the title implies, you have to crack the Pseudorandom Number Generator (PRNG). Most of PRNG are based on the Mersenne Twister generator. It is fast, and has a good distribution, and is a good PRNG in most cases. However, it's not safe at all, since it's easy to predict a number if you now the 624 previous ones.
For my solving script I used this module : https://github.com/tna0y/Python-random-module-cracker

```python
from randcrack import RandCrack
from pwn import*

HOST = "127.0.0.1"
PORT = 7003

s = remote(HOST, PORT)
rc = RandCrack()

print("[+] Gathering first 624 numbers")
for i in range(624):
    s.recvuntil("Guess me : ".encode())
    s.send("1\n".encode())
    data = s.recvuntil("try again\n".encode()).decode()
    number = int(data.split(" ")[3])
    rc.submit(number)

print("[+] Predicting next random number")
prediction = rc.predict_randrange(0, (2**32)-1)
print("|__ :", prediction)

print("[+] Sending back result")
s.recvuntil("Guess me : ".encode())
s.send((str(prediction)+"\n").encode())

print("\n"+s.recvline().decode())
s.close()
```

### Flag

```Hero{n0t_s0_r4nd0m_4ft3r_4ll}```
