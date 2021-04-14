# RustInPeace

### Category

Reverse

### Description

Could you break my super encryption algorithm ?

Format : **Hero{flag}**<br>
Author : **SoEasY**

### Files

- RustInPeace.bin

### Write up

After reversing the binary (quite annoying because of Rust and the fact it is stripped :D), we find that this is just a simple xor operation. The flag is passed by a file which is the second arg and the first arg must be 60.

#### Solution

```python
xored = [0x9, 0x27, 0x31, 0x2b, 0x3e, 0x2, 0x76, 0x2c, 0x16, 0x33, 0x7b, 0x39, 0x12, 0x25, 0x21, 0x60, 0x26, 0xd, 0x67, 0x36, 0x65, 0x23, 0x23, 0x7, 0xb, 0x2f, 0x6e, 0x28, 0x2, 0x2c, 0x6c, 0x16, 0x52, 0x10, 0x10, 0x55, 0xb, 0x1, 0x58, 0x57, 0x14, 0x60]

flag = "FLAG="

for i, c in enumerate(xored):
    flag += chr(c ^ (i+5+60))
    
print(flag)
```
result : FLAG=Hero{D1d_y0u_kn0w_4b0ut_Ru5t_r3v3rs1ng??}

After that we can try to pass it into the program : 
```bash
$ echo "FLAG=Hero{D1d_y0u_kn0w_4b0ut_Ru5t_r3v3rs1ng??}" > flag_file
$ ./RustInPeace 60 flag_file
Good job !
$
```

### Flag

Hero{D1d_y0u_kn0w_4b0ut_Ru5t_r3v3rs1ng??}