#!/bin/bash

while :
do
	exec socat TCP-LISTEN:9001,reuseaddr,fork,forever,keepalive EXEC:'python app/Casino_pwn.py'
done
