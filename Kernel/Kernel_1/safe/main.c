#include "safe.h"
#include <linux/init.h>
#include <linux/module.h>


static int init_safe(void)
{
    int result = 0;
    result = register_device();
    return result;
}

static void exit_safe(void)
{
    unregister_device();
}

module_init(init_safe);
module_exit(exit_safe);
