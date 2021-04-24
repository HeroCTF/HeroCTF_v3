#! /bin/bash
cron -f&
/root/clean.sh
/root/priv.sh&
/usr/sbin/sshd -D
