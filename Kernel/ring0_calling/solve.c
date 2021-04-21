#define __NR_hero 442

long hero_syscall(void)
{
    return syscall(__NR_hero);
}

int main(int argc, char *argv[])
{
    long activity;
    activity = hero_syscall();

    if(activity < 0)
    {
        perror("Seems like it's a fail !\n");
    }

    else
    {
        printf("Seems ok, try to dmesg\n");
    }

    return 0;
}
