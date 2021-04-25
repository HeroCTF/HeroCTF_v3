#!/usr/bin/python3

from Crypto.Util.number import inverse, getPrime, isPrime, long_to_bytes, bytes_to_long
from Crypto.Util.Padding import pad
from Crypto.Cipher import AES
from sympy import nextprime
import os, sys, hashlib, base64
import time


class Challenge(object):

	def __init__(self):
		"""
		Init the challenge by reading the flag and setting the blocksize
		""" 
		self.bs  = AES.block_size
		self.key = self._strengthenKey( os.getenv("SECRET_KEY") )

	def encrypt(self, raw):
		"""
		Incripts the plaintext with AES, base64 encodes it and returns it
		"""
		raw = pad(raw.encode(), self.bs)
		iv  = pad(long_to_bytes(int(time.time())), self.bs)
		cipher = AES.new(self.key, AES.MODE_CBC, iv)

		return base64.b64encode(cipher.encrypt(raw))

	def generateKeyParts(self):
		"""
		Securely generate the public and private parts of a RSA key
		"""
		p = getPrime(1024)
		q = p

		# can't have them too close
		# that wouldn't be secure
		for _ in range(10):
			q = nextprime(q)

		e = 0x10001
		n = p*q
		phi = (p-1)*(q-1)
		d = inverse(e, phi)
		return n, e, d

	def _strengthenKey(self, key):
		"""
		Hash the key using sha256 to make it longer and
		more secure
		"""

		# this'll probably strengthen the key, probably ?
		key = hashlib.sha256().update( key.encode() )
		key = pad(str(key).encode(), self.bs)
		return key


chall = Challenge()

n, e, d = chall.generateKeyParts()

welcome_banner = f"""
	Bob my darling is that you ? It's me, Alice !
	To prove you're the one I'm talking to, send me "the_proof_of_your_love".
	Beware, I'll only accept it if it's signed with the (private) key to my heart.
	I know that your love for me is strong enough to factor a 4096bit modulus <3

	public modulus  : {n}
	public exponent : {e}

"""

congrat_banner = f"""
	La courbe eliptique de tes yeux fait le tour de mon kernel,
	Un math.rand de danse et de douceur,
	Auréole du temps, anneau nocturne et sûr,
	Et si je ne sais plus tout ce que j’ai vécu
	C’est que tes yeux ne m’ont pas toujours vu.

	- {chall.encrypt(os.getenv('FLAG'))}, 1926

"""

m = b'the_proof_of_your_love'
h = bytes_to_long(hashlib.sha512(m).digest())

print(welcome_banner)

while True:
	try:
		cmd = input("input >> ")
		hashFromSignature = pow(int(cmd), e, n)

		if str(h) == str(hashFromSignature):
			print(congrat_banner)
		
		# elif cmd == "help me I'm lost":	
		# 	print('You need to sign the string : "the_proof_of_your_love" and send it')
		
		else :
			print("I don't believe you >:c")


	except ValueError as ex:
		print('What ?')
	except Exception as e:
		print("Goodbye, my darling Bob...")
		exit()
