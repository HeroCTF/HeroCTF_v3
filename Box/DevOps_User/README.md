# DevOps User

### Category

Box

### Description

Can you find the **user.txt flag** on the box ?

URL : http://box.heroctf.fr (only dockers are on the scope, not the real machine behind)

The machine resets itself every hour, so keep track of your work !

Format : **Hero{flag}**<br>
Author : **xanhacks**

### Hints

- There are a some steps and a lot of information to consider before validating this machine, but the overall level remains easy.
- You get a password ? Check other services !

### Files

- [nmap.txt](nmap.txt)

### Write up

A very good write up can be found here : [https://podalirius.net/writeups/heroctf-2021-devops-box-writeup/](https://podalirius.net/writeups/heroctf-2021-devops-box-writeup/).

Nmap

port 2222 : ssh
port 3000 : gitea
port 8080 : jenkins

Search for passwords (2 ways) :
- git/ecommerce : Crack the private key and get "heroes" as passphrase
- git/infra : The password "heroes" was also in the gitea Dockerfile : `RUN echo "git:heroes" | chpasswd`.

Log in into Jenkins admin dashboard with admin:heroes, you can now execute command on the Jenkins docker by going to the configuration panel of jenkins and executing Groovy script.

```groovy
println "whoami".execute().text
```

Then, you can make a reverse shell with python for example.

```shell
@jenkins $ cat user.txt
Hero{dc97a2f7da5304d12fe820bd2a6d343d}
```

User flag gg !

### Flag

Hero{dc97a2f7da5304d12fe820bd2a6d343d}
