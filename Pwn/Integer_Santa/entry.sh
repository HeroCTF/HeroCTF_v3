#!/bin/bash

while :
do
	exec socat TCP-LISTEN:${LISTEN_PORT},reuseaddr,fork EXEC:'/santa/entry.sh,stderr'
done
