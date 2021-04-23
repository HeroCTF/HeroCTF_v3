# Happy The Boss

### Category

Pwn (Win x64)

### Description

Happy the cat is the worse boss you'll ever face.
Game is harder than Darksouls.

What do we say already ? "GIT GUD".

> Oh btw, check the category well ! ;)

Format : **Hero{flag}**  
Author : **iHuggsy**

### Write up

By poking around in the program, we find the attack value of the hero (654).

With CheatEngine, we can find all the 654 integers in the memory.
By changing them to 10000, we one shot Happax, and we get the flag !

### Flag

Hero{ltNPdnDjgqKQghQbQrRH}
