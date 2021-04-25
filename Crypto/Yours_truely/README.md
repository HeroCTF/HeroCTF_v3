# Truely_yours

### Category

Crypto

### Description

Alice <3 Bob <\3 Eve

```
nc chall3.heroctf.fr 9000
```

Format : **Hero{flag}**<br>
Author : **yarienkiva**

### Files

- [challenge.py](challenge.py)

### Write up

The RSA key used for signing is insecure because the two primes p and q are close together.
We can factor them using Fermat's factorization method for example.

The strengthenKey function returns a constant value so the AES encryption key is constant.
The IV is derived from the time the Challenge object is created so by storing the time before making our request to the server we can efficiently bruteforce the IV. 

### Flag

Hero{P4ul_Eluh4ck}
