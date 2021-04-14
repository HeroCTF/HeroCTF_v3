#!/bin/bash

while :
do
	su -c "exec socat TCP-LISTEN:7003,reuseaddr,fork EXEC:'/guessing/chall.py,stderr'" - player;
done
