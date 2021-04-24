#! /bin/bash

if [ "$1" = "-ld" ] && [ "$2" = "/home/bob/.financial.txt" ]
then
    echo "-rwx------ 1 accountant accountant   113 avril 21 21:44 /home/bob/.financial.txt"
else
    echo "This is a shared instance. You can right in /home/bob/ but it will deleted every half second"
    echo "/tmp will be cleared every minute aswell"
    echo "-rwsr-xr-x 1 root root   113 avril 21 21:44 /home/bob/exportSafePerms"
fi
