#!/bin/bash

while :
do
	su -c "exec socat TCP-LISTEN:8060,reuseaddr,fork EXEC:'python3 /home/robot/chall.py',stderr,pty,echo=0" - robot;
done
