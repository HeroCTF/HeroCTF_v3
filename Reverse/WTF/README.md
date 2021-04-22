# WTF

### Category

Reverse

### Description

Find the flag in this android application.

Format : **Hero{flag}**<br>
Author : **SoEasY**

### Files

- WTF.bin

### Write up

This challenge in nothing more than a sudoku game :)
The programm will split your input like that : 
- row number (as int)
- column number (as int)
- value to put (as char)

The initialisation part in \_start give you the grid, with a ' ' for the blanks.
<img src="https://user-images.githubusercontent.com/34216946/115768094-22e2f880-a3aa-11eb-93c1-80f4e558d246.png" width="350" height="350">

Jou can then use an online sudoku solver to have the correct input.

<img src="https://user-images.githubusercontent.com/34216946/115768177-4148f400-a3aa-11eb-85f1-fea2883ddab2.png" width="350" height="350">.

So a correct input could be for example : 
```
111127138172183214239243258261275286315326352367371388423442451464476498524531548556565579593616628632647674681695712744757773789791818834846877885892913929937941955962984
```

We can try : 
```bash
$ ./WTF_macho 111127138172183214239243258261275286315326352367371388423442451464476498524531548556565579593616628632647674681695712744757773789791818834846877885892913929937941955962984

Well done ! You can validate with this flag : 
Hero{178546239429381567563927184935214678741865923682793415256478391814639752397152846}
```

The flag is then constituted of all the number of the sudoku grid completed !

### Flag

Hero{178546239429381567563927184935214678741865923682793415256478391814639752397152846}
