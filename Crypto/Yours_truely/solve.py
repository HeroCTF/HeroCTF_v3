from Crypto.Util.number import inverse, getPrime, isPrime, long_to_bytes, bytes_to_long
from Crypto.Util.Padding import pad
from Crypto.Cipher import AES
from sympy import nextprime
import os, sys, hashlib, base64
import time

from pwn import *


def find_invpowAlt(x,n):
	low = 10 ** (len(str(x)) // n)
	high = low * 10

	while low < high:
		mid = (low + high) // 2
		if low < mid and mid**n < x:
			low = mid
		elif high > mid and mid**n > x:
			high = mid
		else:
			return mid
	return mid + 1

def strengthenKey():
	"""
	Hash the key using sha256 to make it longer and
	more secure
	"""
	key = ""
	# this'll probably strengthen the key, probably ?
	key = hashlib.sha256().update( key.encode() )
	key = pad(str(key).encode(), AES.block_size)
	return key

start = int(time.time())

r = remote("localhost", 9000, level='debug')

for _ in range(6):
	r.recvline()

n = int(r.recvline().split(b':')[1].strip())
e = int(r.recvline().split(b':')[1].strip())

r.recvuntil("input >> ")

p = find_invpowAlt(n, 2)
q = 0

i = 0
while n != p*q:
	p = nextprime(p)
	q = n // p
	i +=1
	if i%1000:print(i*1000, "numbers tested")

print('Found :', [p, q])

phi = (p - 1) * (q - 1) 
d   = inverse(e, phi)

m = b'the_proof_of_your_love'
h = int.from_bytes(hashlib.sha512(m).digest(), byteorder='big')
s = pow(h, d, n)

r.sendline(str(s).encode())

for _ in range(7):
	print(r.recvline())

enc_flag = base64.b64decode(r.recvline().split(b"'")[1])
key  = strengthenKey()
flag = b""

while b"Hero" not in flag:
	iv = pad(long_to_bytes(start), AES.block_size)
	cipher = AES.new(key, AES.MODE_CBC, iv)
	flag = cipher.decrypt(enc_flag)
	print(flag)
	start += 1
