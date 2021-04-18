cmd_/home/jeje/kernel_2/safe/modules.order := {   echo /home/jeje/kernel_2/safe/safe_mod.ko; :; } | awk '!x[$$0]++' - > /home/jeje/kernel_2/safe/modules.order
