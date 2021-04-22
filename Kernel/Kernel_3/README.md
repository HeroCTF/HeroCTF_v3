# Kernel #3 : Wheel Locked safe

### Category

Kernel

### Description

Message from : Mom 23/04/21 23:00
> Hey honey !  
> I hid a last gift in the living room.  
> It's in another box.  
> The key's in the second safe, you know the wheel protected one.  
>  
> PS : #define W_COMBINATION _IOW('x', 'w', int*)
> 
> Love you ! xoxo


Format : **Hero{flag}**  
Author : **iHuggsy**

### Write up

This time, if we reverse the driver, we can see in the IOCTL function that it expects some IOCTLS.

By investigating, and with the IOCTL given in the challenge, we can then call it with the appropriate values and get the flag out.

```C
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <linux/types.h>
#include <linux/stat.h>
#include <unistd.h>
#include <linux/ioctl.h>
#include <fcntl.h>

/* IOCTL */
#define W_COMBINATION _IOW('x', 'w', int*)

int main()
{
    // File descriptor
    int fd;
    int32_t value, number;

    printf("Trying to open the device\n");
    fd = open("/dev/safe", O_RDWR);
    
    if (fd < 0)
    {
        printf("Couldn't open the device file !");
        return 1;
    }

    int i = 0;
    while (i < 3)
    {
	printf("Enter the combination :");
	scanf("%d", &number);
        printf("Writing value to driver\n");
        ioctl(fd, W_COMBINATION, (int32_t) number);
        ++i;
    }

    printf("Closing driver\n");
    close(fd);
    printf("Opening shell. Enjoy root ! \n");
    system("/bin/sh");

    exit(0);
}
```

### Flag

Hero{y0u_4re_Da_cHrD3V_M4sT3R}
