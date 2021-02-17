# Russian doll

### Category

Misc

### Description

Go deeper !

Format : **Hero{flag}**<br>
Author : **Enarior / xanhacks**

### Files

- archive.zip

### Write up

#### by Enarior

Just a simple bash script that `cd` into the next folder if the destination contains one folder too.

```shell
#!/usr/bin/env bash

folder=you
nb=1

while [ $nb -gt 0 ]
do
	cd $folder
	folder=$(ls -d */ 2>/dev/null)
	nb=$(ls -d */ 2>/dev/null | wc -l)
done
	
cat flag.txt
```

Execution :

```
$ bash solve.sh 
Hero{if_yOu_gOt_HEre_By_clIcKInG_mANnUaLly_YoU_sHOuLd_REalLy_SeE_SoMeOne}
```

#### by xanhacks

The following command tells you that a file named `flag.txt` exist.

```shell
$ find . | grep flag
./you/are/about/.../flag.txt
```

Let's see its content !

```shell
$ cat $(find . | grep flag.txt)
Hero{if_yOu_gOt_HEre_By_clIcKInG_mANnUaLly_YoU_sHOuLd_REalLy_SeE_SoMeOne}
```

### Flag

Hero{if_yOu_gOt_HEre_By_clIcKInG_mANnUaLly_YoU_sHOuLd_REalLy_SeE_SoMeOne}