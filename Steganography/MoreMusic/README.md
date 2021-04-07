# MoreMusic

### Category

Steganography

### Description

Pretty good music in stereo !

Format : **Hero{flag}**<br>
Author : **Thib**

### Files

- MoreMusic.wav

#### Solution

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
