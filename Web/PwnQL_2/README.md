# PwnQL #2

### Category

Web

### Description

Extract the *admin*'s password from the database.

URL : http://challs.heroctf.fr:XXXX (same URL than before)

Format : **Hero{password}**<br>
Author : **xanhacks**

### Write up

So, here we are with the same vulnerability that the first PwnQL, but we need to extract the admin's password.

The goal here is to find the password according to the server response.

```
Example :

password : a% -> login error
password : b% -> login error
password : c% -> login error
password : d% -> login success

The admin's password starts with the letter 'd'.
```

Let's make a python to script to do the job for us.

```python3
#!/usr/bin/env python3

print("todo")
```

### Flag

Hero{s3cur3P@ss}