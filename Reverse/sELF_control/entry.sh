#!/usr/bin/env ash

while :
do
	exec socat TCP-LISTEN:$LISTEN_PORT,reuseaddr,fork EXEC:'./sELF_control,stderr'
done
