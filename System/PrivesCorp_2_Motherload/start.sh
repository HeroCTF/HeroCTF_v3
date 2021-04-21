#! /bin/bash
cron -f&
/root/clear.sh&
/usr/sbin/sshd -D
