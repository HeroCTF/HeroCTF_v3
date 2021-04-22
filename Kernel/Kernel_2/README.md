# Kernel #2 : Password Locked safe

### Category

Kernel

### Description

Message from : Mom 23/04/21 22:00
> Hey sweetie !  
>  
> I placed a little gift for you in the living room.  
> It's in a box that's locked though.  
> The key's in the safe, and this time I locked it with a password.  
> Love you ! xoxo  
>  
> PS : Happax seems to be back to normal.

Format : **Hero{flag}**  
Author : **iHuggsy**

### Write up

By catting into the driver, we're being told that the safe is password locked.

By reversing the driver, we see that in the *device_file_write* function that the driver expects an input.

By investigating further, we see that it's awaiting "OpenSesame" in rot13.


```C
#include <fcntl.h>
#include <unistd.h>
#include <stdio.h>
#include <string.h>

int main()
{
	int fd = open("/dev/safe", O_RDWR);

	char* pass = "BcraFrfnzr";

	write(fd, pass, strlen(pass));

	close(fd);
	
	system("/bin/sh");
}

```

### Flag

Hero{y0u_c4n_4ls0_Wr1t3_?!!}
