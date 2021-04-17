TARGET_MODULE:=safe_mod

ifneq ($(KERNELRELEASE),)
		$(TARGET_MODULE)-objs := safe.o main.o
		obj-m := $(TARGET_MODULE).o

else
	#BUILDSYSTEM_DIR?=/lib/modules/$(shell uname -r)/build
	BUILDSYSTEM_DIR?=/home/jeje/linux-5.11.15
	PWD:=$(shell pwd)

all : 
# run kernel build system to make module
	$(MAKE) -C $(BUILDSYSTEM_DIR) M=$(PWD) modules

clean:
# run kernel build system to cleanup in current directory
	$(MAKE) -C $(BUILDSYSTEM_DIR) M=$(PWD) clean

load:
	insmod ./$(TARGET_MODULE).ko pid=48896

unload:
	rmmod ./$(TARGET_MODULE).ko

endif
