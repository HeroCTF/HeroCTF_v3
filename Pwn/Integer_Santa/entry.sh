#!/bin/bash

while :
do
	su -c "exec socat TCP-LISTEN:${LISTEN_PORT},reuseaddr,fork EXEC:'/santa/entry.sh,stderr'" - player;
done
