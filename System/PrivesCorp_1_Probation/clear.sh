#! /bin/bash

rm -rf /home/bob/* /tmp/*
cp /root/locked.txt /home/bob/locked.txt
cp /roo/note.txt /home/bob/note.txt
chmod 500 /home/bob/locked.txt
chown bob:bob /home/bob/note.txt
chmod 544 /home/bob/note.txt
