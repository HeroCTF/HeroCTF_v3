#! /bin/bash
cron -f&
/root/priv.sh&
/usr/sbin/sshd -D
