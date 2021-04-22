#!/bin/bash

while :
do
	exec socat TCP-LISTEN:9002,reuseaddr,fork,forever,keepalive EXEC:'./y'
done
