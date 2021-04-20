# Password Keeper

### Category

Reverse

### Description

You are mandated to pentest a new password manager application.
Try to log your self to the application !

Format : **Hero{user:password}**<br>
Author : **SoEasY**

### Files

- hero-password-keeper.app

### Write up

This in an iOS application which can be opened as a folder. In this folder we can find the application as a binary file because this iOS application in developed in Objective c.

We can now open this binary file in a disassembler (IDA in my case). The interesting function here is `-[ViewController viewDidLoad]`.

![image](https://user-images.githubusercontent.com/34216946/115162286-f0cc5080-a0a2-11eb-80de-517fa5b9707b.png)

There we can see that a password will be constitued of `Sw4gGP4ssw0rd`, concatenated with "-" and GetRandomNumberBetween1and10("Sw4gGP4ssw0rd").
Then, a username wille be decoded from base64 `eFhENHJLX0szdjFuWHg=`.

You can also use the decompiler to see this.

```c
void __cdecl -[ViewController viewDidLoad](ViewController *self, SEL a2)
{
  void *v2; // rax
  void *v3; // rax
  void *v4; // rax
  void *v5; // rax
  void *v6; // rax
  void *v7; // rax
  void *v8; // rax
  void *v9; // rax
  __int64 v10; // ST08_8
  void *v11; // rax
  __int64 v12; // rax
  void *v13; // rax
  __int64 v14; // rax
  NSDictionary *v15; // rsi
  __int64 v16; // ST00_8
  void *v17; // [rsp+38h] [rbp-58h]
  void *v18; // [rsp+40h] [rbp-50h]
  __int64 v19; // [rsp+48h] [rbp-48h]
  __int64 v20; // [rsp+50h] [rbp-40h]
  void *v21; // [rsp+58h] [rbp-38h]
  __int64 v22; // [rsp+60h] [rbp-30h]
  void *v23; // [rsp+68h] [rbp-28h]
  ViewController *v24; // [rsp+70h] [rbp-20h]
  __objc2_class *v25; // [rsp+78h] [rbp-18h]
  SEL v26; // [rsp+80h] [rbp-10h]
  ViewController *v27; // [rsp+88h] [rbp-8h]

  v27 = self;
  v26 = a2;
  v24 = self;
  v25 = &OBJC_CLASS___ViewController;
  objc_msgSendSuper2(&v24, "viewDidLoad");
  v2 = (void *)objc_retain(CFSTR("Sw4gGP4ssw0rd"));
  v23 = v2;
  v3 = objc_msgSend(v2, "GetRandomNumberBetween1and10");
  v22 = objc_retainAutoreleasedReturnValue(v3);
  v4 = objc_msgSend(v23, "stringByAppendingString:", CFSTR("-"));
  v5 = (void *)objc_retainAutoreleasedReturnValue(v4);
  v21 = v5;
  v6 = objc_msgSend(v5, "stringByAppendingString:", v22);
  v20 = objc_retainAutoreleasedReturnValue(v6);
  v19 = objc_retain(CFSTR("eFhENHJLX0szdjFuWHg="));
  v7 = (void *)objc_alloc(&OBJC_CLASS___NSData);
  v18 = objc_msgSend(v7, "initWithBase64EncodedString:options:", v19, 0LL);
  v8 = (void *)objc_alloc(&OBJC_CLASS___NSString);
  v17 = objc_msgSend(v8, "initWithData:encoding:", v18, 4LL);
  v9 = objc_msgSend(&OBJC_CLASS___NSArray, "arrayWithObjects:", v20, 0LL);
  v10 = objc_retainAutoreleasedReturnValue(v9);
  v11 = objc_msgSend(&OBJC_CLASS___NSArray, "arrayWithObjects:", v17, 0LL);
  v12 = objc_retainAutoreleasedReturnValue(v11);
  v13 = objc_msgSend(&OBJC_CLASS___NSDictionary, "dictionaryWithObjects:forKeys:", v10, v12, v12);
  v14 = objc_retainAutoreleasedReturnValue(v13);
  v15 = v27->dico;
  v27->dico = (NSDictionary *)v14;
  objc_release(v15);
  objc_release(v16);
  objc_release(v10);
  objc_storeStrong(&v17, 0LL);
  objc_storeStrong(&v18, 0LL);
  objc_storeStrong(&v19, 0LL);
  objc_storeStrong(&v20, 0LL);
  objc_storeStrong(&v21, 0LL);
  objc_storeStrong(&v22, 0LL);
  objc_storeStrong(&v23, 0LL);
}
```

If we take a look at the function `GetRandomNumberBetween1and10` we can see that it is in fact a MD5 function !

![image](https://user-images.githubusercontent.com/34216946/115258343-30417e00-a131-11eb-9f6f-8f53081e15b9.png)


#### Solution

To conclude, we can find the username easily : 
```bash
$ echo eFhENHJLX0szdjFuWHg= | base64 -d
xXD4rK_K3v1nXx
```

For the password we have : 
```python
$ python
Python 3.9.4 (default, Apr  5 2021, 01:50:46) 
[Clang 12.0.0 (clang-1200.0.32.29)] on darwin
Type "help", "copyright", "credits" or "license" for more information.
>>> from hashlib import md5
>>> passwd = 'Sw4gGP4ssw0rd'
>>> hash = md5(passwd.encode()).hexdigest()
>>> passwd += '-'
>>> passwd += hash.upper()
>>> passwd
'Sw4gGP4ssw0rd-D6E3698EFE051ACE727202E0D8BC56A1'
```
We can execute this (beautiful) application to confirm it !

![image](https://user-images.githubusercontent.com/34216946/115262745-1b66e980-a135-11eb-94ae-5913a6848c7f.png)

### Flag

Hero{xXD4rK_K3v1nXx:Sw4gGP4ssw0rd-D6E3698EFE051ACE727202E0D8BC56A1}
