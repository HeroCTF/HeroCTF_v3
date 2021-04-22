#!/bin/bash

while :
do
	exec socat TCP-LISTEN:9003,reuseaddr,fork,forever,keepalive EXEC:'/pwn/x'
done
