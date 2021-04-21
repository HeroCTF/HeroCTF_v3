# Kernel #1 : Opened safe

### Category

Kernel

### Description

Message from : Mom 23/04/21 21:00
> Hey sweetheart !
>  
> I left a little something for you in the safe.  
> It's unlocked, so you just have to retrieve it.  
> Love you ! xoxo  
>  
> PS : Happax, the cat, has been behaving oddly lately..

Format : **Hero{flag}**  
Author : **iHuggsy**

### Write up

If we list the devices in /dev, we see an interesting ```/dev/safe```.

The first thing that comes to mind is to cat the flag out.
```sh
cat /dev/safe
```

But as the descriptions says, the cat behaves oddly.
We can then just code the flag out in C.

Go in the temporary directory on the host machine and compile this

```C
#include <fcntl.h>
#include <unistd.h>
#include <stdio.h>

int main()
{
	# Open the file
	int fd = open("/dev/safe", O_RDWR);
	char* flag;
	# Read the flag from the file into the char*
	read(fd, flag, 35);
	# Print the flag
	printf("%s", flag);

    exit(0);
}


```

### Flag

Hero{S3eD3d_Scr4Mbl3}