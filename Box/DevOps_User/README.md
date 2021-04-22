# DevOps User

### Category

Box

### Description

Can you find the **user.txt flag** on the box ?

URL : **http://box.heroctf.fr ** (only dockers are on the scope, not the real machine behind)

Format : **Hero{flag}**<br>
Author : **xanhacks**

### Hints

There are a some steps and a lot of information to consider before validating this machine, but the overall level remains easy.

### Files

- [nmap.txt](nmap.txt)

### Write up

Nmap

port 2222 : ssh
port 3000 : gitea
port 8080 : jenkins

Secret in git/ecommerce, crack the private key and get "heroes" as password

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
