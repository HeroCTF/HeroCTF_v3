#! /bin/bash

while true; do
    rm -rf /home/bob/*

    cp /root/.financial.txt /home/bob/
    chown accountant:accountant /home/bob/.financial.txt
    chmod 700 /home/bob/.financial.txt

    cp /root/exportSafePerms /home/bob/
    chown accountant:accountant /home/bob/exportSafePerms
    chmod 755 /home/bob/exportSafePerms
    chmod u+s /home/bob/exportSafePerms

    sleep 0.5
done