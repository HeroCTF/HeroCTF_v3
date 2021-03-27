#! /bin/bash
cron -f&
/usr/sbin/sshd -D
