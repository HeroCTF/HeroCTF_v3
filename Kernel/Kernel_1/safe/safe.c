#define _GNU_SOURCE


#include "safe.h"
#include <linux/module.h>
#include <linux/kernel.h>   
#include <linux/fs.h>
#include <linux/cdev.h>
#include <linux/errno.h>
#include <linux/uaccess.h>
#include <linux/ioctl.h>
#include <linux/slab.h>
#include <linux/string.h>
#include <linux/types.h>
#include <linux/kmod.h>
#include <linux/pid.h>
#include <linux/cred.h>
#include <linux/sched.h>
#include <linux/uidgid.h>

/* Buffer size */
#define MAX_BUF_LEN 256

// The n value for the rot-n
static int32_t SHIFT_VAL = 13;

static int pid = 0;
MODULE_LICENSE("GPL");
module_param(pid,int,0000);

char *p_flag = "Hero{s0_yOu_C4n_r34d_Fr0m_cHrD3v}\n\x00";

static ssize_t device_file_read(struct file *file_ptr, char __user *user_buffer, size_t count, loff_t *offset)
{
    /* Give the user his data */
    /* Note : use strlen because sizeof(ptr) will return the ptr size.. */
    size_t flag_len = strlen(p_flag);

    if (*offset > flag_len)
        return 0;


    if (copy_to_user(user_buffer, p_flag, strlen(p_flag)+1) != 0)
        return -EFAULT;
    *offset += count;
    return count;
}


static struct file_operations rot13_fops = 
{
    .owner = THIS_MODULE,
    .read  = device_file_read,
};

static int device_file_major_number = 0;
static const char device_name[] = "safe";

int register_device(void)
{
    int result = 0;

    printk(KERN_NOTICE "safe: Registering device");

    result = register_chrdev(device_file_major_number, device_name, &rot13_fops);
    
    if (result < 0)
    {
        printk(KERN_WARNING "safe: Couldn\'t reguster device, ec=%i", result);
        return result;
    }

    device_file_major_number = result;
    printk(KERN_NOTICE "safe: device registered with major number %i", result);

    return 0;
}

void unregister_device(void)
{
    printk(KERN_NOTICE "safe: device unregistering");


    if (device_file_major_number != 0)
    {
        unregister_chrdev(device_file_major_number, device_name);
    }    

}
