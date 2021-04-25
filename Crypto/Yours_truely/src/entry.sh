#!/usr/bin/env ash

while :
do
	exec socat TCP-LISTEN:$LISTEN_PORT,reuseaddr,fork EXEC:'/app/challenge.py,stderr'
done
