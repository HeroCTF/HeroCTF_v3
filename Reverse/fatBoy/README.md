# fatBoy

### Category

Reverse

### Description

You'll never find my flag.

Format : **Hero{flag}**<br>
Author : **SoEasY**

### Files

- fatBoy

### Write up

We can notice that this file is a universal mach-o, which means that it can be runned on multiple architectures. To do this, a version per architecture is stored in the binary and the version corresponding of your architecture will be launched at runtime.

The encryption algorithm is a simple Vigenere with a ROT1 cipher. The key unxored at the begining of the encryption function.

After solving the challenge in x86_64, we find the flag "Hero{IMSORRYBUTTHISISNOTTHEFLAG}" with the key "BESTRONG", and we have to reverse the ARM version to find the good flag which is "Hero{WTFISTHISFUCKINGFILEFORMAT}" with the key "FATMACHO".


#### Solution

We first need to apply a minus one on the encrypted result expected and then decode it as vinegere with the unxoreed key.
```python
Python 3.9.2 (default, Mar 15 2021, 17:37:51) 
[Clang 12.0.0 (clang-1200.0.32.29)] on darwin
Type "help", "copyright", "credits" or "license" for more information.
>>> str = "CUZVTWPXYGOPLLVVLJFRGRZBGU"
>>> new = ""
>>> for i in str:
...     new += chr(ord(i)-1)
>>> new
'BTYUSVOWXFNOKKUUKIEQFQYAFT'
```

![image](https://user-images.githubusercontent.com/34216946/112377984-a8f61b80-8ce6-11eb-97ca-a814a9cd6bed.png)

### Flag

Hero{WTFISTHISFUCKINGFILEFORMAT}
