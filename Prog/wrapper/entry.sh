#!/bin/bash

while :
do
	su -c "exec socat TCP-LISTEN:7001,reuseaddr,fork EXEC:'/wrapped/chall.py,stderr'" - player;
done
