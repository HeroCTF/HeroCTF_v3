cmd_/home/jeje/kernel_3/safe/modules.order := {   echo /home/jeje/kernel_3/safe/safe_mod.ko; :; } | awk '!x[$$0]++' - > /home/jeje/kernel_3/safe/modules.order
