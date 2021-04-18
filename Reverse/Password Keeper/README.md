
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


#### Solution


### Flag
