#! /bin/bash

rm -rf /home/bob/* /tmp/*
cp /root/locked.txt /home/bob/locked.txt
chmod 500 /home/bob/locked.txt
