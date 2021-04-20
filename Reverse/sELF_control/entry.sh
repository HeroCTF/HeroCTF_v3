#!/usr/bin/env ash

while :
do
	su -c "exec socat TCP-LISTEN:$LISTEN_PORT,reuseaddr,fork EXEC:'/usr/src/sELF_control,stderr'" - heroctf;
done
