cmd_/home/jeje/kernel_1/safe/Module.symvers := sed 's/ko$$/o/' /home/jeje/kernel_1/safe/modules.order | scripts/mod/modpost     -o /home/jeje/kernel_1/safe/Module.symvers -e -i Module.symvers   -T -
