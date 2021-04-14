# Assistant

### Category

System

### Description

Welcome ! This machine is equiped with the next generation personnal assistant technology. Make good use of it ;)

credentials -> brian:password123

URL : http://challs.heroctf.fr:XXXX

Format : **Hero{flag}**<br>
Author : **Log_s**

### Hints

 - Don't forget to check what you can run as root without password

### Write up

In this challenge, you can run the script `/bin/assistant.py` as root. Let's take a look at the script.

Depending on what you input, a different command will be written inside a file called **order.cmd**. This file is world writable. Finally it calls another python script `/root/run.py` which we can't read.

Now we run the script `sudo /bin/assistant.py` but there is no trace of **order.cmd**. The other script probably deletes it. But as the first script mentions, there is now a **output.txt** file which contains the output of the command we chose.

If you run the second choice (`id`) you'll see that every thing is ran as root, even on the second script (python does not naturally drop privileges). 

If you run the third choice (`cat /root/path.txt`) you'll get the path of the flag. It's very unusual, and would it would have been hard to spot on our own : `/lib/udev/rules/d/02-uaccesss.rules`.

So are we going to read this file ? We can't write our own **order.cmd** because the first script deletes it before doing any writing. We'll have to exploit a "*race condition*".

A race condition defines a situation where the final outcomes depends on the order in which the same actions are conducted. In some cases, it can be used to quickely write critical data for an application.

In this case, there is a fraction of second where **order.cmd** exist, and can be written before it's read by `/root/run.py`.

Take the following bash script :
```bash
while :
do
	echo 'cat /lib/udev/rules.d/02-uaccesss.rules' > /home/brian/order.cmd
done
 ```

 It basically continuously writes int the **order.cmd**, so that in the short lap of time where the first script is done and the second reads the data, it got replaced. We could get creative with the payload, but this serves our purpose.

```
>> ./race.sh &

>> sudo /bin/assistant.py
```

Run the exploit in background, and run the assistant, chose any command you want and get your flag in **output.txt**. You may have to run the assistant a few times. The timing is very short, and it can occure the `race.sh` doesn't write at the right moment.

### Flag

```Hero{c4r3fUl1_w1th_R4cE_c0nd1tI0nS}```