#!/bin/bash

while :
do
	su -c "exec socat TCP-LISTEN:7004,reuseaddr,fork EXEC:'/polysemy/chall.py,stderr'" - player;
done
