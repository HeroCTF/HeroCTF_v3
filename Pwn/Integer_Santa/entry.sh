#!/bin/bash

while :
do
	exec socat TCP-LISTEN:${LISTEN_PORT},reuseaddr,fork EXEC:'/santa/integer_santa.bin,stderr'
done
