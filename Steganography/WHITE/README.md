# WHITE

### Category

Steganography

### Description

White on white...

Format : **Hero{flag}**<br>
Author : **SoEasY**

### Files

- WHITE.png

### Write up

This challenge's purpose is to look at the colors index table of the PNG, the "PLTE" (for "palette" chunk in the PNG).
![image](https://user-images.githubusercontent.com/34216946/112852723-7b292200-90ac-11eb-9b7c-72f776479299.png)

We can see that there are two entries at the value #ffffff (white in RGB) so we can have the idea to change one of these two values.

#### Solution (by SoEasY, not the most interesting one)

Open the file in Photoshop (or in another photo editing software) and go to "Image" > "Mode" > "Indexed colors".

Then, you can change every color in the index table by going to "Image" > "Mode" > "Color Table".

Change one of the two colors from white to black for example and get a QRcode.
![image](https://user-images.githubusercontent.com/34216946/112852898-a6ac0c80-90ac-11eb-88ee-699f9baa2a10.png)

After reading this QRcode with an application or an online tool for example you'll get the flag in base64 !
```bash
echo SGVyb3tCNGhhaGFoX3R3MF9jb2wwdXI1X3MzcmkwdXNsWT8/fQ== | base64 -d
Hero{B4hahah_tw0_col0ur5_s3ri0uslY??}
```

### Flag

Hero{B4hahah_tw0_col0ur5_s3ri0uslY??}
