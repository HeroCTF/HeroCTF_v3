# PrivesCorp #3: Help Me...

### Category

System

### Description

PrivesCorp is about to conduct a wave of layoffs. If only you knew if you are on the list...

```shell
$ ssh bob@chall0.heroctf.fr -p 5003
password : password123
```

Format : **Hero{flag}**<br>
Author : **Log_s**

### Write up

First thing we notice is that the .flag.txt is owned by the user *hr*, and that nobody else is allowed to read it.

Next we learn thanks to note.txt that dylan left us some credentials. You can look around, but it's a rabithole. He also specified leaving the *other* access open for us. If you take a look at /home/dylan/.ssh/authorized\_keys, you'll see an RSA public key for the user bob (that's us :) ).

```ssh dylab@localhost```

Now that we're connected as dylan, let's see what he is allowed to run as sudo

```sudo -l```

He can run /bin/journalctl as util.

```sudo -u util /bin/journalctl```

We get no entries because the first PID is not the one it should be (we're in a docker). But if you run the following with a small enough terminal size, the help menu will be displayed using the **more** binary.

```sudo -u util /bin/journalctl --help```

**more** and **less** allows you to run commands when hiting **!**

```!/bin/bash```

inside the help menu will get us a shell as util.

In his home directory, a binary gives us the password for hr : *$3cur3_l0l*. **su** won't work since the binary is not present on the machine. Juste disconnect from the machine and

```
ssh hr@ip
password : $3cur3_l0l
```

Here you go ! Lot's of steps, but it allows you to see two fairly common privelege escalations vectors.

### Flag

```Hero{0ff_7h3_h0Ok_f0r_n0w}```