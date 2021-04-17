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
}

