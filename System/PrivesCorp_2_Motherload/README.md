# PrivesCorp #2: Motherload

### Category

System

### Description

You were contracted (for a lot of a money) by l'Hackonfrerie to steal some financial data. Extra money is always nice.
Your credentials on PrivesCorp's network -> bob:password123

URL : http://challs.heroctf.fr:XXXX

Format : **Hero{flag}**<br>
Author : **Log_s**

### Files

 - src/exportSafePerms.cpp

### Write up

The mistake that was made here is to use relative path for a system command instead of absolute. ```~~ls -ld~~ -> /bin/ls -ld```
This mistake allows us to trick the program in executing our own **ls** command. As *exportSafePerms* has SUID enabled, user bob is able to run it with the accountant's privileges (and therefor read the flag).

```echo "cat .financial.txt" > ls && chmod +x ls```

Now that we have our own **ls**, we juste have to indicate the system to run this one, instead of the legit one.

```export PATH=.:$PATH```

Now it will look in the current directory, before looking in /bin. One thing good to know, is that SUID allows a user to run a program with someon else's permissions, but no as this user. Therefore, the user's path is kept, wich allows us to exploit it.

```./exportSafePerms```

PS : SUID does not directly work on a python script for example, since it will be interpreted by the python interpreter, which acts as a middle man, and does not have the SUID bit.

### Flag

```Hero{m0th3rl04d_g0e5_brrr}```
