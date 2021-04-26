#!/bin/bash -p
TEMP=$(mktemp -d)
STTY=$(stty -g)
stty intr ^-

chmod 777 ${TEMP}

echo ""
echo "Welcome to the kernel challenge #1 !"
echo "---- Your share : host:${TEMP} -> guest:/mnt/share ----"
echo "- Use CTRL+Z to put qemu in the background"
echo "- Use CTRL+* to exit the VM (shutdown)"
echo "- If qemu is in the background, use the 'fg' command to return to the vm"
echo ""


qemu-system-x86_64 \
-m 128M \
-kernel bzImage \
-display none \
-serial stdio \
-append 'console=ttyS0 loglevel=3' \
-initrd initramfs \
-snapshot \
-virtfs local,path=${TEMP},mount_tag=heroshare,security_model=passthrough,id=heroshare

rm -rf "${TEMP}" 2> /dev/null
stty "${STTY}"
