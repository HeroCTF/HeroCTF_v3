# Ring0 Calling

### Category

Kernel

### Description

I like to compile my kernels. And I like to do it the old way.
And I also like doing it 50x times because I forgot an option.

Can you get the flag ?

Format : **Hero{flag}**
Author : **SoEasy & iHuggsy**

### Write up

After looking in the "backup" folder, we see that there is a syscall_tbl.
Number 442 is the __NR_HERO. Seems interesting.

We just have to call it and see what happens.

```C
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
```

Then, if we dmesg :

> [   24.598590] Hero{0h_d4mn_y0u_4r2_th3_sysc4ll_m4st3r_!!!}


### Flag

Hero{0h_d4mn_y0u_4r2_th3_sysc4ll_m4st3r_!!!}