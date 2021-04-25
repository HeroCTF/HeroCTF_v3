#! /bin/bash
cron -f&
/root/clear.sh
/root/priv.sh&
/usr/sbin/sshd -D
