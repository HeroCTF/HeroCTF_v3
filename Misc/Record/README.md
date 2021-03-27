# Record

### Category

Misc

### Description

Can you find anything special about this domain **heroctf.fr** ?

Format : **Hero{flag}**<br>
Author : **xanhacks**

### Write up

This challenge was about DNS records. You can use **dig**, a DNS lookup utility, to see all the records of a DNS.

```shell
$ dig TXT heroctf.fr

; <<>> DiG 9.16.12 <<>> TXT heroctf.fr
;; global options: +cmd
;; Got answer:
;; ->>HEADER<<- opcode: QUERY, status: NOERROR, id: 31126
;; flags: qr rd ra; QUERY: 1, ANSWER: 2, AUTHORITY: 0, ADDITIONAL: 1

;; OPT PSEUDOSECTION:
; EDNS: version: 0, flags:; udp: 1280
;; QUESTION SECTION:
;heroctf.fr.			IN	TXT

;; ANSWER SECTION:
heroctf.fr.		3600	IN	TXT	"Hero{cl34rtXt_15_b4d}"
...
```

### Flag

Hero{cl34rtXt_15_b4d}