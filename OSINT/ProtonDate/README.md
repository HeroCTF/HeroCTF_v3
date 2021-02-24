# ProtonDate

### Category

OSINT

### Description

Can you retrieve the creation date of this email address, **xanhacks@protonmail.com**.

Format : **Hero{time_stamp}**<br>
Author : **xanhacks**

### Write up

You can use the Protonmail API to find the creation date of the public key attached to each Protonmail address.

https://api.protonmail.ch/pks/lookup?op=index&search=xanhacks@protonmail.com

```
info:1:1
pub:f58fb9d9433d5a612a580d158251db3f67ddb2f7:1:2048:1567772559::
uid:xanhacks@protonmail.com <xanhacks@protonmail.com>:1567772559::
```

1567772559 is the timestamp !

### Flag

Hero{1567772559}