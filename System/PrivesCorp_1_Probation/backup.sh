#! /bin/bash
cd /home/bob
tar cf /var/backups/backup.tar *
chmod 500 /var/backups
chmod 500 /var/backups/*
