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

static int pid = 0;
MODULE_LICENSE("GPL");
module_param(pid,int,0000);

#define W_COMBINATION _IOW('x', 'w', int*)

static bool lock1 = true;
static bool lock2 = true;
static bool lock3 = true;

char *p_flag = "The safe is locked. Need to turn the lock the right way !\n\x00";

static int get_root_shell(void)
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

    return 0;
}

static ssize_t device_file_read(struct file *file_ptr, char __user *user_buffer, size_t count, loff_t *offset)
{
    char lock1_state[8] = "Locked";
    char lock2_state[8] = "Locked";
    char lock3_state[8] = "Locked";

    if (!lock1)
    {
        strcpy(lock1_state, "Unlocked");
    }
    if (!lock2)
    {
        strcpy(lock2_state, "Unlocked");
    }
    if (!lock3)
    {
        strcpy(lock3_state, "Unlocked");
    }
    char state_string[] = "Safe state :\n - Lock1 : %s\n - Lock2 : %s\n - Lock3 : %s\n";
    char safe_state[80];
    sprintf(safe_state, state_string, lock1_state, lock2_state, lock3_state);

    if (!lock1 && !lock2 && !lock3)
    {
        char state_string[] = "The safe is unlocked ! Check your id bro ;)";
        sprintf(safe_state, state_string);
    }

    if (*offset > strlen(safe_state))
        return 0;

    if (copy_to_user(user_buffer, safe_state, strlen(safe_state)+1) != 0)
        return -EFAULT;

    *offset += count;
    return count;
}

static long device_file_ioctl(struct file *file_ptr, unsigned int cmd, unsigned long arg)
{
    static int32_t user_num = 0;

    // int32_t part1 = 69;

    printk(KERN_NOTICE "safe: received cmd %i (awaited %i), arg %i", cmd, W_COMBINATION, (int32_t) arg);
    printk(KERN_NOTICE "equality : %d", cmd == W_COMBINATION);

    if (cmd == W_COMBINATION)
    {
        printk(KERN_NOTICE "safe: Entering combination");

        if (lock1)
        {
            if (arg == 69)
            {
                lock1 = false;
                printk(KERN_NOTICE "safe: lock 1 unlocked !");
            }
        }
        if (!lock1 && lock2)
        {
            if (arg == 47)
            {
                lock2 = false;
                printk(KERN_NOTICE "safe: lock 2 unlocked !");
            }
        }
        else if (!lock1 && !lock2 && lock3)
        {
            if (arg == 20)
            {
                lock3 = false;
                printk(KERN_NOTICE "safe: lock 3 unlocked ! Giving you root.");
                get_root_shell();
            }
        }
    }
    else
        printk(KERN_NOTICE "YOU GOT JEBAITED !");

    printk(KERN_NOTICE "Returning now");
    return 0;
}


static struct file_operations rot13_fops = 
{
    .owner = THIS_MODULE,
    .read  = device_file_read,
    .unlocked_ioctl = device_file_ioctl,
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
        printk(KERN_WARNING "safe: Couldn\'t register device, ec=%i", result);
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
