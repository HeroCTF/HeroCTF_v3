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

