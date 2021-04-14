# PrivesCorp #4: Go Deep

### Category

System

### Description

The layoff list was leaked... The reponsible hr was let go, but before that, he barricaded very important information on his account. If you could get to it, there would probably be a promotion in sight.
Your credentials on PrivesCorp's network -> bob:password123

URL : http://challs.heroctf.fr:XXXX

Format : **Hero{flag}**<br>
Author : **Log_s**

### Hints

- You can pass arguments through SSH

### Write up

First thing we can establish, is that there is a 39 character limit, that import and builtins are not usable, and that variables are not kept from one line to another.

We also notice that some words are filtered, like `dir`, and others are completely banned, like `builtins`. The difference is that filtered words are just taken out of the input before it being executed, whereas banned words prevent the input of being executed at all.

One way of implementing filtered words is to do something like this :
```python
for word in filtered:
    cmd = cmd.replace(word, "")
```
But there is an easy way to bypass it aswell. If you type in `didirr`, the filter will take out the middle part (`di`**dir**`r`) leaving `dir` to be executed.

So let's see what this python has to offer.

```
bob@godeep > didirr()
--->  dir()
['TO_KEEP', '_86924', '__annotations__', '__builtins__', '__cached__', '__doc__', '__file__', '__loader__', '__name__', '__package__', '__spec__', 'argv', 'clear_vars', 'cmd', 'flag', 'forbidden', 're', 'res', 'ssh_arg', 'vars']
```

If you try to display some these variables, some are filtered, and other banned (like `forbidden`). If we try to display the content of `flag` with the same technic as previously, we will get a fake flag. `TO_KEEP` and `_86924` are more usefull.

```
bob@godeep > _8692_869244
--->  _86924
<built-in function open>
```

We have access to the `open()` function. Might come in handy to read a certain file ;)

```
bob@godeep > TOTO_KEEP_KEEP
--->  TO_KEEP
{'__name__': '__main__',
...,
'ssh_arg': 'Sesame', 'forbidden': ['TO_KEEP', 'dir', 'flag', '_86924', 'secret/879.txt'], 'TO_KEEP': {}, 'flag': 'fake{NOP_LOL}', 'clear_vars': <function clear_vars at 0x7f76e9e21040>}
```

Here we have access to the content of the previously discorvered variables. If you are wondering, the shell removes any newly created variable after every command. However, some variables are needed, so it stores in `TO_KEEP` all variables that souldn't be removed.

We learn something very important : the list of all filtered words. I wonder what is inside **secret/879.txt**. Let's try to read it.

The obvious payload is the following :
```python
_8692_869244("secret/879.txsecret/879.txtt").read()
```
But since we can't use more then 39 characters, we'll have to find a way to bypass it. The `flag` variable that seemed to be nothing more than a troll from that mean challenge creater, is actually writtable (and won't be deleted since it's inside the TO_KEEP variable).
```
bob@godeep > flflagag="secret/879.txsecret/879.txtt"
--->  flag="secret/879.txt"
secret/879.txt

bob@godeep > _8692_869244(flflagag).read()
--->  _86924(flag).read()
Hero{H0w_d1d_u_g3t_0u7}
```

A bit of a tortious path, but congratz !

### Flag

```Hero{H0w_d1d_u_g3t_0u7}```